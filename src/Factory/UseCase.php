<?php

namespace G4\CleanCore\Factory;

use G4\CleanCore\Request\Request;

class UseCase
{
    /**
     * @var \G4\CleanCore\Request\Request
     */
    private $request;

    /**
     * @var \G4\CleanCore\Response\Response
     */
    private $response;

    /**
     * @var \G4\CleanCore\UseCase\UseCaseAbstract
     */
    private $useCase;

    /**
     * @var string
     */
    private $useCaseName;

    /**
     * @throws \Exception
     */
    public function getRequest(): \G4\CleanCore\Request\Request
    {
        if (!$this->request instanceof \G4\CleanCore\Request\Request) {
            throw new \Exception('Request must be instance of \G4\CleanCore\Request\Request');
        }
        return $this->request;
    }

    /**
     * @param string $part
     * @return mixed
     */
    public function getResource($part = null)
    {
        return $part === null
            ? $this->getResponse()->getResponseObject()
            : $this->getResponse()->getResponseObjectPart($part);
    }

    public function getResponse(): \G4\CleanCore\Response\Response
    {
        if (!$this->response instanceof \G4\CleanCore\Response\Response) {
            $this->setResponse();
        }
        return $this->response;
    }

    /**
     * @throws \Exception
     */
    public function getUseCase(): \G4\CleanCore\UseCase\UseCaseAbstract
    {
        if (!$this->useCase instanceof \G4\CleanCore\UseCase\UseCaseAbstract) {
            $this->factory();
        }
        return $this->useCase;
    }

    public function setRequest(Request $request): self
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
