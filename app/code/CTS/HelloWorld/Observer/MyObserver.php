<?php

namespace CTS\HelloWorld\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class MyObserver implements ObserverInterface
{
    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
         $displayText = $observer->getData('text');
         $newText = '<span style="background-color:yellow;font-weight:bold">'.
            $displayText['label'].
            ' calling from Event and Observer!!!</span>';
         $displayText->setText($newText);
         return $this;
    }
}
