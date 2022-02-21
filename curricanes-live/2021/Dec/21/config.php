<?php
return [
    'scopes' => [
        'websites' => [
            'admin' => [
                'website_id' => '0',
                'code' => 'admin',
                'name' => 'Admin',
                'sort_order' => '0',
                'default_group_id' => '0',
                'is_default' => '0'
            ],
            'furniture' => [
                'website_id' => '1',
                'code' => 'furniture',
                'name' => 'CURRICANES.COM',
                'sort_order' => '0',
                'default_group_id' => '1',
                'is_default' => '1'
            ]
        ],
        'groups' => [
            [
                'group_id' => '0',
                'website_id' => '0',
                'code' => 'default',
                'name' => 'Default',
                'root_category_id' => '0',
                'default_store_id' => '0'
            ],
            [
                'group_id' => '1',
                'website_id' => '1',
                'code' => 'furniture_store',
                'name' => 'CURRICANES.COM',
                'root_category_id' => '2',
                'default_store_id' => '1'
            ]
        ],
        'stores' => [
            'admin' => [
                'store_id' => '0',
                'code' => 'admin',
                'website_id' => '0',
                'group_id' => '0',
                'name' => 'Admin',
                'sort_order' => '0',
                'is_active' => '1'
            ],
            'furniture_store_view' => [
                'store_id' => '1',
                'code' => 'furniture_store_view',
                'website_id' => '1',
                'group_id' => '1',
                'name' => 'CURRICANES.COM',
                'sort_order' => '0',
                'is_active' => '1'
            ]
        ]
    ],
    'system' => [
        'default' => [
            'general' => [
                'locale' => [
                    'code' => 'es_MX'
                ]
            ],
            'dev' => [
                'static' => [
                    'sign' => '1'
                ],
                'front_end_development_workflow' => [
                    'type' => 'server_side_compilation'
                ],
                'template' => [
                    'minify_html' => '0'
                ],
                'js' => [
                    'merge_files' => '0',
                    'minify_files' => '0',
                    'minify_exclude' => [
                        'tiny_mce' => '/tiny_mce/',
                        'authorizenet_acceptjs' => '\\.authorize\\.net/v1/Accept'
                    ],
                    'session_storage_logging' => '0',
                    'translate_strategy' => 'dictionary',
                    'enable_js_bundling' => '0'
                ],
                'css' => [
                    'minify_files' => '1',
                    'minify_exclude' => [
                        'tiny_mce' => '/tiny_mce/'
                    ],
                    'merge_css_files' => '1'
                ]
            ]
        ],
        'stores' => [

        ],
        'websites' => [

        ]
    ],
    'modules' => [
        'Magento_Store' => 1,
        'Magento_Directory' => 1,
        'Magento_Theme' => 1,
        'Magento_Eav' => 1,
        'Magento_AdvancedPricingImportExport' => 1,
        'Magento_Rule' => 1,
        'Magento_Customer' => 1,
        'Magento_Backend' => 1,
        'Magento_Amqp' => 1,
        'Magento_Config' => 1,
        'Magento_User' => 1,
        'Magento_Authorization' => 1,
        'Magento_AdminNotification' => 1,
        'Magento_Indexer' => 1,
        'Magento_Variable' => 1,
        'Magento_Backup' => 1,
        'Magento_Cms' => 1,
        'Magento_Quote' => 1,
        'Magento_SalesSequence' => 1,
        'Magento_Catalog' => 1,
        'Magento_CatalogInventory' => 1,
        'Magento_Bundle' => 1,
        'Magento_GraphQl' => 1,
        'Magento_BundleImportExport' => 1,
        'Magento_BundleImportExportStaging' => 1,
        'Magento_Payment' => 1,
        'Magento_CacheInvalidate' => 1,
        'Magento_CatalogUrlRewrite' => 1,
        'Magento_AdvancedCatalog' => 1,
        'Magento_Security' => 1,
        'Magento_MediaStorage' => 1,
        'Magento_EavGraphQl' => 1,
        'Magento_CatalogImportExport' => 1,
        'Magento_CatalogImportExportStaging' => 1,
        'Magento_Sales' => 1,
        'Magento_CatalogInventoryGraphQl' => 1,
        'Magento_Msrp' => 1,
        'Magento_CatalogPageBuilderAnalytics' => 1,
        'Magento_CatalogPageBuilderAnalyticsStaging' => 1,
        'Magento_Search' => 1,
        'Magento_Widget' => 1,
        'Magento_Checkout' => 1,
        'Magento_SalesRule' => 1,
        'Magento_CatalogRule' => 1,
        'Magento_Downloadable' => 1,
        'Magento_GiftCard' => 1,
        'Magento_Captcha' => 1,
        'Magento_StoreGraphQl' => 1,
        'Magento_Wishlist' => 1,
        'Magento_CustomerCustomAttributes' => 1,
        'Magento_AuthorizenetAcceptjs' => 1,
        'Magento_Ui' => 1,
        'Magento_CheckoutAddressSearch' => 1,
        'Magento_CheckoutAgreements' => 1,
        'Magento_Staging' => 1,
        'Magento_CloudComponents' => 1,
        'Magento_AdvancedCheckout' => 1,
        'Magento_CmsGraphQl' => 1,
        'Magento_CmsPageBuilderAnalytics' => 1,
        'Magento_CmsPageBuilderAnalyticsStaging' => 1,
        'Magento_CmsStaging' => 1,
        'Magento_CmsUrlRewrite' => 1,
        'Magento_CmsUrlRewriteGraphQl' => 1,
        'Magento_Integration' => 1,
        'Magento_ConfigurableProduct' => 1,
        'Magento_ProductAlert' => 1,
        'Magento_CatalogGraphQl' => 1,
        'Magento_ConfigurableProductSales' => 1,
        'Magento_Reports' => 1,
        'Magento_Contact' => 1,
        'Magento_Cookie' => 1,
        'Magento_Cron' => 1,
        'Magento_CurrencySymbol' => 1,
        'Magento_CustomAttributeManagement' => 1,
        'Magento_AdvancedRule' => 1,
        'Magento_Analytics' => 1,
        'Magento_CustomerBalance' => 1,
        'Magento_CustomerSegment' => 1,
        'Magento_CustomerFinance' => 1,
        'Magento_CustomerGraphQl' => 1,
        'Magento_CustomerImportExport' => 1,
        'Magento_CatalogWidget' => 1,
        'Magento_Vault' => 1,
        'Magento_Deploy' => 1,
        'Magento_Developer' => 1,
        'Magento_Dhl' => 1,
        'Magento_AdvancedSearch' => 1,
        'Magento_DirectoryGraphQl' => 1,
        'Magento_TargetRule' => 1,
        'Magento_DownloadableGraphQl' => 1,
        'Magento_ImportExport' => 1,
        'Magento_Tax' => 1,
        'Magento_Paypal' => 1,
        'Magento_BundleGraphQl' => 1,
        'Magento_CatalogSearch' => 1,
        'Magento_Elasticsearch' => 1,
        'Magento_WebsiteRestriction' => 1,
        'Magento_Email' => 1,
        'Magento_EncryptionKey' => 1,
        'Magento_Enterprise' => 1,
        'Magento_Eway' => 1,
        'Magento_Fedex' => 1,
        'Magento_Weee' => 1,
        'Magento_GiftCardAccount' => 1,
        'Magento_GiftCardGraphQl' => 1,
        'Magento_GiftCardImportExport' => 1,
        'Magento_GiftRegistry' => 1,
        'Magento_GiftMessage' => 1,
        'Magento_GiftMessageStaging' => 1,
        'Magento_UrlRewrite' => 1,
        'Magento_GiftWrapping' => 1,
        'Magento_GiftWrappingStaging' => 1,
        'Magento_GoogleAdwords' => 1,
        'Magento_GoogleAnalytics' => 1,
        'Magento_GoogleOptimizer' => 1,
        'Magento_GoogleOptimizerStaging' => 1,
        'Magento_PageCache' => 1,
        'Magento_UrlRewriteGraphQl' => 1,
        'Magento_GraphQlCache' => 1,
        'Magento_GroupedProduct' => 1,
        'Magento_GroupedImportExport' => 1,
        'Magento_GroupedCatalogInventory' => 1,
        'Magento_GroupedProductGraphQl' => 1,
        'Magento_GroupedProductStaging' => 1,
        'Magento_DownloadableImportExport' => 1,
        'Magento_CatalogStaging' => 1,
        'Magento_InstantPurchase' => 1,
        'Magento_CatalogAnalytics' => 1,
        'Magento_Inventory' => 1,
        'Magento_InventoryAdminUi' => 1,
        'Magento_InventoryApi' => 1,
        'Magento_InventoryBundleProduct' => 1,
        'Magento_InventoryBundleProductAdminUi' => 1,
        'Magento_InventoryCatalog' => 1,
        'Magento_InventorySales' => 1,
        'Magento_InventoryCatalogAdminUi' => 1,
        'Magento_InventoryCatalogApi' => 1,
        'Magento_InventoryCatalogSearch' => 1,
        'Magento_InventoryConfigurableProduct' => 1,
        'Magento_InventoryConfigurableProductAdminUi' => 1,
        'Magento_InventoryConfigurableProductIndexer' => 1,
        'Magento_InventoryConfiguration' => 1,
        'Magento_InventoryConfigurationApi' => 1,
        'Magento_InventoryDistanceBasedSourceSelection' => 1,
        'Magento_InventoryDistanceBasedSourceSelectionAdminUi' => 1,
        'Magento_InventoryDistanceBasedSourceSelectionApi' => 1,
        'Magento_InventoryElasticsearch' => 1,
        'Magento_InventoryExportStockApi' => 1,
        'Magento_InventoryIndexer' => 1,
        'Magento_InventorySalesApi' => 1,
        'Magento_InventoryGroupedProduct' => 1,
        'Magento_InventoryGroupedProductAdminUi' => 1,
        'Magento_InventoryGroupedProductIndexer' => 1,
        'Magento_InventoryImportExport' => 1,
        'Magento_InventoryCache' => 1,
        'Magento_InventoryLowQuantityNotification' => 1,
        'Magento_InventoryLowQuantityNotificationAdminUi' => 1,
        'Magento_InventoryLowQuantityNotificationApi' => 1,
        'Magento_InventoryMultiDimensionalIndexerApi' => 1,
        'Magento_InventoryProductAlert' => 1,
        'Magento_InventoryReservations' => 1,
        'Magento_InventoryReservationCli' => 1,
        'Magento_InventoryReservationsApi' => 1,
        'Magento_InventoryExportStock' => 1,
        'Magento_InventorySalesAdminUi' => 1,
        'Magento_InventoryGraphQl' => 1,
        'Magento_InventorySalesFrontendUi' => 1,
        'Magento_InventorySetupFixtureGenerator' => 1,
        'Magento_InventoryShipping' => 1,
        'Magento_Shipping' => 1,
        'Magento_InventorySourceDeductionApi' => 1,
        'Magento_InventorySourceSelection' => 1,
        'Magento_InventorySourceSelectionApi' => 1,
        'Magento_Invitation' => 1,
        'Magento_LayeredNavigation' => 1,
        'Magento_LayeredNavigationStaging' => 1,
        'Magento_Logging' => 1,
        'Magento_Marketplace' => 1,
        'Magento_CatalogEvent' => 1,
        'Magento_MessageQueue' => 1,
        'Magento_CatalogRuleConfigurable' => 1,
        'Magento_MsrpConfigurableProduct' => 1,
        'Magento_MsrpGroupedProduct' => 1,
        'Magento_MsrpStaging' => 1,
        'Magento_MultipleWishlist' => 1,
        'Magento_Multishipping' => 1,
        'Magento_MysqlMq' => 1,
        'Magento_NewRelicReporting' => 1,
        'Magento_Newsletter' => 1,
        'Magento_OfflinePayments' => 1,
        'Magento_OfflineShipping' => 1,
        'Magento_VersionsCms' => 1,
        'Magento_PageBuilder' => 1,
        'Magento_Banner' => 1,
        'Magento_AdminGws' => 1,
        'Magento_PaymentStaging' => 1,
        'Magento_Braintree' => 1,
        'Magento_PaypalCaptcha' => 1,
        'Magento_PaypalOnBoarding' => 1,
        'MSP_ReCaptcha' => 1,
        'Magento_Persistent' => 1,
        'Magento_PersistentHistory' => 1,
        'Magento_PricePermissions' => 1,
        'Magento_ConfigurableProductStaging' => 1,
        'Magento_ProductVideo' => 1,
        'Magento_ProductVideoStaging' => 1,
        'Magento_PromotionPermissions' => 1,
        'Magento_BannerPageBuilderAnalytics' => 1,
        'Magento_QuoteAnalytics' => 1,
        'Magento_QuoteGraphQl' => 1,
        'Magento_ReleaseNotification' => 1,
        'Magento_Reminder' => 1,
        'Magento_CatalogStagingPageBuilder' => 1,
        'Magento_RequireJs' => 1,
        'Magento_ResourceConnections' => 1,
        'Magento_Review' => 1,
        'Magento_ReviewAnalytics' => 1,
        'Magento_ReviewStaging' => 1,
        'Magento_Reward' => 1,
        'Magento_RewardGraphQl' => 1,
        'Magento_SalesRuleStaging' => 1,
        'Magento_Rma' => 1,
        'Magento_RmaGraphQl' => 1,
        'Magento_RmaStaging' => 1,
        'Magento_Robots' => 1,
        'Magento_Rss' => 1,
        'Magento_AdvancedSalesRule' => 1,
        'Magento_BannerCustomerSegment' => 1,
        'Magento_SalesAnalytics' => 1,
        'Magento_Signifyd' => 1,
        'Magento_SalesGraphQl' => 1,
        'Magento_SalesInventory' => 1,
        'Magento_CatalogRuleStaging' => 1,
        'Magento_RewardStaging' => 1,
        'Magento_BannerPageBuilder' => 1,
        'Magento_SampleData' => 1,
        'Magento_ScalableCheckout' => 1,
        'Magento_ScalableInventory' => 1,
        'Magento_ScalableOms' => 1,
        'Magento_ScheduledImportExport' => 1,
        'Magento_CatalogPermissions' => 1,
        'Magento_SearchStaging' => 1,
        'Magento_CustomerAnalytics' => 1,
        'Magento_SendFriend' => 1,
        'Magento_SendFriendGraphQl' => 1,
        'Magento_InventoryShippingAdminUi' => 1,
        'Magento_SalesArchive' => 1,
        'Magento_Sitemap' => 1,
        'Magento_CheckoutStaging' => 1,
        'Magento_StagingPageBuilder' => 1,
        'Magento_Authorizenet' => 1,
        'Magento_ConfigurableProductGraphQl' => 1,
        'Magento_Support' => 1,
        'Magento_Webapi' => 1,
        'Magento_SwaggerWebapi' => 1,
        'Magento_SwaggerWebapiAsync' => 1,
        'Magento_Swatches' => 1,
        'Magento_SwatchesGraphQl' => 1,
        'Magento_SwatchesLayeredNavigation' => 1,
        'Magento_DownloadableStaging' => 1,
        'Magento_CatalogInventoryStaging' => 1,
        'Magento_TaxGraphQl' => 1,
        'Magento_TaxImportExport' => 1,
        'Magento_Elasticsearch6' => 1,
        'Magento_ThemeGraphQl' => 1,
        'Magento_Tinymce3' => 1,
        'Magento_Tinymce3Banner' => 1,
        'Magento_Translation' => 1,
        'Magento_CheckoutAddressSearchGiftRegistry' => 1,
        'Magento_Ups' => 1,
        'Magento_CatalogUrlRewriteStaging' => 1,
        'Magento_CatalogUrlRewriteGraphQl' => 1,
        'Magento_AsynchronousOperations' => 1,
        'Magento_Usps' => 1,
        'Magento_ConfigurableImportExport' => 1,
        'Magento_Cybersource' => 1,
        'Magento_VaultGraphQl' => 1,
        'Magento_Version' => 1,
        'Magento_GoogleTagManager' => 1,
        'Magento_VisualMerchandiser' => 1,
        'Magento_Swagger' => 1,
        'Magento_WebapiAsync' => 1,
        'Magento_WebapiSecurity' => 1,
        'Magento_ElasticsearchCatalogPermissions' => 1,
        'Magento_GiftCardStaging' => 1,
        'Magento_WeeeGraphQl' => 1,
        'Magento_WeeeStaging' => 1,
        'Magento_PageBuilderAnalytics' => 1,
        'Magento_BundleStaging' => 1,
        'Magento_WishlistAnalytics' => 1,
        'Magento_WishlistGraphQl' => 1,
        'Magento_Worldpay' => 1,
        'Amazon_Core' => 1,
        'Amazon_Login' => 1,
        'Amazon_Payment' => 1,
        'Andering_ConfigurableDynamic' => 1,
        'CompactCode_FixProductBreadcrumbs' => 1,
        'Compropago_Magento2' => 0,
        'Dotdigitalgroup_Email' => 1,
        'Dotdigitalgroup_Enterprise' => 1,
        'Ebizmarts_MailChimp' => 1,
        'Fastly_Cdn' => 1,
        'Klarna_Core' => 1,
        'Klarna_Ordermanagement' => 1,
        'Klarna_Kp' => 1,
        'Magento_PaypalReCaptcha' => 1,
        'MSP_TwoFactorAuth' => 1,
        'Mageplaza_Core' => 1,
        'Mageplaza_AjaxLayer' => 1,
        'Mageplaza_GoogleRecaptcha' => 1,
        'Mageplaza_LayeredNavigation' => 1,
        'Mageplaza_Smtp' => 1,
        'Mageplaza_SocialLogin' => 1,
        'Meetanshi_Paymulti' => 1,
        'MercadoPago_Core' => 1,
        'SearchSpring_Feed' => 1,
        'Temando_Shipping' => 1,
        'TemplateMonster_AjaxCatalog' => 0,
        'TemplateMonster_AjaxCompare' => 1,
        'TemplateMonster_AjaxSearch' => 1,
        'TemplateMonster_AjaxWishlist' => 1,
        'TemplateMonster_Blog' => 1,
        'TemplateMonster_CatalogImagesGrid' => 1,
        'TemplateMonster_CountdownTimer' => 1,
        'TemplateMonster_FeaturedProduct' => 1,
        'TemplateMonster_FilmSlider' => 1,
        'TemplateMonster_GoogleMap' => 1,
        'TemplateMonster_ThemeOptions' => 1,
        'TemplateMonster_Megamenu' => 1,
        'TemplateMonster_NewsletterPopup' => 1,
        'TemplateMonster_Parallax' => 1,
        'TemplateMonster_SampleDataInstaller' => 1,
        'TemplateMonster_ShopByBrand' => 1,
        'TemplateMonster_SiteMaintenance' => 1,
        'TemplateMonster_SocialLogin' => 1,
        'TemplateMonster_SocialSharing' => 1,
        'TemplateMonster_LayoutSwitcher' => 1,
        'Vertex_Tax' => 1,
        'Wagento_AjaxSearch' => 1,
        'Wagento_CurricanesHelper' => 1,
        'Wagento_FixMercadoPago' => 1,
        'Wagento_FixSocialLogin' => 1,
        'Wagento_Framework' => 1,
        'Wagento_InstallConfig' => 1,
        'Wagento_Mailchimp' => 1,
        'Wagento_SalesRule' => 1,
        'Wagento_SavedCc' => 1,
        'Wagento_ShippingLocal' => 1,
        'WebShopApps_MatrixRate' => 1,
        'Xtento_XtCore' => 1,
        'Xtento_SavedCc' => 1,
        'Zemez_Amp' => 1
    ],
    'admin_user' => [
        'locale' => [
            'code' => [
                'en_US',
                'es_MX'
            ]
        ]
    ]
];
