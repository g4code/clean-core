<?php

namespace G4\CleanCore;

use G4\CleanCore\Response\Response;
use G4\CleanCore\Service\ServiceAbstract;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Dispatcher\Dispatcher;

class Application
{

    /**
     * @var Dispatcher
     */
    private $_dispatcher;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Response
     */
    private $_response;

    /**
     * @var string
     */
    private $_appNamespace;

    /**
     * @var \G4\CleanCore\Service\ServiceAbstract
     */
    private $_service;


    /**
     * @return \G4\CleanCore\Dispatcher\Dispatcher
     */
    public function getDispatcher()
    {
        if (!$this->_dispatcher instanceof Dispatcher)
        {
            $this->_dispatcher = new Dispatcher();
        }

        return $this->_dispatcher;
    }

    /**
     * @return \G4\CleanCore\Response\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    public function run()
    {
        $this->getDispatcher()
            ->setRequest($this->_request)
            ->setAppNamespace($this->_appNamespace)
            ->dispatch();

//TODO: Drasko: refactor this!!!
        $this->_service  = $this->getDispatcher()->getService();
        $this->_response = $this->_service === null
            ? $this->_get404()
            : $this->_service->getFormattedResponse();

        return $this;
    }

    /**
     * @param string $serviceNamespace
     * @return \G4\CleanCore\Application
     */
    public function setAppNamespace($appNamespace)
    {
        $this->_appNamespace = $appNamespace;
        return $this;
    }

    /**
     * @param Request $request
     * @return \G4\CleanCore\Application
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @param Dispatcher $dispatcher
     * @return \G4\CleanCore\Application
     */
    public function setDispatcher(Dispatcher $dispatcher)
    {
        $this->_dispatcher = $dispatcher;
        return $this;
    }
//TODO: Drasko: refactor this!!!
    private function _get404()
    {
        $response = new Response();

        return $response->setHttpResponseCode(404);
    }

}