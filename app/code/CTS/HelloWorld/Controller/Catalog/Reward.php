<?php
namespace CTS\HelloWorld\Controller\Catalog;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;


class Reward extends Action
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;


    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory, JsonFactory $resultJsonFactory)
    {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;

        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $resultPage = $this->_resultPageFactory->create();
        $post = $this->getRequest()->getPostValue();

        if (!$post) {
            $this->_redirect('*/*/');
            return;
        }

        $email = $post['emailId'];
        $yob = $post['yob'];

        $block = $resultPage->getLayout()
                ->createBlock('CTS\HelloWorld\Block\Catalog\Reward')
                ->setTemplate('CTS_HelloWorld::catalog/reward.phtml')
                ->setData('data',['email' => $email, 'yob' => $yob])
                ->toHtml();

        $result->setData(['output' => $block]);

        //$result->setData(['output' => $email]);

        return $result;
    }

}
