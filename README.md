# ATTENTION!!! This library is not the official one, but since the official one does not seem to have support anymore I've decided to fully update it so it's working again for newer Symfony versions. I haven't put any efforts on making it compatible with Symfony 4 or older versions, but contributions are welcome.


# BotDetect PHP Captcha generator integration for the Symfony 5 framework (possibly on Symfony 4.4 too)

[![Total Downloads](https://poser.pugx.org/carlos-mg89/symfony-captcha-bundle/downloads)](https://packagist.org/packages/carlos-mg89/symfony-captcha-bundle)
[![Latest Stable Version](https://poser.pugx.org/carlos-mg89/symfony-captcha-bundle/v/stable)](https://packagist.org/packages/carlos-mg89/symfony-captcha-bundle)

![BotDetect PHP CAPTCHA Library](https://captcha.com/images/help/screenshots/captcha-examples.png)


## BotDetect Symfony CAPTCHA integration on captcha.com

* [Symfony Captcha Integration Quickstart](https://captcha.com/doc/php/symfony-captcha-bundle-quickstart.html)
* [Symfony Application](https://captcha.com/doc/php/howto/symfony-captcha-bundle.html)
* [Symfony Captcha Api Basics Example](https://captcha.com/doc/php/examples/symfony-basic-captcha-bundle-example.html)
* [Symfony Captcha Form Model Validation Example](https://captcha.com/doc/php/examples/symfony-form-validation-captcha-bundle-example.html)
* [Symfony Captcha FOSUserBundle Example](https://captcha.com/doc/php/examples/symfony-fosuserbundle-captcha-example.html)


## Other BotDetect PHP Captcha integrations

* [Plain PHP Captcha Integration](https://captcha.com/doc/php/php-captcha-quickstart.html)
* [WordPress Captcha Plugin](https://captcha.com/doc/php/wordpress-captcha.html)
* [CakePHP Captcha Integration](https://captcha.com/doc/php/cakephp-captcha-quickstart.html)
* [CodeIgniter Captcha Integration](https://captcha.com/doc/php/codeigniter-captcha-quickstart.html)
* [Laravel Captcha Integration](https://captcha.com/doc/php/laravel-captcha-quickstart.html)


## Questions?

If you encounter bugs, implementation issues, a usage scenario you would like to discuss, or you have any questions, please contact [BotDetect CAPTCHA Support](http://captcha.com/support).

# How to install with Composer

Simply run `composer require carlos-mg89/symfony-captcha-bundle`

# Usage example in a Symfony 5.x project

1. Install dependency with Composer as explained above
2. Add the following in your `config/routes.yaml`:
   ```
   captcha_routing:
         resource: "@CaptchaBundle/Resources/config/routing.yml"
   ```
3. Create this file `config/packages/captcha.php` with the following content (or similar):
   ```
   <?php
    if (!class_exists('CaptchaConfiguration')) { return; }

    // You could have more than one object like ExampleCaptcha. For example, one for the login page, another for the register page, etc.
    return [
      'ExampleCaptcha' => [
        'UserInputID' => 'captchaCode',
        'CodeLength' => CaptchaRandomization::GetRandomCodeLength(5, 6),
        'ImageWidth' => 250,
        'ImageHeight' => 50,
      ],
    ];
   ```
 4. Edit your `config/services.yaml` so it autowires the controllers used in the library:
    ``` 
    # We need to autowire the Container (or manually wire it)
    services:
        Captcha\Bundle\CaptchaBundle\Controller\:
            resource: '../vendor/carlos-mg89/symfony-captcha-bundle/Controller'
            autowire: true
    ```
 5. Edit your `FormType` or your `FormBuilderInterface` with this bit that adds the captcha along with the constraing to validate the form:
    ```
    $builder->add('captchaCode', CaptchaType::class, [
        'captchaConfig' => 'ExampleCaptcha',
        'constraints' => [
            new ValidCaptcha([
                'message' => 'Invalid captcha, please try again',
            ]),
        ]
    ]);
    ```
 6. Now edit your Twig template with the new `captchaCode` (`CaptchaType`):
    ```
    {{ form_label(form.captchaCode) }}
    {{ form_widget(form.captchaCode}) }}
    ```
 7. Finally, add the Form validation:
    ```
    $contactForm = $this->createForm(ContactType::class);
    $contactForm->handleRequest($request);

    if ($contactForm->isSubmitted() && $contactForm->isValid()) {
        
        // Do whatever you want, be it register a user, send an email, etc

        $this->addFlash('success', $translator->trans('Contact.Form.SuccessMsg'));
    } elseif ($contactForm->isSubmitted() && !$contactForm->isValid()) {
        throw new Exception('Invalid form');
    }
    ```
 
 
 You have the original documentation here: https://captcha.com/doc/php/howto/symfony-captcha-bundle-integration.html#howto_display_captcha_config but it's not fully up to date nor complete.
