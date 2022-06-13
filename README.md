# Roadiz Rozier bundle
**Legacy administration interface port to Roadiz v2**

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
- Disable Twig `strict_variables`
- Add custom `security` configuration:
```yaml
# config/packages/security.yaml
security:
    enable_authenticator_manager: true
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface:
            algorithm: auto
    providers:
        openid_user_provider:
            id: RZ\Roadiz\OpenId\Authentication\Provider\OpenIdAccountProvider
        roadiz_user_provider:
            entity:
                class: RZ\Roadiz\CoreBundle\Entity\User
                property: username
        all_users:
            chain:
                providers: [ 'openid_user_provider', 'roadiz_user_provider' ]

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: all_users
            switch_user: { role: ROLE_SUPERADMIN, parameter: _su }
            logout:
                path: logoutPage
            custom_authenticator:
                - RZ\Roadiz\RozierBundle\Security\RozierAuthenticator
    access_control:
        - { path: ^/rz-admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/rz-admin, roles: ROLE_BACKEND_USER }
```
- Add custom routes:
```yaml
# config/routes.yaml
roadiz_rozier:
    resource: "@RoadizRozierBundle/config/routing.yaml"

rz_intervention_request:
    resource: "@RZInterventionRequestBundle/Resources/config/routing.yml"
    prefix:   /
```
