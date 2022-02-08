<?php

declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\Controller;

use Psr\Log\LoggerInterface;
use RZ\Roadiz\CompatBundle\Controller\AppController;
use RZ\Roadiz\Core\Models\FileAwareInterface;
use RZ\Roadiz\CoreBundle\Bag\NodeTypes;
use RZ\Roadiz\CoreBundle\Bag\Roles;
use RZ\Roadiz\CoreBundle\Bag\Settings;
use RZ\Roadiz\CoreBundle\Mailer\EmailManager;
use RZ\Roadiz\OpenId\OAuth2LinkGenerator;
use RZ\Roadiz\Utils\Asset\Packages;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Themes\Rozier\RozierServiceRegistry;

/**
 * Special controller app file for backend themes.
 *
 * This AppController implementation will use a security scheme
 */
abstract class BackendController extends AppController
{
    protected static bool $backendTheme = true;
    public static int $priority = -10;

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'securityAuthenticationUtils' => AuthenticationUtils::class,
            'urlGenerator' => UrlGeneratorInterface::class,
            EmailManager::class => EmailManager::class,
            'logger' => LoggerInterface::class,
            'kernel' => KernelInterface::class,
            'settingsBag' => Settings::class,
            'nodeTypesBag' => NodeTypes::class,
            'rolesBag' => Roles::class,
            'assetPackages' => Packages::class,
            'csrfTokenManager' => CsrfTokenManagerInterface::class,
            OAuth2LinkGenerator::class => OAuth2LinkGenerator::class,
            FileAwareInterface::class => FileAwareInterface::class,
            RozierServiceRegistry::class => RozierServiceRegistry::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function createEntityListManager($entity, array $criteria = [], array $ordering = [])
    {
        return parent::createEntityListManager($entity, $criteria, $ordering)
            ->setDisplayingNotPublishedNodes(true);
    }
}
