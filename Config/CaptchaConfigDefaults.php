<?php

use Captcha\Bundle\CaptchaBundle\Routing\Generator\UrlGenerator;

$captchaUrlGenerator = UrlGenerator::getInstance();

// generate Absolute URLs
$LBD_Resource_Url = $captchaUrlGenerator->generate('captcha_resource', array(), true) . '/';
$LBD_Handler_Url = $captchaUrlGenerator->generate('captcha_handler', array(), true);

// config captcha resources
$LBD_CaptchaConfig = \CaptchaConfiguration::GetSettings();
$LBD_CaptchaConfig->HandlerUrl =  $LBD_Handler_Url;
$LBD_CaptchaConfig->ReloadIconUrl = $LBD_Resource_Url . 'lbd_reload_icon.gif';
$LBD_CaptchaConfig->SoundIconUrl = $LBD_Resource_Url . 'lbd_sound_icon.gif';
$LBD_CaptchaConfig->LayoutStylesheetUrl = $LBD_Resource_Url . 'lbd_layout.css';
$LBD_CaptchaConfig->ScriptIncludeUrl = $LBD_Resource_Url . 'lbd_scripts.js';

// use Symfony sessions to store persist Captcha codes and other Captcha data
$LBD_CaptchaConfig->SaveFunctionName = 'SF_Session_Save';
$LBD_CaptchaConfig->LoadFunctionName = 'SF_Session_Load';
$LBD_CaptchaConfig->ClearFunctionName = 'SF_Session_Clear';

// re-define custom session handler functions
global $session;
$session = $includeData;

function SF_Session_Save($key, $value)
{
    global $session;
    // save the given value with the given string key
    $session->set($key, serialize($value));
}

function SF_Session_Load($key)
{
    global $session;
    // load persisted value for the given string key
    if ($session->has($key)) {
        return unserialize($session->get($key)); // NOTE: returns false in case of failure
    }
}

function SF_Session_Clear($key)
{
    global $session;
    // clear persisted value for the given string key
    if ($session->has($key)) {
        $session->remove($key);
    }
}
