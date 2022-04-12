<?php

namespace G4\CleanCore\Bootstrap;

use G4\CleanCore\Request\Request;

class Factory
{
    /** @var BootstrapInterface */
    private $_bootstrap;

    /**
     * @var string
     */
    private $_appNamespace;

    private $_fullBootstrapName;

    /**
     * @var \G4\CleanCore\Request\Request
     */
    private $_request;

    public function initBootstrap()
    {
        if (!$this->_bootstrap instanceof BootstrapInterface) {
            $this
                ->_constructFullBootstrapName()
                ->_bootstrapFactory();
        }
    }

    /**
     * @return BootstrapInterface
     */
    public function getBootstrap()
    {
        return $this->_bootstrap;
    }

    /**
     * @param string $serviceNamespace
     * @return Factory
     */
    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return Factory
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return Factory
     */
    private function _constructFullBootstrapName()
    {
        $this->_fullBootstrapName = join('\\', array(
            $this->_appNamespace,
            'Bootstrap'
        ));
        return $this;
    }

    /**
     * @return bool
     */
    private function _bootstrapExist()
    {
        return class_exists($this->_fullBootstrapName);
    }

    private function _bootstrapFactory()
    {
        if ($this->_bootstrapExist()) {
            $bootstrapName    = $this->_fullBootstrapName;
            $this->_bootstrap = new $bootstrapName();
            $this->_bootstrap
                ->setRequest($this->_request)
                ->init();
        }
    }
}