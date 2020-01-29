<?php
namespace CTS\HelloWorld\Block;

class RecentViewed extends \Magento\Framework\View\Element\Template
{
    protected $recentlyViewed;
    protected $productRepo;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Reports\Block\Product\Viewed $recentlyViewed,
        \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory,
        array $data = []
    ) {
        $this->recentlyViewed = $recentlyViewed;
        $this->productRepo = $productRepositoryFactory;
        parent::__construct( $context, $data );
    }

    protected function _prepareLayout()
    {
         parent::_prepareLayout();
         $this->pageConfig->getTitle()->set(__('Recently Viewed'));
         if ($this->getItems()) {
             $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'cts.helloworld.recentViewed'.rand(2,100)
             )->setAvailableLimit(array(2=>2,5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
                $this->getItems()
             );
             $this->setChild('pager', $pager);
             $this->getItems()->load();
         }
         return $this;
    }

    public function getMostRecentlyViewed(){
        return $this->recentlyViewed->getItemsCollection();
    }

    public function getProductImage($productId)
    {
       $product = $this->productRepo->create()->getById($productId);
       return $image =  $this->getUrl().'pub/media/catalog/product'.$product->getData('thumbnail');
       //$fullUrl = $this->getUrl('pub/media/catalog/product', ['_secure' => $this->getRequest()->isSecure()]);
       //echo $fullUrl.$image;die;
    }

    public function getProductUrl($productId)
    {
      $product = $this->productRepo->create()->getById($productId);
      return $product->getProductUrl();
   }

    //This Method is for listing the items and pagination
  public function getItems()
  {
     //get values of current page. if not the param value then it will set to 1
      $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
  //get values of current limit. if not the param value then it will set to 1
      $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 2;
      $itemsCollection = $this->getMostRecentlyViewed();
      $itemsCollection->setPageSize($pageSize);
      $itemsCollection->setCurPage($page);
      //$afterObserver = $this->eventManager->dispatch('hello_world_after_item_event', ['data' => $itemsCollection]);
      return $itemsCollection;
  }

     //This Method is for pagination
   public function getPagerHtml()
   {
        return $this->getChildHtml('pager');
   }
}
