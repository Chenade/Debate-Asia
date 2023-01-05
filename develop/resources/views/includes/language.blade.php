<?php
    $lang = session('setLocale') ? session('setLocale') : app()->getLocale();
    App::setLocale($lang);
?>
