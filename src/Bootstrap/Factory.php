<?php

namespace G4\CleanCore\Bootstrap;

use G4\CleanCore\Request\Request;

class Factory
{
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
        if (!$this->_bootstrap instanceof \G4\CleanCore\Bootstrap\BootstrapInterface) {
            $this
                ->_constructFullBootstrapName()
                ->_bootstrapFactory();
        }
    }

    /**
     * @param string $serviceNamespace
     * @return \G4\CleanCore\Bootstrap\Factory
     */
    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

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
     * @return \G4\CleanCore\Bootstrap\Factory
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
            $this->bootstrap = new $bootstrapName();
            $this->bootstrap
                ->setRequest($this->_request)
                ->init();
        }
    }
}