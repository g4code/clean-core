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
    private $request;

    /**
     *
     * @var Response
     */
    private $response;

    private $formatter;

    public function __construct()
    {
        $this->setResponse(new Response());
    }

    public function forward(string $useCaseName)
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
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
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
     *
     * @param string $resourcePart
     * @return mixed
     */
    public function reference(string $useCaseName, $resourcePart = null, Request $request = null)
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
     * @return UseCaseAbstract
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return UseCaseAbstract
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }
}