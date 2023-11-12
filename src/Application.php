<?php

namespace G4\CleanCore;

use G4\CleanCore\Controller\Front;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Dispatcher\Dispatcher;

class Application
{
    private ?\G4\CleanCore\Bootstrap\Factory $bootstrapFactory = null;

    private ?\G4\CleanCore\Error\Error $error = null;

    private ?\G4\CleanCore\Controller\Front $frontController = null;

    private ?\G4\CleanCore\Request\Request $request = null;

    private ?\G4\CleanCore\Response\Response $response = null;

    private ?string $appNamespace = null;


    public function getAppNamespace(): string
    {
        return $this->appNamespace;
    }

    public function getBootstrapFactory(): \G4\CleanCore\Bootstrap\Factory
    {
        if (!$this->bootstrapFactory instanceof \G4\CleanCore\Bootstrap\Factory) {
            $this->bootstrapFactory = new \G4\CleanCore\Bootstrap\Factory();
        }
        return $this->bootstrapFactory;
    }

    public function getError(): \G4\CleanCore\Error\Error
    {
        if (!$this->error instanceof \G4\CleanCore\Error\Error) {
            $this->error = new \G4\CleanCore\Error\Error();
        }
        return $this->error;
    }

    public function getFrontController(): \G4\CleanCore\Controller\Front
    {
        if (!$this->frontController instanceof Front) {
            $this->frontController = new Front();
        }
        return $this->frontController;
    }

    public function getResponse(): \G4\CleanCore\Response\Response
    {
        if (!$this->response instanceof Response) {
            $this->response = new Response();
        }
        return $this->response;
    }

    public function getRequest(): \G4\CleanCore\Request\Request
    {
        if (!$this->request instanceof Request) {
            $this->request = new Request();
        }
        return $this->request;
    }

    public function run(): self
    {
        try {
            $this
                ->initBootstrap()
                ->runFrontController();
        } catch (\Exception $exception) {
            $this->getError()
                ->setException($exception)
                ->setResponse($this->getResponse())
                ->manage();
        }
        return $this;
    }

    public function setAppNamespace(string $appNamespace): self
    {
        $this->appNamespace = $appNamespace;
        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    private function initBootstrap(): self
    {
        $this->getBootstrapFactory()
            ->setAppNamespace($this->appNamespace)
            ->setRequest($this->request)
            ->initBootstrap();
        return $this;
    }

    private function runFrontController(): self
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
