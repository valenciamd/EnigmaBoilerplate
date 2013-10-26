<?php
global $db;

// Select Template File
$this->template->buildFromTemplates('test');
// Set Page Header
$this->template->getPage()->setTitle('Home');

$siteQuery = $db->query("SELECT * FROM site");
$siteCache = $db->cacheQuery();

// Add Site Head
$this->template->addTemplateBit('head', 'head');
$this->template->getPage()->addTag('head', array('SQL', $siteCache));
// Add Header
$this->template->addTemplateBit('header', 'header');
$this->template->getPage()->addTag('header', array('SQL', $siteCache));
// Add Navigation
$this->template->addTemplateBit('navigation', 'navigation');
// Add Site search
$this->template->addTemplateBit('site-search', 'site-search');
// Add Content
$shopQuery = $db->query("SELECT * FROM shop INNER JOIN site");
$shopCache = $db->cacheQuery();
$this->template->addTemplateBit('content', 'master');
$this->template->getPage()->addTag('content', array('SQL', $shopCache));

$sidebarQuery = $db->query("SELECT * FROM sidebar_promotions INNER JOIN site ORDER BY promo_id ASC LIMIT 4");
$sidebarCache = $db->cacheQuery();
$this->template->getPage()->addTag('sidebar_promotions', array('SQL', $sidebarCache));

$homePromoQuery = $db->query("SELECT * FROM homepage_promotions INNER JOIN site ORDER BY promo_id ASC LIMIT 9");
$homePromoCache = $db->cacheQuery();
$this->template->getPage()->addTag('homepage_promotions', array('SQL', $homePromoCache));

// Add Footer 
$this->template->addTemplateBit('footer', 'footer');

$this->template->parseOutput();
print $this->template->getPage()->getContent();