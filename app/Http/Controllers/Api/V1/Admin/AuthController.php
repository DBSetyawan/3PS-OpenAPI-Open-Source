<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\User;
use App\Customer;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Authenticator;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Ramsey\Uuid\UuidFactory;
use App\Http\Traits\PassportToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use App\Http\Resources\Admin\FormatteResponse;
use App\Http\Controllers\Helpers\UuidsIntegerInterface;


class AuthController extends Controller
{
    // https://tools.ietf.org/html/rfc6749#section-4.4.3


    public $successStatus = 200;

    private $authenticator;
    private $client;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;

    }

     /**
        * @OA\Post(
        *      path="/api/v1/registers",
        *      operationId="RegisterApiToken",
        *      tags={"Register Access API key"},
        *      summary="Register data with scheme apiKey <Token>",
        *      description="Returns Api Access Token",
        *      @OA\RequestBody(
        *       required=true,
        *       description="Register API Access Token",
        *       @OA\JsonContent(
        *          @OA\Property(property="code_customer", type="string"),
        *                  @OA\Property(property="password", type="string")
        *       ),
        *     ),
        *      @OA\Response(
        *          response=400,
        *          description="Bad Request"
        *      ),
        *      @OA\Response(
        *          response=500,
        *          description="Internal server error",
        *          @OA\JsonContent(ref="#/components/schemas/RegisterAPIkey")
        *      ),
        * )
    */
    public function fetch_access_token_customer (Request $request) {


        try {
       
        $validator = Validator::make($request->all(), [
            'code_customer' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
    
        $Customer = Customer::where('customer_id', $request->input('code_customer'))->first();
        $Customer->password = Hash::make($request->input('password'));

        $token = $Customer->createToken('3PS Register Customers 1 Password Grant Client [event] { Verification }', $scopes = [] );
        
        $strToken = $token->accessToken;
        $Customer->api_token = $strToken;
        $Customer->update();

        $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());
        $factory = new UuidFactory();
        $codec = new OrderedTimeCodec($factory->getUuidBuilder());

        $factory->setCodec($codec);

        $orderedTimeUuid = $factory->uuid1();

        $s = [
           'UUIDs' => $orderedTimeUuid->toString(),
            'Date' => $orderedTimeUuid->getDateTime()->format('r')
        ];
                $response = [
                        'access_token_id' => Uuid::uuid4($token->token->id),
                        'expires_at' => $expiration,
                        'access_token_registered' => $strToken,
                        'user' => 
                                    [
                                        'id' => Uuid::uuid1($Customer->id),
                                        'project_id' => $Customer->project_id,
                                        'itemID_accurate' => $Customer->itemID_accurate,
                                        'no_pajak' => $Customer->tax_no,
                                        'created_at' => $Customer->created_at,
                                        'updated_at' => $Customer->updated_at
                                    ]
                    ];
                    
            return FormatteResponse::success($s, $response, 'Customer register successfully');

        } catch (\Exception $exception) {
            
        
             return FormatteResponse::error("Internal server error", 'Creating default object from empty value', 500);
        
        }
    
    }

    // public function login(Request $request){

    //     $request->validate([
    //                 'customer_id' => 'required|string',
    //                 'password' => 'required|string'
    //                 // 'remember_me' => 'boolean'
    //             ]);

    //     // $credentials = ['customer_id' => $request->post('customer_id'), 'password' => $request->post('password')];
    // //     return response()->json([
    // //         'message' => Auth::guard('customer')->attempt($credentials, false, false)
    // // ], 401);die;
    //     if (!\Auth::guard('customer')->attempt(['customer_id' => $request->input('customer_id'), 'password' => Hash::make($request->password) ])) {
    //         return response()->json([
    //                 'message' => 'Unauthorized'
    //         ], 401);
    //     } else {
    //         return response()->json([
    //             'message' => 'in'
    //     ], 200);
    //     }

    //     // if(Auth::guard('customer')->attempt(['customer_id' => request('customer_id'), 'password' => request('password')])){
    //     //     $user = Auth::User();
    //     //     $createdToken = $user->createToken('Customer System 3PS Access Token');
    //     //     $token = $createdToken->token;
    //     //     $token->expires_at = Carbon::now()->addWeeks(1);

    //     //     $token->save();
      
    //     //     return response()->json([
    //     //     'access_token' => $createdToken->accessToken,
    //     //     'token_type' => 'Bearer',
    //     //     'expires_at' => Carbon::parse(
    //     //         $createdToken->token->expires_at
    //     //     )->toDateTimeString()], $this->successStatus);
    //     // }
    // }


     /**
        * @OA\Post(
        *      path="/api/v1/login",
        *      operationId="Authorized access Token with scope(s)",
        *      tags={"Authorization Access Token API key"},
        *      summary="Authorization data with scheme apiKey ( Bearer <token> )",
        *      description="Returns personal access token with scope(s)",
        *      @OA\RequestBody(
        *       required=true,
        *       description="Authorization Access Token API key with scope(s)",
        *       @OA\JsonContent(
        *                  @OA\Property(property="customer_id", type="string"),
        *                  @OA\Property(property="password", type="string"),
        *                  @OA\Property(property="provider", type="string"),
        *                  @OA\Property(property="scopes", type="string")
        *       ),
        *     ),
        *      @OA\Response(
        *          response=400,
        *          description="Bad Request"
        *      ),
        *      @OA\Response(
        *          response=500,
        *          description="Internal server error",
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Successful Authorization API Token with scope(s)",
        *          @OA\JsonContent(ref="#/components/schemas/OauthApiKey")
        *       ),
        * )
        */
    public function login(Request $request)
    {
        try {
       
            $credentials = array_values($request->only('customer_id', 'password', 'provider'));

                if (! $user = $this->authenticator->attempt(...$credentials)) {
                    throw new AuthenticationException();
                }

                        $token = $user->createToken('3PS Register Customers 1 Password Grant Client [event] { login }', $scopes = explode(" ", implode($request->only('scopes'))) );

                        $strToken = $token->accessToken;
                
                    $expiration = $token->token->expires_at->diffInSeconds(Carbon::now());
                    $access_id = $token->token->id; 

                 $users = Customer::where('customer_id', $user->customer_id)->update(['oauth_access_account_id' => $token->token->{"id"}, 'api_token' => $strToken  ]);

                // return  response 
                // $rfs = $this->getBearerTokenByUser($users, 1, false);
                // $users->api_token = $token->accessToken;
                $factory = new UuidFactory();
                $codec = new OrderedTimeCodec($factory->getUuidBuilder());
        
                $factory->setCodec($codec);
        
                $orderedTimeUuid = $factory->uuid1();
        
                $s = [
                   'UUIDs' => $orderedTimeUuid->toString(),
                    'Date' => $orderedTimeUuid->getDateTime()->format('r')
                ];
                    $verifiedUsers = [
                        'token_type' => 'Bearer',
                        'expires_token_at' => $expiration,
                        'access_token' => $strToken,
                        'd' => [
                                'user' => [
                                            'id' => $token->token->id,
                                            'client_id' => Uuid::uuid5(Uuid::NAMESPACE_URL, $token->token->client_id),
                                            'user_id' => Uuid::uuid5(Uuid::NAMESPACE_URL, $token->token->user_id),
                                            'created_at' => $token->token->created_at,
                                            'expired_at' => $token->token->expires_at->toDateTimeString()
                                        ]
                        ]
                    ];

                return FormatteResponse::success($s, $verifiedUsers, 'Customer verified successfully');

            } catch (\Throwable $th) {
                
            return FormatteResponse::error("Internal server error", 'Please check. code customer, password, provider | scope must be : item-customer create-address-book', 500);

        }

    }

    // public function registers(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required',
    //         'password' => 'required|min:6|confirmed'
    //     ]);
    
    //     if ($validator->fails())
    //     {
    //         return response(['errors'=>$validator->errors()->all()], 422);
    //     }
        
    //     $http = new \GuzzleHttp\Client;

    //     $response = $http->post('http://api.3permata.co.id/oauth/token', [
    //         'form_params' => [
    //                 'grant_type' => 'client_credentials',
    //                 'client_id' => 1,
    //                 'client_secret' => '808Dw3FJn2Sy4FAMq1hY3FXkRCuIpYfKxTQb59Kt',
    //                 'username' =>  $request->input('username'),
    //                 'password' =>  Hash::make($request->input('password')),
    //                 'provider' => 'customer',
    //         ],
    //     ]);
        
    //     return response()->json([
    //         'd' => json_decode((string) $response->getBody(), true)
    //     ]);

    // }

    // public function login(Request $request){
    //     // $validator = Validator::make($request->all(), [
    //     //     'id' => 'required|string',
    //     //     'password' => 'required|min:6',
    //     // ]);
    //     // if ($validator->fails()) {  
    //     //     return response()->json(['error'=>$validator->errors()], 401);
    //     // }
    //     $admin = Customer::find(10);
    //     $admin->createToken('My Customer Token Access grant');
    //     $admin->api_token = $admin->tokens();
    //     // $credentials = $request->only('id', 'password');
    //     // if(Auth::guard('customer-api')->attempt(['id' => $request->input('id'), 'password' => $request->input('password')])){
    //     //     $user = Auth::guard('customer-api')->user();
    //     //     $success['token'] =  $user->createToken('customer-api access token')->accessToken;
    //     //     return response()->json(['success' => $success], $this->successStatus);
    //     // }
    //     // else{
    //     //     return response()->json(['error'=>'Unauthorised'], 401);
    //     // }
    //     // $admin->tokens()->each(function ($token) {
    //     //     return  $token->name; // My Admin Token
    //     //     // return $admin->api_token = $da;
    //     //     // return response()->json(['error'=> $token->name ], 200);

    //     //     // 
    //     // });
    //     // ;
    //     $admin->update();
    //     return response()->json(['error'=> $admin ], 200);

    //     // $admin = Customer::find(10);

    //     // $admin->createToken('My Admin Token');

    //     // $admin->tokens()->each(function ($token) {
    //     //     return response()->json(['token' => $token->name]);
    //     // });
    //     // if(Auth::guard('customer')->attempt($credentials)){
    //     //     $user = Auth::guard('customer')->user();

    //     //     $Customer = Customer::findOrFail($request->input('id'));

    //     //     $success['token'] =  $user->createToken('Customers System 3PS Access Token')->accessToken;

    //     //     $Customer->api_token =  $success['token'];
    //     //     $Customer->update();

    //     //     return response()->json(['success' => $success , 'user' => $user, 's' => Auth::guard('customer')->check() , 'active_user' => Auth::guard('customer')->user() ], $this->successStatus);
    //     // }
    //     // else{
    //     //     return response()->json(['error'=> auth()->guard('customer')->check()], 401);
    //     // }
    // }

    public function details()
    {
        $user = Auth::guard('customer')->user();
        return response()->json(['detail user' => $user], $this->successStatus);
    }


    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();
    
        $response = 'berhasil keluar aplikasi';
        return response($response, 200);
    
    }
}