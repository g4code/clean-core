<?php

namespace G4\CleanCore\Formatter\Collection;

class IteratorFactory
{
    private $_collection;

    public function __construct($collection)
    {
        $this->_collection = $collection;
    }

    public function getIterator()
    {
        return $this->_isIterator()
            ? new \Zend\Paginator\Adapter\Iterator($this->_collection)
            : new \Zend\Paginator\Adapter\ArrayAdapter($this->_collection);
    }

    private function _isIterator()
    {
        return $this->_collection instanceof \Iterator
            && $this->_collection instanceof \Countable;
    }
}