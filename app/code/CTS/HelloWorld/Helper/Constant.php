<?php
namespace CTS\HelloWorld\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Created by Carl Owens (carl@partfire.co.uk)
 * Company: PartFire Ltd (www.partfire.co.uk)
 **/
class Constant extends AbstractHelper
{
    const ORDER_TABLES = [
          'Quote' => [
             'quote' => 'This table contains records on every shopping cart created in your store, whether they were abandoned or converted to a purchase',
             'quote_address' => 'This table keeping shipping address and billing address id based on quote id',
             'quote_address_item' => 'Not in use during quote',
             'quote_id_mask' => 'It doesn’t include the cart_id_mask value in the quote_id_mask table, it makes difficult for hackers to obtain information of your registered users',
             'quote_item' => 'This table contains records on every item added to a shopping cart',
             'quote_item_option' => 'Managed relation between item and product',
             'quote_payment' => 'Before fulfill order payment details of that quote is captured in this table',
             'quote_shipping_rate' => 'Before fulfill order shipping details of that quote is captured in this table'
          ],
          'Order' => [
             'sales_order' => 'It is designed to store all information required for sales order grid rendering, so custom columns are required to be added to this table.',
             'sales_order_address' => 'It store all addresses of the customer',
             'sales_order_aggregated_created' => 'Holds order amount in aggregrated forms related to shipping, tax, discount, invoice, profice and lots more',
             'sales_order_aggregated_updated' => 'This is same as sales_order_aggregated_created table but only when any amount is updated',
             'sales_order_grid' => 'This is index table and is used for order grid rendering speed up,  It is designed to store all information required for sales order grid rendering',
             'sales_order_item' => 'This table is same a quote item',
             'sales_order_payment' => 'This is used to store the payment details of your order ',
             'sales_order_status' => 'This is for the status of the order',
             'sales_order_status_history' => 'All the status is storing for the order. i.e when it is process, when invoice created ...',
             'sales_order_status_label' => 'The table sales_order_status only has label and code for each order statu',
             'sales_order_status_state' => 'sales_order_status_state stores the association of order status to order state.',
             'sales_order_tax' => 'This holds the tax for each order',
             'sales_order_tax_item' => 'This holds the tax for each item in the order',
             'sales_refunded_aggregated_order' => 'NA',
             'sales_shipping_aggregated_order' => 'NA',
          ],
    ];


}
