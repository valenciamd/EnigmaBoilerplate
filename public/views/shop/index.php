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
//$this->template->addTemplateBit('content', 'master');
// Add Footer 
$this->template->addTemplateBit('footer', 'footer');

$this->template->parseOutput();
print $this->template->getPage()->getContent();