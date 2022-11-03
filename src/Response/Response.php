<?php
namespace G4\CleanCore\Response;

class Response
{
    private $applicationResponseCode;

    private $formattedResource;

    private $httpResponseCode = null;

    //TODO: Drasko: Remove this!!!
    private $responseMessage;

    private $rawResource;

    public function __construct()
    {
    }

    public function addPartToResponseObject($key, $value): self
    {
        $this->rawResource[$key] = $value;
        return $this;
    }

    public function getApplicationResponseCode()
    {
        return $this->applicationResponseCode;
    }

    public function getFormattedResource()
    {
        return $this->formattedResource;
    }

    public function getHttpResponseCode(): int
    {
        if ($this->httpResponseCode === null) {
            $this->httpResponseCode = $this->hasResponseObject() ? 200 : 204;
        }
        return $this->httpResponseCode;
    }

    public function getHttpMessage()
    {
        return \G4\CleanCore\Response\Code::asMessage($this->getHttpResponseCode());
    }

    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    public function getResponseObject()
    {
        return $this->rawResource;
    }

    public function getResponseObjectPart($key)
    {
        return $this->rawResource[$key] ?? null;
    }

    public function hasResponseObject(): bool
    {
        return isset($this->rawResource);
    }

    public function setApplicationResponseCode($applicationResponseCode): self
    {
        $this->applicationResponseCode = $applicationResponseCode;
        return $this;
    }

    public function setFormattedResource($formattedResource): self
    {
        $this->formattedResource = $formattedResource;
        return $this;
    }

    public function setHttpResponseCode($httpResponseCode): self
    {
        $this->httpResponseCode = $httpResponseCode;
        return $this;
    }

    public function setResponseMessage($value): self
    {
        $this->responseMessage = $value;
        return $this;
    }

    public function setResponseObject($rawResource): self
    {
        $this->rawResource = $rawResource;
        return $this;
    }
}
