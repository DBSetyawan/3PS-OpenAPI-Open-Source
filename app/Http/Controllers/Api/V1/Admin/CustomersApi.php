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
use App\Http\Resources\Admin\FormatteResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomersApi extends Controller
{

    public function __construct()
    {
        $this->middleware(['multiauth:customer','swfix']);
    }

     /**
     * @OA\Get(
     *      path="/api/v1/Customers",
     *      operationId="getTransportOrders",
     *      tags={"Customer View SO"},
     *      security={
     *        {"X-3PS-Authorization": {}},
     *      },
     *      summary="Get list of Sales Order Customer",
     *      description="Returns list of SO Customers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TransportOrders")
     *       ),
     *  )
     */
    public function index(Request $req)
    {

        if(!$req->user('customer')->tokenCan('shipment-view')) {

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
                    'cek_status_transaction','customers:id,name','addressRelatsOrigins.citys:id,name',
                    'addressRelatsDestinations.citys:id,name','job_transaction_details.job_transports_normalize',
                    'job_transaction_ones.job_transports.status_vendor_jobs'
                ];

                $d = Transport_orders::with($operation)
                    ->whereIn('customer_id', [$req->user('customer')->id])
                        ->get();

                $cs = Customer::find($req->user('customer')->id);

            return FormatteResponse::success($s, array($d, 'transaction' => 'verified'), 'List customer only successfully');
            // return FormatteResponse::success($s, array($d, $cs->tokens()->find($cs->oauth_access_account_id)), 'List customer only successfully');
                
        }
        
    }

}
