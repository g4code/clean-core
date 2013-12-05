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


    public function dispatch()
    {
        $this->_constructFullServiceName()
             ->_serviceFactory();

        if ($this->_isCorrectType()) {

            $this->_service
                ->setRequest($this->_request)
                ->run();
        }
    }

    /**
     * @return \G4\CleanCore\Service\ServiceAbstract
     */
    public function getService()
    {
        return $this->_service;
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
    private function _constructFullServiceName()
    {
        $this->_fullServiceName = join('\\', array(
            $this->_appNamespace,
            'Service',
            $this->_getServiceName(),
            $this->_getClassName()
        ));
        return $this;
    }

    /**
     * @return string
     */
    private function _getClassName()
    {
        return ucfirst($this->_request->getMethod());
    }

    /**
     * @return string
     */
    private function _getServiceName()
    {
        return ucfirst(preg_replace(
                "/\-(.)/e", "strtoupper('\\1')",
                $this->_request->getResourceName()
            ));
    }

    /**
     * @return boolean
     */
    private function _isCorrectType()
    {
        return $this->_service instanceof ServiceAbstract;
    }

    /**
     * @return bool
     */
    private function _serviceExist()
    {
        return class_exists($this->_fullServiceName);
    }


    private function _serviceFactory()
    {
        if ($this->_serviceExist()) {

            $serviceName    = $this->_fullServiceName;
            $this->_service = new $serviceName();
        }
    }
}