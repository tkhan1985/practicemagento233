<?php
namespace CTS\HelloWorld\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Created by Carl Owens (carl@partfire.co.uk)
 * Company: PartFire Ltd (www.partfire.co.uk)
 **/
class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    private $httpContext;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Http\Context $httpContext
    ) {
        parent::__construct($context);
        $this->httpContext = $httpContext;
    }

    public function isLoggedIn()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return $isLoggedIn;
    }
}
