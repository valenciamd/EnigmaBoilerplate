<?php
global $db;
global $basket;

// Select Template File
$this->template->buildFromTemplates('default');
// Set Page Header
$product = $db->resultsFromCache($this->shop->product);
$title = $product[0]['prod_title'];
$this->template->getPage()->setTitle($title);

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Header Template
$this->template->addTemplateBit('header', 'global/header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'global/navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'shop/product');
// Add Footer Template
$this->template->addTemplateBit('footer', 'global/footer');

/*******************************************************************************
 * START PAGE SPECIFIC TEMPLATES
 ******************************************************************************/
// Add Product Rating
$this->template->addTemplateBit('product_rating', 'shop/static/product-rating');
// Add Favorites Bar
$this->template->addTemplateBit('favorites_bar', 'shop/static/favorites-bar');
// Add Social Bar
$this->template->addTemplateBit('social_bar', 'shop/static/social-bar');
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

// Add Product Data
$this->template->getPage()->addTag('product', array('SQL', $this->shop->product));

// Get Product Rating
$rating = $this->shop->productRating();
$this->template->getPage()->addTag('star_rating', array('DATA', $rating));

// Get Special Offers
$offerQuery = $db->query("SELECT brand_offer FROM product_brands WHERE brand_id = :id");
$db->bind(':id', $this->shop->brand_id);
$offerCache = $db->cacheQuery($offerQuery);
$this->template->getPage()->addTag('special_offers', array('SQL', $offerCache));

// Get Product Availability
$prod = $db->resultsFromCache($this->shop->product);
$stock = $prod[0]['prod_stock'];
if($stock > 0):
    $stockAvailable = array(
        'stock_class'   => 'available',
        'stock_text'    => 'In Stock'
    );
else:
    $stockAvailable = array(
        'stock_class' => 'unavailable',
        'stock_text'    => 'Sold Out'
    );
endif;
$stockCache = $db->cacheData($stockAvailable);
$this->template->getPage()->addTag('stock_available', array('DATA', $stockCache));

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