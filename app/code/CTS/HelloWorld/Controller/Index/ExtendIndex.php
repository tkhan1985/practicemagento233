<?php
namespace CTS\HelloWorld\Controller\Index;
class ExtendIndex extends \Magento\Cms\Controller\Index\Index
{
    public function execute($coreRoute = null)
    {
        $this->messageManager->addSuccess('Message from new controller.');
        return parent::execute($coreRoute);
    }
}
 ?>
