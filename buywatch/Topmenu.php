<?php
/**
 * Plumrocket Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End-user License Agreement
 * that is available through the world-wide-web at this URL:
 * http://wiki.plumrocket.net/wiki/EULA
 * If you are unable to obtain it through the world-wide-web, please
 * send an email to support@plumrocket.com so we can send you a copy immediately.
 *
 * @package     Plumrocket_Amp
 * @copyright   Copyright (c) 2016 Plumrocket Inc. (http://www.plumrocket.com)
 * @license     http://wiki.plumrocket.net/wiki/EULA  End-user License Agreement
 */

class Plumrocket_Amp_Block_Page_Html_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    /**
     * Init top menu tree structure and cache
     */
    public function _construct()
    {
        parent::_construct();
        $this->setCacheLifetime(86400);
    }

    public function getCacheKeyInfo()
    {
        $shortCacheId = array(
            'TOPMENU',
            Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
            'template' => $this->getTemplate(),
            'name' => $this->getNameInLayout(),
            'amp' => 1,
        );
        $cacheId = $shortCacheId;

        $shortCacheId = array_values($shortCacheId);
        $shortCacheId = implode('|', $shortCacheId);
        $shortCacheId = md5($shortCacheId);

        $cacheId['short_cache_id'] = $shortCacheId;
        return $cacheId;
    }

    public function getHtml($outermostClass = '', $childrenWrapClass = '')
    {
        Mage::dispatchEvent(
            'page_block_html_topmenu_gethtml_before', array(
            'menu' => $this->_menu,
            'block' => $this
            )
        );

        $this->_menu->setOutermostClass($outermostClass);
        $this->_menu->setChildrenWrapClass($childrenWrapClass);

        if ($renderer = $this->getChild('catalog.topnav.renderer.amp')) {
            $renderer->setMenuTree($this->_menu)->setChildrenWrapClass($childrenWrapClass);
            $html = $renderer->toHtml();
        } else {
            $html = $this->_getHtml($this->_menu, $childrenWrapClass);
        }

        Mage::dispatchEvent(
            'page_block_html_topmenu_gethtml_after', array(
            'menu' => $this->_menu,
            'html' => $html
            )
        );

        return $html;
    }

    public function getModuleName()
    {
        return 'Mage_Page';
    }
}
