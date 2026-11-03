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

// Homepage content calculator
(function () {
  var root = document.querySelector('[data-calc]');
  if (!root) return;
  var form = root.querySelector('form');
  var base = (document.querySelector('.brand') || {}).getAttribute ? document.querySelector('.brand').getAttribute('href').replace(/[^/]*$/, '') : '/';
  var out = function (name) { return root.querySelector('[data-out="' + name + '"]'); };
  var set = function (name, html) { var el = out(name); if (el) el.innerHTML = html; };
  var fmtH = function (h) { return (h < 10 ? Math.round(h * 10) / 10 : Math.round(h)) + 'h'; };

  function calc() {
    var data = new FormData(form);
    var networks = data.getAll('networks').length || 1;
    var perWeek = parseInt(data.get('perweek'), 10) || 1;
    var articles = parseInt(data.get('articles'), 10) || 0;
    var who = data.get('who') || 'me';

    var campaigns = Math.round(perWeek * 52 / 12);
    var social = campaigns * networks;
    var total = social + articles;
    var diy = social * 20 / 60 + articles * 2;
    var withCv = total * 4 / 60;
    var saved = Math.max(0, diy - withCv);

    var plan, price, why, href;
    if (who === 'team') {
      if (campaigns <= 4) { plan = 'Content Starter'; price = '$299'; href = 'done-for-you?package=starter'; }
      else if (campaigns <= 8) { plan = 'Content Growth'; price = '$749'; href = 'done-for-you?package=growth'; }
      else { plan = 'Content Dominator'; price = '$999'; href = 'done-for-you?package=dominator'; }
      why = 'Our team writes, schedules and reports on ' + campaigns + ' campaigns a month. Premium is included.';
    } else if (total <= 5 && networks <= 3 && who === 'me') {
      plan = 'Starter'; price = '$0'; href = 'register';
      why = 'Free covers this. Copy and download every draft.';
    } else if (total <= 40 && social <= 30) {
      plan = 'Pro'; price = '$19'; href = 'register';
      why = 'Covers your monthly volume, with scheduling and repurposing included.';
    } else if (total <= 150 && social <= 150) {
      plan = 'Premium'; price = '$49'; href = 'register';
      why = 'Your volume needs Premium: 150 generations, the AI planner and recycling.';
    } else {
      plan = 'Content Dominator'; price = '$999'; href = 'done-for-you?package=dominator';
      why = 'That is more than 150 pieces a month. Our team can handle it for you.';
    }

    set('perweek', perWeek + ' / week');
    set('articles', String(articles));
    set('total', String(total));
    set('campaigns', String(campaigns));
    set('social', String(social));
    set('diy', fmtH(diy));
    set('saved', fmtH(saved));
    set('plan', plan);
    set('planwhy', why);
    set('price', price + '<small>/mo</small>');
    set('summary', 'Posting <b>' + perWeek + '× a week</b> on <b>' + networks + ' channel' + (networks === 1 ? '' : 's') + '</b>' +
      (articles ? ' plus <b>' + articles + ' article' + (articles === 1 ? '' : 's') + '</b>' : '') +
      ' means about <b>' + total + ' pieces</b> of content every month. That is ' + fmtH(diy) + ' of writing to do it yourself.');
    var ring = root.querySelector('[data-ring]');
    if (ring) ring.style.setProperty('--p', Math.min(100, Math.round(total / 150 * 100)));
    var cta = root.querySelector('[data-out-href="cta"]');
    if (cta) {
      cta.setAttribute('href', base + href);
      cta.textContent = (plan === 'Starter' ? 'Start free' : who === 'team' ? 'Request ' + plan : 'Start with ' + plan) + ' →';
    }
  }
  form.addEventListener('input', calc);
  form.addEventListener('change', calc);
  calc();
})();
