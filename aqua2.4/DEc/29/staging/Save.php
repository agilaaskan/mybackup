<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_ProductAlerts
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\ProductAlerts\Observer\Product;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Mageplaza\ProductAlerts\Helper\Data as HelperData;
use Mageplaza\ProductAlerts\Model\Config\Source\Type;
use Mageplaza\ProductAlerts\Model\LogFactory;
use RuntimeException;

/**
 * Class Save
 * @package Mageplaza\ProductAlerts\Observer\Product
 */
class Save implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * @var LogFactory
     */
    protected $_logFactory;

    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * Save constructor.
     *
     * @param ManagerInterface $messageManager
     * @param LogFactory $logFactory
     * @param HelperData $helperData
     */
    public function __construct(
        ManagerInterface $messageManager,
        LogFactory $logFactory,
        HelperData $helperData
    ) {
        $this->_messageManager = $messageManager;
        $this->_logFactory = $logFactory;
        $this->_helperData = $helperData;
    }

    /**
     * @param Observer $observer
     *
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        if (!$this->_helperData->isEnabled()) {
            return;
        }

        /** @var Product $product */
        $product = $observer->getProduct();
        $currentStockStatus = $product->getOrigData('quantity_and_stock_status');
        $oldPrice = (float)$product->getOrigData('price');
        $newPrice = (float)$product->getData('price');
        $newStockData = $product->getData('stock_data');
        $log = $this->_logFactory->create();
        if (!$newStockData['is_in_stock']
            && $logId = $log->getResource()->getLogByProductId($product->getId(), Type::STOCK_SUBSCRIPTION)) {
            $log->load($logId)->delete();
        }
        if(isset($currentStockStatus)) {
            if (!$currentStockStatus['is_in_stock']
                && $newStockData['is_in_stock']
                && ($newStockData['qty'] > 0)
                && $this->_helperData->getStockConfig('enabled')
                && $this->_helperData->isProductStockNotifyEnabled($product)
            ) {
                $newLog = $this->_logFactory->create();
                try {
                    if (!$newLog->getResource()->getLogByProductId($product->getId(), Type::STOCK_SUBSCRIPTION)) {
                        $newLog->setProductId($product->getId())->setType(Type::STOCK_SUBSCRIPTION)->save();
                    }
                } catch (RuntimeException $e) {
                    $this->_messageManager->addError($e->getMessage());
                } catch (Exception $e) {
                    $this->_messageManager->addException($e, __('Something went wrong while saving the Log.'));
                }
            }
        }
        if ($oldPrice !== $newPrice
            && $this->_helperData->getPriceConfig('enabled')
            && $this->_helperData->isProductPriceAlertEnabled($product)
        ) {
            $log = $this->_logFactory->create();
            try {
                if ($logId = $log->getResource()->getLogByProductId($product->getId(), Type::PRICE_SUBSCRIPTION)) {
                    $oldPrice = $log->load($logId)->getOldPrice();
                    $log->delete();
                }
                $newLog = $this->_logFactory->create();
                $newLog->setProductId($product->getId())
                    ->setType(Type::PRICE_SUBSCRIPTION)
                    ->setOldPrice($oldPrice)
                    ->save();
            } catch (RuntimeException $e) {
                $this->_messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_messageManager->addException($e, __('Something went wrong while saving the Log.'));
            }
        }
    }
}
