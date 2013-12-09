<?php

namespace G4\CleanCore\Formatter\Collection;

use G4\CleanCore\Formatter\FormatterAbstract;

abstract class CollectionAbstract extends FormatterAbstract
{

    protected $_data;


    public function __construct()
    {
        $this->_data = array();
    }

    abstract protected function _getOneResourceFormatterInstance();


    public function format()
    {
        foreach ($this->_getResourceCollection() as $resource) {
            $this->_formatOneResource($resource);
        }

        return $this->_data;
    }

    protected function _formatOneResource($oneResource)
    {
        $this->_resource['resource'] = $oneResource;

        $this->_data[] = $this->_getOneFormattedResource();
    }

    protected function _getOneFormattedResource()
    {
        return $this->_getOneResourceFormatterInstance()
            ->setResource($this->_resource)
            ->format();
    }

    protected function _getResourceCollection()
    {
        return empty($this->_resource['collection'])
            ? array()
            : $this->_resource['collection'];
    }
}