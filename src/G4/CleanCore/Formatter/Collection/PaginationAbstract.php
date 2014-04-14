<?php

namespace G4\CleanCore\Formatter\Collection;

use G4\CleanCore\Formatter\Collection\CollectionAbstract;
use G4\CleanCore\Paginator\Adapter\Iterator;

abstract class PaginationAbstract extends CollectionAbstract
{

    private $_paginator;


    public function format()
    {
        $this->_setPaginator();

        if ($this->_hasItems()) {

            foreach ($this->_paginator as $resource) {
                $this->_formatOneResource($resource);
            }
        }

        return $this->_getPaginatorResponse();
    }

    protected function _getPaginatorResponse()
    {
        return array(
            'current_page_number' => $this->_paginator->getCurrentPageNumber(),
            'total_item_count'    => $this->_paginator->getTotalItemCount(),
            'item_count_per_page' => $this->_paginator->getItemCountPerPage(),
            'current_item_count'  => $this->_paginator->getCurrentItemCount(),
            'page_count'          => count($this->_paginator),
            'current_items'       => $this->getData()
        );
    }

    protected function _getResourcePage()
    {
        $page = $this->getResource('page');
        return empty($page)
            ? 1
            : $page;
    }

    protected function _getResourcePerPage()
    {
        $perPage = $this->getResource('per_page');
        return empty($perPage)
            ? 1
            : $perPage;
    }

    /**
     * @return \G4\CleanCore\Formatter\Collection\PaginationAbstract
     */
    protected function _setPaginator()
    {
        $iteratorFactory  = new \G4\CleanCore\Formatter\Collection\IteratorFactory($this->_getResourceCollection());
        $this->_paginator = new \Zend\Paginator\Paginator($iteratorFactory->getIterator());
        $this->_paginator
            ->setItemCountPerPage($this->_getResourcePerPage())
            ->setCurrentPageNumber($this->_getResourcePage());

        return $this;
    }

    private function _hasItems()
    {
        return is_object($this->_paginator)
            && $this->_paginator->getItemCount($this->_paginator) > 0
            && $this->getResource('page') <= count($this->_paginator);
    }
}