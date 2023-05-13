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
        $import = new ProductImport();
        Excel::import($import, $request->file('img'));
    
        return Redirect('/products');
     
   }
}
