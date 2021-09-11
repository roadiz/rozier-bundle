<?php
declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RoadizRozierBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
