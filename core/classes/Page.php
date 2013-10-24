<?php
/***************************************************************************************************
 * PAGE CLASS
 ***************************************************************************************************
 * 
 **************************************************************************************************/

class Page{
    private $css = array();
    private $js = array();
    private $bodyTag = '';
    private $bodyTagInsert = '';
    
    private $authorised = true;
    private $password = '';
    
    private $title = '';
    private $tags = array();
    private $postParseTags = array();
    private $bits = array();
    private $content = "";
    
    function __construct() {}
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    
    public function setContent($content){
        $this->content = $content;
    }
    
    public function addTag($key, $data){
        $this->tags[$key] = $data;
    }
    
    public function getTags(){
        return $this->tags;
    }
    
    public function addPPTag($key, $data){
        $this->postParseTags[$key] = $data;
    }
    
    public function getPPTags(){
        return $this->postParseTags;
    }
    
    public function addTemplateBit($tag, $bit){
        $this->bits[$tag] = $bit;
    }
    
    public function getBits(){
        return $this->bits;
    }
    
    public function getBlock($tag){
        if(preg_match('#<!-- START '.$tag.' -->(.+?)<!-- END '.$tag.' -->#si', $this->content, $tor)):
            $tor = str_replace('<!-- START '.$tag.' -->', "", $tor[0]);
            $tor = str_replace('<!-- END '.$tag.' -->', "", $tor);
            return $tor;
        endif;
    }
    
    public function getContent(){
        return $this->content;
    }
}