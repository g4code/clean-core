<?php

namespace G4\CleanCore\Error;

use G4\CleanCore\Response\Response;
use G4\Constants\Http;

class Error
{
    private $exception;

    private $response;

    public function manage(): void
    {
        $this->response
            ->setResponseMessage($this->getFormattedResponseMessage())
            ->setApplicationResponseCode($this->exception->getCode())
            ->setHttpResponseCode($this->getHttpCode())
            ->setResponseObject([
                'error' => [
                    'code' => $this->exception->getCode(),
                    'message' => $this->exception->getMessage(),
                ]
            ]);
    }

    public function setException(\Exception $exception): self
    {
        $this->exception = $exception;
        return $this;
    }

    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }

    private function getHttpCode()
    {
        return \G4\CleanCore\Response\Code::isValid($this->exception->getCode())
            ? $this->exception->getCode()
            : Http::CODE_500;
    }

    private function getFormattedResponseMessage(): array
    {
        return [
            'code' => $this->exception->getCode(),
            'message' => $this->exception->getMessage(),
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            'trace' => $this->exception->getTrace()
        ];
    }
}
