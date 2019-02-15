<?php
session_start();
require('php-captcha.inc.php');
$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
$oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60);
#$oVisualCaptcha->SetOwnerText('Source: www.vaci.ge');
#$oVisualCaptcha->SetWidth(100);
$oVisualCaptcha->Create();
?>