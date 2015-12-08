<?php

namespace Captcha\Bundle\CaptchaBundle\Controller;

use Captcha\Bundle\CaptchaBundle\Helpers\CaptchaHandlerHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CaptchaHandlerController extends Controller
{
    /**
     * Handle request from querystring such as getting image, getting sound, etc.
     * 
     * @throws BadRequestHttpException
     */
    public function indexAction(Request $request)
    {
        $captchaId = $request->query->get('c');

        if (is_null($captchaId) || !preg_match('/^(\w+)$/ui', $captchaId)) {
            throw new BadRequestHttpException('command');
        }

        $captchaHandler = new CaptchaHandlerHelper(
            $this->get('session'),
            array('captcha_id' => $captchaId)
        );

        $captchaHandler->getCaptchaResponse();
    }
}
