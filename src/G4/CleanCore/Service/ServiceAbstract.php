<?php

namespace G4\CleanCore\Service;

use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Validator\Validator;
use G4\CleanCore\UseCase\UseCaseAbstract;

abstract class ServiceAbstract
{

    /**
     * @var \G4\CleanCore\Request\Request
     */
    protected $_request;

    /**
     * @var \G4\CleanCore\Response\Response
     */
    protected $_response;

    /**
     * @var \G4\CleanCore\UseCase\UseCaseAbstract
     */
    private $_useCase;

    /**
     * @var \G4\CleanCore\Validator\Validator
     */
    protected $_validator;


    //TODO: Drasko: move to setters!
    public function __construct()
    {
        $this->_validator = new Validator();
    }

    public function areParamsValid()
    {
        return $this->_validator
            ->setRequest($this->_request)
            ->setMeta($this->_meta)
            ->isValid();
    }

    public function getFormattedResponse()
    {
        if (!method_exists($this->_useCase, 'getFormatterInstance')) {
            $this->_response->setResponseObject($this->_getFormattedResource());
        }

        return $this->_response;
    }

    public function run()
    {
        $this->areParamsValid()
            ? $this->runUseCase()
            : $this->_response
                ->setHttpResponseCode(400)
                ->setResponseMessage($this->_validator->getErrorMessages());

         return $this;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function runUseCase()
    {
        $this->_useCase = $this->_getUseCaseInstance();
        $this->_useCase
            ->setRequest($this->_request)
            ->setResponse($this->_response)
            ->run();

        $this->_response = $this->_useCase->getResponse();

        return $this;
    }

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return \G4\CleanCore\Service\ServiceAbstract
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param \G4\CleanCore\Response\Response $response
     * @return \G4\CleanCore\Service\ServiceAbstract
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    abstract protected function _getUseCaseInstance();

    private function _getFormattedResource()
    {
        return $this->_response->hasResponseObject()
            ? $this->_formatterFactory()
            : null;
    }

    private function _formatterFactory()
    {
        return $this->_getFormatterInstance()
            ->setResource($this->_response->getResponseObject())
            ->format();
    }
}