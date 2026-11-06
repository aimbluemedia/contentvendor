(function () {
  // Mobile menu
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Copy buttons
  document.querySelectorAll('[data-copy]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var el = document.querySelector(btn.getAttribute('data-copy'));
      if (!el) return;
      var text = 'value' in el ? el.value : el.innerText;
      var done = function () {
        var label = btn.textContent;
        btn.textContent = 'Copied!';
        setTimeout(function () { btn.textContent = label; }, 1500);
      };
      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(done);
      } else {
        var ta = document.createElement('textarea');
        ta.value = text; document.body.appendChild(ta); ta.select();
        try { document.execCommand('copy'); done(); } catch (e) {}
        document.body.removeChild(ta);
      }
    });
  });

  // Campaign builder: channel limit + loading state
  document.querySelectorAll('[data-builder]').forEach(function (form) {
    var max = parseInt(form.getAttribute('data-max') || '8', 10);
    var boxes = form.querySelectorAll('input[name="channels[]"]');
    var counter = form.querySelector('[data-count]');
    var update = function () {
      var n = 0;
      boxes.forEach(function (b) { if (b.checked) n++; });
      boxes.forEach(function (b) { b.disabled = !b.checked && n >= max; });
      if (counter) counter.textContent = n + ' selected · uses ' + n + ' generation' + (n === 1 ? '' : 's') + (max < 8 ? ' · max ' + max : '');
    };
    boxes.forEach(function (b) { b.addEventListener('change', update); });
    update();
    form.addEventListener('submit', function () {
      var btn = form.querySelector('[data-loading]');
      if (btn) { btn.setAttribute('aria-busy', 'true'); btn.textContent = btn.getAttribute('data-loading'); }
    });
  });

  // Character counter
  document.querySelectorAll('[data-charcount-for]').forEach(function (hint) {
    var ta = document.getElementById(hint.getAttribute('data-charcount-for'));
    if (!ta) return;
    var upd = function () { hint.textContent = ta.value.length + ' characters'; };
    ta.addEventListener('input', upd); upd();
  });
})();

