<?php

namespace G4\CleanCore\Dispatcher;

use G4\CleanCore\Service\ServiceAbstract;
use G4\CleanCore\Request\Request;

class Dispatcher
{
    /**
     * @var string
     */
    private $_fullServiceName;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var ServiceAbstract
     */
    private $_service;

    /**
     * @var string
     */
    private $_appNamespace;

    public function __construct()
    {
        $this->_service = null;
    }

    /**
     * @return \G4\CleanCore\Service\ServiceAbstract
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * @return boolean
     */
    public function isDispatchable()
    {
        $this
            ->constructFullServiceName()
            ->serviceFactory();

        return $this->_service instanceof ServiceAbstract;
    }

    /**
     * @param Request $request
     * @return \G4\CleanCore\Dispatcher\Dispatcher
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param string $serviceNamespace
     * @return \G4\CleanCore\Dispatcher\Dispatcher
     */
    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

    /**
     * @return \G4\CleanCore\Dispatcher\Dispatcher
     */
    private function constructFullServiceName()
    {
        $this->_fullServiceName = join('\\', array(
            $this->_appNamespace,
            'Service',
            $this->getServiceName(),
            $this->getClassName()
        ));
        return $this;
    }

    /**
     * @return string
     */
    private function getClassName()
    {
        return ucfirst($this->_request->getMethod());
    }

    /**
     * @return string
     */
    private function getServiceName()
    {
        return str_replace('-', '', ucwords($this->_request->getResourceName(), '-'));
    }

    /**
     * @return bool
     */
    private function serviceExist()
    {
        return class_exists($this->_fullServiceName);
    }

    private function serviceFactory()
    {
        if ($this->serviceExist()) {
            $serviceName    = $this->_fullServiceName;
            $this->_service = new $serviceName();
        }
    }
}