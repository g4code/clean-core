<?php
namespace G4\CleanCore\Response;

class Response
{
    private $_applicationResponseCode;

    private $_formattedResource;

    private $_httpResponseCode;

    //TODO: Drasko: Remove this!!!
    private $_responseMessage;

    private $_rawResource;


    public function __construct()
    {
        $this->_httpResponseCode = null;
    }

    public function addPartToResponseObject($key, $value)
    {
        $this->_rawResource[$key] = $value;

        return $this;
    }

    public function getApplicationResponseCode()
    {
        return $this->_applicationResponseCode;
    }

    public function getFormattedResource()
    {
        return $this->_formattedResource;
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
        return \G4\CleanCore\Response\Code::asMessage($this->getHttpResponseCode());
    }

    public function getResponseMessage()
    {
        return $this->_responseMessage;
    }

    public function getResponseObject()
    {
        return $this->_rawResource;
    }

    public function getResponseObjectPart($key)
    {
        return isset($this->_rawResource[$key])
            ? $this->_rawResource[$key]
            : null;
    }

    public function hasResponseObject()
    {
        return isset($this->_rawResource);
    }

    public function setApplicationResponseCode($applicationResponseCode)
    {
        $this->_applicationResponseCode = $applicationResponseCode;
        return $this;
    }

    public function setFormattedResource($formattedResource)
    {
        $this->_formattedResource = $formattedResource;
        return $this;
    }

    public function setHttpResponseCode($httpResponseCode)
    {
        $this->_httpResponseCode = $httpResponseCode;
        return $this;
    }

    public function setResponseMessage($value)
    {
        $this->_responseMessage = $value;
        return $this;
    }

    public function setResponseObject($rawResource)
    {
        $this->_rawResource = $rawResource;
        return $this;
    }
}
