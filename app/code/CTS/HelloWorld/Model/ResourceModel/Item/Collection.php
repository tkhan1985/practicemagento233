<?php
namespace CTS\HelloWorld\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use CTS\HelloWorld\Model\Item as Model;
use CTS\HelloWorld\Model\ResourceModel\Item as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
