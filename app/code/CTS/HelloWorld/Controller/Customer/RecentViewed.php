<?php
namespace CTS\HelloWorld\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Customer;

class RecentViewed extends \Magento\Framework\App\Action\Action
{
      protected $customerSession;
      protected $customers;
      /**
        * @var \Magento\Framework\View\Result\PageFactory
       */
      protected $resultPageFactory;
      public function __construct(
         Context $context,
         Session $customerSession,
         Customer $customers,
         \Magento\Framework\View\Result\PageFactory $resultPageFactory
      )
      {
         parent::__construct($context);
         $this->customerSession = $customerSession;
         $this->customers = $customers;
         $this->resultPageFactory = $resultPageFactory;
      }
    /**
     * Default customer account page
     *
     * @return void
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $block = $resultPage->getLayout()->getBlock('customer.account.link.back');
        if ($this->customerSession->getCustomerGroupId()) {
             return $resultPage;
         } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            if ($block) {
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            }
            $resultRedirect->setPath('customer/account/login/');
            return $resultRedirect;
         }
    }
}
?>
