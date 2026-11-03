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

// Homepage content calculator with website check
(function () {
  var root = document.querySelector('[data-calc]');
  if (!root) return;
  var form = root.querySelector('form');
  var scanUrl = root.getAttribute('data-scan-url');
  var states = {};
  root.querySelectorAll('[data-state]').forEach(function (el) { states[el.getAttribute('data-state')] = el; });
  var out = function (n) { return root.querySelector('[data-out="' + n + '"]'); };
  var setText = function (n, t) { var el = out(n); if (el) el.textContent = t; };
  var fmtH = function (h) { return (h < 10 ? Math.round(h * 10) / 10 : Math.round(h)) + 'h'; };
  var errEl = root.querySelector('[data-scan-error]');
  var btn = root.querySelector('[data-scan-btn]');
  var site = null;

  function show(name) { Object.keys(states).forEach(function (k) { states[k].hidden = k !== name; }); }

  function numbers() {
    var data = new FormData(form);
    var networks = data.getAll('networks').length || 1;
    var perWeek = parseInt(data.get('perweek'), 10) || 1;
    var articles = parseInt(data.get('articles'), 10) || 0;
    var social = Math.round(perWeek * 52 / 12) * networks;
    var total = social + articles;
    var diy = social * 20 / 60 + articles * 2;
    var saved = Math.max(0, diy - total * 4 / 60);
    setText('perweek', perWeek + ' / week');
    setText('articles', String(articles));
    setText('total', String(total));
    setText('diy', fmtH(diy));
    setText('saved', fmtH(saved));
    setText('summary', 'Posting ' + perWeek + '× a week on ' + networks + ' channel' + (networks === 1 ? '' : 's') +
      (articles ? ' plus ' + articles + ' article' + (articles === 1 ? '' : 's') : '') + ' each month keeps your business active where customers search.');
  }

  function renderSite() {
    setText('site', site.name || site.domain);
    var list = out('findings');
    list.textContent = '';
    var missing = [];
    var add = function (ok, label, missingLabel) {
      var li = document.createElement('li');
      li.className = ok ? 'ok' : 'miss';
      li.textContent = label;
      list.appendChild(li);
      if (!ok && missingLabel) missing.push(missingLabel);
    };
    if (site.unreachable) {
      var li = document.createElement('li');
      li.className = 'info';
      li.textContent = "We couldn't read " + site.domain + ' right now, so this plan is based on your answers.';
      list.appendChild(li);
      setText('gap', "ContentVendor's free AI tools write your posts, articles and Google updates for you.");
      return;
    }
    add(site.https, 'Secure website (HTTPS)', 'a secure website');
    add(site.description, 'Search description for Google', 'a search description');
    add(site.blog, 'Blog or helpful articles', 'helpful articles');
    add(site.facebook, 'Facebook page linked', 'Facebook');
    add(site.instagram, 'Instagram linked', 'Instagram');
    add(site.google, 'Google Business Profile linked', 'a Google Business Profile link');
    setText('gap', missing.length
      ? 'Missing: ' + missing.join(', ') + ". ContentVendor's free tools help you fill these gaps and post consistently."
      : 'Great foundation. Now stay consistent, because regular fresh content is what keeps you ahead.');
  }

  form.addEventListener('input', function () { numbers(); });
  form.addEventListener('change', function () { numbers(); });
  form.addEventListener('submit', function (ev) {
    ev.preventDefault();
    var input = form.querySelector('[name=website]');
    var value = input.value.trim();
    errEl.hidden = true;
    if (!/^(https?:\/\/)?[^\s\/]+\.[a-z]{2,}(\/\S*)?$/i.test(value)) {
      errEl.textContent = 'Enter your website address, like yourbusiness.com.';
      errEl.hidden = false; input.focus(); return;
    }
    setText('checking', value.replace(/^https?:\/\//i, '').replace(/\/.*$/, ''));
    show('loading');
    btn.disabled = true;
    var body = new FormData();
    body.append('website', value);
    body.append('_csrf', form.querySelector('[name=_csrf]').value);
    fetch(scanUrl, { method: 'POST', body: body, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res || !res.site) {
          errEl.textContent = (res && res.error) || 'Something went wrong. Please try again.';
          errEl.hidden = false; show('empty'); return;
        }
        site = res.site;
        numbers(); renderSite(); show('result');
        if (window.matchMedia('(max-width: 1000px)').matches) states.result.scrollIntoView({ behavior: 'smooth', block: 'start' });
      })
      .catch(function () {
        errEl.textContent = 'Something went wrong. Please try again.';
        errEl.hidden = false; show('empty');
      })
      .then(function () { btn.disabled = false; });
  });
  numbers();
})();
