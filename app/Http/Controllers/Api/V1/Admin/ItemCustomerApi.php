<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\User;
use App\Customer;
use App\Item_transport;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\Http\Resources\Admin\FormatteResponse;
use Symfony\Component\HttpFoundation\Response;

class ItemCustomerApi extends Controller
{

    public function __construct()
    {
        $this->middleware(['multiauth:customer','swfix']);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/ItemCustomers",
     *      operationId="getItemCustomers",
     *      tags={"Customer View Item"},
     *      security={
     *        {"X-3PS-Authorization": {}},
     *      },
     *      summary="Get list of Item Order Customers",
     *      description="Returns list of Item Order Customers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ItemCustomers")
     *       ),
     *  )
     */
    public function index(Request $req)
    {

        if(!$req->user('customer')->tokenCan('item-customers')) {

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
                        'customers','city_show_it_origin','city_show_it_destination','users','sub_services'
                    ];

                 $d = Item_transport::with($operation)->whereIn('customer_id', [$req->user('customer')->id])->get();
            
                $CItemRegistry = Customer::find($req->user('customer')->id);
                
            // return FormatteResponse::success(array($s, $d, $CItemRegistry->tokens()->find($CItemRegistry->oauth_access_account_id)), 'List item customer only successfully');
            return FormatteResponse::success($s, $d, 'List item customer only successfully');

        }

    }

}
