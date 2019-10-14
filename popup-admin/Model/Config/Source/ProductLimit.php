<?php
/**
 * Product Limit Source Options
 *
 * @category   Prestafy
 * @package    Prestafy_PopupAdmin
 * @author     Andresa Martins <contact@andresa.dev>
 * @copyright  Copyright (c) 2019 Prestafy eCommerce Solutions (https://www.prestafy.com.br)
 * @license    http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Prestafy\PopupAdmin\Model\Config\Source;

class ProductLimit implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 5, 'label' => 5],
            ['value' => 10, 'label' => 10],
            ['value' => 15, 'label' => 15],
            ['value' => 20, 'label' => 20],
            ['value' => 25, 'label' => 25]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            5  => 5,
            10 => 10,
            15 => 15,
            20 => 20,
            25 => 25
        ];
    }
}
