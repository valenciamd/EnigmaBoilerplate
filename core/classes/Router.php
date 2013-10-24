<?php

class Router{
    private $url;
    
    public $template;
    public $db;
    
    public $page;
    public $section;
    public $product;
    public $article;
    public $query;
    
    function __construct(){
        global $db, $template;
        $this->url = $_SERVER['REQUEST_URI'];
        $this->template = new Template();
        $this->db = new Database();
        $this->splitUrl();
        $this->route();
    }
    
    private function splitUrl(){
        $url = explode('?',$this->url);
        $urlParts = $url[0];
        
        if($queryString = isset($url[1]) ? $url[1] : null):
            $queryArray = explode('&', $queryString);
            foreach($queryArray as $key => $data):
                $this->query[$key] = $data;
            endforeach;
        endif;
        
        $urlParts = str_replace(SITE_ROOT, '/', $urlParts);
        
        if($urlParts === '/'): 
            $this->page = 'home';
        else:
            $urlParts = explode('/', $urlParts);
            $this->page = $urlParts[0];
            $this->section = isset($urlParts[1]) ? $urlParts[1] : null;
            
            if($this->page === 'blog'):
                $this->article = isset($urlParts[2]) ? $urlParts[2] : null;
            else:
                $this->product = isset($urlParts[2]) ? $urlParts[2] : null;
            endif;
        endif;
    }
    
    private function route(){
        $views = 'public/views/';
        $thisView = $views.$this->page;
        if(!$this->section):
            $thisView .= '/index.php';
        else:
            $thisView .= $this->section . '/index.php';
        endif;
        include($thisView);
    }
}