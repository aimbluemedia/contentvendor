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
