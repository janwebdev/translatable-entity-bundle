<?php

namespace Janwebdev\TranslatableEntityBundle\Tests;

use Doctrine\ORM\Proxy\Proxy;

class TranslatableProxy extends Translatable implements Proxy
{
    public function __load() {}
    public function __isInitialized(): bool {return true;}
    public function __setInitialized($initialized) {}
    public function __setInitializer(\Closure $initializer = null) {}
    public function __getInitializer() {}
    public function __setCloner(\Closure $cloner = null) {}
    public function __getCloner() {}
    public function __getLazyProperties(): array {return [];}
}
