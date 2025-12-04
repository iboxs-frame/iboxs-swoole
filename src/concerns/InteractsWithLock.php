<?php

namespace iboxs\swoole\concerns;

use iboxs\App;
use iboxs\swoole\Lock;

/**
 * Trait InteractsWithLock
 * @package iboxs\swoole\concerns
 *
 * @property App $app
 * @property App $container
 */
trait InteractsWithLock
{
    /**
     * @var Lock
     */
    protected $lock;

    protected function prepareLock()
    {
        if ($this->getConfig('lock.enable', false)) {
            $this->lock = $this->container->make(Lock::class);
            $this->lock->prepare();

            $this->onEvent('workerStart', function () {
                $this->app->instance(Lock::class, $this->lock);
            });
        }
    }
}
