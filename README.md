# rozier-bundle


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
roadiz_rozier:
    resource: "@RoadizRozierBundle/Resources/config/routing.yaml"
```
- Add custom translations
```yaml
# config/packages/translation.yaml
framework:
    translator:
        paths:
            - '%kernel.project_dir%/vendor/roadiz/rozier/src/Resources/translations'
```
