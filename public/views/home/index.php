<?php
// Include Global Database
global $db;
// Select Template File
$this->template->buildFromTemplates('test');
// Set Page Title
$this->template->getPage()->setTitle('Home');

// Add Site Head Template
$this->template->addTemplateBit('head', 'head');
// Add Header Template
$this->template->addTemplateBit('header', 'header');
// Add Navigation Template
$this->template->addTemplateBit('navigation', 'navigation');
// Add Site Search Template
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content Template
$this->template->addTemplateBit('content', 'master');
// Add Footer Template
$this->template->addTemplateBit('footer', 'footer');

// Add Shop Data
$shopQuery = $db->query("SELECT * FROM shop");
$shopCache = $db->cacheQuery();
$this->template->getPage()->addTag('content', array('SQL', $shopCache));
// Add Sidebar Promotion Data
$sidebarQuery = $db->query("SELECT * FROM sidebar_promotions ORDER BY promo_id ASC LIMIT 4");
$sidebarCache = $db->cacheQuery();
$this->template->getPage()->addTag('sidebar_promotions', array('SQL', $sidebarCache));
// Add Homepage Promotion Data
$homePromoQuery = $db->query("SELECT * FROM homepage_promotions ORDER BY promo_id ASC LIMIT 9");
$homePromoCache = $db->cacheQuery();
$this->template->getPage()->addTag('homepage_promotions', array('SQL', $homePromoCache));
// Add Footer Data
$socialQuery = $db->query("SELECT * FROM social_links");
$socialCache = $db->cacheQuery();
$this->template->getPage()->addTag('social_links', array('SQL', $socialCache));

// Add Site Data to Template
$siteQuery = $db->query("SELECT * FROM site");
$siteCache = $db->cacheQuery();
$this->template->getPage()->addTag('template', array('SQL', $siteCache));

// Parse Template Output (Add Data to Template Tags)
$this->template->parseOutput();
// Render Template to Page
print $this->template->getPage()->getContent();