<?php
/**
*
* @package Magento2
* @author Toufique Khan
* @created 03/01/2020
 *
 */

namespace CTS\HelloWorld\Block;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Cart as CartSession;
use CTS\HelloWorld\Model\ResourceModel\Item\Collection;
use CTS\HelloWorld\Model\ResourceModel\Item\CollectionFactory;

use Magento\Framework\Event\ManagerInterface as EventManager;


class Index extends Template
{
   protected $_objectManager;
   protected $_customerSession;
   protected $_cartSession;
   protected $itemscollectionFactory;
   public $eventData;

   const ADD_ITEM_PATH = 'helloworld/item/add';

   const DELETE_ITEM_PATH = 'helloworld/item/delete';

   const PRODUCT_TYPE = ['simple', 'bundle'];

   const ITEM_PATH = 'custom_image';

   /*public function __construct(
      Context $context,
      ObjectManager $objectManager,
      //CartSession $cartSession,
      //CustomerSession $customerSession,
      array $data = []
      )
   {
      $this->_objectManager = $objectManager;
      //$this->_cartSession = $cartSession;
      //$this->_customerSession = $customerSession;

      parent::__construct($context, $data);
   }*/

   /**
     * @var Collection
     */
    private $collection;

    /**
   * @var EventManager
   */
   private $eventManager;

    /**
     * Hello constructor.
     * @param Template\Context $context
     * @param Collection $collection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Collection $collection,
        CollectionFactory $collectionFactory,
        EventManager $eventManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
        $this->itemscollectionFactory = $collectionFactory;
        $this->eventManager = $eventManager;
    }

    //This Method is for pagination
    protected function _prepareLayout()
   {
       parent::_prepareLayout();
       $this->pageConfig->getTitle()->set(__('Hello World Module'));
       if ($this->getItems()) {
           $pager = $this->getLayout()->createBlock(
               'Magento\Theme\Block\Html\Pager',
               'cts.helloworld.pager'.rand(2,100)
           )->setAvailableLimit(array(2=>2,5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
               $this->getItems()
           );
           $this->setChild('pager', $pager);
           $this->getItems()->load();
       }
       return $this;
   }

   public function getObjectManagerInstance()
   {
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
     return $objectManager;
   }

   public function getSessionObject($sessionType)
   {
      switch($sessionType) {
         case 'customer':
            $instance = $this->getObjectManagerInstance()->create('\Magento\Customer\Model\Session');
            break;
         case 'cart':
            $instance = $this->getObjectManagerInstance()->get('\Magento\Checkout\Model\Cart');
            break;
         case 'catalog':
            $instance = $this->getObjectManagerInstance()->create('\Magento\Catalog\Model\Session');
            break;
         case 'checkout':
            $instance = $this->getObjectManagerInstance()->create('\Magento\Checkout\Model\Session');
            break;
         case 'backend':
            $instance = $this->getObjectManagerInstance()->create('\Magento\Backend\Model\Session');
            break;
         case 'newsletter':
            $instance = $this->getObjectManagerInstance()->get('\Magento\Newsletter\Model\Session');
            break;
      }

      return $instance;
   }


   public function getQuote($obj)
   {
      return $obj->getQuote();
   }

   public function getProductData($quoteObj)
   {
     return $productInfo = $quoteObj->getItemsCollection();
    //$productInfo = $this->_cart->getQuote()->getAllItems(); /*****For All items *****/
   }

   public function getCustomerData($customerObj)
   {
      return $customerObj->getCustomer();
   }

   public function getAllItems()
   {
        return $this->collection;
    }

    public function getAddItemPostUrl() {
        return $this->getUrl(self::ADD_ITEM_PATH);
    }

    public function getDeleteItemUrl() {
        return $this->getUrl(self::DELETE_ITEM_PATH);
    }

    //This Method is for listing the items and pagination
    public function getItems()
    {
       $dataobject = new \Magento\Framework\DataObject(array('label' => 'Before Item Collection'));
       $observer = $this->eventManager->dispatch('hello_world_before_item_event', ['text' => $dataobject]);
       $this->eventData = $dataobject->getText();
      //get values of current page. if not the param value then it will set to 1
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
    //get values of current limit. if not the param value then it will set to 1
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
        $itemsCollection = $this->itemscollectionFactory->create();
        $itemsCollection->setPageSize($pageSize);
        $itemsCollection->setCurPage($page);
        //$afterObserver = $this->eventManager->dispatch('hello_world_after_item_event', ['data' => $itemsCollection]);
        return $itemsCollection;
    }

    public function getEventData()
    {
      return $this->eventData;
    }

    //This Method is for pagination
    public function getPagerHtml()
   {
       return $this->getChildHtml('pager');
   }

   public function getOrderTables()
   {
      return \CTS\HelloWorld\Helper\Constant::ORDER_TABLES;
   }

   public function getCurrentProduct()
   {
      return $this->getObjectManagerInstance()->get('Magento\Framework\Registry')->registry('current_product'); //get current product
   }

   public function getProductTypeForCustomBlock()
   {
      return self::PRODUCT_TYPE;
   }

   static function getItemImageAbsPath()
   {
      $om = \Magento\Framework\App\ObjectManager::getInstance();
      /** @var \Magento\Framework\Filesystem $filesystem */
      $filesystem = $om->get('Magento\Framework\Filesystem');

      $file = $om->get('Magento\Framework\Filesystem\Driver\File');
      /** @var \Magento\Framework\Filesystem\Directory\ReadInterface|\Magento\Framework\Filesystem\Directory\Read $reader */
      $reader = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

      return $mediaRootDir = $reader->getAbsolutePath(self::ITEM_PATH);
   }

   static function getItemMediaImageUrl()
   {
      $om = \Magento\Framework\App\ObjectManager::getInstance();
      $storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');
   	/** @var \Magento\Store\Api\Data\StoreInterface|\Magento\Store\Model\Store $currentStore */
   	$currentStore = $storeManager->getStore();

      return $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).self::ITEM_PATH;
   }
}
