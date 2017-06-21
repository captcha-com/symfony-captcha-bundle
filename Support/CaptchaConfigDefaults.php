<?php

use Captcha\Bundle\CaptchaBundle\Routing\Generator\UrlGenerator;

$captchaUrlGenerator = UrlGenerator::getInstance();

$BotDetect = \CaptchaConfiguration::GetSettings();
$BotDetect->HandlerUrl =  $captchaUrlGenerator->generate('captcha_handler', array(), \Symfony\Component\Routing\Generator\UrlGeneratorInterface::RELATIVE_PATH);

// use Symfony sessions to store persist Captcha codes and other Captcha data
$BotDetect->SaveFunctionName = 'SF_Session_Save';
$BotDetect->LoadFunctionName = 'SF_Session_Load';
$BotDetect->ClearFunctionName = 'SF_Session_Clear';

\CaptchaConfiguration::SaveSettings($BotDetect);

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
