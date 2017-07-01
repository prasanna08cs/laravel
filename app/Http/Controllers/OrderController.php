<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\OrderItem;
use Carbon\Carbon;
use App\Http\Controllers\ApiController;
use App\Transformers\OrderTransformer;

class OrderController extends ApiController
{
    //
    protected $orderTransformer;

    public function  __construct(OrderTransformer $orderTransformer){
        $this->orderTransformer = $orderTransformer;
    }

    /*
    *   Creating Order
    */
    public function index(Request $request){
       
        $user_id = $request->input('user_id');
        $email_id = $request->input('email_id');
        $status = 'created';
        $order_items = $request->input('order_items');
        
        $check = User::find($user_id);

        if($check){
            if($email_id != ''){
            if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
                return $this->respondBadRequest([
                        'msg' => "Email you entered is invalid"
                ]);
            }
            }

            if(!empty($order_items)){
                $insert = Order::create([
                    'user_id' => $user_id,
                    'email_id' => $email_id,
                    'status' => $status
                ]);
                if($insert){
                    $order_id = $insert->id;
                    foreach($order_items as $index=>$value){
                        OrderItem::create([
                            'order_id' => $order_id,
                            'name' => $value['name'],
                            'price' => $value['price']
                        ]);
                    }

                    return $this->respond([
                        'msg' => 'Order placed successfully',
                        'order_id' => $order_id
                        
                    ]);
                }
            }else{
                return $this->respondBadRequest([
                            'msg' => "No Order Items found"
                    ]);
            }
        }else{
            return $this->respondUnauthorized([
                'msg' => 'Invalid User ID passed'
            ]);
        }
        
    }

    /*
    *   Updating Order
    */
    public function update($order_id, Request $request){
        
        $status = $request->input('status');
        $checkPayment = Order::find($order_id);
        if(is_null($checkPayment->payment)){
            return $this->respondBadRequest([
                'msg' => 'Unable to update, Payment not completed yet'
            ]);
        }
        return $this->updateStatus($order_id, $status);    
    }

    /*
    *   Cancel the Order
    */
    public function cancel($order_id){

        $status = 'cancelled';
        return $this->updateStatus($order_id, $status);
    }

    /*
    * Update Helper
    */
    public function updateStatus($order_id, $status){
        
        $allowedStatus = [ 
            'processed', 'delivered', 'cancelled' 
            ];
        $check = Order::find($order_id);
        if($check){
            if(!in_array($status, $allowedStatus)){
                return $this->respondBadRequest([
                    'msg' => 'Invalid value passed for key status'
                ]);
            }
            $update = Order::where('id', $order_id)->update([
                                    'status' => $status
                                ]);
            if($update){
                if( $status == 'cancelled'){
                    return $this->respond([
                        'msg' => 'Order Cancelled'
                    ]);
                }else{
                    return $this->respond([
                        'msg' => 'Order Status Updated successfully'
                    ]);
                }
            }                    
        }else{
            return $this->respondNotFound([
                'msg' => 'Invalid Order ID passed'
            ]);
        }
    }

    /*
    *   Add Payment to Order
    */
    public function payment($order_id, Request $request){

        $allowedPaymentTypes = [
            'cod', 'online'
        ];
        $payment = $request->input('payment');
        $check = Order::find($order_id);
        if($check){
            if($check->status == 'cancelled'){
                return $this->respondBadRequest([
                    'msg' => 'Unable to process payment, Order has been cancelled'
                ]);
            }
            if(!is_null($check->payment)){
                return $this->respondBadRequest([
                    'msg' => 'Payment already done'
                ]);
            }
            if(!in_array($payment, $allowedPaymentTypes)){
                return $this->respondBadRequest([
                    'msg' => 'Invalid value passed for key payment'
                ]);
            }
            $update = Order::where('id', $order_id)->update([
                                    'payment' => $payment
                                ]);
            if($update){
                return $this->respond([
                    'msg' => 'Payment added successfully'
                ]);                
            }                    
        }else{
            return $this->respondNotFound([
                'msg' => 'Invalid Order ID passed'
            ]);
        }

    }

    /*
    *   Get Order by ID
    */
    public function getOrder($order_id){

        if($order_id == 'today'){
            return $this->getTodayOrder();
        }
        $check = Order::with('orderitems')->find($order_id);
        if($check){
            return $this->respond([
                'msg' => 'Order Details with ID '.$order_id,
                'data' => $this->orderTransformer->transform($check)
            ]);
        }else{
            return $this->respondNotFound([
                'msg' => 'Invalid Order ID Passed'
            ]);
        }
    }

    /*
    *   Get Order By User
    */
    public function getOrderByUser($user_id){
        
        $check = User::find($user_id);
        if($check){
            $getAllOrders = Order::where('user_id', $user_id)->with('orderitems')->get();
            $count = count($getAllOrders);
            if($count){
                return $this->respond([
                    'msg' => $count.' Orders found',
                    'data' => $this->orderTransformer->transformCollection($getAllOrders->all())
                ]);
            }else{
                return $this->respondNotFound([
                    'msg' => 'No Orders Found',
                    'data' => $getAllOrders
                ]);
            }
        }else{
            return $this->respondUnauthorized([
                'msg' => 'Invalid User ID passed'
            ]);
        }
    }

    /*
    *   Get Today Order
    */
    public function getTodayOrder(){

        $now = Carbon::now()->format('Y-m-d');
        $todayOrder = Order::whereDate('created_at',$now)->with('orderitems')->get();
        $count = count($todayOrder);
        if($count){
            return $this->respond([
                'msg' => $count.' Orders have been made today',
                'data' => $this->orderTransformer->transformCollection($todayOrder->all())
            ]);
        }else{
            return $this->respondNotFound([
                'msg' => 'No Orders found today',
                'data' => $todayOrder
            ]);
        }
    }
}