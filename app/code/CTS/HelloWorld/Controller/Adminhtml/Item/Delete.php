<?php

namespace CTS\HelloWorld\Controller\Adminhtml\Item;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use CTS\HelloWorld\Model\ItemFactory;

class Delete extends Action
{
    /**
     * @var Item
     */
    private $_modelItemFactory;

    /**
     * Add constructor.
     * @param Context $context
     * @param Item $item
     * @param ItemResource $itemResource
     */
    public function __construct(
        Context $context,
        ItemFactory $item
    )
    {
        parent::__construct($context);
        $this->_modelItemFactory = $item;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /* Get the post data */
        $data = $this->getRequest()->getParams();
        $itemId = $data['itemId'];
        $sampleModel = $this->_modelItemFactory->create();
        $item = $sampleModel->load($itemId);
        try {
            /* Use the resource model to save the model in the DB */
            $item->delete();
            $this->messageManager->addSuccessMessage("Item deleted successfully!");
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error in deleting Item"));
        }

        /* Redirect back to custom module page */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('helloworld');
        return $redirect;
    }
}
