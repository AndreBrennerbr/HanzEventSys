<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $search = request('search');
        return view('products',['search'=>$search]);
    }
}
