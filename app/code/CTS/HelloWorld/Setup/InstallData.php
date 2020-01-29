<?php
namespace CTS\HelloWorld\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface{

   public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context){
      $setup->startSetup();
      $setup->getConnection()->insert(
         $setup->getTable('cts_helloworld_items'),
         [
            'name' => 'Item 1',
            'featured_image' => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html'
         ]
      );
      $setup->getConnection()->insert(
      $setup->getTable('cts_helloworld_items'),
         [
            'name' => 'Item 2',
            'featured_image' => '/magento-2-module-development/magento-2-how-to-create-sql-setup-script.html'
         ]
      );

      $setup->endSetup();
   }
}
