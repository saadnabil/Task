<?php
namespace App\Eloquent;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
class ProductRepositoryEloquent implements  ProductRepositoryInterface{

    public function all(){
        return dd('fdf');
    }

}
