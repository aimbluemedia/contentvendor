<?php
$doc = $path === 'terms' ? 'terms' : 'privacy';
render('legal', [
    'title'    => $doc === 'terms' ? 'Terms of Service' : 'Privacy Policy',
    'doc'      => $doc,
    'sections' => $doc === 'terms' ? legal_terms() : legal_privacy(),
]);
