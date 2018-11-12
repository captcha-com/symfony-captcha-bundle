<?php

namespace Captcha\Bundle\CaptchaBundle\Support;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Captcha\Bundle\CaptchaBundle\Support\Exception\FileNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SimpleLibraryLoader
{
    /*
     * @var object
     */
    private $container;

    /**
     * Constructor.
     * 
     * @param ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Load BotDetect CAPTCHA Library and override Captcha Library settings.
     */
    public function load()
    {
        // load bd php library
        self::loadBotDetectLibrary();
    }

    /**
     * Load BotDetect CAPTCHA Library.
     */
    private function loadBotDetectLibrary()
    {
        $libPath = Path::getCaptchaLibPath($this->container);

        if (!self::isLibraryFound($libPath)) {
            throw new FileNotFoundException(sprintf('The BotDetect Captcha library could not be found in %s.', $libPath));
        }
        
        self::includeFile(Path::getSimpleBotDetectFilePath(), true, $libPath);
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
