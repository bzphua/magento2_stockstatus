<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bzphua\Stockstatus\Ui\DataProvider\Product;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;

/**
 * Class AddQuantityFilterToCollection
 */
class AddQuantityAvailableFilterToCollection implements AddFilterToCollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function addFilter(Collection $collection, $field, $condition = null)
    {
        if (isset($condition['gteq'])) {
            $collection->getSelect()->where(
                '(SELECT at_qty.qty-SUM(soi.qty_ordered) FROM sales_order_item soi INNER JOIN sales_order so ON soi.order_id=so.entity_id WHERE soi.product_id=e.entity_id GROUP BY soi.product_id) >= ?',
                (float)$condition['gteq']
            );
        }
        if (isset($condition['lteq'])) {
            $collection->getSelect()->where(
                '(SELECT at_qty.qty-SUM(soi.qty_ordered) FROM sales_order_item soi INNER JOIN sales_order so ON soi.order_id=so.entity_id WHERE soi.product_id=e.entity_id GROUP BY soi.product_id) <= ?',
                (float)$condition['lteq']
            );
        }
    }
}
