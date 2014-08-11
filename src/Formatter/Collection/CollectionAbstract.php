<?php

namespace G4\CleanCore\Formatter\Collection;

use G4\CleanCore\Formatter\Collection\CollectionInterface;
use G4\CleanCore\Formatter\FormatterAbstract;

abstract class CollectionAbstract extends FormatterAbstract implements CollectionInterface
{
    private $_data;

    public function __construct()
    {
        $this->setData(array());
    }

    public function appendToData($value)
    {
        $this->_data[] = $value;
        return $this;
    }

    public function format()
    {
        foreach ($this->_getResourceCollection() as $resource) {
            $this->_formatOneResource($resource);
        }
        return $this->getData();
    }

    public function getData()
    {
        return $this->_data;
    }

    public function setData(array $data)
    {
        $this->_data = $data;
        return $this;
    }

    public function setDataPart($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }

    protected function _formatOneResource($oneResource)
    {
        $this
            ->addToResource('resource', $oneResource)
            ->appendToData($this->_getOneFormattedResource());
    }

    protected function _getOneFormattedResource()
    {
        return $this->getOneResourceFormatterInstance()
            ->setResource($this->getResource())
            ->format();
    }

    protected function _getResourceCollection()
    {
        $collection = $this->getResource('collection');
        return empty($collection)
            ? array()
            : $collection;
    }
}