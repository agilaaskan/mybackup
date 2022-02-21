diff --git a/app/code/Magento/Checkout/Model/Session.php b/app/code/Magento/Checkout/Model/Session.php
index a654c78853d7..4a4861fa9ccd 100644
--- a/app/code/Magento/Checkout/Model/Session.php
+++ b/app/code/Magento/Checkout/Model/Session.php
@@ -7,6 +7,8 @@
 
 use Magento\Customer\Api\Data\CustomerInterface;
 use Magento\Framework\App\ObjectManager;
+use Magento\Framework\Exception\NoSuchEntityException;
+use Magento\Quote\Api\Data\CartInterface;
 use Magento\Quote\Model\Quote;
 use Magento\Quote\Model\QuoteIdMaskFactory;
 use Psr\Log\LoggerInterface;
@@ -21,9 +23,6 @@
  */
 class Session extends \Magento\Framework\Session\SessionManager
 {
-    /**
-     * Checkout state begin
-     */
     const CHECKOUT_STATE_BEGIN = 'begin';
 
     /**
@@ -228,7 +227,7 @@ public function setLoadInactive($load = true)
      *
      * @return Quote
      * @throws \Magento\Framework\Exception\LocalizedException
-     * @throws \Magento\Framework\Exception\NoSuchEntityException
+     * @throws NoSuchEntityException
      * @SuppressWarnings(PHPMD.CyclomaticComplexity)
      * @SuppressWarnings(PHPMD.NPathComplexity)
      */
@@ -273,21 +272,17 @@ public function getQuote()
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
@@ -375,7 +370,7 @@ public function loadCustomerQuote()
 
         try {
             $customerQuote = $this->quoteRepository->getForCustomer($this->_customerSession->getCustomerId());
-        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
+        } catch (NoSuchEntityException $e) {
             $customerQuote = $this->quoteFactory->create();
         }
         $customerQuote->setStoreId($this->_storeManager->getStore()->getId());
@@ -558,7 +553,7 @@ public function restoreQuote()
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