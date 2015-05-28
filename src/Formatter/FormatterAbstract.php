<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Formatter\FormatterInterface;
use G4\CleanCore\Request\Request;

abstract class FormatterAbstract implements FormatterInterface
{
    /**
     * @var mixed
     */
    private $_resource;

    public function addToResource($part, $value)
    {
        $this->_resource[$part] = $value;
        return $this;
    }

    public function doesPartExistsInResource($part)
    {
        return isset($this->_resource[$part]);
    }

    /**
     * @param string $part
     * @return mixed
     */
    public function getResource($part = null)
    {
        return $part === null
            ? $this->_resource
            : $this->_getResourcePart($part);
    }

    /**
     * @return \G4\CleanCore\Factory\UseCase
     */
    public function getUseCaseFactoryInstance()
    {
        return new \G4\CleanCore\Factory\UseCase();
    }

    /**
     * @param \G4\CleanCore\Formatter\FormatterAbstract $formatter
     * @param mixed $resource
     */
    public function reference(\G4\CleanCore\Formatter\FormatterAbstract $formatter, $resource)
    {
        return $formatter
            ->setResource($resource)
            ->format();
    }

    /**
     * @param mixed $response
     * @return FormatterAbstract
     */
    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }

    /**
     * @param string $useCaseName
     * @param string $resourcePart
     * @param \G4\CleanCore\Request\Request $request
     * @return mixed
     */
    public function useCaseReference($useCaseName, $resourcePart = null, Request $request = null)
    {
        return $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($request)
            ->getResource($resourcePart);
    }

    /**
     * @param string $part
     * @return mixed
     */
    private function _getResourcePart($part)
    {
        return $this->doesPartExistsInResource($part)
            ? $this->_resource[$part]
            : null;
    }
}