<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\City;
use App\User;
use App\Customer;
use App\Transport_orders;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\CustomerRsc;
use App\Address_book as origin_address_book;
use App\Http\Resources\Admin\FormatteResponse;
use Symfony\Component\HttpFoundation\Response;

class CityApi extends Controller
{

    private $address;

    public function __construct( 
                                    origin_address_book $addressed
                                )
    {
        $this->middleware(['multiauth:customer','swfix']);
        $this->address = $addressed;

    }

      /**
        * @OA\Get(
        *      path="/api/v1/Citys/{CityId}",
        *      operationId="Getdetailcity",
        *      tags={"Get detail city"},
        *      summary="Get all list city",
        *      description="Returns data list detail city",
        *      security={
        *        {"X-3PS-Authorization": {}},
        *      },
        * @OA\Parameter(
        *    description="ID of city",
        *    in="path",
        *    name="CityId",
        *    required=true,
        *    example="1109",
        *    @OA\Schema(
        *       type="integer",
        *       format="int64"
        *    )
        * ),
        *      summary="Get list of City",
        *      description="Returns list of City",
        *      @OA\Response(
        *          response=200,
        *          description="Successful operation",
        *          @OA\JsonContent(ref="#/components/schemas/Citys")
        *       ),
        *  )    
     */

    public function getALlcity(Request $request){

        if(!$request->user('customer')->tokenCan('city-view')) {

            return response()->json([
                'message' => "Access denied",
            ]);

        } 
            else 
                    {

                        try {
                            
                            $factory = new UuidFactory();
                            $codec = new OrderedTimeCodec($factory->getUuidBuilder());
                    
                            $factory->setCodec($codec);
                    
                            $orderedTimeUuid = $factory->uuid1();
                    
                            $s = [
                               'UUIDs' => $orderedTimeUuid->toString(),
                                'Date' => $orderedTimeUuid->getDateTime()->format('r')
                            ];
                    
                                $d = City::findOrFail($request->CityId);

                                $CItemRegistry = Customer::find($request->user('customer')->id);
                            
                            // return FormatteResponse::success(array($s, $CItemRegistry->tokens()->find($CItemRegistry->oauth_access_account_id), $d), 'list of detail city');
                            return FormatteResponse::success($s, array($d, 'transaction' => 'verified'), 'List city successfully');

                    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    
                return FormatteResponse::error("", 'City not found', 400);

            }

        }
    }
}






 