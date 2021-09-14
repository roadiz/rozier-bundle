<?php
declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\EventSubscriber;

use Doctrine\Common\Cache\CacheProvider;
use RZ\Roadiz\CoreBundle\Event\Node\NodeDeletedEvent;
use RZ\Roadiz\CoreBundle\Event\Node\NodeUndeletedEvent;
use RZ\Roadiz\CoreBundle\Event\Node\NodeUpdatedEvent;
use RZ\Roadiz\CoreBundle\Event\NodesSources\NodesSourcesCreatedEvent;
use RZ\Roadiz\CoreBundle\Event\NodesSources\NodesSourcesDeletedEvent;
use RZ\Roadiz\CoreBundle\Event\Translation\TranslationDeletedEvent;
use RZ\Roadiz\CoreBundle\Event\Translation\TranslationUpdatedEvent;
use RZ\Roadiz\CoreBundle\Event\UrlAlias\UrlAliasCreatedEvent;
use RZ\Roadiz\CoreBundle\Event\UrlAlias\UrlAliasDeletedEvent;
use RZ\Roadiz\CoreBundle\Event\UrlAlias\UrlAliasUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribe to Node, NodesSources and UrlAlias event to clear ns url cache.
 */
class NodesSourcesUrlSubscriber implements EventSubscriberInterface
{
    protected CacheProvider $cacheProvider;

    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    public static function getSubscribedEvents()
    {
        return [
            NodesSourcesCreatedEvent::class => 'purgeNSUrlCache',
            NodesSourcesDeletedEvent::class => 'purgeNSUrlCache',
            TranslationUpdatedEvent::class => 'purgeNSUrlCache',
            TranslationDeletedEvent::class => 'purgeNSUrlCache',
            NodeDeletedEvent::class => 'purgeNSUrlCache',
            NodeUndeletedEvent::class => 'purgeNSUrlCache',
            NodeUpdatedEvent::class => 'purgeNSUrlCache',
            UrlAliasCreatedEvent::class => 'purgeNSUrlCache',
            UrlAliasUpdatedEvent::class => 'purgeNSUrlCache',
            UrlAliasDeletedEvent::class => 'purgeNSUrlCache',
        ];
    }

    /**
     * Empty nodeSources Url cache
     */
    public function purgeNSUrlCache()
    {
        $this->cacheProvider->deleteAll();
    }
}
