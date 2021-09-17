# rozier-bundle

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require roadiz/rozier-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require roadiz/rozier-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    \RZ\Roadiz\RozierBundle\RoadizRozierBundle::class => ['all' => true],
];
```

## Configuration

- Copy `config/packages/roadiz_rozier.yaml` to your Symfony app `config/packages` folder.
- Add assets path
```yaml
# config/packages/framework.yaml
framework:
    assets:
        packages:
            Rozier:
                base_path: '/themes/Rozier/static'
```
- Add custom `Twig` paths:
```yaml
# config/packages/twig.yaml
twig:
    default_path: '%kernel.project_dir%/vendor/roadiz/rozier/src/Resources/views'
    strict_variables: false
    paths:
        '%kernel.project_dir%/vendor/roadiz/rozier/src/Resources/views': Rozier
        '%kernel.project_dir%/templates': ~
```
- Add custom `security` configuration:

```yaml
# config/packages/security.yaml
security:
    enable_authenticator_manager: true
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface:
            algorithm: auto

    providers:
        roadiz_user_provider:
            entity:
                class: RZ\Roadiz\CoreBundle\Entity\User
                property: username

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: roadiz_user_provider
            # activate different ways to authenticate
            # https://symfony.com/doc/current/security.html#firewalls-authentication

            # https://symfony.com/doc/current/security/impersonating_user.html
            switch_user: true
            logout:
                path: logoutPage
            custom_authenticator: RZ\Roadiz\RozierBundle\Security\RozierAuthenticator

    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        - { path: ^/rz-admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/rz-admin, roles: ROLE_BACKEND_USER }
```
- Add custom routes:
```yaml
# config/routes.yaml
roadiz_core:
    resource: "@RoadizCoreBundle/Resources/config/routing.yaml"

roadiz_rozier:
    resource: "@RoadizRozierBundle/Resources/config/routing.yaml"

rz_intervention_request:
    resource: "@RZInterventionRequestBundle/Resources/config/routing.yml"
    prefix:   /
```
- Add custom translations
```yaml
# config/packages/translation.yaml
framework:
    translator:
        paths:
            - '%kernel.project_dir%/vendor/roadiz/rozier/src/Resources/translations'
```
