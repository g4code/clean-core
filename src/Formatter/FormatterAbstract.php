<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Request\Request;

abstract class FormatterAbstract implements FormatterInterface
{
    private mixed $resource;

    public function addToResource($part, $value): self
    {
        $this->resource[$part] = $value;
        return $this;
    }

    public function doesPartExistsInResource($part): bool
    {
        return isset($this->resource[$part]);
    }

    public function getResource(string $part = null): mixed
    {
        return $part === null
            ? $this->resource
            : $this->getResourcePart($part);
    }

    public function getUseCaseFactoryInstance(): \G4\CleanCore\Factory\UseCase
    {
        return new \G4\CleanCore\Factory\UseCase();
    }

    public function reference(\G4\CleanCore\Formatter\FormatterAbstract $formatter, mixed $resource)
    {
        return $formatter
            ->setResource($resource)
            ->format();
    }

    public function setResource(mixed $resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    public function useCaseReference(string $useCaseName, string $resourcePart = null, Request $request = null): mixed
    {
        return $this->getUseCaseFactoryInstance()
            ->setUseCaseName($useCaseName)
            ->setRequest($request)
            ->getResource($resourcePart);
    }

    private function getResourcePart(string $part): mixed
    {
        return $this->doesPartExistsInResource($part)
            ? $this->resource[$part]
            : null;
    }
}
