<?php
if ($me = current_user()) redirect(home_path_for($me));
render('signup', ['title' => 'Create your free account']);
