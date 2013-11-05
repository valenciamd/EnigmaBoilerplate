<?php
global $db;
global $basket;
global $shop;

// Select Template File
$this->template->buildFromTemplates('default');
// Set Page Header
$this->template->getPage()->setTitle(ucwords($this->shop->group));

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Header Template
$this->template->addTemplateBit('header', 'global/header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'global/navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'shop/group');
// Add Footer Template
$this->template->addTemplateBit('footer', 'global/footer');

/*******************************************************************************
 * START PAGE SPECIFIC TEMPLATES
 ******************************************************************************/
// Add Shop Breadcrumbs
$this->template->addTemplateBit('breadcrumbs', 'shop/static/breadcrumbs');
/*******************************************************************************
 * END PAGE SPECIFIC TEMPLATES
 ******************************************************************************/

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
$groupData = array(
    'group_title'    => ucwords($this->shop->group)
);
$groupCache = $db->cacheData($groupData);
$this->template->getPage()->addTag('group', array('DATA', $groupCache));

// Add Category List Data
$groupQuery = $db->query("SELECT p.*, b.* FROM products AS p INNER JOIN product_brands AS b ON b.brand_id = p.prod_brand WHERE p.prod_group = :group_id GROUP BY p.prod_brand");
$db->bind(':group_id', $this->shop->group_id);
$groupListCache = $db->cacheQuery();
$this->template->getPage()->addTag('group_list', array('SQL', $groupListCache));
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
// Add Breadcrumb Data to Template
$this->add_data('breadcrumb');
// Add Site Data to Template
$this->add_data('site');
/*******************************************************************************
 * END GLOBALLY DEFINED DATA
 ******************************************************************************/

// Parse Template Output (Add Data to Template Tags)
$this->template->parseOutput();
// Render Template to Page
print $this->template->getPage()->getContent();