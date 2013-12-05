<?php

namespace G4\CleanCore\Formatter\Collection;

use G4\CleanCore\Formatter\Collection\CollectionAbstract;
use G4\CleanCore\Paginator\Adapter\Iterator;

abstract class PaginationAbstract extends CollectionAbstract
{

    protected $_paginator;


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
            'current_items'       => $this->_data
        );
    }

    protected function _setPaginator()
    {
        $iterator = new \Zend\Paginator\Adapter\Iterator($this->_getResourceCollection());

        $this->_paginator = new \Zend\Paginator\Paginator($iterator);
        $this->_paginator
            ->setItemCountPerPage($this->_resource['per_page'])
            ->setCurrentPageNumber($this->_resource['page']);
    }

    private function _hasItems()
    {
        return is_object($this->_paginator)
            && $this->_paginator->getItemCount($this->_paginator) > 0
            && $this->_resource['page'] <= count($this->_paginator);
    }
}