<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;

/*
*   Base API Controller with various respond methods
*/

class ApiController extends Controller
{
    //
    protected $status_code = 200;

    public function getStatusCode(){
    	return $this->status_code;
    }

    public function setStatusCode($status_code){
    	$this->status_code = $status_code;
    	return $this;
    }

    public function respond($data,$headers = []){
    	return Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondBadRequest($message){
        
        return $this->setStatusCode(400)->respondWithError($message);
        
    }

    public function respondNotFound($message){
    	
    	return $this->setStatusCode(404)->respondWithError($message);
    	
    }

    public function respondInternalError($message = "Internal script error"){
    	return $this->setStatusCode(500)->respondWithError($message);
    }

    public function respondUnauthorized($message){
        return $this->setStatusCode(401)->respondWithError($message);
    }

    public function respondWithError($data, $headers = []){
        return Response::json($data, $this->getStatusCode(), $headers);
    	
    }
}
