<?php

namespace iboxs\swoole\concerns;

use Closure;
use iboxs\App;
use iboxs\swoole\App as SwooleApp;
use iboxs\swoole\Manager;
use iboxs\swoole\pool\Cache;
use iboxs\swoole\pool\Db;
use iboxs\swoole\Sandbox;
use Throwable;

/**
 * Trait WithApplication
 * @package iboxs\swoole\concerns
 * @property App $container
 */
trait WithApplication
{
    /**
     * @var SwooleApp
     */
    protected $app;

    protected function prepareApplication(string $envName)
    {
        if (!$this->app instanceof SwooleApp) {
            $this->app = new SwooleApp($this->container->getRootPath());
            $this->app->setEnvName($envName);
            $this->app->bind(SwooleApp::class, App::class);
            $this->app->bind(Manager::class, $this);
            //绑定连接池
            if ($this->getConfig('pool.db.enable', true)) {
                $this->app->bind('db', Db::class);
                $this->app->resolving(Db::class, function (Db $db) {
                    $db->setLog($this->container->log);
                });
            }
            if ($this->getConfig('pool.cache.enable', true)) {
                $this->app->bind('cache', Cache::class);
            }
            $this->app->initialize();
            $this->app->instance('request', $this->container->request);
            $this->prepareConcretes();
        }
    }

    /**
     * 预加载
     */
    protected function prepareConcretes()
    {
        $defaultConcretes = ['db', 'cache', 'event'];

        $concretes = array_merge($defaultConcretes, $this->getConfig('concretes', []));

        foreach ($concretes as $concrete) {
            $this->app->make($concrete);
        }
    }

    public function getApplication()
    {
        return $this->app;
    }

    /**
     * 获取沙箱
     * @return Sandbox
     */
    protected function getSandbox()
    {
        return $this->app->make(Sandbox::class);
    }

    /**
     * 在沙箱中执行
     * @param Closure $callable
     */
    public function runInSandbox(Closure $callable)
    {
        try {
            $this->getSandbox()->run($callable);
        } catch (Throwable $e) {
            $this->logServerError($e);
        }
    }
}
