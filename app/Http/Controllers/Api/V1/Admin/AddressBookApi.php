<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
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

class AddressBookApi extends Controller
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
    * @OA\Post(
    *      path="/api/v1/add-AddressBooks",
    *      operationId="Add Address book",
    *      tags={"Add address book for customer"},
    *      summary="Add address book customer only",
    *      description="Returns personal data with scope(s)",
    *      security={
    *        {"X-3PS-Authorization": {}},
    *      },
    *      @OA\RequestBody(
    *       required=true,
    *       description="detail required data address book",
    *       @OA\JsonContent(
    *                  @OA\Property(property="name", type="string"),
    *                  @OA\Property(property="details", type="string"),
    *                  @OA\Property(property="address", type="string"),
    *                  @OA\Property(property="city_id", type="string"),
    *                  @OA\Property(property="contact", type="string"),
    *                  @OA\Property(property="phone", type="string"),
    *                  @OA\Property(property="pic_name_origin", type="string"),
    *                  @OA\Property(property="pic_name_destination", type="string"),
    *                  @OA\Property(property="pic_phone_origin", type="string"),
    *                  @OA\Property(property="pic_phone_destination", type="string")
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
    *          @OA\JsonContent(ref="#/components/schemas/AddressBookResources")
    *       ),
    * )
    */
    public function saveAddressBookForms(Request $request){

        if(!$request->user('customer')->tokenCan('create-address-book','view-address-book')) {

            return response()->json([
                'message' => "Access denied",
            ]);

        } 
            else {

                $factory = new UuidFactory();
                $codec = new OrderedTimeCodec($factory->getUuidBuilder());
        
                $factory->setCodec($codec);
        
                $orderedTimeUuid = $factory->uuid1();
        
                $s = [
                   'UUIDs' => $orderedTimeUuid->toString(),
                    'Date' => $orderedTimeUuid->getDateTime()->format('r')
                ];
                
                $this->address->updateOrCreate([
                    'customer_id' => $request->user('customer')->id,
                    'name' => $request->input('name'),
                    'city_id' => $request->input('city_id'),
                    'details' => $request->input('detail'),
                    'address' => $request->input('address'),
                    'contact' => $request->input('contact'),
                    'phone' => $request->input('phone'),
                    'pic_name_origin' => $request->input('pic_name_origin'),
                    'pic_name_destination' => $request->input('pic_name_destination'),
                    'pic_phone_origin' => $request->input('pic_phone_origin'),
                    'pic_phone_destination' => $request->input('pic_phone_destination')
                ]);

            // return FormatteResponse::success($s, $request->all(), 'Created address book successfully');
            return FormatteResponse::success($s, $request->all(),  'Created address book successfully');
       
        }
        
    }

    /**
     * @OA\Get(
     *      path="/api/v1/AddressBooks",
     *      operationId="getTransportOrders",
     *      tags={"Address Book View"},
     *      security={
     *        {"X-3PS-Authorization": {}},
     *      },
     *      summary="Get List Address Book",
     *      description="Returns list of Address Book",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AddressBookResources")
     *       ),
     *  )
    */
    public function index(Request $req)
    {

        if(!$req->user('customer')->tokenCan('create-address-book','view-address-book')) {

            return response()->json([
                'message' => "Access denied",
            ]);

        } 
            else {

                $factory = new UuidFactory();
                $codec = new OrderedTimeCodec($factory->getUuidBuilder());
        
                $factory->setCodec($codec);
        
                $orderedTimeUuid = $factory->uuid1();
        
                $s = [
                   'UUIDs' => $orderedTimeUuid->toString(),
                    'Date' => $orderedTimeUuid->getDateTime()->format('r')
                ];

                $operation = [
                    'users','customers','origins','destinations','citys'
                ];

                    $d = $this->address->with($operation)->whereIn('customer_id', [$req->user('customer')->id])
                        ->get();

                    $cs = Customer::find($req->user('customer')->id);

            // return FormatteResponse::success(array($s, $d, $cs->tokens()->find($cs->oauth_access_account_id)), 'Created address book successfully');
            return FormatteResponse::success($s, $d, 'Get list address book successfully');

        }
    }
}






 