<?php
/**
 * Carousel Source Options
 *
 * @category   Prestafy
 * @package    Prestafy_PopupAdmin
 * @author     Andresa Martins <contact@andresa.dev>
 * @copyright  Copyright (c) 2019 Prestafy eCommerce Solutions (https://www.prestafy.com.br)
 * @license    http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Prestafy\PopupAdmin\Model\Config\Source;

class Carousel implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Related Products')],
            ['value' => 1, 'label' => __('Best Sellers')],
            ['value' => 2, 'label' => __('Newest Products')],
            ['value' => 3, 'label' => __('Random Products')],
            ['value' => 4, 'label' => __('Products on the same category')]
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
            0 => __('Related Products'),
            1 => __('Best Sellers'),
            2 => __('Newest Products'),
            3 => __('Random Products'),
            4 => __('Products on the same category')
        ];
    }
}
