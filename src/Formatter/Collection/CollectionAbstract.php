<?php

namespace G4\CleanCore\Formatter\Collection;

use G4\CleanCore\Formatter\FormatterAbstract;

abstract class CollectionAbstract extends FormatterAbstract implements CollectionInterface
{
    private array $data;

    public function __construct()
    {
        $this->setData([]);
    }

    public function appendToData($value): self
    {
        $this->data[] = $value;
        return $this;
    }

    public function format(): array
    {
        foreach ($this->getResourceCollection() as $resource) {
            $this->formatOneResource($resource);
        }
        return $this->getData();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setDataPart($key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    protected function formatOneResource($oneResource): void
    {
        $this
            ->addToResource('resource', $oneResource)
            ->appendToData($this->getOneFormattedResource());
    }

    protected function getOneFormattedResource()
    {
        return $this->getOneResourceFormatterInstance()
            ->setResource($this->getResource())
            ->format();
    }

    protected function getResourceCollection()
    {
        $collection = $this->getResource('collection');
        return empty($collection)
            ? []
            : $collection;
    }
}
