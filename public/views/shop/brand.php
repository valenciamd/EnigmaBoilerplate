<?php
global $db;
global $basket;
global $shop;

// Select Template File
$this->template->buildFromTemplates('default');
// Set Page Header
$this->template->getPage()->setTitle(ucwords(str_replace('-', ' ', $this->shop->brand)));

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Header Template
$this->template->addTemplateBit('header', 'global/header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'global/navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'shop/brand');
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

// Add Brand Data
$brandQuery = $db->query("SELECT * FROM product_brands WHERE brand_id = :id");
$db->bind(':id', $this->shop->brand_id);
$brandCache = $db->cacheQuery();
/*$brandData = array(
    'brand_title'    => ucwords($this->shop->brand)
);
$brandCache = $db->cacheData($brandData);*/
$this->template->getPage()->addTag('brand', array('SQL', $brandCache));

// Add Category List Data
$brandQuery = $db->query("SELECT * FROM products WHERE prod_category = :cat_id AND prod_brand = :brand_id");
$db->bind(':cat_id', $this->shop->category_id);
$db->bind(':brand_id', $this->shop->brand_id);
$brandListCache = $db->cacheQuery();
$this->template->getPage()->addTag('brand_list', array('SQL', $brandListCache));
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