<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    
    protected $fillable = ['user_id', 'email_id', 'status', 'payment'];
    
    /*
    * Eloquent Relationship between orders and order_items
    */
    public function orderitems(){
        return $this->hasMany('App\OrderItem');
    }
    

     
}
