<?php

namespace G4\CleanCore\Bootstrap;

use \G4\CleanCore\Request\Request;

class BootstrapAbstract
{
    /**
     * @var \G4\CleanCore\Request\Request
     */
    protected $_request;

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return \G4\CleanCore\Bootstrap\Factory
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return \G4\CleanCore\Request\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
}