<?php

namespace G4\CleanCore\Error;

use G4\CleanCore\Response\Response;
use G4\Constants\Http;

class Error
{
    private $_exception;

    private $_response;

    public function manage()
    {
        $this->_response
            ->setResponseMessage($this->_getFormattedResponseMessage())
            ->setApplicationResponseCode($this->_exception->getCode())
            ->setHttpResponseCode($this->_getHttpCode())
            ->setResponseObject([
                'error' => [
                    'code'    => $this->_exception->getCode(),
                    'message' => $this->_exception->getMessage(),
                ]
            ]);
    }

    public function setException(\Exception $exception)
    {
        $this->_exception = $exception;
        return $this;
    }

    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    private function _getHttpCode()
    {
        return \G4\CleanCore\Response\Code::isValid($this->_exception->getCode())
            ? $this->_exception->getCode()
            : Http::CODE_500;
    }

    private function _getFormattedResponseMessage()
    {
        return array(
            'code'    => $this->_exception->getCode(),
            'message' => $this->_exception->getMessage(),
            'file'    => $this->_exception->getFile(),
            'line'    => $this->_exception->getLine(),
            'trace'   => $this->_exception->getTrace()
        );
    }
}