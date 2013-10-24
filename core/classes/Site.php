<?php
/***************************************************************************************************
 * SITE CLASS
 ***************************************************************************************************
 * Contains all Site related data.
 * 
 * Data stored in the database will overwrite default definitions in config.php and settings.php
 **************************************************************************************************/

class Site{
    private $title;
    private $subtitle;
    private $logo;
    private $description;
    private $keywords;
    private $author;
    private $author_email;
    private $date_created;
    private $last_modified;
    
    private $theme = DEFAULT_THEME;
    
    function __construct() {
        global $db;
        
        $db->query("SELECT * FROM site");
        $result = $db->result();
        $this->title            = $result['site_title'];
        $this->subtitle         = $result['site_subtitle'];
        $this->description      = $result['site_description'];
        $this->keywords         = $result['site_keywords'];
        $this->author           = $result['site_author'];
        $this->author_email     = $result['site_author_email'];
        $this->date_created     = $result['site_date_created'];
        $this->last_modified    = $result['site_last_modified'];
        $this->theme            = $result['site_theme'];
        $this->logo             = 'themes/'.$this->theme.'/'.$result['site_logo'];
    }
    
    public function getTheme(){
        return $this->theme;
    }
    
    public function getTitle(){
        return $this->title;
    }
}