<?php

namespace G4\CleanCore\Bootstrap;

use G4\CleanCore\Request\Request;

class Factory
{
    private BootstrapInterface $bootstrap;

    private ?string $appNamespace = null;

    private string $fullBootstrapName;

    private ?Request $request = null;

    public function initBootstrap(): void
    {
            $this
                ->constructFullBootstrapName()
                ->bootstrapFactory();
        }

    public function getBootstrap(): BootstrapInterface
    {
        return $this->bootstrap;
    }

    public function setAppNamespace(string $appNamespace): self
    {
        $this->appNamespace = $appNamespace;
        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    private function constructFullBootstrapName(): self
    {
        $this->fullBootstrapName = implode('\\', [$this->appNamespace, 'Bootstrap']);
        return $this;
    }

    private function bootstrapExist(): bool
    {
        return class_exists($this->fullBootstrapName);
    }

    private function bootstrapFactory(): void
    {
        if ($this->bootstrapExist()) {
            $bootstrapName    = $this->fullBootstrapName;
            $this->bootstrap = new $bootstrapName();
            $this->bootstrap
                ->setRequest($this->request)
                ->init();
        }
    }
}
