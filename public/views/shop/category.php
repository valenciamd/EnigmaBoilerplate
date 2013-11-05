<?php
global $db;
global $basket;
global $shop;

// Select Template File
$this->template->buildFromTemplates('default');
// Set Page Header
$this->template->getPage()->setTitle('Shop '.ucwords($this->shop->category));

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Header Template
$this->template->addTemplateBit('header', 'global/header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'global/navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'shop/category');
// Add Footer Template
$this->template->addTemplateBit('footer', 'global/footer');

/*******************************************************************************
 * START PAGE SPECIFIC DATA
 ******************************************************************************/
// Add Sidebar Promotion Data
$sidebarPromoQuery = $db->query("SELECT * FROM sidebar_promotions ORDER BY promo_id ASC LIMIT 4");
$sidebarPromoCache = $db->cacheQuery();
$this->template->getPage()->addTag('sidebar_promotions', array('SQL', $sidebarPromoCache));

// Add Basket List Data
$basketListData = $basket->getProducts();
$basketListCache = $db->cacheData($basketListData);
$this->template->getPage()->addTag('basket_list', array('DATA', $basketListCache));

// Add Category Data
$categoryData = array(
    'category_title'    => ucwords($this->shop->category)
);
$categoryCache = $db->cacheData($categoryData);
$this->template->getPage()->addTag('category', array('DATA', $categoryCache));

// Add Category List Data
$categoryQuery = $db->query("SELECT * FROM product_groups WHERE category_id = :id");
$db->bind(':id', $this->shop->category_id);
$categoryListCache = $db->cacheQuery();
$this->template->getPage()->addTag('category_list', array('SQL', $categoryListCache));
/*******************************************************************************
 * END PAGE SPECIFIC DATA
 ******************************************************************************/

/*******************************************************************************
 * START GLOBALLY DEFINED DATA
 ******************************************************************************/
// Add Shop Data to Template
$this->add_data('shop');
// Add Footer Data to Template
$this->add_data('footer');
// Add Basket Data to Template
$this->add_data('basket');
// Add Site Data to Template
$this->add_data('site');
/*******************************************************************************
 * END GLOBALLY DEFINED DATA
 ******************************************************************************/

// Parse Template Output (Add Data to Template Tags)
$this->template->parseOutput();
// Render Template to Page
print $this->template->getPage()->getContent();