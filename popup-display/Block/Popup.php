<?php
/**
 * A block that displays some cute cart popup
 *
 * @category   Prestafy
 * @package    Prestafy_PopupDisplay
 * @author     Andresa Martins <contact@andresa.dev>
 * @copyright  Copyright (c) 2019 Prestafy eCommerce Solutions (https://www.prestafy.com.br)
 * @license    http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Prestafy\PopupDisplay\Block;

use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Template;

class Popup extends Template
{
    /** @var AssetRepository  */
    protected $assetRepository;

    /**
     * Popup constructor.
     * @param Template\Context $context
     * @param AssetRepository $assetRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        AssetRepository $assetRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->assetRepository = $assetRepository;
    }

    /**
     * Get shopping cart url
     * @return string
     */
    public function getShoppingCartUrl()
    {
        return $this->getUrl('checkout/cart');
    }

    /**
     * Returns a message to be displayed on the cart popup
     * @return string
     */
    public function getCartMessage()
    {
        $message  = __('A new item has been added to your Shopping Cart. ');
        $message .= __('You now have %s items in your Shopping Cart.');

        return sprintf($message, "<span id='cart-popup-total-count'></span>");
    }

    /**
     * Returns an icon to be displayed
     * @return string
     */
    public function getSuccessIcon()
    {
        return $this->assetRepository->getUrl('Prestafy_PopupDisplay::images/success_icon.png');
    }
}
