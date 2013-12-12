<?php

namespace G4\CleanCore\Controller;

use G4\CleanCore\Request\Request;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Dispatcher\Dispatcher;

class Front
{

    private $_appNamespace;

    private $_dispatcher;

    private $_formatter;

    /**
     * @var \G4\CleanCore\Service\ServiceAbstract
     */
    private $_service;

    /**
     * @var \G4\CleanCore\UseCase\UseCaseAbstract
     */
    private $_useCase;

    /**
     * @var \G4\CleanCore\Response\Request
     */
    private $_request;

    /**
     * @var \G4\CleanCore\Response\Response
     */
    private $_response;


    public function getResponse()
    {
        return $this->_response;
    }

    public function run()
    {
        $this->_dispatcher
            ->setRequest($this->_request)
            ->setAppNamespace($this->_appNamespace);

        $this->_dispatcher->isDispatchable()
            ? $this->_dispatch()
            : $this->_response->setHttpResponseCode(404);

    }

    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->_dispatcher = $dispatcher;
        return $this;
    }

    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    private function _dispatch()
    {
        $this->_service = $this->_dispatcher->getService();
        $this->_service
            ->setRequest($this->_request)
            ->setResponse($this->_response)
            ->run();

        $this->_response = $this->_service->getFormattedResponse();
        var_dump($this->_response);die;
    }
}