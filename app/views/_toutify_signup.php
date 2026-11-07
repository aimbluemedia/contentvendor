<div data-toutify-signup data-client-id="contentvendor" data-login-url="<?= e(url('auth/toutify/login')) ?>" data-title="<?= e($signupTitle ?? 'Create your free account') ?>" data-button="<?= e($signupButton ?? 'Join Free Today') ?>" data-accent="#15803d"></div>
<script src="https://toutify.com/embed/signup.js" async></script>
<p class="signup-fallback small muted">Form not loading? <a href="<?= e(url('auth/toutify/login?signup=1')) ?>">Create your account on Toutify →</a></p>
