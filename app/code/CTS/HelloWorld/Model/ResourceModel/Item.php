<?php

namespace CTS\HelloWorld\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb
{
   protected function _construct()
   {
      $this->_init('cts_helloworld_items', 'id');
   }
}
