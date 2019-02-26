<?php
namespace Bzphua\Stockstatus\Ui\DataProvider\Product;

class AddQuantityProcessingFieldToCollection implements \Magento\Ui\DataProvider\AddFieldToCollectionInterface
{
    public function addField(\Magento\Framework\Data\Collection $collection, $field, $alias = null)
    {
		//$subquery = new \Zend_Db_Expr('(SELECT SUM(soi.qty_ordered) AS quantity_pending FROM sales_order_item soi INNER JOIN sales_order so ON soi.order_id=so.entity_id WHERE status="pending" AND soi.product_id=e.entity_id GROUP BY soi.product_id,so.status )');

		//$collection->getSelect()->from($subquery);
		
		$collection->getSelect()->columns(
                array(
                    'quantity_processing' => new \Zend_Db_Expr('(SELECT SUM(soi.qty_ordered) FROM sales_order_item soi INNER JOIN sales_order so ON soi.order_id=so.entity_id WHERE status="processing" AND soi.product_id=e.entity_id GROUP BY soi.product_id,so.status)')));
		
        //$collection->joinField('quantity_pending', 'sales_order_item', 'manage_stock', 'product_id=entity_id', null, 'left');
		
		/*$collection->getSelect()->group('e.entity_id'); // TRY THIS LINE OF CODE

		$collection->getSelect()
				->columns('SUM(qty_ordered) AS quantity_pending')
				->joinLeft(array("soi" => "sales_order_item"), "soi.product_id = e.entity_id");

		$collection->getSelect()
				->joinLeft(array("so" => "sales_order"), "soi.order_id=so.entity_id AND so.status='pending'");*/
    }
}