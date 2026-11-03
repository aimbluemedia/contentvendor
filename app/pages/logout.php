<?php
if (is_post()) {
    csrf_check();
    logout_user();
}
redirect('');
