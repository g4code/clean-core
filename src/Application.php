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
    private $bootstrapFactory;

    /**
     * @var \G4\CleanCore\Error\Error
     */
    private $error;

    /**
     * @var \G4\CleanCore\Controller\Front
     */
    private $frontController;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var string
     */
    private $appNamespace;


    /**
     * @return string
     */
    public function getAppNamespace()
    {
        return $this->appNamespace;
    }

    /**
     * @return \G4\CleanCore\Bootstrap\Factory
     */
    public function getBootstrapFactory()
    {
        if (!$this->bootstrapFactory instanceof \G4\CleanCore\Bootstrap\Factory) {
            $this->bootstrapFactory = new \G4\CleanCore\Bootstrap\Factory();
        }
        return $this->bootstrapFactory;
    }

    /**
     * @return \G4\CleanCore\Error\Error
     */
    public function getError()
    {
        if (!$this->error instanceof \G4\CleanCore\Error\Error) {
            $this->error = new \G4\CleanCore\Error\Error();
        }
        return $this->error;
    }

    /**
     * @return \G4\CleanCore\Controller\Front
     */
    public function getFrontController()
    {
        if (!$this->frontController instanceof Front) {
            $this->frontController = new Front();
        }
        return $this->frontController;
    }

    /**
     * @return \G4\CleanCore\Response\Response
     */
    public function getResponse()
    {
        if (!$this->response instanceof Response) {
            $this->response = new Response();
        }
        return $this->response;
    }

    /**
     * @return \G4\CleanCore\Request\Request
     */
    public function getRequest()
    {
        if (!$this->request instanceof Request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    public function run()
    {
        try {
            $this
                ->initBootstrap()
                ->runFrontController();
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
        $this->appNamespace = $appNamespace;
        return $this;
    }

    /**
     * @param Request $request
     * @return \G4\CleanCore\Application
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return \G4\CleanCore\Application
     */
    private function initBootstrap()
    {
        $this->getBootstrapFactory()
            ->setAppNamespace($this->appNamespace)
            ->setRequest($this->request)
            ->initBootstrap();
        return $this;
    }

    /**
     * @return \G4\CleanCore\Application
     */
    private function runFrontController()
    {
        $this->getFrontController()
            ->setAppNamespace($this->appNamespace)
            ->setDispatcher(new Dispatcher())
            ->setRequest($this->request)
            ->setResponse($this->getResponse())
            ->run();
        //TODO: Drasko: remove this after UseCase Response dependency refactoring!
        $this->response = $this->getFrontController()->getResponse();
        return $this;
    }
}