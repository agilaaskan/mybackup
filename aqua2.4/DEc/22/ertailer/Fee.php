<?php
namespace Magecomp\Extrafee\Model\Quote\Total;

class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    protected $helperData;
	protected $_priceCurrency;

    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null;

    public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator,
								\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
                                \Magecomp\Extrafee\Helper\Data $helperData,
                                \Magento\Backend\Model\Session\Quote $backendQuoteSession,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethodManagement,
                                \Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->quoteValidator = $quoteValidator;
		$this->_priceCurrency = $priceCurrency;
        $this->helperData = $helperData;
        $this->backendQuoteSession = $backendQuoteSession;
        $this->_storeManager = $storeManager;
        $this->shippingMethod = $shippingMethodManagement;
        $this->_checkoutSession = $checkoutSession;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        if (!count($shippingAssignment->getItems())) {
            return $this;
        }
        //echo 'etea';
        $methodTitle = $this->backendQuoteSession->getQuote()->getShippingAddress()->getShippingMethod();
        $selectedShipping = $this->_checkoutSession->getQuote()->getShippingAddress()->getShippingMethod();
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        $extra_fee = true;
        if($websiteId == 1){
            $extra_fee = true;
        }else{
            $extra_fee = false;
        }
        $enabled = $this->helperData->isModuleEnabled();
        $minimumOrderAmount = $this->helperData->getMinimumOrderAmount();
        $subtotal = $total->getTotalAmount('subtotal');
        $finalamount = 0;
        if($selectedShipping == 'flatrate_flatrate' || $methodTitle == 'flatrate_flatrate'){
            $extra_fee = false;
            $fee=0;
        }else{
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        // retrieve quote items array
        $items = $cart->getQuote()->getAllItems();
        $fee = 0;
        $flag = 0;
        $flag1 = 0;
        if(!empty($items)){
        $item_count = count($items);
        foreach($items as $item) {
            $productid = $item->getProductId();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productid);
            $categoriesIds = $product->getCategoryIds();
            if (in_array("3125", $categoriesIds) && $item_count >= 1){
                $qty = $item->getQty();
                $price = $item->getPrice();
                $amount = $price * $qty;
                $finalamount = $finalamount + $amount;
                $flag++;
                if($finalamount > 250){ $flag = 0;}
            }
        }
        //echo $item_count;
        //echo $flog;
            if($item_count != $flag){
                if($finalamount > 250){
                    $fee = 0;
                }else{
                    $fee = $this->helperData->getExtrafee();
                }
               if($flag == 0){
                   $fee = 0;$extra_fee = false;
               }else{
                $extra_fee = true;
               }
            }
        }
        
        //$items_admin = $this->sessionQuote->getQuote();
        $items_admin = $this->backendQuoteSession->getQuote()->getAllVisibleItems();
       
        //exit();
        // $objectManagerAdmin = \Magento\Backend\Model\Session\Quote;
        // $items_admin = $objectManagerAdmin->getQuote()->getAllVisibleItems();
        if(!empty($items_admin)){
        $item_admin_count = count($items_admin);
        foreach($items_admin as $item){
            $productid = $item->getProductId();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productid);
            $categoriesIds = $product->getCategoryIds();
            //print_r($categoriesIds);
            if (in_array("3125", $categoriesIds) && $item_admin_count >= 1){
                $qty = $item->getQty();
                $price = $item->getPrice();
                $amount = $price * $qty;
                $finalamount = $finalamount + $amount;
                $flag1++;
                if($finalamount > 250){ $flag1 = 0;}
            }
        }
        if($item_admin_count != $flag1){
            if($finalamount > 250){
                $fee = 0;
            }else{
                $fee = $this->helperData->getExtrafee();
            }
            if($flag1 == 0){$fee = 0;$extra_fee = false;}else{
                $extra_fee = true;
            }
            
        }else{
                 $extra_fee = false;
            }
        }
        }
        if ($enabled && $minimumOrderAmount <= $subtotal && $extra_fee) {
            
            //$fee = $this->helperData->getExtrafee();
            //Try to test with sample value
            //$fee=50;
            $total->setTotalAmount('fee', $fee);
            $total->setBaseTotalAmount('fee', $fee);
            $total->setFee($fee);
            $quote->setFee($fee);
            
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
			$version = (float)$productMetadata->getVersion(); 
			if($version > 2.1)
			{
				//$total->setGrandTotal($total->getGrandTotal() + $fee);
			}
			else
			{
				$total->setGrandTotal($total->getGrandTotal() + $fee);
			}
			
		}
        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $methodTitle = $this->backendQuoteSession->getQuote()->getShippingAddress()->getShippingMethod();
        $selectedShipping = $this->_checkoutSession->getQuote()->getShippingAddress()->getShippingMethod();
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        $extra_fee = true;
        if($websiteId == 1){
            $extra_fee = true;
        }else{
            $extra_fee = false;
        }
        $enabled = $this->helperData->isModuleEnabled();
        $minimumOrderAmount = $this->helperData->getMinimumOrderAmount();
        $subtotal = $total->getTotalAmount('subtotal');
        $finalamount = 0;
        if($selectedShipping == 'flatrate_flatrate' || $methodTitle == 'flatrate_flatrate'){
            $extra_fee = false;
            $fee=0;
        }else{
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
        // retrieve quote items array
        $items = $cart->getQuote()->getAllItems();
        $fee = 0;
        $flag = 0;
        $flag1 = 0;
        if(!empty($items)){
        $item_count = count($items);
        foreach($items as $item) {
            $productid = $item->getProductId();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productid);
            $categoriesIds = $product->getCategoryIds();
            if (in_array("3125", $categoriesIds) && $item_count >= 1){
                $qty = $item->getQty();
                $price = $item->getPrice();
                $amount = $price * $qty;
                $finalamount = $finalamount + $amount;
                $flag++;
                if($finalamount > 250){ $flag = 0;}
            }
        }
        //echo $item_count;
        //echo $flog;
            if($item_count != $flag){
                if($finalamount > 250){
                    $fee = 0;
                }else{
                    $fee = 45;//$this->helperData->getExtrafee();
                }
               if($flag == 0){
                   $fee = 0;$extra_fee = false;
               }else{
                $extra_fee = true;
               }
            }
        }
        
        //$items_admin = $this->sessionQuote->getQuote();
        $items_admin = $this->backendQuoteSession->getQuote()->getAllVisibleItems();
       
        //exit();
        // $objectManagerAdmin = \Magento\Backend\Model\Session\Quote;
        // $items_admin = $objectManagerAdmin->getQuote()->getAllVisibleItems();
        if(!empty($items_admin)){
        $item_admin_count = count($items_admin);
        foreach($items_admin as $item){
            $productid = $item->getProductId();
            $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productid);
            $categoriesIds = $product->getCategoryIds();
            //print_r($categoriesIds);
            if (in_array("3125", $categoriesIds) && $item_admin_count >= 1){
                $qty = $item->getQty();
                $price = $item->getPrice();
                $amount = $price * $qty;
                $finalamount = $finalamount + $amount;
                $flag1++;
                if($finalamount > 250){ $flag1 = 0;}
            }
        }
        if($item_admin_count != $flag1){
            if($finalamount > 250){
                $fee = 0;
            }else{
                $fee = 45;//$this->helperData->getExtrafee();
            }
            if($flag1 == 0){$fee = 0;$extra_fee = false;}else{
                $extra_fee = true;
            }
            
        }else{
                 $extra_fee = false;
            }
        }
        }

        $enabled = $this->helperData->isModuleEnabled();
        $minimumOrderAmount = $this->helperData->getMinimumOrderAmount();
        $subtotal = $quote->getSubtotal();
        //$fee = $quote->getFee();
        $result = [];
        if ($enabled && ($minimumOrderAmount <= $subtotal) && $fee) {
            $result = [
                'code' => 'fee',
                'title' => $this->helperData->getFeeLabel(),
                'value' => $fee
            ];
        }
        return $result;
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Extra Fee');
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     */
    protected function clearValues(\Magento\Quote\Model\Quote\Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);

    }
}
