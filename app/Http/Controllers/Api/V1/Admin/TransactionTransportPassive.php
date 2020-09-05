<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\User;
use App\Customer;
use GuzzleHttp\Client;
use App\Transport_orders;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\CustomerRsc;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Admin\FormatteResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionTransportPassive extends Controller
{

    public function __construct()
    {
        $this->middleware(['multiauth:customer','swfix']);
    }

    /**
    * @OA\Post(
    *      path="/api/v1/create-shipment",
    *      operationId="PostTransportOrders",
    *      tags={"Create Shipment"},
    *      security={
    *        {"X-3PS-Authorization": {}},
    *      },
    *    @OA\RequestBody(
    *       required=true,
    *       description="detail required data create shipment",
    *       @OA\JsonContent(
    *                  @OA\Property(property="item_transport", type="integer"),
    *                  @OA\Property(property="address_origin_id", type="integer"),
    *                  @OA\Property(property="address_destination_id", type="integer"),
    *                  @OA\Property(property="estimated_time_of_delivery", type="string"),
    *                  @OA\Property(property="origin", type="string"),
    *                  @OA\Property(property="destination", type="string"),
    *                  @OA\Property(property="estimated_time_of_arrival", type="string"),
    *                  @OA\Property(property="time_zone", type="string"),
    *                  @OA\Property(property="collie", type="integer"),
    *                  @OA\Property(property="quantity", type="integer"),
    *                  @OA\Property(property="volume", type="integer"),
    *                  @OA\Property(property="actual_weight", type="integer"),
    *                  @OA\Property(property="chargeable_weight", type="integer"),
    *                  @OA\Property(property="notes", type="string"),
    *                  @OA\Property(property="origin_address", type="string"),
    *                  @OA\Property(property="destination_address", type="string"),
    *                  @OA\Property(property="pic_name_destination", type="string"),
    *                  @OA\Property(property="pic_phone_origin", type="string"),
    *                  @OA\Property(property="pic_phone_destination", type="string"),
    *                  @OA\Property(property="harga", type="string")
    *       ),
    *     ),
    *      summary="Data list of Sales Order Customers",
    *      description="Returns data of Shipment Customers",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\JsonContent(ref="#/components/schemas/ShipmentModels")
    *       ),
    *       @OA\Response(
    *          response=500,
    *          description="Internal Server error"
    *       ),
    *       @OA\Response(
    *          response=422,
    *          description="Unprocessable Entity"
    *       ),
    *       @OA\Response(
    *          response=403,
    *          description="Access Denied"
    *       ),
    *  )
    */
    public function createShipment(Request $req)
    {

        // try {

            // $client = new Client(['auth' => ['samsunguser', 'asdf123']]);
            
            // $response = $client->post(
            //                 'http://api.trial.izzytransport.com/customer/v1/shipment/new',
            //                 [
            //                     'headers' => [
            //                         'Content-Type' => 'application/x-www-form-urlencoded',
            //                         'X-IzzyTransport-Token' => 'ab567919190b1b8df2b089c02e0eb3321124cf6f.1575862464',
            //                         'Accept' => 'application/json'
            //                     ],
            //                     'form_params' => [
            //                         'Sh[projectId]' => '197',
            //                         'Sh[vendorId]' => '10',
            //                         'Sh[poCodes]' => '',
            //                         'Sh[collie]' => $req->input('collie'),
            //                         'Sh[actualWeight]' =>  $req->input('actual_weight'),
            //                         'Sh[chargeableWeight]' => $req->input('chargeable_weight'),
            //                         'Sh[loadingType]' => 'Item Code',
            //                         'Sh[service]' => $req->input('sub_servicess'),
            //                         'Sh[etd]' => $req->input('etd'),
            //                         'Sh[eta]' => $req->input('eta'),
            //                         'Sh[timeZone]' => $req->input('time_zone'),
            //                         'Sh[notes]' => $req->input('time_zone'),
            //                         'Sh[origin]' => $req->input('origin'),
            //                         'Sh[originCompany]' => $req->input('origin'),
            //                         'Sh[originAddress]' => $req->input('origin_address'),
            //                         'Sh[originContact]' => $req->input('pic_name_origin'),
            //                         'Sh[originPhone]' => $req->input('pic_phone_origin'),
            //                         'Sh[destination]' => $req->input('destination'),
            //                         'Sh[destinationCompany]' => $req->input('destination'),
            //                         'Sh[destinationAddress]' => $req->input('destination_address'),
            //                         'Sh[destinationContact]' => $req->input('pic_name_destination'),
            //                         'Sh[destinationPhone]' => $req->input('pic_phone_destination') 
            //                     ]
            //                 ]
            //             );

            // $shipment_code = json_decode($response->getBody()->getContents(), true);

            if(!$req->user('customer')->tokenCan('create-shipment')) {

                return FormatteResponse::error("Forbidden", 'Access denied', 403);

    
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

                $validator = Validator::make($req->all(), [
                    'address_origin_id' => 'required|integer',
                    'address_destination_id' => 'required|integer',
                    'estimated_time_of_arrival' => 'required|string',
                    'estimated_time_of_delivery' => 'required|string',
                    'time_zone' => 'required|string',
                    'collie' => 'required|integer',
                    'quantity' => 'required|integer',
                    'volume' => 'required|integer',
                    'actual_weight' => 'required|integer',
                    'chargeable_weight' => 'required|integer',
                    'notes' => 'required|string',
                ]);
            
                if ($validator->fails())
                {
                    return response(['errors'=>$validator->errors()->all()], 422);
                }

                $d = Transport_orders::updateOrCreate(
                        [
                            'customer_id' => $req->user('customer')->id,
                            // 'order_id' =>  $shipment_code['Shipment']['code'],
                            'purchase_order_customer' => '',
                            'item_transport' => $req->input('items_tc'),
                            'saved_origin_id' => $req->input('address_origin_id'),
                            'status_order_id' => 1,

                            'saved_destination_id' => $req->input('address_destination_id'),
                        
                            'estimated_time_of_delivery' => $req->input('estimated_time_of_delivery'),
                            'estimated_time_of_arrival' => $req->input('estimated_time_of_arrival'),
                            'time_zone' => $req->input('time_zone'),
                            'collie' => $req->input('collie'),
                            'quantity' => $req->input('quantity'),
                            'harga' => $req->input('harga'),
                            'volume' => $req->input('volume'),
                            'actual_weight' => $req->input('actual_weight'),
                            'chargeable_weight' => $req->input('chargeable_weight'),
                            'notes' => $req->input('notes')
                        ]
                );

            $cs = Customer::find($req->user('customer')->id);
                
            // return FormatteResponse::success(array($s, $d, $cs->tokens()->find($cs->oauth_access_account_id)), 'List item customer only successfully');
            return FormatteResponse::success($s, $d, 'Create shipment customer only successfully');

        // }  
            // catch (\GuzzleHttp\Exception\ClientException $handlingApi) {

            //     return response()->json([
            //         's' =>
            //                 [
            //                     'error_message' => json_decode($handlingApi->getResponse()->getBody()->getContents(), JSON_PRETTY_PRINT)
            //                 ]
                        
            //         ]
            //     );
                    
            // }
        }

    }

}
