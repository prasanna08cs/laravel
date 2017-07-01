# SpotSoonTest
A Laravel 5.4 Rest API and URL Shortener


### Requirements:
```
 php version : ">=5.6.4", 
 composer
```

### Composer Install to install dependencies/providers:
```
Run 'composer install'
```

### Change Database Credentials in '.env':
```
DB_DATABASE=SpotASAPTest
DB_USERNAME=root
DB_PASSWORD=root
```


### Database Migration:
```
Run 'php artisan migrate'
```

### Database Seeder for Default User Data:
```
Run 'php artisan db:seed --class=UsersTableSeeder'
```

### Start Laravel Deployment Server:
```
Run 'php artisan serve'
```



## URL Shortener


**URL: http://localhost:8000/**

**Package Used : mbarwick83/shorty 1.0**

*Github* : https://github.com/mbarwick83/shorty




## The Restful API routes are in 'routes/api.php'

#### 1. Creating Orders

##### URL : localhost:8000/api/orders

##### Method : POST

##### Request body 
     
    {	
        "user_id" : 1,
        "email_id" : "borth.rondip@gmail.com",
        "order_items" : [
                            {
                                "name" : "Nike Shoe",
                                "price" : "1000.00"
                            },
                            {
                                "name" : "Adidas Shoe",
                                "price" : "549.00"
                                
                            }
                        ]
    }
    
##### Response

###### On Success (200) 
    
    {
        "msg": "Order placed successfully",
        "order_id": 1
    }
    
###### On Invalid Email (400)
    
    {
        "msg": "Email you entered is invalid"
    }  
                           
###### On Invalid User ID (400) 
    
    {
        "msg": "Invalid User ID passed"
    }
    
###### If No order items are found (400)
    
    {
        "msg": "No Order Items found"
    }                                                     
                      
#### 2. Order Update

##### URL : localhost:8000/api/orders/1

##### Method : PUT

##### Request body

    {
        "status" : "processed"
    }
    
##### Response 

###### On Success (200)
     
    {
        "msg": "Order Status Updated successfully"
    }
                    
###### If Payment not Completed (400)
    
    {
        "msg": "Unable to update, Payment not completed yet"
    } 
                    
###### Invalid Status value (400)
    
    {
        "msg": "Invalid value passed for key status"
    }   

#### 3. Cancel Order

##### URL: localhost:8000/api/orders/1/cancel

##### Method: PUT

##### Response
        
    {
        "msg": "Order Cancelled"
    }
    
####  4. Order Payment

##### URL: localhost:8000/api/orders/1/payment

##### Method: PUT

##### Request Body
    
    {
        "payment": "cod"
    } 
    
##### Response

###### On Success (200) 
    
    {
        "msg": "Payment added successfully"
    } 
                   
###### If Payment already done (400) 
     
    {
        "msg": "Payment already done"
    }
    
###### If Order is cancelled (400) 
    
    {
        "msg": "Unable to process payment, Order has been cancelled"
    }                     

#### 5. Get Order By ID

##### URL : localhost:8000/api/orders/1

##### Method : GET

##### Response 

###### On Success (200)
    
    {
        "msg": "Order Details with ID 1",
        "data": {
            "id": 1,
            "email_id": "borth.rondip@gmail.com",
            "status": "delivered",
            "created_at": "1 hour ago",
            "order_items": [
                {
                    "order_item_id": 1,
                    "name": "Nike Shoe",
                    "price": 1000
                },
                {
                    "order_item_id": 2,
                    "name": "Adidas Shoe",
                    "price": 549
                }
            ]
        }
    }        
      
###### Invalid Order ID (404) 
    
    {
        "msg": "Invalid Order ID Passed"
    }   
             
#### 6. Get Order by User                            

##### URL: localhost:8000/api/orders/search/user_id=1

##### Method: GET

##### Response

###### On Success (200)

    {
        "msg": "1 Orders found",
        "data": [
            {
                "id": 1,
                "email_id": "borth.rondip@gmail.com",
                "status": "delivered",
                "created_at": "1 hour ago",
                "order_items": [
                    {
                        "order_item_id": 1,
                        "name": "Nike Shoe",
                        "price": 1000
                    },
                    {
                        "order_item_id": 2,
                        "name": "Adidas Shoe",
                        "price": 549
                    }
                ]
            }
        ]
    }
    
###### Invalid User ID (401)

    {
        "msg": "Invalid User ID passed"
    } 
                        
###### If user does not have any orders (404) 
    
    {
        "msg": "No Orders Found",
        "data": []
    }   

#### 7. Get Orders created today

##### URL: localhost:8000/api/orders/today

##### Method: GET

##### Response

###### On Success (200)
     
    {
        "msg": "1 Orders have been made today",
        "data": [
            {
                "id": 1,
                "email_id": "borth.rondip@gmail.com",
                "status": "delivered",
                "created_at": "2 hours ago",
                "order_items": [
                    {
                        "order_item_id": 1,
                        "name": "Nike Shoe",
                        "price": 1000
                    },
                    {
                        "order_item_id": 2,
                        "name": "Adidas Shoe",
                        "price": 549
                    }
                ]
            }
        ]
    }     
                                           
 ###### If no orders created today (404)
    
    {
        "msg": "No Orders found today",
        "data": []
    } 
                  # laravel
