<?php
namespace App\Transformers;
use Carbon\Carbon;

/*
* Transform an order object
*/
class OrderTransformer extends Transformer {

	public function transform($order) 
	{	
		
        $transformedOrderItems = array();
        foreach($order['orderitems'] as $index=>$value){
            array_push($transformedOrderItems, array(
                'order_item_id' => $value['id'],
                'name' => $value['name'],
                'price' => $value['price']
            ));
        }

		return [	
			'id'       	=> $order['id'],
			'email_id'	=> $order['email_id'],
            'status'    => $order['status'],
            'created_at' => Carbon::parse($order['created_at'])->diffForHumans(),
            'order_items' => $transformedOrderItems
			
		];
	}
}