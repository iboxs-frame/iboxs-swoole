<?php

namespace iboxs\swoole;

/**
 * @mixin \iboxs\swoole\lock\Table
 */
class Lock extends \iboxs\Manager
{
    protected $namespace = "\\iboxs\\swoole\\lock\\";

    protected function resolveConfig(string $name)
    {
        return $this->app->config->get("swoole.lock.{$name}", []);
    }

    /**
     * 默认驱动
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return $this->app->config->get('swoole.lock.type', 'table');
    }
}
