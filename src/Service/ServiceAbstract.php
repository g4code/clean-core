<?php

namespace G4\CleanCore\Service;

use G4\CleanCore\Meta\Meta;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;

abstract class ServiceAbstract implements \G4\CleanCore\Service\ServiceInterface
{

    private ?\G4\CleanCore\Request\Request $request = null;

    private ?\G4\CleanCore\Response\Response $response = null;

    private ?\G4\CleanCore\UseCase\UseCaseAbstract $useCase = null;

    private ?\G4\CleanCore\Validator\Validator $validator = null;

    public function areParamsValid(): bool
    {
        return $this->getValidator()
            ->setRequest($this->request)
            ->setMeta($this->getMeta())
            ->setWhitelistParams($this->getWhitelistParams())
            ->isValid();
    }

    public function getFormattedResponse(): \G4\CleanCore\Response\Response
    {
        if ($this->useCase && !method_exists($this->useCase, 'getFormatterInstance')) {
            $this->response->setResponseObject($this->getFormattedResource());
        }
        return $this->response;
    }

    public function getValidator(): \G4\CleanCore\Validator\Validator
    {
        if (!$this->validator instanceof \G4\CleanCore\Validator\Validator) {
            $this->validator = $this->getValidatorInstance();
        }
        return $this->validator;
    }

    public function getValidatorInstance(): \G4\CleanCore\Validator\Validator
    {
        return new \G4\CleanCore\Validator\Validator();
    }

    public function getWhitelistParams(): array
    {
        return [];
    }

    public function run(): self
    {
        $this->areParamsValid()
            ? $this->runUseCase()
            : $this->response
            ->setHttpResponseCode(400)
            ->setResponseMessage($this->getValidator()->getErrorMessages());

        return $this;
    }

    public function getResponse(): \G4\CleanCore\Response\Response
    {
        return $this->response;
    }

    public function getRequest(): \G4\CleanCore\Request\Request
    {
        return $this->request;
    }

    public function runUseCase(): self
    {
        $this->useCase = $this->getUseCaseInstance();
        $this->useCase
            ->setRequest($this->request)
            ->setResponse($this->response)
            ->run();

        $this->response = $this->useCase->getResponse();

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

    private function getFormattedResource()
    {
        return $this->response->hasResponseObject()
            ? $this->formatterFactory()
            : null;
    }

    private function formatterFactory()
    {
        return $this->getFormatterInstance()
            ->setResource($this->response->getResponseObject())
            ->format();
    }
}
