<?php
// Include Globals
global $db;
global $basket;

// Select Template File
$this->template->buildFromTemplates('default');
// Set Page Title
$this->template->getPage()->setTitle('Home');

// Add Site Head Template
$this->template->addTemplateBit('head', 'global/head');
// Add Header Template
$this->template->addTemplateBit('header', 'global/header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'global/navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'home/front-page');
// Add Footer Template
$this->template->addTemplateBit('footer', 'global/footer');

/*******************************************************************************
 * START PAGE SPECIFIC DATA
 ******************************************************************************/
// Add Sidebar Promotion Data
$sidebarPromoQuery = $db->query("SELECT * FROM sidebar_promotions ORDER BY promo_id ASC LIMIT 4");
$sidebarPromoCache = $db->cacheQuery();
$this->template->getPage()->addTag('sidebar_promotions', array('SQL', $sidebarPromoCache));
// Add Hero Data
$heroQuery = $db->query("SELECT * FROM hero_promotions");
$heroCache = $db->cacheQuery();
$this->template->getPage()->addTag('hero', array('SQL', $heroCache));
// Add Homepage Promotion Data
$homePromoQuery = $db->query("SELECT * FROM homepage_promotions ORDER BY promo_id ASC LIMIT 9");
$homePromoCache = $db->cacheQuery();
$this->template->getPage()->addTag('homepage_promotions', array('SQL', $homePromoCache));
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