// Homepage content analysis (sample report -> real report)
(function () {
  var root = document.querySelector('[data-calc]');
  if (!root) return;
  var form = root.querySelector('form');
  var scanUrl = root.getAttribute('data-scan-url');
  var input = form.querySelector('[name=website]');
  var errEl = root.querySelector('[data-scan-error]');
  var btn = root.querySelector('[data-scan-btn]');
  var loading = root.querySelector('[data-state=loading]');
  var report = root.querySelector('[data-state=report]');
  var ctaSample = root.querySelector('[data-cta=sample]');
  var ctaReal = root.querySelector('[data-cta=real]');
  var out = function (n) { return root.querySelector('[data-out="' + n + '"]'); };
  var setText = function (n, t) { var el = out(n); if (el) el.textContent = t; };
  var fmtH = function (h) { return (h < 10 ? Math.round(h * 10) / 10 : Math.round(h)) + 'h'; };
  var real = false;

  var UNITS = {
    google: ['Google Business updates', 1, 20], facebook: ['Facebook posts', 1, 20], instagram: ['Instagram posts', 1, 20],
    pinterest: ['Pinterest pins', 1, 15], tiktok: ['TikTok video scripts', 0.5, 45], youtube: ['YouTube Shorts scripts', 0.5, 45],
    reddit: ['helpful Reddit posts', 0.25, 30]
  };

  function plan() {
    var data = new FormData(form);
    var perWeek = parseInt(data.get('perweek'), 10) || 1;
    var articles = parseInt(data.get('articles'), 10) || 0;
    var perMonth = Math.round(perWeek * 52 / 12);
    var list = out('plan');
    list.textContent = '';
    var total = articles, minutes = articles * 120, ai = [];

    form.querySelectorAll('input[name=networks]:checked').forEach(function (cb) {
      if (cb.getAttribute('data-group') === 'ai') { ai.push(cb); return; }
      var u = UNITS[cb.value]; if (!u) return;
      var n = Math.max(1, Math.round(perMonth * u[1]));
      total += n; minutes += n * u[2];
      list.appendChild(row(cb, n + ' ' + u[0]));
    });
    if (articles) {
      var li = document.createElement('li');
      var ic = document.createElement('i'); ic.textContent = '📝'; ic.className = 'emoji';
      var t = document.createElement('span'); t.textContent = 'Website';
      var v = document.createElement('b'); v.textContent = articles + ' helpful article' + (articles === 1 ? '' : 's');
      li.appendChild(ic); li.appendChild(t); li.appendChild(v); list.appendChild(li);
    }
    if (ai.length) {
      var names = ai.map(function (cb) { return cb.getAttribute('data-label'); });
      var li2 = row(ai[0], articles ? 'Found through your articles & updates' : 'Add articles to be found', names.length > 1 ? names[0] + ' +' + (names.length - 1) : names[0]);
      li2.className = 'ai';
      list.appendChild(li2);
    }
    if (!list.children.length) {
      var empty = document.createElement('li'); empty.className = 'empty'; empty.textContent = 'Choose where you want to be found.'; list.appendChild(empty);
    }
    var diy = minutes / 60;
    setText('perweek', perWeek + ' / week');
    setText('articles', String(articles));
    setText('total', String(total));
    setText('diy', fmtH(diy));
    setText('saved', fmtH(Math.max(0, diy - total * 4 / 60)));
  }

  function row(cb, value, name) {
    var li = document.createElement('li');
    var ic = document.createElement('i');
    ic.textContent = cb.getAttribute('data-icon');
    ic.style.background = cb.getAttribute('data-color');
    var t = document.createElement('span'); t.textContent = name || cb.getAttribute('data-label');
    var v = document.createElement('b'); v.textContent = value;
    li.appendChild(ic); li.appendChild(t); li.appendChild(v);
    return li;
  }

  function showSite(site) {
    real = true;
    root.classList.add('is-real');
    setText('badge', 'Your report');
    setText('when', 'Checked just now');
    setText('site', site.name || site.domain);
    setText('sub', site.name ? site.domain : 'Your website');
    setText('initial', (site.name || site.domain || '?').charAt(0).toUpperCase());
    var list = out('findings'); list.textContent = '';
    var ring = root.querySelector('[data-ring]');
    if (site.unreachable) {
      setText('score', '–'); ring.style.setProperty('--p', 0);
      setText('band', "We couldn't read your site right now");
      setText('bandtext', 'Your content plan below is based on your answers.');
      var li = document.createElement('li'); li.className = 'info'; li.textContent = 'Website check unavailable for ' + site.domain; list.appendChild(li);
      setText('gap', "ContentVendor's free AI tools write your posts, articles and Google updates for you.");
    } else {
      var checks = [
        [site.https, 'Secure website (HTTPS)', 'a secure website', 10],
        [site.description, 'Search description for Google', 'a search description', 15],
        [site.blog, 'Blog or helpful articles', 'helpful articles', 25],
        [site.facebook, 'Facebook page linked', 'Facebook', 15],
        [site.instagram, 'Instagram linked', 'Instagram', 10],
        [site.google, 'Google Business Profile linked', 'a Google Business Profile link', 25]
      ];
      var score = 0, missing = [];
      checks.forEach(function (c) {
        var li = document.createElement('li'); li.className = c[0] ? 'ok' : 'miss'; li.textContent = c[1]; list.appendChild(li);
        if (c[0]) score += c[3]; else missing.push(c[2]);
      });
      setText('score', String(score)); ring.style.setProperty('--p', score);
      setText('band', score >= 70 ? 'Strong: now stay consistent' : score >= 40 ? 'Fair: gaps competitors can use' : 'Low: customers may not find you');
      setText('bandtext', missing.length ? 'Missing ' + missing.slice(0, 3).join(', ') + (missing.length > 3 ? ' and more' : '') + '.' : 'Your website covers the basics.');
      setText('gap', missing.length
        ? "ContentVendor's free tools help you fill these gaps and post consistently, so customers and AI assistants find you."
        : 'Great foundation. Fresh, regular content is what keeps you ahead. Start free and stay consistent.');
    }
    ctaSample.hidden = true; ctaReal.hidden = false;
  }

  root.querySelector('[data-focus-url]').addEventListener('click', function () {
    input.scrollIntoView({ behavior: 'smooth', block: 'center' });
    input.focus({ preventScroll: true });
    input.parentNode.classList.add('pulse');
    setTimeout(function () { input.parentNode.classList.remove('pulse'); }, 1200);
  });
  form.addEventListener('input', plan);
  form.addEventListener('change', plan);
  form.addEventListener('submit', function (ev) {
    ev.preventDefault();
    var value = input.value.trim();
    errEl.hidden = true;
    if (!/^(https?:\/\/)?[^\s\/]+\.[a-z]{2,}(\/\S*)?$/i.test(value)) {
      errEl.textContent = 'Enter your website address, like yourbusiness.com.';
      errEl.hidden = false; input.focus(); return;
    }
    setText('checking', value.replace(/^https?:\/\//i, '').replace(/\/.*$/, ''));
    loading.hidden = false; report.hidden = true; btn.disabled = true;
    var body = new FormData();
    body.append('website', value);
    body.append('_csrf', form.querySelector('[name=_csrf]').value);
    var minWait = new Promise(function (r) { setTimeout(r, 900); });
    Promise.all([fetch(scanUrl, { method: 'POST', body: body, credentials: 'same-origin' }).then(function (r) { return r.json(); }), minWait])
      .then(function (res) {
        res = res[0];
        if (!res || !res.site) {
          errEl.textContent = (res && res.error) || 'Something went wrong. Please try again.';
          errEl.hidden = false; return;
        }
        showSite(res.site); plan();
        if (window.matchMedia('(max-width: 1000px)').matches) report.scrollIntoView({ behavior: 'smooth', block: 'start' });
      })
      .catch(function () { errEl.textContent = 'Something went wrong. Please try again.'; errEl.hidden = false; })
      .then(function () { loading.hidden = true; report.hidden = false; btn.disabled = false; });
  });
  plan();
})();

// Tools showcase: filter, select, auto-rotate until the visitor interacts
(function () {
  var root = document.querySelector('[data-tools]');
  if (!root) return;
  var items = Array.prototype.slice.call(root.querySelectorAll('.tl-item'));
  var panes = {};
  root.querySelectorAll('.tl-pane').forEach(function (p) { panes[p.getAttribute('data-pane')] = p; });
  var filters = document.querySelectorAll('.tl-filter button');
  var timer = null, userActed = false;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function select(item, fromUser) {
    items.forEach(function (i) { i.classList.toggle('on', i === item); i.setAttribute('aria-current', i === item ? 'true' : 'false'); });
    Object.keys(panes).forEach(function (k) {
      var p = panes[k], on = k === item.getAttribute('data-tool');
      p.hidden = !on; p.classList.toggle('on', on); p.classList.remove('play');
      if (on) { void p.offsetWidth; p.classList.add('play'); }
    });
    var list = item.parentNode;
    if (list.scrollWidth > list.clientWidth) {
      list.scrollTo({ left: item.offsetLeft - list.offsetLeft - 8, behavior: fromUser ? 'smooth' : 'auto' });
    } else if (fromUser === false && list.scrollHeight > list.clientHeight) {
      var top = item.offsetTop - list.offsetTop;
      if (top < list.scrollTop || top > list.scrollTop + list.clientHeight - item.offsetHeight) list.scrollTo({ top: top - 8, behavior: 'smooth' });
    }
  }
  function visible() { return items.filter(function (i) { return !i.hidden; }); }
  function stop() { userActed = true; if (timer) { clearInterval(timer); timer = null; } }
  function start() {
    if (reduce || userActed || timer) return;
    timer = setInterval(function () {
      var v = visible(); var cur = v.indexOf(root.querySelector('.tl-item.on'));
      select(v[(cur + 1) % v.length], false);
    }, 4500);
  }

  items.forEach(function (i) { i.addEventListener('click', function () { stop(); select(i, true); }); });
  filters.forEach(function (f) {
    f.addEventListener('click', function () {
      stop();
      filters.forEach(function (x) { x.classList.toggle('on', x === f); });
      var tier = f.getAttribute('data-filter');
      items.forEach(function (i) { i.hidden = tier !== 'all' && i.getAttribute('data-tier') !== tier; });
      select(visible()[0], true);
    });
  });
  root.addEventListener('mouseenter', function () { if (timer) { clearInterval(timer); timer = null; } });
  root.addEventListener('mouseleave', function () { start(); });
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) start(); else if (timer) { clearInterval(timer); timer = null; } });
    }, { threshold: 0.35 }).observe(root);
  }
})();

