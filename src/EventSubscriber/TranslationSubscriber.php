<?php
declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\EventSubscriber;

use Doctrine\Common\Cache\CacheProvider;
use RZ\Roadiz\CoreBundle\Event\Translation\TranslationCreatedEvent;
use RZ\Roadiz\CoreBundle\Event\Translation\TranslationDeletedEvent;
use RZ\Roadiz\CoreBundle\Event\Translation\TranslationUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribe to Translation event to clear result cache.
 */
class TranslationSubscriber implements EventSubscriberInterface
{
    protected CacheProvider $cacheProvider;

    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    public static function getSubscribedEvents()
    {
        return [
            TranslationCreatedEvent::class => 'purgeCache',
            TranslationUpdatedEvent::class => 'purgeCache',
            TranslationDeletedEvent::class => 'purgeCache',
        ];
    }

    /**
     * Empty nodeSources Url cache
     */
    public function purgeCache()
    {
        $this->cacheProvider->deleteAll();
    }
}
