<?php

declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle;

final class Aliases
{
    /**
     * @return array<class-string, class-string>
     */
    public static function getAliases(): array
    {
        return [
            \RZ\Roadiz\RozierBundle\Controller\BackendController::class => \RZ\Roadiz\CMS\Controllers\BackendController::class,
        ];
    }
}
