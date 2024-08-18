<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Models\Product;

class ProductController extends Controller
{
   public function index()
   {
      $products = Product::all();
      return view('products.index',['products'=>$products]);
   }
   public function delete()
   {
       
      return Redirect('/products');

   }
   public function uploadPdts(Request $request)
   {
      $path1 = $request->file('data')->store('temp');
      $path=storage_path('app').'/'.$path1;


          Excel::import(new productImport(),$path);
    
        return Redirect('/products');
     
   }
}
