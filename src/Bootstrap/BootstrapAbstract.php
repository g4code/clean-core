<?php

namespace G4\CleanCore\Bootstrap;

use \G4\CleanCore\Request\Request;

class BootstrapAbstract
{
    /**
     * @var \G4\CleanCore\Request\Request
     */
    protected $request;

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest(): \G4\CleanCore\Request\Request
    {
        return $this->request;
    }
}