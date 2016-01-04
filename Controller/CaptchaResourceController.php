<?php

namespace Captcha\Bundle\CaptchaBundle\Controller;

use Captcha\Bundle\CaptchaBundle\Config\Path;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaResourceController extends Controller
{
    /**
     * Get contents of Captcha resources (js, css, gif files).
     *
     * @param string  $fileName
     * 
     * @throws BadRequestHttpException 
     */
    public function getResourceAction($fileName)
    {
        if (!preg_match('/^[a-z_]+\.(css|gif|js)$/', $fileName)) {
            throw new BadRequestHttpException('Invalid file name.');
        }

        $resourcePath = realpath(Path::getPublicDirPathInLibrary() . $fileName);

        if (!is_file($resourcePath)) {
            throw new BadRequestHttpException(sprintf('File "%s" could not be found.', $fileName));
        }

        // captcha resource file information
        $fileInfo = pathinfo($resourcePath);
        $fileContents = file_get_contents($resourcePath);
        $mimeType = self::getMimeType($fileInfo['extension']);

        return new Response(
            $fileContents,
            200,
            array('content-type' => $mimeType)
        );
    }

    /**
     * Mime type information.
     *
     * @param string  $ext
     * 
     * @return string
     */
    private static function getMimeType($ext)
    {
        $mimes = array(
            'css' => 'text/css',
            'gif' => 'image/gif',
            'js'  => 'application/x-javascript'
        );

        return (in_array($ext, array_keys($mimes))) ? $mimes[$ext] : '';
    }
}
