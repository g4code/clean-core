<?php

namespace G4\CleanCore;

use G4\CleanCore\Controller\Front;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Dispatcher\Dispatcher;

class Application
{
    /**
     * @var \G4\CleanCore\Bootstrap\Factory
     */
    private $_bootstrapFactory;

    /**
     * @var \G4\CleanCore\Error\Error
     */
    private $_error;

    /**
     * @var \G4\CleanCore\Controller\Front
     */
    private $_frontController;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Response
     */
    private $_response;

    /**
     * @var string
     */
    private $_appNamespace;

    /**
     * @return \G4\CleanCore\Bootstrap\Factory
     */
    public function getBootstrapFactory()
    {
        if (!$this->_bootstrapFactory instanceof \G4\CleanCore\Bootstrap\Factory) {
            $this->_bootstrapFactory = new \G4\CleanCore\Bootstrap\Factory();
        }
        return $this->_bootstrapFactory;
    }

    /**
     * @return \G4\CleanCore\Error\Error
     */
    public function getError()
    {
        if (!$this->_error instanceof \G4\CleanCore\Error\Error) {
            $this->_error = new \G4\CleanCore\Error\Error();
        }
        return $this->_error;
    }

    /**
     * @return \G4\CleanCore\Controller\Front
     */
    public function getFrontController()
    {
        if (!$this->_frontController instanceof Front) {
            $this->_frontController = new Front();
        }
        return $this->_frontController;
    }

    /**
     * @return \G4\CleanCore\Response\Response
     */
    public function getResponse()
    {
        if (!$this->_response instanceof Response) {
            $this->_response = new Response();
        }
        return $this->_response;
    }

    public function run()
    {
        try {
            $this
                ->_initBootstrap()
                ->_runFrontController();
        } catch(\Exception $exception) {
            $this->getError()
                ->setException($exception)
                ->setResponse($this->getResponse())
                ->manage();
        }
        return $this;
    }

    /**
     * @param string $serviceNamespace
     * @return \G4\CleanCore\Application
     */
    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

    /**
     * @param Request $request
     * @return \G4\CleanCore\Application
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
        if (!$this->_request instanceof Request) {
            $this->_request = new Request();
        }
        return $this->_request;
    }

    /**
     * @return \G4\CleanCore\Application
     */
    private function _initBootstrap()
    {
        $this->getBootstrapFactory()
            ->setAppNamespace($this->_appNamespace)
            ->setRequest($this->_request)
            ->initBootstrap();
        return $this;
    }

    /**
     * @return \G4\CleanCore\Application
     */
    private function _runFrontController()
    {
        $this->getFrontController()
            ->setAppNamespace($this->_appNamespace)
            ->setDispatcher(new Dispatcher())
            ->setRequest($this->_request)
            ->setResponse($this->getResponse())
            ->run();
        //TODO: Drasko: remove this after UseCase Response dependency refactoring!
        $this->_response = $this->getFrontController()->getResponse();
        return $this;
    }
}