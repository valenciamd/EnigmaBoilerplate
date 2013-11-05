<?php
/**
 * Description of Shop
 *
 * @author nflynn
 */
class Shop {
    public $category = null;
    public $category_id = 0;
    public $category_products = null;
    
    public $group = null;
    public $group_id = 0;
    public $group_products = null;
    
    public $brand = null;
    public $brand_id = 0;
    public $brand_products = null;
    
    public $product = null;
    
    public function __construct($category, $group = null, $brand = null, $product = null){
        $this->setup_category($category);
        if($group): $this->setup_group($group); endif;
        if($brand): $this->setup_brand($brand); endif;
        if($product): $this->setup_product($product); endif;
    }
    
    private function setup_category($category){
        global $db;
        $this->category = $category;
        $db->query("SELECT p.*, c.*, c.cat_id AS category_id FROM products AS p INNER JOIN product_categories AS c ON c.cat_id = p.prod_category WHERE c.cat_name = :category");
            $db->bind(':category', $category);
        $this->category_products = $db->resultset();
        $this->category_id = $this->category_products[0]['category_id'];
    }
    
    private function setup_group($group){
        global $db;
        $this->group = $group;
        $db->query("SELECT p.*, g.*, g.group_id AS group_id FROM products AS p INNER JOIN product_groups AS g ON g.group_id = p.prod_group WHERE g.group_slug = :group");
            $db->bind(':group', $group);
        $this->group_products = $db->resultset();
        $this->group = $this->group_products[0]['group_title'];
        $this->group_id = $this->group_products[0]['group_id'];
    }
    
    private function setup_brand($brand){
        global $db;
        $this->brand = $brand;
        $db->query("SELECT p.*, b.*, b.brand_id AS brand_id FROM products AS p INNER JOIN product_brands AS b ON b.brand_id = p.prod_brand WHERE b.brand_slug = :brand AND p.prod_category = :category");
            $db->bind(':brand', $brand);
            $db->bind(':category', $this->category_id);
        $this->brand_products = $db->resultset();
        $this->brand_id = $this->brand_products[0]['brand_id'];
    }
    
    private function setup_product($product){
        global $db;
        $db->query("SELECT * FROM products WHERE prod_category = :category AND prod_group = :group AND prod_slug = :product");
            $db->bind(':category', $this->category_id);
            $db->bind(':group', $this->group_id);
            $db->bind(':product', $product);
        $this->product = $db->cacheQuery();
    }
    
    public function productRating(){
        global $db;
        $rating = array();
        $starLimit = 5;
        $product = $db->resultsFromCache($this->product);
        $thisRating = $product[0]['prod_rating'];
        
        if($thisRating == 0):
            for($i = 1; $i <= $starLimit; $i++):
                array_push($rating, array('class' => 'empty'));
            endfor;
        else:
            for($i = 1; $i <= $starLimit; $i++):
                if($i <= $thisRating):
                    array_push($rating, array('class' => 'full'));
                else:
                    array_push($rating, array('class' => 'empty'));
                endif;
            endfor;
        endif;
        
        return $db->cacheData($rating);
    }
}
