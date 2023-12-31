<?php

namespace iboxs\swoole;

class App extends \iboxs\App
{
    protected $inConsole = true;

    public function setInConsole($inConsole = true)
    {
        $this->inConsole = $inConsole;
    }

    public function runningInConsole(): bool
    {
        return $this->inConsole;
    }

    public function clearInstances()
    {
        $this->instances = [];
    }
}
