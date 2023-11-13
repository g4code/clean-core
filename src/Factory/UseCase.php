<?php

namespace G4\CleanCore\Factory;

use G4\CleanCore\Request\Request;
use G4\CleanCore\Response\Response;
use G4\CleanCore\UseCase\UseCaseAbstract;

class UseCase
{
    private ?Request $request = null;

    private ?Response $response = null;

    private ?UseCaseAbstract $useCase = null;

    private ?string $useCaseName = null;

    /**
     * @throws \Exception
     */
    public function getRequest(): Request
    {
        if (!$this->request instanceof Request) {
            throw new \Exception('Request must be instance of \G4\CleanCore\Request\Request');
        }
        return $this->request;
    }

    public function getResource(string $part = null): mixed
    {
        return $part === null
            ? $this->getResponse()->getResponseObject()
            : $this->getResponse()->getResponseObjectPart($part);
    }

    public function getResponse(): Response
    {
        if (!$this->response instanceof Response) {
            $this->setResponse();
        }
        return $this->response;
    }

    /**
     * @throws \Exception
     */
    public function getUseCase(): UseCaseAbstract
    {
        if (!$this->useCase instanceof UseCaseAbstract) {
            $this->factory();
        }
        return $this->useCase;
    }

    public function setRequest(Request $request = null): self
    {
        $this->request = $request;
        return $this;
    }

    public function setUseCaseName(string $useCaseName): self
    {
        $this->useCaseName = $useCaseName;
        return $this;
    }

    private function factory(): self
    {
        $useCaseName    = $this->useCaseName;
        $this->useCase = new $useCaseName();
        $this->useCase
            ->setRequest($this->getRequest());
        return $this;
    }

    private function setResponse(): self
    {
        $this->getUseCase()->run();
        $this->response = $this->getUseCase()->getResponse();
        return $this;
    }
}
