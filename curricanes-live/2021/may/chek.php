<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Checkout\Model;
 
 use Magento\Customer\Api\Data\CustomerInterface;
 use Magento\Framework\App\ObjectManager;
 use Magento\Framework\Exception\NoSuchEntityException;
 use Magento\Quote\Api\Data\CartInterface;
 use Magento\Quote\Model\Quote;
 use Magento\Quote\Model\QuoteIdMaskFactory;
 use Psr\Log\LoggerInterface;

/**
 * Represents the session data for the checkout process
 *
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.CookieAndSessionMisuse)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @since 100.0.2
  */
 class Session extends \Magento\Framework\Session\SessionManager
 {
     const CHECKOUT_STATE_BEGIN = 'begin';
 
     /**
 * Quote instance
     *
     * @var Quote
     */
    protected $_quote;

    /**
     * Customer Data Object
     *
     * @var CustomerInterface|null
     */
    protected $_customer;

    /**
     * Whether load only active quote
     *
     * @var bool
     */
    protected $_loadInactive = false;

    /**
     * A flag to track when the quote is being loaded and attached to the session object.
     *
     * Used in trigger_recollect infinite loop detection.
     *
     * @var bool
     */
    private $isLoading = false;

    /**
     * Loaded order instance
     *
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $_remoteAddress;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;

    /**
     * @param bool
     */
    protected $isQuoteMasked;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\Session\SidResolverInterface $sidResolver
     * @param \Magento\Framework\Session\Config\ConfigInterface $sessionConfig
     * @param \Magento\Framework\Session\SaveHandlerInterface $saveHandler
     * @param \Magento\Framework\Session\ValidatorInterface $validator
     * @param \Magento\Framework\Session\StorageInterface $storage
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param LoggerInterface|null $logger
     * @throws \Magento\Framework\Exception\SessionException
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Session\SidResolverInterface $sidResolver,
        \Magento\Framework\Session\Config\ConfigInterface $sessionConfig,
        \Magento\Framework\Session\SaveHandlerInterface $saveHandler,
        \Magento\Framework\Session\ValidatorInterface $validator,
        \Magento\Framework\Session\StorageInterface $storage,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\App\State $appState,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        LoggerInterface $logger = null
    ) {
        $this->_orderFactory = $orderFactory;
        $this->_customerSession = $customerSession;
        $this->quoteRepository = $quoteRepository;
        $this->_remoteAddress = $remoteAddress;
        $this->_eventManager = $eventManager;
        $this->_storeManager = $storeManager;
        $this->customerRepository = $customerRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->quoteFactory = $quoteFactory;
        parent::__construct(
            $request,
            $sidResolver,
            $sessionConfig,
            $saveHandler,
            $validator,
            $storage,
            $cookieManager,
            $cookieMetadataFactory,
            $appState
        );
        $this->logger = $logger ?: ObjectManager::getInstance()
            ->get(LoggerInterface::class);
    }

    /**
     * Set customer data.
     *
     * @param CustomerInterface|null $customer
     * @return \Magento\Checkout\Model\Session
     * @codeCoverageIgnore
     */
    public function setCustomerData($customer)
    {
        $this->_customer = $customer;
        return $this;
    }

    /**
     * Check whether current session has quote
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function hasQuote()
    {
        return isset($this->_quote);
    }

    /**
     * Set quote to be loaded even if inactive
     *
     * @param bool $load
     * @return $this
     * @codeCoverageIgnore
     */
    public function setLoadInactive($load = true)
    {
        $this->_loadInactive = $load;
        return $this;
    }

    /**
     * Get checkout quote instance by current session
     *
      * @return Quote
      * @throws \Magento\Framework\Exception\LocalizedException
      * @throws NoSuchEntityException
      * @SuppressWarnings(PHPMD.CyclomaticComplexity)
      * @SuppressWarnings(PHPMD.NPathComplexity)
      */
