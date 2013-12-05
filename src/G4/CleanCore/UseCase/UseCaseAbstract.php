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


    public function __construct($request = null)
    {
        //TODO: Drasko: change this when all the services are in Api\Service namespace
        $this->setRequest($request);
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
        return $this->_response;
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