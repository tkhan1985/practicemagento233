<?php

namespace CTS\HelloWorld\Model;

use Magento\Framework\Model\AbstractModel;
use CTS\HelloWorld\Model\ResourceModel\Item as ResourceModel;

class Item extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
