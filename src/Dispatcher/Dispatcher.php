<?php

namespace G4\CleanCore\Dispatcher;

use G4\CleanCore\Service\ServiceAbstract;
use G4\CleanCore\Request\Request;

class Dispatcher
{
    /**
     * @var string
     */
    private $fullServiceName;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ServiceAbstract
     */
    private $service = null;

    /**
     * @var string
     */
    private $appNamespace;

    public function __construct()
    {
    }

    public function getService(): \G4\CleanCore\Service\ServiceAbstract
    {
        return $this->service;
    }

    public function isDispatchable(): bool
    {
        $this
            ->constructFullServiceName()
            ->serviceFactory();

        return $this->service instanceof ServiceAbstract;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function setAppNamespace(string $appNamespace): self
    {
        $this->appNamespace = $appNamespace;
        return $this;
    }

    private function constructFullServiceName(): self
    {
        $this->fullServiceName = implode('\\', [
            $this->appNamespace,
            'Service',
            $this->getServiceName(),
            $this->getClassName()
        ]);
        return $this;
    }

    private function getClassName(): string
    {
        return ucfirst($this->request->getMethod());
    }

    private function getServiceName(): string
    {
        return ucfirst(
            preg_replace_callback(
                '/-([a-z])/',
                function ($matches): string {
                    return strtoupper($matches[1]);
                },
                $this->request->getResourceName()
            )
        );
    }

    private function serviceExist(): bool
    {
        return class_exists($this->fullServiceName);
    }

    private function serviceFactory(): void
    {
        if ($this->serviceExist()) {
            $serviceName    = $this->fullServiceName;
            $this->service = new $serviceName();
        }
    }
}
