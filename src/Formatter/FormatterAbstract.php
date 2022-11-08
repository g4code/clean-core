<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Request\Request;

abstract class FormatterAbstract implements FormatterInterface
{
    /**
     * @var mixed
     */
    private $resource;

    public function addToResource($part, $value)
    {
        $this->resource[$part] = $value;
        return $this;
    }

    public function doesPartExistsInResource($part)
    {
        return isset($this->resource[$part]);
    }

    /**
     * @param string $part
     * @return mixed
     */
    public function getResource($part = null)
    {
        return $part === null
            ? $this->resource
            : $this->getResourcePart($part);
    }

    public function getUseCaseFactoryInstance(): \G4\CleanCore\Factory\UseCase
    {
        return new \G4\CleanCore\Factory\UseCase();
    }

    /**
     * @param mixed $resource
     */
    public function reference(\G4\CleanCore\Formatter\FormatterAbstract $formatter, $resource)
    {
        return $formatter
            ->setResource($resource)
            ->format();
    }

    /**
     * @param mixed $resource
     * @return FormatterAbstract
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param string $resourcePart
     * @return mixed
     */
    public function useCaseReference(string $useCaseName, $resourcePart = null, Request $request = null)
    {
        return $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($request)
            ->getResource($resourcePart);
    }

    /**
     * @return mixed
     */
    private function getResourcePart(string $part)
    {
        return $this->doesPartExistsInResource($part)
            ? $this->resource[$part]
            : null;
    }
}
