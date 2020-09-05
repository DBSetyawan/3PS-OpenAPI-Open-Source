<?php

namespace App\Http\Controllers\Api\V1\Admin;

      /**
         * @OA\Info(
         *      version="1.0.0",
         *      title="3PS OpenAPI Documentation",
         *      description="3PS OpenAPI publish",
         *      @OA\Contact(
         *          email="artexsdns@gmail.com"
         *      ),
         *      @OA\License(
         *          name="Apache 2.0",
         *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
         *      )
         * )
         *
         * @OA\Server(
         *      url=L5_SWAGGER_CONST_HOST,
         *      description="3PS OpenAPI Published",
         * )
        */

    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    }