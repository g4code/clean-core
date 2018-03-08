<?php

namespace G4\CleanCore\UseCase;

use G4\CleanCore\Response\Response;
use G4\CleanCore\Request\Request;
use G4\CleanCore\UseCase\UseCaseInterface;

abstract class UseCaseAbstract implements UseCaseInterface
{
    /**
     * @var Request
     */
    private $_request;

    /**
     *
     * @var Response
     */
    private $_response;

    private $_formatter;

    public function __construct()
    {
        $this->setResponse(new Response());
    }

    /**
     * @param string $useCaseName
     */
    public function forward($useCaseName)
    {
        $this->getResponse()->setResponseObject(
            $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($this->getRequest())
            ->getResource());
    }

    /**
     * @return \G4\CleanCore\Request\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        if (method_exists($this, 'getFormatterInstance') && $this->_response->hasResponseObject()) {
            $formattedResource = $this->getFormatterInstance()
                ->setResource($this->_response->getResponseObject())
                ->format();

            $this->_response->setResponseObject($formattedResource);
        }

        return $this->_response;
    }

    /**
     * @return \G4\CleanCore\Factory\UseCase
     */
    public function getUseCaseFactoryInstance()
    {
        return new \G4\CleanCore\Factory\UseCase();
    }

    /**
     * Factory method for use of a new UseCase class
     * Returns whole resource or just one part
     *
     * @param string $useCaseName
     * @param string $resourcePart
     * @param Request $request
     * @return mixed
     */
    public function reference($useCaseName, $resourcePart = null, Request $request = null)
    {
        if(null === $request) {
            $request = $this->getRequest();
        }
        return $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($request)
            ->getResource($resourcePart);
    }

    /**
     * @param Request $request
     * @return UseCaseAbstract
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param Response $response
     * @return UseCaseAbstract
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }
}