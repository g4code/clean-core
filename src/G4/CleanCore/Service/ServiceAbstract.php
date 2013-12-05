<?php

namespace G4\CleanCore\Service;

use Api\Authenticate\Authenticate;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Validator\Validator;
use Gee\Log\Writer;

abstract class ServiceAbstract
{

    /**
     * @var Response
     */
    protected $_response;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * @var Validator
     */
    protected $_validator;


    //TODO: Drasko: move to setters!
    public function __construct()
    {
        $this->_response  = new Response();
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
        $this->_response->setResponseObject($this->_getFormattedResource());

        return $this->_response;
    }

    public function run()
    {
        $this->areParamsValid()
            ? $this->runUseCase()
            : $this->_response->setHttpResponseCode(400);

         return $this;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function runUseCase()
    {
        $useCase = $this->_getUseCaseInstance();
        $useCase
            ->setRequest($this->_request)
            ->setResponse($this->_response)
            ->run();

        $this->_response = $useCase->getResponse();

        return $this;
    }

    /**
     * @param Request $request
     * @return \G4\CleanCore\Service\ServiceAbstract
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    abstract protected function _getFormatterInstance();

    abstract protected function _getUseCaseInstance();

    private function _getFormattedResource()
    {
        return $this->_response->hasResponseObject()
            ? $this->_getFormatterInstance()
                ->setResource($this->_response->getResponseObject())
                ->format()
            : null;
    }
}