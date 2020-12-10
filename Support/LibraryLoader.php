<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Captcha\Bundle\CaptchaBundle\Support\Exception\FileNotFoundException;
use Psr\Container\ContainerInterface;

class LibraryLoader
{
    /*
     * @var object
     */
    private $container;

    /*
     * @var object
     */
    private $session;

    /**
     * Constructor.
     * 
     * @param ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->session = $this->container->get('session');
    }

    /**
     * Load BotDetect CAPTCHA Library and override Captcha Library settings.
     */
    public function load()
    {
        // load bd php library
        self::loadBotDetectLibrary();

        // load the captcha configuration defaults
        self::loadCaptchaConfigDefaults();
    }

    private function loadBotDetectLibrary()
    {
        $libPath = Path::getDefaultLibPackageDirPath();
        
        if (!self::isLibraryFound($libPath)) {
            throw new FileNotFoundException(sprintf('The BotDetect Captcha library could not be found in %s.', $libPath));
        }

        self::includeFile(Path::getBotDetectFilePath(), true, $libPath);
    }

    private function loadCaptchaConfigDefaults()
    {
        self::includeFile(Path::getCaptchaConfigDefaultsFilePath(), true, $this->session);
    }

    /**
     * Check if the path to Captcha library is correct or not
     */
    private static function isLibraryFound($libPath)
    {
        return file_exists($libPath . '/botdetect/CaptchaIncludes.php');
    }

    /**
     * Include a file.
     *
     * @param string  $filePath
     * @param bool    $once
     * @param string  $includeData
     */
    private static function includeFile($filePath, $once = false, $includeData = null)
    {
        if (is_file($filePath)) {
            ($once) ? include_once($filePath) : include($filePath);
        }
    }
}