public function getQuote()
    {
        $this->_eventManager->dispatch('custom_quote_process', ['checkout_session' => $this]);

        if ($this->_quote === null) {
            if ($this->isLoading) {
                throw new \LogicException("Infinite loop detected, review the trace for the looping path");
            }
            $this->isLoading = true;
            $quote = $this->quoteFactory->create();
            if ($this->getQuoteId()) {
                try {
                    if ($this->_loadInactive) {
                        $quote = $this->quoteRepository->get($this->getQuoteId());
                    } else {
                        $quote = $this->quoteRepository->getActive($this->getQuoteId());
                    }

                    $customerId = $this->_customer
                        ? $this->_customer->getId()
                        : $this->_customerSession->getCustomerId();

                    if ($quote->getData('customer_id') && (int)$quote->getData('customer_id') !== (int)$customerId) {
                        $quote = $this->quoteFactory->create();
                        $this->setQuoteId(null);
                    }

                    /**
                     * If current currency code of quote is not equal current currency code of store,
                     * need recalculate totals of quote. It is possible if customer use currency switcher or
                     * store switcher.
                     */
                         $quote = $this->quoteRepository->get($this->getQuoteId());
                     }
-                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
+                } catch (NoSuchEntityException $e) {
                     $this->setQuoteId(null);
                 }
             }
 
             if (!$this->getQuoteId()) {
                 if ($this->_customerSession->isLoggedIn() || $this->_customer) {
-                    $customerId = $this->_customer
-                        ? $this->_customer->getId()
-                        : $this->_customerSession->getCustomerId();
-                    try {
-                        $quote = $this->quoteRepository->getActiveForCustomer($customerId);
-                        $this->setQuoteId($quote->getId());
-                    } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
-                        $this->logger->critical($e);
+                    $quoteByCustomer = $this->getQuoteByCustomer();
+                    if ($quoteByCustomer !== null) {
+                        $this->setQuoteId($quoteByCustomer->getId());
+                        $quote = $quoteByCustomer;
                     }
                 } else {
                     $quote->setIsCheckoutCart(true);
public function loadCustomerQuote()
    {
        if (!$this->_customerSession->getCustomerId()) {
            return $this;
        }

        $this->_eventManager->dispatch('load_customer_quote_before', ['checkout_session' => $this]);

        try {
            $customerQuote = $this->quoteRepository->getForCustomer($this->_customerSession->getCustomerId());
        } catch (NoSuchEntityException $e) {
            $customerQuote = $this->quoteFactory->create();
        }
        $customerQuote->setStoreId($this->_storeManager->getStore()->getId());

        if ($customerQuote->getId() && $this->getQuoteId() != $customerQuote->getId()) {
            if ($this->getQuoteId()) {
                $this->quoteRepository->save(
                    $customerQuote->merge($this->getQuote())->collectTotals()
                );
                $newQuote = $this->quoteRepository->get($customerQuote->getId());
                $this->quoteRepository->save(
                    $newQuote->collectTotals()
                );
                $customerQuote = $newQuote;
            }

            $this->setQuoteId($customerQuote->getId());

            if ($this->_quote) {
                $this->quoteRepository->delete($this->_quote);
            }
            $this->_quote = $customerQuote;
        } else {
            $this->getQuote()->getBillingAddress();
            $this->getQuote()->getShippingAddress();
            $this->getQuote()->setCustomer($this->_customerSession->getCustomerDataObject())
                ->setTotalsCollectedFlag(false)
                ->collectTotals();
            $this->quoteRepository->save($this->getQuote());
        }
        return $this;
    }
 
         try {
             $customerQuote = $this->quoteRepository->getForCustomer($this->_customerSession->getCustomerId());
-        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
+        } catch (NoSuchEntityException $e) {
             $customerQuote = $this->quoteFactory->create();
         }
         $customerQuote->setStoreId($this->_storeManager->getStore()->getId());
public function restoreQuote()
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $this->getLastRealOrder();
        if ($order->getId()) {
            try {
                $quote = $this->quoteRepository->get($order->getQuoteId());
                $quote->setIsActive(1)->setReservedOrderId(null);
                $this->quoteRepository->save($quote);
                $this->replaceQuote($quote)->unsLastRealOrderId();
                $this->_eventManager->dispatch('restore_quote', ['order' => $order, 'quote' => $quote]);
                return true;
            } catch (NoSuchEntityException $e) {
                $this->logger->critical($e);
            }
        }

        return false;
    }
                 $this->replaceQuote($quote)->unsLastRealOrderId();
                 $this->_eventManager->dispatch('restore_quote', ['order' => $order, 'quote' => $quote]);
                 return true;
-            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
+            } catch (NoSuchEntityException $e) {
                 $this->logger->critical($e);
             }
         }
