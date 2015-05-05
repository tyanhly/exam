<?php
class ProductTableSeeder extends Seeder {

    public function run()
    {
        for($i=0; $i<200;$i++){
            $products = new Product;
            $products->name = 'TestProduct' . $i;
            $products->code= "p$i";
            $products->stock_quantity = rand(1,100);
            $products->sale_price = rand(1,20) *1000;
            if(! $products->save()) {
                echo "add Product $i fail\n";
                 print_r((array)$products->errors());
            } else {
                echo "add Product $i success \n";
            }
        }
        echo "Add Products Done!";
    }
}