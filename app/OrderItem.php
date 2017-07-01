<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //

    
    protected $fillable = ['order_id', 'name', 'price'];

    protected $cast = ['price' => 'double'];

    /*
    * Eloquent Relationship between order_items and orders
    */
    public function order(){
        return belongsTo('App\Order');
    }
    
    
    protected $table = 'order_items';
     
}
