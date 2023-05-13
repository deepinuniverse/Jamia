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
use Illuminate\Database\QueryException;
use DB;
use App\Models\Complaint;
use App\Models\Director;
use App\Models\DiscardReport;

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

    



    // API COPS / JAMAIYA


    public function getBranchesCat()
    {
        try {
            // Retrieve branches from the 'branches' table in descending order of creation date               

                $branchesCat = DB::table('branch_categories')
                ->get();
    
            // Create a JSON response with success status, data, and response code
            return response()->json([
                'code' => 200,
                'status' => true,
                'data' => $branchesCat
            ], 200);
        } catch (QueryException $e) {
            // If a database query exception occurs, create a JSON response with error status, error message, and response code
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'Failed to retrieve branches cat  from the database: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // If any other exception occurs, create a JSON response with error status, error message, and response code
            return response()->json([
                'code' => 500,
                'status' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    } 
    
   


        public function getBranches()
        {
           /* try
            {
                                
                $proCat = DB::table('branches')           
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
            } */

            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $branches = DB::table('branches')
                    ->join('branch_categories', 'branches.branch_categories_id', '=', 'branch_categories.id')
                    ->select('branches.*', 'branch_categories.name as category_name')
                    ->orderBy('branches.created_at', 'desc') // Add orderBy clause to order by created_at column in descending order
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $branches
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   


         //Get Branches on given branch ID 
         public function getBranchesByBranchCatId(Request $request)
         {
             try {
                 // Retrieve branches from the 'branches' table in descending order of creation date, filtered by ID
                
                 
                     // Retrieve branches with category name from the 'branches' and 'branch_categories' tables
                     $branches = DB::table('branches')
                         ->join('branch_categories', 'branches.branch_categories_id', '=', 'branch_categories.id')
                         ->select('branches.*', 'branch_categories.name as category_name')
                         ->orderBy('branches.created_at', 'desc') // Add orderBy clause to order by created_at column in descending order
                         ->where('branch_categories.id', $request['catid']) // Add where clause to filter by 'id' parameter
                         ->get();
 
 
                     if ($branches->isEmpty()) {
                         // If no records found, create a JSON response with appropriate error status, message, and response code
                        /* return response()->json([
                             'code' => 404,
                             'status' => false,
                             'message' => 'No branches found with the given ID'
                         ], 404); */

                         return response()->json(['message' => null]);
                     }
 
                 // Create a JSON response with success status, data, and response code
                 return response()->json([
                     'code' => 200,
                     'status' => true,
                     'data' => $branches
                 ], 200);
             } catch (QueryException $e) {
                 // If a SQL exception occurs, create a JSON response with error status, error message, and response code
                 return response()->json([
                     'code' => 500,
                     'status' => false,
                     'message' => 'Failed to retrieve branches: ' . $e->getMessage()
                 ], 500);
             } catch (\Exception $e) {
                 // If any other exception occurs, create a JSON response with error status, error message, and response code
                 return response()->json([
                     'code' => 500,
                     'status' => false,
                     'message' => 'An error occurred: ' . $e->getMessage()
                 ], 500);
             }
         }

        //Get Branches on given branch ID 
        public function getBranchesById(Request $request)
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date, filtered by ID
               
                
                    // Retrieve branches with category name from the 'branches' and 'branch_categories' tables
                    $branches = DB::table('branches')
                        ->join('branch_categories', 'branches.branch_categories_id', '=', 'branch_categories.id')
                        ->select('branches.*', 'branch_categories.name as category_name')
                        ->orderBy('branches.created_at', 'desc') // Add orderBy clause to order by created_at column in descending order
                        ->where('branches.id', $request['id']) // Add where clause to filter by 'id' parameter
                        ->get();


                    if ($branches->isEmpty()) {
                        // If no records found, create a JSON response with appropriate error status, message, and response code
                       /* return response()->json([
                            'code' => 404,
                            'status' => false,
                            'message' => 'No branches found with the given ID'
                        ], 404);  */

                        return response()->json(['message' => null]);
                    }

                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $branches
                ], 200);
            } catch (QueryException $e) {
                // If a SQL exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve branches: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

        //Get News 
        public function getNews()
        {
            try {
                // Retrieve news from the 'news_details' table in descending order of creation date
                $news = DB::table('news_details')
                    ->orderBy('created_at', 'desc')                  
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $news
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve news from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }    


        //Get News By ID
        public function getNewsById(Request $request)
        {
            try {
                $id = $request['id']; // Retrieve 'id' parameter from the request
                
                // Retrieve news from the 'news_details' table based on ID and in descending order of creation date
                $news = DB::table('news_details')
                    ->where('id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                if ($news->isEmpty()) {
                    // If no data is found, create a JSON response with appropriate message, status, and response code
                  /*  return response()->json([
                        'code' => 404,
                        'status' => false,
                        'message' => 'No news found'
                    ], 404); */

                    return response()->json(['message' => null]);
                }

                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $news
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve news from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }

        //Get Offers
        public function getOffersFestivals()
        {
            try {
                // Retrieve offers from the 'news_details' table in descending order of creation date
                $offers = DB::table('offers')
                    ->orderBy('created_at', 'desc')                  
                    ->get();

                   

                    if ($offers->isEmpty()) {
                        // No records found
                       // return response()->json(['error' => 'No records found'], 404);
                        return response()->json(['message' => null]);
                    }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $offers
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve ofsfers  from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        
        
        } 


        public function getOffersFestivalsImagesDetALL()
        {
            try {
                // Retrieve offers from the 'news_details' table in descending order of creation date
               /* $offersFestivals = DB::table('offers')
                    ->orderBy('created_at', 'desc')                  
                    ->get(); */

                   /* $offersFestivals = DB::table('offers')
                    ->join('offers_images', 'offers_images.offers_id', '=', 'offers.id')
                    ->select('offers_images.* ')
                    ->where('offers_images.offers_id', $request['id'])               
                    ->get(); */


                  /*  $offersFestivals = DB::table('offers')
                    ->join('offers_images', 'offers_images.offers_id', '=', 'offers.id')
                    ->select('offers_images.*', 'offers.*')
                    //->where('offers_images.offers_id', $request['id'])               
                    ->get(); */


                  /*     $offersFestivals = DB::table('offers')
                    ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                    ->select('offers.*', 'offers_images.image')
                    ->get(); */
                    
                  /*  $offersFestivals = DB::table('offers')
                    ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                    ->select('offers.*', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                    ->groupBy('offers.id')
                    ->get(); */

                /*  $offersFestivals = DB::table('offers')
        ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
        ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
        ->get(); */


        $offersFestivals = DB::table('offers')
        ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
       // ->select('offers.*', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
       // ->groupBy('offers.id')
       ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
      
        ->get();

    $offersFestivals = $offersFestivals->map(function ($offersFestivals) {
        $offersFestivals->images = explode(',', $offersFestivals->images);
        return $offersFestivals;
    });

    return $offersFestivals;

                   

                    if ($offersFestivals->isEmpty()) {
                        // No records found
                       // return response()->json(['error' => 'No records found'], 404);
                        return response()->json(['message' => null]);
                    }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $offersFestivals
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve ofsfers  from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function getOffersFestivalsImagesDet(Request $request)
        {
            try {
                // Retrieve offers from the 'news_details' table in descending order of creation date
               /* $offersFestivals = DB::table('offers')
                    ->orderBy('created_at', 'desc')                  
                    ->get(); */

                   /* $offersFestivals = DB::table('offers')
                    ->join('offers_images', 'offers_images.offers_id', '=', 'offers.id')
                    ->select('offers_images.* ')
                    ->where('offers_images.offers_id', $request['id'])               
                    ->get(); */


                    $offersFestivals = DB::table('offers')
                    ->join('offers_images', 'offers_images.offers_id', '=', 'offers.id')
                    ->select('offers_images.* , offers.*')
                    ->where('offers_images.offers_id', $request['id'])               
                    ->get();

                   

                    if ($offersFestivals->isEmpty()) {
                        // No records found
                       // return response()->json(['error' => 'No records found'], 404);
                        return response()->json(['message' => null]);
                    }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $offersFestivals
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve ofsfers  from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 
        
        
        public function getOffersFestivalsByID(Request $request)
        {
            try {
                // Retrieve offers from the 'news_details' table in descending order of creation date
              
                    $id = $request['id']; // Retrieve 'id' parameter from the request
                
                    // Retrieve news from the 'news_details' table based on ID and in descending order of creation date
                /*    $offers = DB::table('offers')
                        ->where('id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get(); */


                        $offersFestivals = DB::table('offers')
                        ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                       // ->select('offers.*', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                       // ->groupBy('offers.id')
                       ->where('offers.id', $request['id'])
                       ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
                      
                        ->get();
                
                    $offersFestivals = $offersFestivals->map(function ($offersFestivals) {
                        $offersFestivals->images = explode(',', $offersFestivals->images);
                        return $offersFestivals;
                    });
                
                    return $offersFestivals;


                    if ($offersFestivals->isEmpty()) {
                        // No records found
                        //return response()->json(['error' => 'No records found'], 404);
                        return response()->json(['message' => null]);
                    }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $offers
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve ofsfers  from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   
        
        
        public function getCoupenOffersCat()
        {
            try {
                // Retrieve offers from the 'news_details' table in descending order of creation date
                $offer_categories = DB::table('offer_categories')
                    ->orderBy('created_at', 'desc')                  
                    ->get();

                    if ($offer_categories->isEmpty()) {
                        // No records found
                        //return response()->json(['error' => 'No records found'], 404);

                        return response()->json(['message' => null]);
                    }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $offer_categories
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve offer_categories  from the database: ' . $e->getMessage()
                ], 500);
            } catch (Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }     
        
        
        public function getCoupenOffers()
        {        
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                $couponOffers = DB::table('coupon_offers')
                ->join('offer_categories', 'coupon_offers.offer_categories_id', '=', 'offer_categories.id')
                ->select('coupon_offers.*', 'offer_categories.name as offer_category_name')               
                ->get();

                if ($couponOffers->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'No records found'], 404);
                    return response()->json(['message' => null]);
                }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $couponOffers
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to couponOffers branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   


        public function getCoupenOffersByCatID(Request $request)
        { 

            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                $couponOffer = DB::table('coupon_offers')
                ->join('offer_categories', 'coupon_offers.offer_categories_id', '=', 'offer_categories.id')
                ->select('coupon_offers.*', 'offer_categories.name as offer_category_name')
                ->where('offer_categories.id', $request['id'])
                ->get();


                if ($couponOffer->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'No records found'], 404);
                    return response()->json(['message' => null]);
                }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $couponOffer
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to couponOffers branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

        }

        public function getCoupenOffersById(Request $request)
        {        
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                $couponOffer = DB::table('coupon_offers')
                ->join('offer_categories', 'coupon_offers.offer_categories_id', '=', 'offer_categories.id')
                ->select('coupon_offers.*', 'offer_categories.name as offer_category_name')
                ->where('coupon_offers.id', $request['id'])
                ->get();


                if ($couponOffer->isEmpty()) {
                    // No records found
                    //return response()->json(['message' => 'null'], 404);
                    // return null;
                    return response()->json(['message' => null]);

                }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $couponOffer
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to couponOffers branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   



        public function getGallaeriesCatName()
        {        
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                $gallaryCat = DB::table('galleries')
                ->orderBy('created_at', 'desc')                  
                ->get();


                if ($gallaryCat->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'No records found'], 404);
                    return response()->json(['message' => null]);
                }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $gallaryCat
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to gallaryCat branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   

        public function getGallaeriesPhotoByCatID(Request $request)
        {        
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                $GallaryPhotos = DB::table('galleries')
                ->join('gallery_photos', 'galleries.id', '=', 'gallery_photos.galleries_id')
                ->select('galleries.*', 'gallery_photos.photo as gallery_photos')
                ->where('gallery_photos.galleries_id', $request['id'])         
                ->get();



                if ($GallaryPhotos->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'No records found'], 404);
                    return response()->json(['message' => null]);
                }
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $GallaryPhotos
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to GallaryPhotos branches from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        }   


        public function getSocialMedia()
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $socialmedia = DB::table('socialmedia')
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $socialmedia
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve socialmedia   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function getDirectors()
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $Director = DB::table('directors')
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $Director
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve Director   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function CreateComplaint(Request $request){
            try {
                $complaint = new Complaint();
                $complaint->name = $request['name'];
                $complaint->number = $request['contact'];
                $complaint->email = $request['email'];
                $complaint->reason = $request['reason'];
                $complaint->notes = $request['details'];
                $complaint->save();
                $response = [
                    'status' => true,
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

        public function CreateDiscardReport(Request $request){
            try 
            {
                $discard = new DiscardReport();
                $discard->item_name = $request['item'];
                $discard->customer_contact = $request['contact'];
                $discard->jamia_name = $request['name'];
                $discard->customer_note = $request['cust_not'];
                $img_url = '';
                $img = $request->file('img');
                if($img != null){
                $image_name  = uniqid().'.'.$img->getClientOriginalExtension();
                $destination = 'storage/DiscardReport';
                $img->move($destination, $image_name );
                $img_url = $request->getSchemeAndHttpHost().'/storage/DiscardReport/'.$image_name;
                }
                $discard->item_photo = $img_url;
                $discard->report_dt = $request['date'];
                $discard->admin_note = $request['ad_not'];
                $discard->status = $request['status'];
                $discard->save();              
                $response = [
                    'status' => true,
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



        public function getSlideShows()
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $slideshows = DB::table('slideshows')
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $slideshows
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve slideshows   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function getFamilyCardBarCodeImage(Request $request)
        {
            try {
               
                    $id = $request['civil_id'];
                    $box_no = $request['box_no']; // Retrieve 'id' parameter from the request
                
                    // Retrieve news from the 'news_details' table based on ID and in descending order of creation date
                    $familyCardDetails = DB::table('shareholdersnfamilydata')
                    ->select('SHR_NO','NAME','CIVIL_ID','CODE','PROFIT')
                        ->where('CIVIL_ID', $id)         
                        ->where('SHR_NO', $box_no)                   
                        ->get();

                        
                if ($familyCardDetails->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'CIVIL ID and Box number are not correct'], 404);

                    return response()->json(['message' => null]);
                }

               /* if (is_null($familyCardDetails[0]->CODE)) {
                    return response()->json([
                        'code' => 404,
                        'status' => false,
                        'message' => 'Family Card Not Applied'
                    ], 404);
                } */
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $familyCardDetails
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve FamilyData   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function getShareHolderProfit(Request $request)
        {
            try {
               
                    $id = $request['civil_id']; // Retrieve 'id' parameter from the request
                    $box_no = $request['box_no'];
                
                    // Retrieve news from the 'news_details' table based on ID and in descending order of creation date
                    $ShareHolderProfit = DB::table('shareholdersnfamilydata')
                    ->select('SHR_NO','NAME','CIVIL_ID','CODE','PROFIT')
                        ->where('CIVIL_ID', $id)                        
                        ->Where('SHR_NO', $box_no)                    
                        ->get();

                        
                if ($ShareHolderProfit->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'CIVIL ID and Box number are not correct'], 404);

                    return response()->json(['message' => null]);
                }

                //if (is_null($ShareHolderProfit[0]->PROFIT)) {
                  //  return response()->json([
                    //    'code' => 404,
                    //    'status' => false,
                    //    'message' => 'No Profit found'
                   // ], 404);
               // }
        

                //Depep
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $ShareHolderProfit
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve FamilyData   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 

        public function getShareHolderProfitTitle()
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $customer_profit = DB::table('customer_profit')
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $customer_profit
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve customer_profit   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 

        public function getaboutUS()
        {
            try {
                // Retrieve branches from the 'branches' table in descending order of creation date               

                    $customer_profit = DB::table('information')
                    ->get();
        
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $customer_profit
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve about us  info   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 


        public function CreateDeviceFCM(Request $request){
            try {
                $complaint = new Complaint();
                $complaint->name = $request['name'];
                $complaint->number = $request['contact'];
                $complaint->email = $request['email'];
                $complaint->reason = $request['reason'];
                $complaint->notes = $request['details'];
                $complaint->save();
                $response = [
                    'status' => true,
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

        public function storeDeviceFCMToken1(Request $request)
        {
              
            $device_fcm_token = $request->input('device_fcm_token');
            // Insert data into the 'device_fcm_token' table
            DB::table('device_fcm_token')->insert([                
                'device_fcm_token' => $device_fcm_token
            ]);
    
            // Return a response, redirect, or perform any other desired actions
        }

        public function storeDeviceFCMToken(Request $request)
        {
            try {

                $device_fcm_token = $request->input('device_fcm_token');
                
                // Insert data into the 'device_fcm_token' table
                DB::table('device_fcm_token')->insert([
                    'device_fcm_token' => $device_fcm_token
                ]);

                // Return a success response
                return response()->json(['message' => 'Data stored successfully'], 200);
            } catch (\Exception $e) {
                // Handle the exception and return an error response
                return response()->json(['message' => 'Failed to store data'], 500);
            }
        }


        public function getDataFromAllTables()
        {
            $branches = DB::table('branches')
                        ->join('branch_categories', 'branches.branch_categories_id', '=', 'branch_categories.id')
                        ->select('branches.id', 'branches.name', 'branches.address', 'branches.phone', 'branches.hours', 'branches.picture', 'branches.location', 'branch_categories.name as category_name')
                        ->get();

            $complaints = DB::table('complaints')
                        ->select('id', 'name', 'number', 'email', 'reason', 'notes', 'admin_note')
                        ->get();

            $coupon_offers = DB::table('coupon_offers')
                        ->join('offer_categories', 'coupon_offers.offer_categories_id', '=', 'offer_categories.id')
                        ->select('coupon_offers.id', 'coupon_offers.offer_name', 'coupon_offers.picture', 'coupon_offers.description', 'coupon_offers.from_dt', 'coupon_offers.to_dt', 'coupon_offers.contact_no', 'offer_categories.name as category_name')
                        ->get();

            $directors = DB::table('directors')
                        ->select('id', 'name', 'position', 'photo')
                        ->get();

            return response()->json([
                'branches' => $branches,
                'complaints' => $complaints,
                'coupon_offers' => $coupon_offers,
                'directors' => $directors
            ]);
        }



        public function getProductByItemName(Request $request)
        {
            try {
               
                    $itemName = $request['itemName']; // Retrieve 'id' parameter from the request
                   
                
                    // Retrieve news from the 'news_details' table based on ID and in descending order of creation date
                 


                  //  $productDet = DB::table('jamaiya_products')
                  //  ->select('id', 'ItemBarcode','ItemCode','ItemName','ItemPrice','vendor')
                    //    ->where('itemName', $itemName)  
                      //  ->get();


                        $productDet = DB::table('jamaiya_products')
                ->select('id', 'ItemBarcode', 'ItemCode', 'ItemName', 'ItemPrice', 'vendor')
                ->where('ItemName', 'LIKE', '%' . $itemName . '%')
                ->get();

                        
                if ($productDet->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'CIVIL ID and Box number are not correct'], 404);

                    return response()->json(['message' => null]);
                }

                //if (is_null($ShareHolderProfit[0]->PROFIT)) {
                  //  return response()->json([
                    //    'code' => 404,
                    //    'status' => false,
                    //    'message' => 'No Profit found'
                   // ], 404);
               // }
        

                //Depep
                // Create a JSON response with success status, data, and response code
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $productDet
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve productDetails   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 



        public function getProductByItemBarCode(Request $request)
        {
            try {
               
                    $ItemBarcode = $request['ItemBarcode']; // Retrieve 'id' parameter from the request
                   
                
                 
                    $productDet = DB::table('jamaiya_products')
                    ->select('id', 'ItemBarcode','ItemCode','ItemName','ItemPrice','vendor')
                        ->where('ItemBarcode', $ItemBarcode)  
                       ->get();



                        
                if ($productDet->isEmpty()) {
                    // No records found
                    //return response()->json(['error' => 'CIVIL ID and Box number are not correct'], 404);

                    return response()->json(['message' => null]);
                }
       

                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $productDet
                ], 200);
            } catch (QueryException $e) {
                // If a database query exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'Failed to retrieve productDetails   from the database: ' . $e->getMessage()
                ], 500);
            } catch (\Exception $e) {
                // If any other exception occurs, create a JSON response with error status, error message, and response code
                return response()->json([
                    'code' => 500,
                    'status' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }
        } 





}
