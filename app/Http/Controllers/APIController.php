<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class APIController extends Controller
{
    public function login(Request $request){
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $reponse = [
                    'status' => true,
                    'user' => $user,
                    'metadata'=>$this->shopMetaData(),
                ];
            }else{
                $reponse = [
                    'status' => false,
                    'error' => 'invalid_credentials',
                ];
            }
            return response()->json($reponse, 200);
        } catch(\Exception $e){
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }
    
    public function shopMetaData(){
        try {
            $brands = Brand::orderBy('created_at', 'desc')->limit(9)->get();
            $categories = Category::orderBy('created_at', 'desc')->limit(8)->get();
            $products = Product::orderBy('created_at', 'desc')->limit(8)->get();
            $trans = DB::table('trasnslations')->select(['org','en','ar'])->get();
            $count = count($trans);
            for ($i=0; $i < $count; $i++) { 
                $translated [$trans[$i]->org] =  $trans[$i];
            }
            $response =  [
                'status'=> true,
                'code'=>200,
                'trans'=> $translated,
                'brands'=>$brands,
                'categories'=>$categories,
		'products'=> $products,
		'in_review'=>false,
		'season'=>2022,
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    public function register(Request $request){
        try {
            $user = new User();
            $user->name = strip_tags($request['name']);
            $user->email = strip_tags($request['email']);
            $user->phone = strip_tags($request['phone']);
            $user->password = Hash::make($request['password']);
            $user->role = 0;
            $user->save();
            $reponse = [
                'status' => true,
            ];
            return response()->json($reponse, 200);
        } catch (\Exception $e) {
            $error = [
                'status'=> false,
                'error' => $e->getMessage(),
            ];
            return response()->json($error, 200);
        }
    }

    // Get All Brands
    public function getAllBrands(){
	    try
        {		
            $brands = DB::table('brands')           
            ->orderBy('created_at', 'desc')                
            ->get();

		    $response = [
			    'code'=>200,
			    'status'=>true,
			    'data'=>$brands,

                ];
		    return response()->json($response,200);
        } catch (\Exception $e) {
            $response = [
                'code'=>500,
                'message'=>$e->getMessage(),
                'status'=>false
            ];
            return response()->json($response,200);
        }
    }

        // Get All Product Categories
        public function getAllCategories()
        {
            try
            {
                                
                $proCat = DB::table('categories')           
                ->orderBy('created_at', 'desc')                
                ->get();

                $response = [
                    'code'=>200,
                    'status'=>true,
                    'data'=>$proCat,
    
                    ];
                return response()->json($response,200);
            } catch (\Exception $e) {
                $response = [
                    'code'=>500,
                    'message'=>$e->getMessage(),
                    'status'=>false
                ];
                return response()->json($response,200);
            }
        }   

        public function getProdcuts()
        {
            try
            {     
                $prodcuts = DB::table('products AS pt')
                ->Join('categories As ct', 'pt.category', '=', 'ct.id')                    
                ->Join('brands As br', 'pt.brand', '=', 'br.id')                        
                ->select('pt.id as id','pt.uid','pt.avatar','pt.images','pt.name','pt.description','pt.stock','pt.brand as brandId','br.name as brandName','pt.category as catgoryId','ct.name as CategoryName','pt.price','pt.color', 'pt.size','pt.show','pt.created_at')
                ->orderBy('created_at', 'desc')     
                ->take(10)    // top 10                          
                ->get();

                $response = [
                    'code'=>200,
                    'status'=>true,
                    'data'=>$prodcuts,
    
                    ];
                return response()->json($response,200);
            } catch (\Exception $e) {
                $response = [
                    'code'=>500,
                    'message'=>$e->getMessage(),
                    'status'=>false
                ];
                return response()->json($response,200);
            }
        }        
        
        
        //Get Products by Vendor ID
        public function getProductsByVenodrID(Request $request)
        {
            try
            {
                $response = [];
                $vendorID = $request['uid'];              

                $prod = DB::table('products AS pt')
                ->Join('categories As ct', 'pt.category', '=', 'ct.id')                    
                ->Join('brands As br', 'pt.brand', '=', 'br.id')
                ->select('pt.id as id','pt.uid','pt.avatar','pt.images','pt.name','pt.description','pt.stock','pt.brand as brandId','br.name as brandName','pt.category as catgoryId','ct.name as CategoryName','pt.price','pt.color', 'pt.size','pt.show','pt.created_at')
                ->where('pt.uid', $vendorID)
                ->get();

                $response = [
                    'code'=>200,
                    'status'=>true,
                    'data'=>$prod,
                ];
                return response()->json($response,200);
            }
            catch (\Exception $e) 
            {
                $response = [
                    'code'=>500,
                    'message'=>$e->getMessage(),
                    'status'=>false
                ];
                return response()->json($response,200);
            }
        }   
    public function translate(Request $request){
        try {
            $data = $request['data'];
            $lang = $request['lang'];
            $response = [];
            foreach ($data as $key => $string) {
                $trans = DB::table('trasnslations')->where('org',$string,)->first();
                if(isset($trans)){
                    if($lang == 'en'){
                        $response[] = $trans->en;
                    }else{
                        $response[] = $trans->ar;
                    }
                }else{
                    DB::table('trasnslations')->insert([
                        'org'=>$string,
                        'en'=>$string,
                    ]);
                    $response[] = $string;
                }
            }
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return  response()->json('error', 200);
        }
    }

    public function getPlyersPolls() {
        try {
            $polls = DB::table('players_poll')->get();
            return response()->json($polls, 200);

        } catch (\Exception $e) {
            return  response()->json('error', 200);
        }
    }
    public function openPoll(Request $request) {
        try {
            $players = DB::table('poll_players')->where('poll_id',$request['id'])->get();
            return response()->json($players, 200);

        } catch (\Exception $e) {
            return  response()->json('error', 200);
        }
    }

    public function votePlayer(Request $request){
        try {
            $check = DB::table('poll_answers')->where('uuid',$request['uuid'])->where('pid',$request['poll'])->get();
            if(count($check) == 0){
                DB::table('poll_answers')->insert([
                    'uuid'=>$request['uuid'],
                    'pid'=>$request['poll']
                ]);
                DB::table('poll_players')->where('poll_id',$request['poll'])
                ->where('id',$request['pid'])
                ->update([
                    'votes'=> $request['votes']
                ]);
               
            }
            return response()->json(true, 200);
        } catch (\Exception $e) {
            return  response()->json($e->getMessage(), 200);
        }
    }

    public function getLeagues(){
        $leagues = DB::table('fb_leagues')->where('active', 1)->get();
        return response()->json($leagues, 200);
    } 
    public function saveLeagues(Request $request){
        $leagues = $request['leagues'];
        $inputs = [];
        foreach($leagues as $key=> $league){
            array_push($inputs,
                [
                    'id'=>$league['league']['id'],
                    'logo'=>$league['league']['logo'],
                    'name_en'=>$league['league']['name'],
                    'name_ar'=>$league['league']['name'],
                ]
            );
        }
        DB::table('fb_leagues')->insert($inputs);
    }

    public function kuwaitSports(){
        $sports_categories = DB::table('sports_categories')->get();
        return response()->json($sports_categories, 200);
    }

    public function getNews(){
        $news = DB::table('news_details')
        ->join('news_categories as nc','nc.id','=','news_details.news_category_id')
        ->select(['news_details.*','nc.name as news_cat'])
        ->get();
        return response()->json($news, 200);
    }
}
