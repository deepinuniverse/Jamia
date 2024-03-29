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
//use DB;
use App\Models\Complaint;
use App\Models\Director;
use App\Models\DiscardReport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;
//use Illuminate\Support\Facades\Mail;



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
 
                       //  $locationUrl = $branches[0]->location;
 
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
                    // 'locationUrl' => $locationUrl
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
                    //'locationUrl' => 'deepak'
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
                    ->limit(5)                
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
        //->orderBy('offers.id', 'desc')
        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
        ->orderBy('offers.created_at', 'desc')
        ->limit(5)
        ->get();

   /* $offersFestivals = $offersFestivals->map(function ($offersFestivals) {
        $offersFestivals->images = explode(',', $offersFestivals->images);
        return $offersFestivals;
    }); */

    $offersFestivals = $offersFestivals->map(function ($offersFestival) {
        $offersFestival->images = explode(',', $offersFestival->images);
        return $offersFestival;
    });

   // return $offersFestivals;

                   

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

        //Not Used
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
               
              
                    $id = $request['id']; // Retrieve 'id' parameter from the request
                
              

                        $offersFestivals = DB::table('offers')
                        ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                       // ->select('offers.*', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                       // ->groupBy('offers.id')
                       ->where('offers.id', $request['id'])
                       ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
                      
                        ->get();
                
                  /*  $offersFestivals = $offersFestivals->map(function ($offersFestivals) {
                        $offersFestivals->images = explode(',', $offersFestivals->images);
                        return $offersFestivals;
                    }); */


                    $offersFestivals = $offersFestivals->map(function ($offersFestival) {
                        $offersFestival->images = explode(',', $offersFestival->images);
                        return $offersFestival;
                    });

                
                    //return $offersFestivals;


                    if ($offersFestivals->isEmpty()) {
                        // No records found
                        //return response()->json(['error' => 'No records found'], 404);
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


        public function getOffersFestivalsByID_1(Request $request)
        {
            try {
                // Retrieve 'id' parameter from the request
                $id = $request->input('id');

                $offersFestivals = DB::table('offers')
                    ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                    ->where('offers.id', $id)
                    ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                    ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
                    ->get();

                $offersFestivals = $offersFestivals->map(function ($offersFestival) {
                    $offersFestival->images = explode(',', $offersFestival->images);
                    return $offersFestival;
                });

                if ($offersFestivals->isEmpty()) {
                    // No records found
                    return response()->json([
                        'code' => 404,
                        'status' => false,
                        'message' => 'No records found'
                    ], 404);
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
                    'message' => 'Failed to retrieve offers from the database: ' . $e->getMessage()
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
                    ->limit(50)                   
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
                ->orderBy('coupon_offers.created_at', 'desc')
                ->limit(50)              
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
                ->limit(5)                 
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
                $complaint->device_fcm_token = $request['device_fcm_token'];
                $complaint->save();


                $lastInsertedId = $complaint->id; // Retrieve the last inserted record ID

               
                //Insert to fcm_message table 

               
                $title = 'جمعية صباح الناصر التعاونية';
                $notificationType = 'Complaint';

                  //TEST DEEP CALL FOR Notification


                $device_fcm_token = $request->input('device_fcm_token');
                $title = $title;
                $notificationType = $notificationType; 
                $reason = $request->input('reason');
                $description = $request->input('details');
                 // $admin_explanation = $request->input('admin_explanation');
                 
                 DB::table('fcm_messages')->insert([
                    'device_fcm_token' => $device_fcm_token,
                    'title' => $title,
                    'notificationType' => $notificationType,
                    'reason' => $reason,
                    'description' => $description,
                  
                ]);




                 $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

             
                  $complaintid = $lastInsertedId;//$request['id'];
   
             
                 $complaintinfo = DB::table('complaints')
               ->select('reason', 'notes','device_fcm_token')
               ->where('id', $complaintid)
                ->first();
   
                
   
                $reason = $complaintinfo->reason;
   
                $reason = "تم استلام طلب  تواصل معنا  بنجاح ! : "  . $reason;
                $notes = $complaintinfo->notes;           
                $deviceToken = $complaintinfo->device_fcm_token;
   
                   $title = 'جمعية صباح الناصر التعاونية';
              
                   
   
                   $responses = [];
   
                   
                       // Create the notification payload.
                       $notificationPayload = [
                           'to' => $deviceToken,
                           'notification' => [
                               'title' =>  $title,
                               //'body' => $reason ,
                               'body' => $reason . "\n" . $notes,
                           ],
                           'data' => [
                               'key1' => 'value1',
                               'key2' => 'value2',
                              // 'reason' => $reason,
                             //  'notes' => $notes,
                           ],
                       ];
                           
                       
   
                       // Send the notification to FCM.
                       $response = Http::withHeaders([
                           'Authorization' => 'key=' . $serverKey,
                       ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);
   
                       // Check the response status code.
                       if ($response->getStatusCode() !== 200) {
                           throw new \Exception('An error occurred while sending the notification.');
                       }
   
   
   
                   //TEST DEEP END
   





                $response = [
                    'status' => true,
                  //  'lastInsertedId' => $lastInsertedId,
                    //'$result' => $result 

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
                $discard->device_fcm_token = $request['device_fcm_token'];

                $discard->save();   

                $lastInsertedId = $discard->id; 
                
                




                
                $title = 'جمعية صباح الناصر التعاونية';
                $notificationType = 'Disard Report';

                  //TEST DEEP CALL FOR Notification


                $device_fcm_token = $request->input('device_fcm_token');
                $title = $title;
                $notificationType = $notificationType; 
                $reason = $request->input('item');
                $description = $request->input('cust_not');
                 // $admin_explanation = $request->input('admin_explanation');
                 
                 DB::table('fcm_messages')->insert([
                    'device_fcm_token' => $device_fcm_token,
                    'title' => $title,
                    'notificationType' => $notificationType,
                    'reason' => $reason,
                    'description' => $description,
                  
                ]);



                 //TEST DEEP CALL FOR Notification


                  $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

             
                   $discardid = $lastInsertedId;//$request['id'];
    
              
                  $disardInfo = DB::table('discard_reports')
                ->select('item_name', 'customer_note','device_fcm_token')
                ->where('id', $discardid)
                 ->first();
    
                 
    
                 $itemname = $disardInfo->item_name;
    
                 $itemname = "تم استلام طلب  إبلاغ عن سلعه  بنجاح ! :  "  . $itemname;
                 $custnotes = $disardInfo->customer_note;           
                 $deviceToken = $disardInfo->device_fcm_token;
    
                    $title = 'جمعية صباح الناصر التعاونية';
               
                    
    
                    $responses = [];
    
                    
                        // Create the notification payload.
                        $notificationPayload = [
                            'to' => $deviceToken,
                            'notification' => [
                                'title' =>  $title,
                                //'body' => $reason ,
                                'body' => $itemname . "\n" . $custnotes,
                            ],
                            'data' => [
                                'key1' => 'value1',
                                'key2' => 'value2',
                               // 'reason' => $reason,
                              //  'notes' => $notes,
                            ],
                        ];
                            
                        
    
                        // Send the notification to FCM.
                        $response = Http::withHeaders([
                            'Authorization' => 'key=' . $serverKey,
                        ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);
    
                        // Check the response status code.
                        if ($response->getStatusCode() !== 200) {
                            throw new \Exception('An error occurred while sending the notification.');
                        }
    
    
    
                    //TEST DEEP END





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
                    ->orderBy('created_at', 'desc')  
                    ->limit(5)   
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
            
                // Check if the device_fcm_token already exists
                $existingRecord = DB::table('device_fcm_token')
                    ->where('device_fcm_token', $device_fcm_token)
                    ->first();
            
                //if (!$existingRecord) {
                    // Insert data into the 'device_fcm_token' table
                  //  DB::table('device_fcm_token')->insert([
                  //      'device_fcm_token' => $device_fcm_token
                  //  ]);
               // }


                DB::table('device_fcm_token')->insert([
                    'device_fcm_token' => $device_fcm_token
                ]);
            
                // The insertion will be skipped if the device_fcm_token already exists in the table.
            
                // Return a success response
                return response()->json(['message' => 'Device FCM token saved successfully']);
            } catch (\Exception $e) {
                // Return an error response
                return response()->json(['message' => 'Error occurred while saving device FCM token', 'error' => $e->getMessage()], 500);
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


    

           

            //working

            public function SendPushNotificationSingle(Request $request)
            {
                
                    // Get the FCM server key from the .env file.
                 $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

                 // Ios Token
                 $deviceToken = 'dPW1numVB0HpohbGEjpmiS:APA91bEJhyoK6o1-Q-K1TopMO3sfNINHHpGzRugjws9dwgfyMVmsBM7dF5pRNCQFh_8XYPPFDPr0O8LM9C2tBsM4PQJdoGcSKpBrMMiPu3ExnxkcbDCTDZmOEpJv28LnHuBmUfD8YOnl';

                  // Android Token
                  $deviceToken = 'fnDPddOzQDOeePx6XmqHEc:APA91bH5a5ELIYpJYoRmSWa4Ga7qbk8JXjq-6-t9dfbE495IwqdQiIeR_1z9PILn1qoeg4mYV95YpAcS0qpxu0_LrVVP8lfqKYAl-1l9imba51MM6h0x91i7_akSkP1a3ASm8_3Ngh6j';


                            // Retrieve the device tokens from the database.
               // $deviceTokens = DB::table('device_fcm_token')->pluck('device_fcm_token')->toArray();

                // Create an array to store the responses for each device.
               
                $responses = [];
                
                                // Create the notification payload.
                    $notificationPayload = [
                        'to' => $deviceToken,
                        'notification' => [
                            'title' => $request->input('title'),
                            'body' => $request->input('message'),
                        ],
                        'data' => [
                            'key1' => 'value1',
                            'key2' => 'value2',
                        ],
                    ];

                    // Send the notification to FCM.
                    $response = Http::withHeaders([
                        'Authorization' => 'key=' . $serverKey,
                    ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);

                    // Check the response status code.
                    if ($response->getStatusCode() !== 200) {
                        throw new \Exception('An error occurred while sending the notification.');
                    }

                    $responseData = [
                        'title' => $request->input('title'),
                        'body' => $request->input('message'),
                        'response' => $response->getBody(),
                    ];

                    $responses[] = $responseData;

                    // Return the response body.
                   return $response->getBody();
                 // return $responses;
                                            
            }



            public function SendPushNotificationAll_OLD(Request $request)
            {
                $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

               // $deviceTokens = ['dPW1numVB0HpohbGEjpmiS:APA91bEJhyoK6o1-Q-K1TopMO3sfNINHHpGzRugjws9dwgfyMVmsBM7dF5pRNCQFh_8XYPPFDPr0O8LM9C2tBsM4PQJdoGcSKpBrMMiPu3ExnxkcbDCTDZmOEpJv28LnHuBmUfD8YOnl', 'another_device_token'];

               $notificationId = $request['id'];

              $notificationDesc = DB::table('notifications')
              ->where('id', $notificationId)
              ->value('notes');

                $title = 'جمعية صباح الناصر التعاونية';
                $message = $notificationDesc;

                $notificationType = "General";

             


                $deviceTokens = DB::table('device_fcm_token')
                ->select('device_fcm_token')
                ->whereNotNull('device_fcm_token')
                ->distinct()
                ->pluck('device_fcm_token')
                ->toArray();
              
                //return $deviceTokens;


                $values = [];

                foreach ($deviceTokens as $token) {
                    $values[] = [
                        'device_fcm_token' => $token,
                        'title' => $title,
                        'notificationType' => $notificationType,                        
                        'description' => $notificationDesc                      
                    ];
                }

                DB::table('fcm_messages')->insert($values);
                

                $responses = [];

                
                    // Create the notification payload.
                    $notificationPayload = [
                        'registration_ids' => $deviceTokens,
                        'notification' => [
                            'title' =>  $title,
                            'body' => $message ,
                           // 'body' => $message . "\n" . 'deepak',
                        ],
                        'data' => [
                            'key1' => 'value1',
                            'key2' => 'value2',
                            //'notes' =>  ,
                        ],
                    ];
                        
                    

                    // Send the notification to FCM.
                    $response = Http::withHeaders([
                        'Authorization' => 'key=' . $serverKey,
                    ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);

                    // Check the response status code.
                    if ($response->getStatusCode() !== 200) {
                       // throw new \Exception('An error occurred while sending the notification.');
                    
                        return response()->json(['message' => 'Error occurred while signing up', 'error' => $e->getMessage()], 500);

                    }

                    $responseData = [
                        'title' => $request->input('title'),
                        'body' => $request->input('message'),
                        'response' => $response->getBody(),
                    ];

                    $responses[] = $responseData;
                

                // Return the responses array.
                return $responses;
            }



            
            

           
            public function SendPushNotificationAll(Request $request)
            {
    try {
        $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

        $notificationId = $request['id'];

        $notificationDesc = DB::table('notifications')
            ->where('id', $notificationId)
            ->value('notes');

        $title = 'جمعية صباح الناصر التعاونية';
        $notificationType = "General";

        $deviceTokens = DB::table('device_fcm_token')
            ->select('device_fcm_token')
            ->whereNotNull('device_fcm_token')
            ->distinct()
            ->pluck('device_fcm_token')
            ->toArray();

            

            $values = [];

            foreach ($deviceTokens as $token) {
                $values[] = [
                    'device_fcm_token' => $token,
                    'title' => $title,
                    'notificationType' => $notificationType,                        
                    'description' => $notificationDesc                      
                ];
            }

            DB::table('fcm_messages')->insert($values);



        $responses = [];

        foreach ($deviceTokens as $token) {
            $message = $notificationDesc; // Set the message for each device

            // Create the notification payload for each device token.
            $notificationPayload = [
                'to' => $token, // Set the 'to' field to the current device token
                'notification' => [
                    'title' => $title,
                    'body' => $message,
                ],
                'data' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                ],
            ];

            // Send the notification to FCM.
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
            ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);

            // Check the response status code for each device.
            if ($response->getStatusCode() === 200) {
                $responseData = [
                    'title' => $title,
                    'body' => $message,
                    'response' => $response->getBody(),
                ];
                $responses[] = $responseData;
            } else {
                // Handle the error gracefully for each device.
                $errorResponse = $response->json();
                $errorMessage = 'Failed to send the notification to FCM for device token ' . $token . '. Response code: ' . $response->getStatusCode();
                if (isset($errorResponse['error'])) {
                    $errorMessage .= ' - ' . $errorResponse['error']['message'];
                }
                $responses[] = ['error' => $errorMessage];
            }
        }

        // Return the responses array.
        return response()->json($responses, 200);
    } catch (\Exception $e) {
        // Handle exceptions gracefully and return a JSON response with an error message.
        return response()->json(['message' => 'An error occurred while processing the request.', 'error' => $e->getMessage()], 500);
    }
    }   

         







            //For Test
            public function SendPushNotificationComplaint(Request $request)
            {
                $serverKey = 'AAAAFtZOxqk:APA91bGElbCGY0gqC7ayPq7evrctaw754RSPZzs5nZbYjfay-TGDLPL0xeE7DnV17K5cQDrADp5__YrApHf7KJeUDQl13DwPtqp75SkyaedSgG0f48sysGR1-B7ya3mfT1eNK7wg-Ha8'; // Replace with your FCM server key

             
               $complaintid = $request['id'];

          
              $complaintinfo = DB::table('complaints')
            ->select('reason', 'notes','device_fcm_token')
            ->where('id', $complaintid)
             ->first();

             

             $reason = $complaintinfo->reason;

             $reason = "We have received your complaint "  . $reason;
             $notes = $complaintinfo->notes;           
             $deviceToken = $complaintinfo->device_fcm_token;

                $title = 'جمعية صباح الناصر التعاونية';
           
                

                $responses = [];

                
                    // Create the notification payload.
                    $notificationPayload = [
                        'to' => $deviceToken,
                        'notification' => [
                            'title' =>  $title,
                            //'body' => $reason ,
                            'body' => $reason . "\n" . $notes,
                        ],
                        'data' => [
                            'key1' => 'value1',
                            'key2' => 'value2',
                           // 'reason' => $reason,
                          //  'notes' => $notes,
                        ],
                    ];
                        
                    

                    // Send the notification to FCM.
                    $response = Http::withHeaders([
                        'Authorization' => 'key=' . $serverKey,
                    ])->post('https://fcm.googleapis.com/fcm/send', $notificationPayload);

                    // Check the response status code.
                    if ($response->getStatusCode() !== 200) {
                        throw new \Exception('An error occurred while sending the notification.');
                    }

                    $responseData = [
                        'title' => $request->input('title'),
                        'body' => $request->input('message'),
                        'response' => $response->getBody(),
                    ];

                    $responses[] = $responseData;
                

                // Return the responses array.
                return $responses;
            }


            public function getFCMMessages(Request $request)
            {
                try {
                   
                    $device_fcm_token = $request['device_fcm_token']; // Retrieve 'id' parameter from the request
                       
                    
                     
                    $fcmmessage = DB::table('fcm_messages')
                    ->select('id', 'device_fcm_token','title','notificationType','reason','description','admin_explanation','created_at')
                    ->where('device_fcm_token', $device_fcm_token)  
                    ->orderByDesc('id')
                    ->get();
    
    
                            
                    if ($fcmmessage->isEmpty()) {
                        // No records found
                        //return response()->json(['error' => 'CIVIL ID and Box number are not correct'], 404);
    
                        return response()->json(['message' => null]);
                    }
           
    
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                        'data' => $fcmmessage
                    ], 200);
                } catch (QueryException $e) {
                    // If a database query exception occurs, create a JSON response with error status, error message, and response code
                    return response()->json([
                        'code' => 500,
                        'status' => false,
                        'message' => 'Failed to retrieve fcmmessage   from the database: ' . $e->getMessage()
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



            public function MobileUserSignup(Request $request)
            {
                try {
                    // Validate the request data
                    $validatedData = $request->validate([
                        'name' => 'required',
                        'phone' => 'required',
                        'email' => 'required|email',
                        'password' => 'required',
                        'civilid' => 'required',
                        'box_no' => 'required',
                    ]);


                    $existingUser = DB::table('appusers')
                    ->where('civilid', $validatedData['civilid'])
                    ->first();


                    $existingUserCIVILandPhone = DB::table('appusers')
                    ->where('civilid', $validatedData['civilid'])
                    ->where('phone', $validatedData['phone'])
                      ->first();


        
                    if ($existingUser) {
                        return response()->json(['message' => 'Civil ID  already registered'], 409);
                    }

                    if ($existingUserCIVILandPhone) {
                        return response()->json(['message' => 'Same record Civil ID and Phone Number both already registered'], 409);
                    }
        
                    // Create a new user
                    $userId = DB::table('appusers')->insertGetId($validatedData);
                    
                    // Retrieve the created user
                    $user = DB::table('appusers')->find($userId);



                   // $ShareHolderProfit = DB::table('shareholdersnfamilydata')
                  //  ->select('SHR_NO as Box_No','NAME','CIVIL_ID','CODE as ShareHolderBarCode','PROFIT')
                    //    ->where('CIVIL_ID', $validatedData['civilid'])                        
                       // ->Where('SHR_NO', $box_no)                    
                    //    ->get();

                    
                       // if ($ShareHolderProfit->isEmpty()) {
                            // Return an empty message
                        //    return response()->json(['message' => 'No shareholder family card data found.']);
                       // }

        
                    // Return a success response
                    return response()->json(['message' => 'Signup successful', 'user' => $user]);

                  // return response()->json(['message' => 'Signup successful', 'user' => $ShareHolderProfit]);

                  //return response()->json(['message' =>  $ShareHolderProfit]);


                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while signing up', 'error' => $e->getMessage()], 500);
                }
            }

            public function MobileUserSignInOLD(Request $request)
            {


                try {
                    // Validate the request data
                    $validatedData = $request->validate([
                        'civilid' => 'required',
                        'password' => 'required',
                    ]);
            
                    // Check if the user exists in the database
                    $user = DB::table('appusers')
                        ->where('civilid', $validatedData['civilid'])
                        ->where('password', $validatedData['password'])
                        ->first();
            
                    // If the user is not found or the password is incorrect, return an error response
                    if (!$user) {
                        return response()->json(['message' => 'Invalid credentials'], 401);
                    }



                    $ShareHolderProfit = DB::table('shareholdersnfamilydata')
                    ->select('SHR_NO as Box_No','NAME','CIVIL_ID','CODE as ShareHolderBarCode','PROFIT')
                        ->where('CIVIL_ID', $validatedData['civilid'])                        
                       // ->Where('SHR_NO', $box_no)                    
                        ->get();

                    
                        if ($ShareHolderProfit->isEmpty()) {
                            // Return an empty message
                            return response()->json(['message' => 'No shareholder family card data found.']);
                        }



            
                    // Return a success response
                    return response()->json(['message' =>  $ShareHolderProfit]);
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while signing in', 'error' => $e->getMessage()], 500);
                }

                
            }



            public function MobileUserSignIn(Request $request)
                {
                    try {
                        // Validate the request data
                        $validatedData = $request->validate([
                            'civilid' => 'required',
                            'password' => 'required',
                        ]);

                        // Check if the user exists in the database
                        $user = DB::table('appusers')
                            ->where('civilid', $validatedData['civilid'])
                            ->where('password', $validatedData['password'])
                            ->first();

                        // If the user is not found or the password is incorrect, return an error response
                        if (!$user) {
                            return response()->json(['message' => 'Invalid credentials'], 401);
                        }

                        $ShareHolderProfit = DB::table('shareholdersnfamilydata')
                            ->select('SHR_NO as SHR_NO', 'NAME', 'CIVIL_ID', 'CODE as CODE', 'PROFIT')
                            ->where('CIVIL_ID', $validatedData['civilid'])
                            ->get();

                        if ($ShareHolderProfit->isEmpty()) {
                            // Return an empty message with status 200
                            return response()->json(['message' => 'No shareholder family card data found.'], 200);
                        }

                        // Return a success response with the ShareHolderProfit data
                       // return response()->json(['message' => $ShareHolderProfit], 200);
                        return response()->json(['status' => true, 'message' => $ShareHolderProfit], 200);


                    } catch (\Exception $e) {
                        // Return an error response
                        return response()->json(['message' => 'Error occurred while signing in', 'error' => $e->getMessage()], 500);
                    }
                }




            public function sendMobileUserPassword(Request $request)
            {
                try {
                    // Validate the request data
                    $validatedData = $request->validate([
                        'email' => 'required|email',
                    ]);
            
                    // Find the user in the database
                    $user = DB::table('appUsers')
                        ->where('email', $validatedData['email'])
                        ->first();
            
                    // If the user is found, send the password to their email
                    if ($user) {
                        // Send the password to the user's email
                        Mail::raw("Your password: $user->password", function ($message) use ($validatedData) {
                            $message->to($validatedData['email'])
                                ->subject('Your Password');
                        });
            
                        // Return a success response
                        return response()->json(['message' => 'Password sent to user email']);
                    } else {
                        // If the user is not found, return an error response
                        return response()->json(['message' => 'User email not found'], 404);
                    }
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending password', 'error' => $e->getMessage()], 500);
                }
            }

            


            public function sendMobileUserPassword1(Request $request)
            {
                try {
                    // Validate the request data
                    $validatedData = $request->validate([
                        'email' => 'required|email',
                    ]);

                    // Find the user in the database
                    $user = DB::table('appUsers')
                        ->where('email', $validatedData['email'])
                        ->first();

                    // If the user is found, send the password to their email
                    if ($user) {
                        // Set the mailer configuration
                        $config = [
                            'transport' => 'smtp',
                            'host' => 'smtp.gmail.com',
                            'port' => 465,
                            'encryption' => 'tsl',
                            'username' => 'deepinuniverse@gmail.com',
                            'password' => 'donald42376#12',
                            'from' => [
                                'address' => 'deepinuniverse@gmail.com',
                                'name' => 'Support Team, Sabah Alnasar'
                            ]
                        ];
                        config(['mail' => $config]);

                        // Send the password to the user's email
                        Mail::raw("Your password: $user->password", function ($message) use ($validatedData) {
                            $message->to($validatedData['email'])
                                ->subject('Your Password');
                        });

                        // Return a success response
                        return response()->json(['message' => 'Password sent to user email']);
                    } else {
                        // If the user is not found, return an error response
                        return response()->json(['message' => 'User email not found'], 404);
                    }
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending password', 'error' => $e->getMessage()], 500);
                }
            }


            public function sendMobileUserPassword2(Request $request)
            {
                try {
                    // Validate the request data
                    $validatedData = $request->validate([
                        'email' => 'required|email',
                    ]);

                    // Find the user in the database
                    $user = DB::table('appUsers')
                        ->where('email', $validatedData['email'])
                        ->first();

                    // If the user is found, send the password to their email
                    if ($user) {
                        // Set the mailer configuration
                        $config = [
                            'driver' => 'smtp',
                            'host' => 'mail.privateemail.com',
                            'port' => 465,
                            'encryption' => 'ssl',
                            'username' => 'support@sabahalnaser.com',
                            'password' => '123456',
                            'from' => [
                                'address' => 'support@sabahalnaser.com',
                                'name' => 'Support Team, Sabah Alnasar'
                            ]
                        ];

                        // Send the password to the user's email using the specified mailer
                        Mail::mailer('smtp')->raw("Your password: $user->password", function ($message) use ($validatedData) {
                            $message->to($validatedData['email'])
                                ->subject('Your Password');
                        });

                        // Return a success response
                        return response()->json(['message' => 'Password sent to user email']);
                    } else {
                        // If the user is not found, return an error response
                        return response()->json(['message' => 'User email not found'], 404);
                    }
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending password', 'error' => $e->getMessage()], 500);
                }
            }


            public function sendEmail()
            {
                try {
                    // Set the email details
                    $toEmail = 'deepinuniverse@gmail.com';
                    $subject = 'Test Email';
                    $content = 'This is a test email sent from Laravel using Gmail SMTP.';

                    // Set the mailer configuration
                    $config = [
                        'driver' => 'smtp',
                        'host' => 'smtp.gmail.com',
                        'port' => 587,
                        'encryption' => 'tls',
                        'username' => 'deepinuniverse@gmail.com',
                        'password' => 'donald42376#12',
                        'timeout' => null,
                        'auth_mode' => null,
                    ];

                    // Send the email using the specified mailer and configuration
                    Mail::mailer('smtp')->send([], [], function ($message) use ($toEmail, $subject, $content) {
                        $message->to($toEmail)
                            ->subject($subject)
                            ->setBody($content);
                    });

                    // Return a success response
                    return response()->json(['message' => 'Email sent successfully']);
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending email', 'error' => $e->getMessage()], 500);
                }
            }


            public function sendEmail1()
            {
                try {
                    // Set the email details
                    $toEmail = 'deepinuniverse@gmail.com';
                    $subject = 'Test Email';
                    $content = 'This is a test email sent using Laravel with custom SMTP settings.';

                    // Set the mailer configuration
                    $config = [
                        'driver' => 'smtp',
                        'host' => 'mail.privateemail.com',
                        'port' => 465,
                        'encryption' => 'SSL',
                        'username' => 'support@sabahalnaser.com',
                        'password' => '123456',
                    ];

                    // Send the email using the specified mailer and configuration
                    Mail::mailer('smtp')->send([], [], function ($message) use ($toEmail, $subject, $content) {
                        $message->to($toEmail)
                            ->subject($subject)
                            ->setBody($content);
                    });

                    // Return a success response
                    return response()->json(['message' => 'Email sent successfully']);
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending email', 'error' => $e->getMessage()], 500);
                }
            }



            





            public function GetHomeScreenData()
            {
                try {
                    // Retrieve news from the 'news_details' table in descending order of creation date
                  //  $news = DB::table('news_details')
                   //     ->orderBy('created_at', 'desc')
                  //      ->limit(5)
                  //      ->get();

                    // Retrieve slideshows from the 'slideshows' table in descending order of creation date
                    $slideshows = DB::table('slideshows')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

                
                    
                  // Retrieve news from the 'offersFestivals' table 

                        $offersFestivals = DB::table('offers')
                        ->leftJoin('offers_images', 'offers.id', '=', 'offers_images.offers_id')
                  
                        ->select('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo', DB::raw('GROUP_CONCAT(offers_images.image) as images'))
                      
                        ->groupBy('offers.id', 'offers.topic', 'offers.location', 'offers.details', 'offers.from_dt', 'offers.to_dt', 'offers.photo')
                        ->orderBy('offers.created_at', 'desc')
                        ->limit(5)
                        ->get();

                        $offersFestivals = $offersFestivals->map(function ($offersFestival) {
                            $offersFestival->images = explode(',', $offersFestival->images);
                            return $offersFestival;
                        });


                     $socialmedia = DB::table('socialmedia')
                    ->get();

                    //Shareholder  title
                    $sharholderTitle = DB::table('customer_profit')
                    ->orderBy('id', 'desc')
                    ->first();


                        // Retrieve news from the 'branchesCat' table 
                     //   $branchesCat = DB::table('branch_categories')
                    //    ->get();


                         // Retrieve news from the 'offer_categories' table 
                   // $offer_categories = DB::table('offer_categories')
                  //  ->orderBy('created_at', 'desc') 
                 //   ->limit(5)                   
                  //  ->get();
                    

                    // Create a JSON response with success status, data, and response code
                    return response()->json([
                        'code' => 200,
                        'status' => true,
                       // 'news' => $news,
                        'slideshows' => $slideshows,
                        'offersFestivals' => $offersFestivals,
                        'socialmedia' => $socialmedia,
                        'sharholderTitle' => $sharholderTitle,
                    ], 200);
                } catch (QueryException $e) {
                    // If a database query exception occurs, create a JSON response with error status, error message, and response code
                    return response()->json([
                        'code' => 500,
                        'status' => false,
                        'message' => 'Failed to retrieve data from the database: ' . $e->getMessage()
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




            public function getCoordinates()
            {
                // Define the address or location
                $address = 'https://goo.gl/maps/8r2AjH3zbxuYrEGP6';

                // Initialize Guzzle HTTP client
                $client = new Client();

                // Send a GET request to the Google Maps Geocoding API
                $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'query' => [
                        'address' => $address,
                        'key' => 'YOUR_API_KEY', // Replace with your Google Maps API key
                    ],
                ]);

                // Parse the response JSON
                $data = json_decode($response->getBody(), true);

                // Check if the API request was successful
                if ($data['status'] === 'OK') {
                    // Extract the latitude and longitude
                    $latitude = $data['results'][0]['geometry']['location']['lat'];
                    $longitude = $data['results'][0]['geometry']['location']['lng'];

                    // Return the latitude and longitude
                    return response()->json([
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                    ]);
                } else {
                    // Return an error response if the API request failed
                    return response()->json(['message' => 'Failed to retrieve coordinates'], 500);
                }
            }



            public function sendEmail5(Request $request)            
            {
                try 
                {


                    $validatedData = $request->validate([
                        'email' => 'required|email',
                    ]);

                    // Find the user in the database
                   // $user = DB::table('appUsers')
                      //  ->where('email', $validatedData['email'])
                     //   ->first();


                        $user = DB::table('appusers')
                        ->where('email', $validatedData['email'])
                        ->value('password');


                    if (!$user) {
                        return response()->json(['message' => 'User email not found'], 404);
                    }


                    // Create the SMTP transport
                    $transport = new Swift_SmtpTransport('mail.privateemail.com', 465, 'ssl');
                    $transport->setUsername('support@sabahalnaser.com');
                    $transport->setPassword('123456');

                    // Create the Swift Mailer instance
                    $mailer = new Swift_Mailer($transport);

                    // Create the message
                    $message = new Swift_Message();
                    $message->setSubject('كلمة مرور جديدة');
                   // $message->setSubject(' deep ');
                    $message->setFrom(['support@sabahalnaser.com' => 'Support - Sabha Alnaser']);
                    //$message->setTo(['deepinuniverse@gmail.com' => 'Recipient Name']);
                    $message->setTo([$validatedData['email'] => 'Recipient Name']);
                   // $message->setBody('كلمة المرور الجديدة');

                    $message->setBody('كلمة المرور الجديدة: ' . $user);

                    // Send the email
                    $result = $mailer->send($message);

                    // Check if the email was sent successfully
                    if ($result) {
                        // Return a success response
                        return response()->json(['message' => 'Email sent successfully']);
                    } else {
                        // Return an error response
                        return response()->json(['message' => 'Failed to send email'], 500);
                    }
                } catch (\Exception $e) {
                    // Return an error response
                    return response()->json(['message' => 'Error occurred while sending email', 'error' => $e->getMessage()], 500);
                }
            }



            public function getShareHolderProfitByCivil(Request $request)
            {        
                try {
                    // Retrieve branches from the 'branches' table in descending order of creation date               
    


                    $ShareHolderProfit = DB::table('shareholdersnfamilydata')
                    ->select('PROFIT', 'CODE' )
                        ->where('CIVIL_ID', $request['civilid'])                        
                       // ->Where('SHR_NO', $box_no)                    
                        ->get();

                 
    
    
    
                        if ($ShareHolderProfit->isEmpty()) {
                            // No records found
                            return response()->json([
                                'code' => 404,
                                'status' => false,
                                'message' => 'No records found',
                                'data' => null
                            ], 404);
                        }
            
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
                        'message' => 'Failed to shareholder profit branches from the database: ' . $e->getMessage()
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

            
           
    





} // end of Main Class
