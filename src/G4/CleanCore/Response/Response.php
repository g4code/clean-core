<?php
namespace G4\CleanCore\Response;

use G4\CleanCore\Response\Code;

class Response
{
    private $_applicationResponseCode;

    private $_httpResponseCode;

    //TODO: Drasko: Remove this!!!
    private $_responseMessage;

    private $_responseObject;


    public function __construct()
    {
        $this->_httpResponseCode = null;
    }

    public function addPartToResponseObject($key, $value)
    {
        $this->_responseObject[$key] = $value;

        return $this;
    }

    public function getApplicationResponseCode()
    {
        return $this->_applicationResponseCode;
    }

    public function getHttpResponseCode()
    {
        if ($this->_httpResponseCode === null) {

            $this->_httpResponseCode = $this->hasResponseObject() ? 200 : 204;
        }

        return $this->_httpResponseCode;
    }

    public function getHttpMessage()
    {
        return Code::asMessage($this->getHttpResponseCode());
    }

    public function getResponseObject()
    {
        return $this->_responseObject;
    }

    public function getResponseObjectPart($key)
    {
        return isset($this->_responseObject[$key])
            ? $this->_responseObject[$key]
            : null;
    }

    public function hasResponseObject()
    {
        return isset($this->_responseObject);
    }

    public function setApplicationResponseCode($value)
    {
        $this->_applicationResponseCode = $value;
        return $this;
    }

    public function setHttpResponseCode($value)
    {
        $this->_httpResponseCode = $value;
        return $this;
    }

    //TODO: Drasko: Remove this!!!
    public function setResponseMessage($value)
    {
        $this->_responseMessage = $value;
        return $this;
    }

    public function setResponseObject($value)
    {
        $this->_responseObject = $value;
        return $this;
    }
}