@@ -588,4 +583,22 @@ protected function isQuoteMasked()
     {
         return $this->isQuoteMasked;
     }
+
+    /**
+     * Returns quote for customer if there is any
+     */
+    private function getQuoteByCustomer(): ?CartInterface
+    {
+        $customerId = $this->_customer
+            ? $this->_customer->getId()
+            : $this->_customerSession->getCustomerId();
+
+        try {
+            $quote = $this->quoteRepository->getActiveForCustomer($customerId);
+        } catch (NoSuchEntityException $e) {
+            $quote = null;
+        }
+
+        return $quote;
+    }
 }
diff --git a/app/code/Magento/Checkout/Test/Unit/Model/SessionTest.php b/app/code/Magento/Checkout/Test/Unit/Model/SessionTest.php
index 26234992e613..969631901adf 100644
--- a/app/code/Magento/Checkout/Test/Unit/Model/SessionTest.php
+++ b/app/code/Magento/Checkout/Test/Unit/Model/SessionTest.php
@@ -9,7 +9,8 @@
  */
 namespace Magento\Checkout\Test\Unit\Model;
 
-use \Magento\Checkout\Model\Session;
+use Magento\Checkout\Model\Session;
+use Magento\Framework\Exception\NoSuchEntityException;
 
 /**
  * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
@@ -374,6 +375,68 @@ public function testGetStepData()
         $this->assertEquals($stepData['complex']['key'], $session->getStepData('complex', 'key'));
     }
 
+    /**
+     * Ensure that if quote not exist for customer quote will be null
+     *
+     * @return void
+     */
+    public function testGetQuote(): void
+    {
+        $storeManager = $this->getMockForAbstractClass(\Magento\Store\Model\StoreManagerInterface::class);
+        $customerSession = $this->createMock(\Magento\Customer\Model\Session::class);
+        $quoteRepository = $this->createMock(\Magento\Quote\Api\CartRepositoryInterface::class);
+        $quoteFactory = $this->createMock(\Magento\Quote\Model\QuoteFactory::class);
+        $quote = $this->createMock(\Magento\Quote\Model\Quote::class);
+        $logger = $this->createMock(\Psr\Log\LoggerInterface::class);
+        $loggerMethods = get_class_methods(\Psr\Log\LoggerInterface::class);
+
+        $quoteFactory->expects($this->once())
+             ->method('create')
+             ->willReturn($quote);
+        $customerSession->expects($this->exactly(3))
+             ->method('isLoggedIn')
+             ->willReturn(true);
+        $store = $this->getMockBuilder(\Magento\Store\Model\Store::class)
+             ->disableOriginalConstructor()
+             ->setMethods(['getWebsiteId', '__wakeup'])
+             ->getMock();
+        $storeManager->expects($this->any())
+             ->method('getStore')
+             ->will($this->returnValue($store));
+        $storage = $this->getMockBuilder(\Magento\Framework\Session\Storage::class)
+             ->disableOriginalConstructor()
+             ->setMethods(['setData', 'getData'])
+             ->getMock();
+        $storage->expects($this->at(0))
+             ->method('getData')
+             ->willReturn(1);
+        $quoteRepository->expects($this->once())
+             ->method('getActiveForCustomer')
+         ->willThrowException(new NoSuchEntityException());
+
+        foreach ($loggerMethods as $method) {
+            $logger->expects($this->never())->method($method);
+        }
+
+        $quote->expects($this->once())
+             ->method('setCustomer')
+             ->with(null);
+
+        $constructArguments = $this->_helper->getConstructArguments(
+            \Magento\Checkout\Model\Session::class,
+            [
+                'storeManager' => $storeManager,
+                'quoteRepository' => $quoteRepository,
+                'customerSession' => $customerSession,
+                'storage' => $storage,
+                'quoteFactory' => $quoteFactory,
+                'logger' => $logger
+            ]
+        );
+        $this->_session = $this->_helper->getObject(\Magento\Checkout\Model\Session::class, $constructArguments);
+        $this->_session->getQuote();
+    }
+
     public function testSetStepData()
     {
         $stepData = [