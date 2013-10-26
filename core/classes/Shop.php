<?php
/**
 * Description of Shop
 *
 * @author nflynn
 */
class Shop {
    public $category = null;
    public $product_count = 0;
    public $product = null;
    
    public function __construct($category, $product = null){
        $this->category = $category;
    }
}
