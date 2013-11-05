<?php
class Basket{
    public $contents = array();
    public $total = 0;
    
    public function __construct(){
        for($i = 0; $i < 4; $i++):
            $product = array(
                'prod_code'         => $i,
                'prod_name'         => 'Test Product '.$i,
                'prod_quantity'     => 1,
                'prod_price'        => 12.00,
                'prod_available'    => true,
                'prod_sub'          => 12.00
            );
        
            array_push($this->contents, $product);
        endfor;
    }
    
    public function basketCount(){
        return count($this->contents);
    }
    
    public function basketTotal(){
        $total = 0;
        foreach($this->contents as $item =>$details):
            $price = $details['prod_sub'];
            $total = round($total + $price, 2);
        endforeach;
        return number_format($total, 2);
    }
    
    public function getProducts(){
        return $this->contents;
    }
    
    public function emptyBasket(){
        $this->contents = array();
        $this->total = 0;
    }
}