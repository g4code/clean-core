<?php

namespace G4\CleanCore\UseCase;

use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;

abstract class UseCaseAbstract implements UseCaseInterface
{
    private \G4\CleanCore\Request\Request $request;

    private \G4\CleanCore\Response\Response $response;

    private $formatter;

    public function __construct()
    {
        $this->request = new Request();
        $this->setResponse(new Response());
    }

    public function forward(string $useCaseName): void
    {
        $this->getResponse()->setResponseObject(
            $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($this->getRequest())
            ->getResource()
        );
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        if (method_exists($this, 'getFormatterInstance') && $this->response->hasResponseObject()) {
            $formattedResource = $this->getFormatterInstance()
                ->setResource($this->response->getResponseObject())
                ->format();

            $this->response->setResponseObject($formattedResource);
        }

        return $this->response;
    }

    public function getUseCaseFactoryInstance(): \G4\CleanCore\Factory\UseCase
    {
        return new \G4\CleanCore\Factory\UseCase();
    }

    /**
     * Factory method for use of a new UseCase class
     * Returns whole resource or just one part
     */
    public function reference(string $useCaseName, string $resourcePart = null, Request $request = null): mixed
    {
        if (null === $request) {
            $request = $this->getRequest();
        }
        return $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($request)
            ->getResource($resourcePart);
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
}
