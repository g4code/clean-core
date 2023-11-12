<?php

namespace G4\CleanCore\UseCase\Gateway;

use G4\CleanCore\UseCase\UseCaseAbstract;
use G4\Constants\Format;
use G4\Gateway\GatewayInterface;

abstract class UseCaseGatewayAbstract extends UseCaseAbstract implements UseCaseGatewayInterface
{
    /**
     * @var GatewayInterface
     */
    private $gateway;


    /**
     * @return GatewayInterface
     * @deprecated
     */
    public function getGateway()
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        if (!$this->gateway instanceof GatewayInterface) {
            $this->gateway = $this->getGatewayInstance();
        }
        return $this->gateway;
    }

    public function getGatewayResource()
    {
        return $this->getGateway()->getResource();
    }

    public function getParams(): array
    {
        return $this->getRequest()->getParams();
    }

    public function run(): void
    {
        $this->getGateway()
            ->setParams($this->getParams())
            ->execute();
        $this->addToResponse();
    }

    private function addToResponse(): void
    {
        !$this->getGateway()->isOk()
            ? $this->throwError()
            : $this->getResponse()->addPartToResponseObject(
                'data',
                $this->getGatewayResource()
            )->setHttpResponseCode($this->getResponseCodeFromGatway());
    }

    private function throwError(): never
    {
        $this->getResponse()->addPartToResponseObject(Format::FORMAT, Format::JSON);

        $resource = $this->getGateway()->getResource();

        $message = isset($resource['error']) && isset($resource['error']['message'])
            ? $resource['error']['message']
            : null;

        throw new \Exception($message, $this->getGateway()->getResponseCode());
    }

    private function getResponseCodeFromGatway()
    {
        $responseBody = $this->getGateway()->getResponseBody();
        return $responseBody['code'] ?? $this->getGateway()->getResponseCode();
    }
}
