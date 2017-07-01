<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response; 
use Mbarwick83\Shorty\Facades\Shorty;

class UrlShortenerController extends Controller
{
    //
    public function index(Request $request){

        $url = $request->input('url');
        $shortenUrl = Shorty::shorten($url);
        return Response::json($shortenUrl);
    }
}
