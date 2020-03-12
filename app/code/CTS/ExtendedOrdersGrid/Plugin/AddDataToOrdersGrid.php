<?php
namespace CTS\ExtendedOrdersGrid\Plugin;

/**
 * Class AddDataToOrdersGrid
 */
class AddDataToOrdersGrid
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * AddDataToOrdersGrid constructor.
     *
     * @param \Psr\Log\LoggerInterface $customLogger
     * @param array $data
     */
    public function __construct(
        \Psr\Log\LoggerInterface $customLogger,
        array $data = []
    ) {
        $this->logger   = $customLogger;
    }

    /**
     * @param \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject
     * @param \Magento\Sales\Model\ResourceModel\Order\Grid\Collection $collection
     * @param $requestName
     * @return mixed
     */
    public function afterGetReport($subject, $collection, $requestName)
    {
        if ($requestName !== 'sales_order_grid_data_source') {
            return $collection;
        }

        if ($collection->getMainTable() === $collection->getResource()->getTable('sales_order_grid')) {
            try {
                $orderAddressTableName = $collection->getResource()->getTable('sales_order_address');
                $collection->getSelect()->joinLeft(
                   ['soat' => $orderAddressTableName],
                   'soat.parent_id = main_table.entity_id AND soat.address_type = \'shipping\'',
                   ['s_city'=>'city','s_postcode'=>'postcode']
              );
              $orderAddressTableName2 = $collection->getResource()->getTable('sales_order_address');
              $collection->getSelect()->joinLeft(
                 ['soat1' => $orderAddressTableName2],
                 'soat1.parent_id = main_table.entity_id AND soat1.address_type = \'billing\'',
                 ['b_city'=>'city','b_postcode'=>'postcode']
            );
            } catch (\Zend_Db_Select_Exception $selectException) {
                // Do nothing in that case
                $this->logger->log(100, $selectException);
            }
        }

        return $collection;
    }
}
