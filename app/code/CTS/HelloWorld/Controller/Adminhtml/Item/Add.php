<?php

namespace CTS\HelloWorld\Controller\Adminhtml\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use CTS\HelloWorld\Model\Item;
use CTS\HelloWorld\Model\ResourceModel\Item as ItemResource;

class Add extends Action
{
    /**
     * @var Item
     */
    private $item;
    /**
     * @var ItemResource
     */
    private $itemResource;

    /**
     * Add constructor.
     * @param Context $context
     * @param Item $car
     * @param ItemResource $carResource
     */
    public function __construct(
        Context $context,
        Item $item,
        ItemResource $itemResource
    )
    {
        parent::__construct($context);
        $this->item = $item;
        $this->itemResource = $itemResource;
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

        /* Set the data in the model */
        $itemModel = $this->item;
        $itemModel->setData($data);

        try {
            /* Use the resource model to save the model in the DB */
            $this->itemResource->save($itemModel);
            $this->messageManager->addSuccessMessage("Item saved successfully!");
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error saving Item"));
        }

        /* Redirect back to custom module page */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('helloworld/index');
        return $redirect;
    }
}