// App sidebar (mobile open/close)
(function () {
  var openBtn = document.querySelector('[data-sb-open]');
  if (!openBtn) return;
  var set = function (open) {
    document.body.classList.toggle('sb-open', open);
    openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) { var first = document.querySelector('#sidebar .sb-link, #sidebar .sb-cta'); if (first) first.focus(); }
  };
  openBtn.addEventListener('click', function () { set(true); });
  document.querySelectorAll('[data-sb-close]').forEach(function (el) { el.addEventListener('click', function () { set(false); openBtn.focus(); }); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && document.body.classList.contains('sb-open')) { set(false); openBtn.focus(); } });
})();

// Plan creator: live summary
(function () {
  var form = document.querySelector('[data-plan-form]');
  if (!form) return;
  var out = form.querySelector('[data-plan-sum]');
  var per = { 5: 1, 15: 1, 30: 2, 60: 3 };
  function upd() {
    var days = form.querySelectorAll('input[name="days[]"]:checked').length;
    var plats = form.querySelectorAll('input[name="platforms[]"]:checked').length;
    var m = parseInt((form.querySelector('input[name=minutes]:checked') || {}).value || '15', 10);
    var perWeek = days * per[m];
    if (m === 5 && days > 3) perWeek = Math.ceil(days / 2);
    out.textContent = (!plats || !days) ? 'Pick at least one platform and one day'
      : 'About ' + perWeek + ' task' + (perWeek === 1 ? '' : 's') + ' a week across ' + plats + ' platform' + (plats === 1 ? '' : 's');
  }
  form.addEventListener('change', upd); upd();
})();

// My platforms: enforce plan limit and save as soon as a switch changes
(function () {
  var form = document.querySelector('[data-pf]');
  if (!form) return;
  var limit = parseInt(form.getAttribute('data-limit'), 10) || 1;
  var inputs = Array.prototype.slice.call(form.querySelectorAll('.pf-input'));
  var used = document.querySelector('[data-pf-used]');
  var count = document.querySelector('[data-pf-count]');
  function refresh() {
    var on = inputs.filter(function (i) { return i.checked; }).length;
    if (used) used.textContent = on;
    if (count) count.classList.toggle('is-full', on >= limit && limit < inputs.length);
    var hint = form.querySelector('[data-pf-hint]');
    if (hint) hint.hidden = !(on >= limit && limit < inputs.length);
    inputs.forEach(function (i) {
      var row = i.closest('.pf-row'), lock = row.querySelector('.pf-lock');
      var blocked = !i.checked && on >= limit;
      i.disabled = blocked;
      row.classList.toggle('is-disabled', blocked);
      if (lock) lock.hidden = !blocked;
    });
  }
  inputs.forEach(function (i) {
    i.addEventListener('change', function () { refresh(); form.submit(); });
  });
  refresh();
})();
