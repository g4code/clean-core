<?php

namespace G4\CleanCore\Factory;

use G4\CleanCore\Request\Request;

class UseCase
{
    /**
     * @var \G4\CleanCore\Request\Request
     */
    private $_request;

    /**
     * @var \G4\CleanCore\Response\Response
     */
    private $_response;

    /**
     * @var \G4\CleanCore\UseCase\UseCaseAbstract
     */
    private $_useCase;

    /**
     * @var string
     */
    private $_useCaseName;

    /**
     * @throws \Exception
     * @return \G4\CleanCore\Request\Request
     */
    public function getRequest()
    {
        if (!$this->_request instanceof \G4\CleanCore\Request\Request) {
            throw new \Exception('Request must be instance of \G4\CleanCore\Request\Request');
        }
        return $this->_request;
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

    /**
     * @return G4\CleanCore\Response\Response
     */
    public function getResponse()
    {
        if (!$this->_response instanceof \G4\CleanCore\Response\Response) {
            $this->_setResponse();
        }
        return $this->_response;
    }

    /**
     * @throws \Exception
     * @return \G4\CleanCore\UseCase\UseCaseAbstract
     */
    public function getUseCase()
    {
        if (!$this->_useCase instanceof \G4\CleanCore\UseCase\UseCaseAbstract) {
            $this->_factory();
        }
        return $this->_useCase;
    }

    /**
     * @param \G4\CleanCore\Request\Request $request
     * @return \G4\CleanCore\Factory\UseCase
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param string $useCaseName
     * @return \G4\CleanCore\Factory\UseCase
     */
    public function setUseCaseName($useCaseName)
    {
        $this->_useCaseName = $useCaseName;
        return $this;
    }

    /**
     * @return \G4\CleanCore\Factory\UseCase
     */
    private function _factory()
    {
        $useCaseName    = $this->_useCaseName;
        $this->_useCase = new $useCaseName();
        $this->_useCase
            ->setRequest($this->getRequest());
        return $this;
    }

    /**
     * @return \G4\CleanCore\Factory\UseCase
     */
    private function _setResponse()
    {
        $this->getUseCase()->run();
        $this->_response = $this->getUseCase()->getResponse();
        return $this;
    }
}