<?php

namespace CTS\HelloWorld\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
   /**
   *
   *
   */
   public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
   {
      $setup->startSetup();
      if(!$setup->tableExists('cts_helloworld_items')) {

         $table = $setup->getConnection()->newTable(
            $setup->getTable('cts_helloworld_items')
         )->addColumn(
            'id', // Name of the field
            Table::TYPE_INTEGER, // Type of the field
            null, //Size of the field
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Item Id' //comments
         )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Item Name'
         )->addColumn(
				'featured_image',
				Table::TYPE_TEXT,
				255,
				[],
				'Post Featured Image'
			)->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created Date'
         )->addIndex(
            $setup->getIdxName('cts_helloworld_items', ['name', 'featured_image']),
            ['name', 'featured_image']
         )->setComment('Sample Items');

         $setup->getConnection()->createTable($table);
      }
      $setup->endSetup();
   }



}
