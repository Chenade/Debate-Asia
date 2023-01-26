<?php
    $lang = session()->has('setLocale') ? session('setLocale') : env('DEFAULT_LANGUAGE', 'cn');
    App::setLocale($lang);
?>
