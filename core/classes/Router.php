<?php

class Router{
    private $url;
    
    public $template;
    public $db;
    public $views_url;
    
    public $page;
    public $section;
    public $article;
    public $action;
    public $query;
    
    public $shop = null;
    
    private $view;
    
    function __construct(){
        $this->url = $_SERVER['REQUEST_URI'];
        $this->views_url = 'public/views/';
        $this->template = new Template();
        $this->db = new Database();
        $this->splitUrl();
        $this->route();
    }
    
    private function splitUrl(){
        $url = explode('?',$this->url);
        if($queryString = isset($url[1]) ? $url[1] : false):
            $this->get_queryString($queryString);
        endif;
        $urlParts = str_replace(SITE_ROOT, '', $url[0]);
        $this->get_urlParts($urlParts);
    }
    
    private function get_queryString($string){
        $queryArray = explode('&', $string);
        foreach($queryArray as $key => $data):
            $this->query[$key] = $data;
        endforeach;
    }
    
    private function get_urlParts($parts){
        if($parts === ''): 
            $this->page = 'home';
        else:
            $urlParts = explode('/', $parts);
            $this->page = $urlParts[0];
            if($this->page === 'shop'):
                $this->setup_shop($urlParts);
            else:
                $this->setup_page($urlParts);
            endif;
        endif;
    }
    
    private function setup_shop($parts){
        if(isset($parts[4]) && $parts[4] !== ''):
            $this->shop = new Shop($parts[1], $parts[2], $parts[3], $parts[4]);
        elseif(isset($parts[3]) && $parts[3] !== ''):
            $this->shop = new Shop($parts[1], $parts[2], $parts[3]);
        elseif(isset($parts[2]) && $parts[2] !== ''):
            $this->shop = new Shop($parts[1], $parts[2]);
        elseif(isset($parts[1]) && $parts[1] !== ''):
            $this->shop = new Shop($parts[1]);
        else:
            die('404: Page Could Not Be Found');
        endif;
    }
    
    private function setup_page($parts){
        $this->section = isset($parts[1]) ? $parts[1] : null;
        $this->article = isset($parts[2]) ? $parts[2] : null;
        $this->action  = isset($parts[3]) ? $parts[3] : null;
    }
    
    private function route(){
        $this->route_page();
        if($this->shop !== null):
            $this->route_shop();
        else:
            $this->route_section();
        endif;
        include($this->view);
    }
    
    private function route_page(){
        $this->view = $this->views_url.$this->page;
    }
    
    private function route_shop(){
        if(is_int($this->shop->product)):
            $this->view .= '/product.php';
        elseif($this->shop->brand):
            $this->view .= '/brand.php';
        elseif($this->shop->group):
            $this->view .= '/group.php';
        elseif($this->shop->category):
            $this->view .= '/category.php';
        else:
            $this->page = '404.php';
        endif;
    }
    
    private function route_section(){
        if($this->section == ''):
            $this->view .= '/index.php';
        elseif(file_exists($this->view.'/'.$this->section.'.php')):
            $this->view .= '/'.$this->section.'.php';
        else:
            $this->view .= '/'.$this->section;
            $this->route_article();
        endif;
    }
    
    private function route_article(){
        if($this->article !== ''):
            if($this->page === 'blog'):
                $this->view .= '/article.php';
            else:
                $this->view .= '/'.$this->article;
                $this->route_action();
            endif;
        else:
            $this->view .= '/index.php';
        endif;
    }
    
    private function route_action(){
        if($this->action == ''):
            $this->view .= '/index.php';
        else:
            $this->view .= '/'.$this->action.'.php';
        endif;
    }
    
    public function add_data($bit){
        $func = 'add_'.$bit.'_data';
        call_user_func(array($this, $func));
    }
    
    private function add_site_data(){
        global $db;
        $siteQuery = $db->query("SELECT s.*, n.* FROM site AS s INNER JOIN site_notices AS n ON s.site_notice = n.notice_id");
        $siteCache = $db->cacheQuery();
        $this->template->getPage()->addTag('template', array('SQL', $siteCache));
    }
    
    private function add_footer_data(){
        global $db;
        $socialQuery = $db->query("SELECT * FROM social_links");
        $socialCache = $db->cacheQuery();
        $this->template->getPage()->addTag('social_links', array('SQL', $socialCache));
    }
    
    private function add_shop_data(){
        global $db;
        $shopQuery = $db->query("SELECT * FROM shop");
        $shopCache = $db->cacheQuery();
        $this->template->getPage()->addTag('content', array('SQL', $shopCache));
    }
    
    private function add_basket_data(){
        global $db;
        global $basket;
        $basketData = array(
            'basket_count'  => $basket->basketCount(),
            'basket_price'  => $basket->basketTotal()
        );
        $basketCache = $db->cacheData($basketData);
        $this->template->getPage()->addTag('basket', array('DATA', $basketCache));
    }
    
    private function add_breadcrumb_data(){
        global $db;
        $breadcrumbData = array();
        if($this->shop->category):
            $breadcrumb = array(
                'breadcrumb_link' => SITE_ROOT.'shop/'.strtolower(str_replace(' ', '-', $this->shop->category)).'/',
                'breadcrumb_name' => ucwords(str_replace('-', ' ', $this->shop->category))
            );
            array_push($breadcrumbData, $breadcrumb);
        endif;
        if($this->shop->group):
            $breadcrumb = array(
                'breadcrumb_link' => SITE_ROOT.'shop/'.strtolower(str_replace(' ', '-', $this->shop->category)).'/'.strtolower(str_replace(' ', '-', $this->shop->group)).'/',
                'breadcrumb_name' => ucwords(str_replace('-', ' ', $this->shop->group))
            );
            array_push($breadcrumbData, $breadcrumb);
        endif;
        if($this->shop->brand):
            $breadcrumb = array(
                'breadcrumb_link' => SITE_ROOT.'shop/'.strtolower(str_replace(' ', '-', $this->shop->category)).'/'.strtolower(str_replace(' ', '-', $this->shop->group)).'/'.strtolower(str_replace(' ', '-', $this->shop->brand)).'/',
                'breadcrumb_name' => ucwords(str_replace('-', ' ', $this->shop->brand))
            );
            array_push($breadcrumbData, $breadcrumb);
        endif;
        $breadcrumbCache = $db->cacheData($breadcrumbData);
        $this->template->getPage()->addTag('bc_links', array('DATA', $breadcrumbCache));
    }
}