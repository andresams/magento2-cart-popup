<?php
/**
 * PopupCart data source
 *
 * @category   Prestafy
 * @package    Prestafy_PopupDisplay
 * @author     Andresa Martins <contact@andresa.dev>
 * @copyright  Copyright (c) 2019 Prestafy eCommerce Solutions (https://www.prestafy.com.br)
 * @license    http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Prestafy\PopupDisplay\CustomerData;

use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Checkout\Helper\Cart as CartHelper;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Prestafy\PopupDisplay\Helper\Data as Helper;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

/**
 * PopupCart source
 */
class PopupCartData implements SectionSourceInterface
{
    const CONFIG_PRODUCT_LIMIT = 4;
    const CONFIG_COLLECTION_TYPE = 'cartpopup/settings/product_carousel';

    /**
     * @var Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;

    /** @var Magento\Catalog\Helper\Image */
    protected $catalogImage;

    /**
     * @var PricingHelper
     */
    protected $pricingHelper;

    /**
     * @var Status
     */
    protected $productStatus;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /** @var Collection */
    protected $collection;

    /**
     * @var \Magento\Checkout\Helper\Cart
     */
    protected $cartHelper;

    /** @var Helper */
    protected $helper;

    /**
     * @param CollectionFactory $collectionFactory
     * @param Image $catalogImage
     * @param PricingHelper $pricingHelper
     * @param Status $productStatus
     * @param Visibility $productVisibility
     * @param CartHelper $cartHelper
     * @param Helper $helper
     * @codeCoverageIgnore
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Image $catalogImage,
        PricingHelper $pricingHelper,
        Status $productStatus,
        Visibility $productVisibility,
        CartHelper $cartHelper,
        Helper $helper
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->catalogImage = $catalogImage;
        $this->pricingHelper = $pricingHelper;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->cartHelper = $cartHelper;
        $this->helper = $helper;

        $this->_initCollection();
    }

    /**
     * Return data for section "cartpopup"
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $collectionType = $this->helper->getStoreConfig(self::CONFIG_COLLECTION_TYPE);
        $this->$collectionType();
        $output = [
            'cartTotalCount' => $this->cartHelper->getSummaryCount(),
            'products'       => $this->_getCollection()
        ];

        return $output;
    }

    /**
     * Init Product Collection
     */
    private function _initCollection()
    {
        /**
         * I'm still using a collection here because currently
         * it is not possible to sort a repository result randomly.
         *
         * TODO: Remove collection and implement a repository
         */

        $this->collection = $this->collectionFactory->create();
        $this->collection->addAttributeToSelect('*');
        $this->collection->addStoreFilter();
        $this->collection->addAttributeToFilter(
            'status',
            ['in' => $this->productStatus->getVisibleStatusIds()]
        );
        $this->collection->addAttributeToFilter(
            'visibility',
            ['in' => $this->productVisibility->getVisibleInSiteIds()]
        );
        $this->collection->addUrlRewrite();
        $this->collection->addMinimalPrice();
    }

    /**
     * Select random products
     */
    private function _randomProducts()
    {
        $this->collection->getSelect()->orderRand();
    }

    /**
     * Select latest products
     */
    private function _latestProducts()
    {
        $this->collection->addAttributeToSort('entity_id', 'desc');
    }

    /**
     * Build Collection
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function _getCollection()
    {
        /**
         * Set collection limit
         * TODO: Create admin configuration to set this value and implement product carousel
         */
        $this->collection->setPageSize(self::CONFIG_PRODUCT_LIMIT);

        foreach ($this->collection as $i => $product) {
            $product->setData('product_url', $product->getProductUrl());
            $product->setData(
                'product_image',
                $this->catalogImage->init($product, 'product_base_image')
                    ->getUrl()
            );
            $product->setData(
                'product_price',
                $this->pricingHelper->currency(
                    $product->getMinimalPrice(),
                    true,
                    false
                )
            );
            $this->collection->removeItemByKey($i);
            $this->collection->addItem($product);
        }

        return $this->collection->toArray();
    }
}
