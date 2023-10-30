<?php

namespace G4\CleanCore\Bootstrap;

use G4\CleanCore\Request\Request;

class Factory
{
    /** @var BootstrapInterface */
    private $bootstrap;

    /**
     * @var string
     */
    private $appNamespace;

    private $fullBootstrapName;

    /**
     * @var \G4\CleanCore\Request\Request
     */
    private $request;

    public function initBootstrap(): void
    {
        if (!$this->bootstrap instanceof BootstrapInterface) {
            $this
                ->constructFullBootstrapName()
                ->bootstrapFactory();
        }
    }

    public function getBootstrap(): \G4\CleanCore\Bootstrap\BootstrapInterface
    {
        return $this->bootstrap;
    }

    /**
     * @param string $serviceNamespace
     */
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
        $this->fullBootstrapName = join('\\', [$this->appNamespace, 'Bootstrap']);
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
