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
    protected $_request;

    /**
     *
     * @var Response
     */
    protected $_response;

    private $_formatter;


    public function __construct()
    {
        $this->setResponse(new Response());
    }

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
     * Factory method for use of a new UseCase class
     * Returns whole resource or just one part
     *
     * @param string  $useCaseName
     * @param string  $resourcePart
     * @param Request $request
     */
    public function reference($useCaseName, $resourcePart = null, Request $request = null)
    {
        if(null === $request) {
            $request = $this->getRequest();
        }

        //TODO: Drasko: move to Factory class!!!
        $useCase = new $useCaseName();
        $useCase
            ->setRequest($request)
            ->run();
        $response = $useCase->getResponse();

        return $resourcePart === null
            ? $response->getResponseObject()
            : $response->getResponseObjectPart($resourcePart);
    }

    /**
     * @param Request $request
     * @return UseCaseAbstract
     */
    public function setRequest($request) //TODO: Drasko: add Request type hinting
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