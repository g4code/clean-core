<?php

namespace G4\CleanCore\Bootstrap;

use G4\CleanCore\Request\Request;

abstract class BootstrapAbstract implements BootstrapInterface
{
    protected Request $request;

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    abstract public function init();

    public function getAllowedMedia()
    {
        return [];
    }
}
