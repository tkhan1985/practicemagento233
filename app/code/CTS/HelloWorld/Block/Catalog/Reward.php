<?php
namespace CTS\HelloWorld\Block\Catalog;

use Magento\Framework\View\Element\Template;

class Reward extends Template
{
   const ELIGIBILITY_YEAR = 1985;

   public function __construct(Template\Context $context, array $data = [])
   {
     parent::__construct($context, $data);
   }

   protected function _prepareLayout()
   {
        return parent::_prepareLayout(); // TODO: Change the autogenerated stub
   }

   public function getReward()
   {
      $formData = $this->getData();
      $email = $formData['data']['email'];
      $yob = $formData['data']['yob'];
      $eligibililty = $this->validateEligibility($yob);
      if($eligibililty) {
         $coupon = $this->generateCoupon($email);
         //$this->saveCouponCode($coupon);
         return $coupon['code'];
      } else {
         return false;
      }
   }

   public function validateEligibility($yob)
   {
      return ($yob <= self::ELIGIBILITY_YEAR) ? true : false;
   }

   public function generateCoupon($email)
   {
      $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; //random string to generate the code
      $email = explode('@', $email);
      $ranCode = substr($email[0], 0, 4).substr(str_shuffle($str_result), 0, 8);
      $ranStr = substr($email[0], 0, 4).substr(str_shuffle($str_result), 0, 5);
      $coupon['name'] = 'ADDITIONAL_REWARD-'.$ranStr.''; //Generate a rule name
      $coupon['desc'] = 'Discount on few product type based on birth year';
      $coupon['start'] = date('Y-m-d'); //Coupon use start date
      $coupon['end'] = ''; //coupon use end date
      $coupon['max_redemptions'] = 1; //Uses per Customer
      $coupon['discount_type'] ='cart_fixed'; //for discount type
      $coupon['discount_amount'] = 10; //discount amount/percentage
      $coupon['flag_is_free_shipping'] = 'no';
      $coupon['redemptions'] = 1;
      $coupon['code'] = $ranCode;

      return $coupon;
   }

   public function saveCouponCode($coupon)
   {
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      $shoppingCartPriceRule = $objectManager->create('Magento\SalesRule\Model\Rule');
      $shoppingCartPriceRule->setName($coupon['name'])
      ->setDescription($coupon['desc'])
      ->setFromDate($coupon['start'])
      ->setToDate($coupon['end'])
      ->setUsesPerCustomer($coupon['max_redemptions'])
      ->setCustomerGroupIds(array('1','2','3')) //select customer group pass 0 for non logged in user
      ->setIsActive(1)
      ->setSimpleAction($coupon['discount_type'])
      ->setDiscountAmount($coupon['discount_amount'])
      ->setDiscountQty(1)
      ->setApplyToShipping($coupon['flag_is_free_shipping'])
      ->setTimesUsed($coupon['redemptions'])
      ->setWebsiteIds(array('1'))
      ->setCouponType(2)
      ->setCouponCode($coupon['code'])
      ->setUsesPerCoupon(1);
      $shoppingCartPriceRule->save();
   }

}
