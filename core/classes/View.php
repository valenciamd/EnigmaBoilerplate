<?php

class View{
    
    public $name;
    public $template;
    public $currentCache;
    public $siteCache;
    
    public function __construct($name){
        $this->name = $name;
        $this->template = new Template();
    }
    
    public function renderHead(){
        global $db;
        $this->template->addTemplateBit('head', 'head');
        $db->query("SELECT * FROM site");
        $this->siteCache = $db->cacheQuery();
        $this->template->getPage()->addTag('head', array('SQL', $this->siteCache));
    }
    
    public function renderHeader(){
        $this->template->addTemplateBit('header', 'header');
        $this->template->getPage()->addTag('header', array('SQL', $this->siteCache));
    }
    
    public function renderNav(){
        $this->template->addTemplateBit('navigation', 'navigation');
    }
    
    public function renderFooter(){
        $this->template->addTemplateBit('footer', 'footer');
    }
    
}