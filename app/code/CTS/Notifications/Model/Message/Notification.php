<?php
namespace Cts\Notifications\Model\Message;
class Notification implements \Magento\Framework\Notification\MessageInterface
{
   protected $sm;
   public $urls = [
        'Development' => 'https://macle-dev1.bricard.com/',
        'Development 2' => 'https://macle-dev2.bricard.com/',
        'UAT' => 'https://macle-uat.bricard.com/'
        ];

   protected $baseUrl;
   protected $displayed = false;

   public function __construct()
   {
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      $this->sm = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
      $this->baseUrl = $this->sm->getStore()->getBaseUrl();
   }
   public function getIdentity()
   {
       // Retrieve unique message identity
       return 'identity';
   }
   public function isDisplayed()
   {
        if(in_array($this->baseUrl, $this->urls)) {
           $data = array_keys($this->urls, $this->baseUrl);
           $this->displayed = $data[0];
       } else {
           $this->displayed = false;
        }

       // Return true to show your message, false to hide it
       return ($this->displayed) ? true : false;
   }
   public function getText()
   {
       return  ($this->displayed) ? "<p style='color:green;font-size:22px;text-align: center;font-style: italic;font-weight: bold;'>You are in admin panel of <span style='text-decoration: underline;color:blue;'>".$this->displayed."</span> Environment!</p>" : "";

   }
   public function getSeverity()
   {
       return self::SEVERITY_MINOR;
   }
}
