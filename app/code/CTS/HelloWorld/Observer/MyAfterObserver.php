<?php

namespace CTS\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class MyAfterObserver implements ObserverInterface
{
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
         /*foreach($observer->getData('data') as $key => $item) {
            var_dump($item);
            die;
            $observer[$key]->setName('Testing');
         }

         return $observer;*/
    }
}
