<?php

namespace G4\CleanCore\Controller;

use G4\CleanCore\Request\Request;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Dispatcher\Dispatcher;

class Front
{
    private string $appNamespace;

    private ?\G4\CleanCore\Dispatcher\Dispatcher $dispatcher = null;

    private ?\G4\CleanCore\Service\ServiceAbstract $service = null;

    private ?\G4\CleanCore\Request\Request $request = null;

    private ?\G4\CleanCore\Response\Response $response = null;

    public function getResponse(): \G4\CleanCore\Response\Response
    {
        return $this->response;
    }

    public function run(): void
    {
        $this->dispatcher
            ->setRequest($this->request)
            ->setAppNamespace($this->appNamespace);

        $this->dispatcher->isDispatchable()
            ? $this->dispatch()
            : $this->response->setHttpResponseCode(404);
    }

    public function setAppNamespace($appNamespace): self
    {
        $this->appNamespace = $appNamespace;
        return $this;
    }

    public function setDispatcher(Dispatcher $dispatcher): self
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }

    private function dispatch(): void
    {
        $this->service = $this->dispatcher->getService();
        $this->service
            ->setRequest($this->request)
            ->setResponse($this->response)
            ->run();

        $this->response = $this->service->getFormattedResponse();
    }
}
