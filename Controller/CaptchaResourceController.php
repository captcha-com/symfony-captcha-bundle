<?php

namespace Captcha\Bundle\CaptchaBundle\Controller;

use Captcha\Bundle\CaptchaBundle\Support\Path;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaResourceController extends Controller
{
    /**
     * Get contents of Captcha resources (js, css, gif files).
     *
     * @param string  $filename
     * 
     * @throws BadRequestHttpException 
     */
    public function indexAction($filename)
    {
        if (!preg_match('/^[a-z-]+\.(css|gif|js)$/', $filename)) {
            throw new BadRequestHttpException('Invalid file name.');
        }

        $resourcePath = realpath(Path::getPublicDirPathInLibrary() . $filename);

        if (!is_file($resourcePath)) {
            throw new BadRequestHttpException(sprintf('File "%s" could not be found.', $filename));
        }

        $mimesType = array('css' => 'text/css', 'gif' => 'image/gif', 'js'  => 'application/x-javascript');
        $fileInfo = pathinfo($resourcePath);

        return new Response(
            file_get_contents($resourcePath),
            200,
            array('content-type' => $mimesType[$fileInfo['extension']])
        );
    }
}
