<?php

/**
 * This internationalization (i18n) include file relies on the
 * pre-installd php-gettext package; on Debian systems, just do 
 * `apt install php-php-gettext`.
 *
 * Localization (l10n) should work smoothly event when some locale
 * is not installed at system level.
 **/

putenv("LANGUAGE="); //	PHP seems to honor too much this variable!

// depends on the package php-php-gettext!
include_once "/usr/share/php/php-php-gettext/gettext.inc";

// test a LANG environment variable eventually given to the browser
$wanted1 = getenv("LANG");

// test the browser's preferred language
$wanted2 = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ?  $_SERVER['HTTP_ACCEPT_LANGUAGE']: false;

// test a GET parameter such as "lang"
$wanted3 = !empty($_GET["lang"]) ? $_GET["lang"]: false;

// test a cookie named preferred_language
$wanted4 = !empty($_COOKIE["preferred_language"]) ? $_COOKIE["preferred_language"] : false;

if ($wanted1) $lang = $wanted1;
if ($wanted2) $lang = $wanted2;
if ($wanted3) $lang = $wanted3;
if ($wanted4) $lang = $wanted4;

switch (substr($lang, 0, 2)) {
case "en":
    $lang = "en_US.UTF-8";
    $_COOKIE["preferred_language"] = "en_US.UTF-8";
    break;
case "ru":
    $lang = "ru_RU.UTF-8";
    $_COOKIE["preferred_language"] = "ru_RU.UTF-8";
    break;
default:
    $lang = "fr_FR.UTF-8";
    $_COOKIE["preferred_language"] = "fr_FR.UTF-8";
    break;
}

$locale = T_setlocale(LC_MESSAGES, $lang); // this only works for enabled locales

bindtextdomain("crustula", "./lang/locale");
bind_textdomain_codeset("crustula", "utf-8");
textdomain("crustula");

function N_($msg) {
    // used to mark a string litteral as translatable, without translating it
    return $msg;
}

header("Cache-Control: no-cache");
header("Cache-Control: max-age=0");
header("Content-type: text/html; charset=utf-8");

// no closing tag at the end of the file to prevent errors.
