<?php

namespace CTS\HelloWorld\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use CTS\HelloWorld\Model\Item;
use CTS\HelloWorld\Model\ResourceModel\Item as ItemResource;
use CTS\HelloWorld\Block\Index as ItemBlock;
//For Image
use  Magento\Framework\App\Filesystem\DirectoryList;

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

   //For Image Upload
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;

    /**
     * Add constructor.
     * @param Context $context
     * @param Item $car
     * @param ItemResource $carResource
     */
    public function __construct(
        Context $context,
        Item $item,
        ItemResource $itemResource,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Image\AdapterFactory $adapterFactory,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        parent::__construct($context);
        $this->item = $item;
        $this->itemResource = $itemResource;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
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
        $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'featured_image']);

        try {
              $imageAdapter = $this->adapterFactory->create();
              /* start of validated image */
              $uploaderFactory->addValidateCallback('custom_image_upload',
              $imageAdapter,'validateUploadFile');
              $uploaderFactory->setAllowRenameFiles(true);
              $uploaderFactory->setFilesDispersion(true);
              //$mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
              //$destinationPath = $mediaDirectory->getAbsolutePath('custom_image');
              $destinationPath = ItemBlock::getItemImageAbsPath();
              $result = $uploaderFactory->save($destinationPath);
              if (!$result) {
                  throw new LocalizedException(
                      __('File cannot be saved to path: $1', $destinationPath)
                  );
              }
             $data['featured_image'] = $result['file'];
             /* Set the data in the model */
             $itemModel = $this->item;
             $itemModel->setData($data);
            /* Use the resource model to save the model in the DB */
            $this->itemResource->save($itemModel);
            $this->messageManager->addSuccessMessage("Item saved successfully!");
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error saving Item"));
            $this->messageManager->addErrorMessage(__($exception->mesage()));
        }

        /* Redirect back to custom module page */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('helloworld/index');
        return $redirect;
    }
}
