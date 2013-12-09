<?php

namespace G4\CleanCore;

use G4\CleanCore\Controller\Front;
use G4\CleanCore\Response\Response;
use G4\CleanCore\Service\ServiceAbstract;
use G4\CleanCore\Request\Request;
use G4\CleanCore\Dispatcher\Dispatcher;

class Application
{

    /**
     * @var \G4\CleanCore\Controller\Front
     */
    private $_frontController;

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
     * @return \G4\CleanCore\Controller\Front
     */
    public function getFrontController()
    {
        if (!$this->_frontController instanceof Front) {
            $this->_frontController = new Front();
        }
        return $this->_frontController;
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
        $this->getFrontController()
            ->setAppNamespace($this->_appNamespace)
            ->setDispatcher(new Dispatcher())
            ->setRequest($this->_request)
            ->setResponse(new Response())
            ->run();

        $this->_response = $this->getFrontController()->getResponse();

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
}