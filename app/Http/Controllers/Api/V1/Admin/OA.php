// /**
<!-- https://medium.com/@ivankolodiy/how-to-write-swagger-documentation-for-laravel-api-tips-examples-5510fb392a94 -->
<!-- https://javorszky.co.uk/2017/03/18/i-modified-the-token-authentication-in-laravel-spark/ -->

<!-- untuk implicit password passport token
window.onload = function() {

     var urlToDocs = @json($urlToDocs);
  // var passwordClient = @json(\Laravel\Passport\Client::where('password_client', 1)->whereNull('user_id')->first());
  var passwordClient = @json(\Laravel\Passport\Client::where('password_client', 1)->whereNull('user_id')->first()->makeVisible('secret'));
  // Build a system
  const ui = SwaggerUIBundle({
    dom_id: '#swagger-ui',

    url: urlToDocs,
    operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
    configUrl: {!! isset($additionalConfigUrl) ? '"' . $additionalConfigUrl . '"' : 'null' !!},
    validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
    oauth2RedirectUrl: "{{ route('l5-swagger.oauth2_callback') }}",

    requestInterceptor: function(request) {
      request.headers['X-CSRF-TOKEN'] = @json(csrf_token());
      // request.headers['Authorization'] = 'Bearer ' + '{{ Cookie::get("token") }}'
      return request;
    },

    responseInterceptor: function (response) {
        if (response.status >= 200 && response.status < 300) {
            var docsUrl = @json(config('l5-swagger.paths.docs_json'));
            var storageKeys = Object.keys(window.localStorage);

            if (response.url.indexOf(urlToDocs) < 0 && storageKeys.indexOf('token') < 0 && response.obj) {
              window.localStorage.setItem('token', JSON.stringify(response.obj));
            }
        }
        return response;
    },

    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],

    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],

    layout: "StandaloneLayout"
  });

  var oldLogout = ui.authActions.logout;
    ui.authActions.logout = function(payload) {
        window.localStorage.removeItem('token');
        return oldLogout(payload);
    };
    
  if (passwordClient) {
    ui.initOAuth({
      clientId: passwordClient.id,
      clientSecret: passwordClient.secret,
    });
  }

  var tokenData = window.localStorage.getItem('token');
  var token = null;
  if (tokenData) {
      try {
          token = JSON.parse(tokenData);
      } catch(e) {

      }
  }

  if (token) {
      ui.authActions.preAuthorizeImplicit({
          auth: {
              schema: {
                  flow: 'password',
                  get: function (key) {
                      return this[key];
                  }
              },
              name: 'passport'
          },
          token: token,
          isValid: true
      });
  }

  window.ui = ui
}

 -->

 <!-- untuk penyimpanan data storage apiKey type Authorization

      window.onload = function() {
  var urlToDocs = @json($urlToDocs);
  var passwordClient = @json(\Laravel\Passport\Client::where('password_client', 1)->whereNull('user_id')->first());
  const ui = SwaggerUIBundle({
    dom_id: '#swagger-ui',

    url: urlToDocs,
    operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
    configUrl: {!! isset($additionalConfigUrl) ? '"' . $additionalConfigUrl . '"' : 'null' !!},
    validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
    oauth2RedirectUrl: "{{ route('l5-swagger.oauth2_callback') }}",

    requestInterceptor: function(request) {
      request.headers['X-CSRF-TOKEN'] = @json(csrf_token());
      return request;
    },

    responseInterceptor: function (response) {
        if (response.status >= 200 && response.status < 300) {
            var docsUrl = @json(config('l5-swagger.paths.docs_json'));
            var storageKeys = Object.keys(window.localStorage);

            if (response.url.indexOf(urlToDocs) < 0 && storageKeys.indexOf('token') < 0 && response.obj) {
              window.localStorage.setItem('token', JSON.stringify(response.obj));
            }
        }
        return response;
    },

    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],

    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],

    layout: "StandaloneLayout"
  });

  (function() {
   const tokenData = window.localStorage.getItem('token');
  const token = null;
  setTimeout(function() {
    if (tokenData) {
      ui.authActions.preAuthorizeImplicit({
        auth: {
          schema: {
            type: 'apiKey',
            in: 'header',
            name: 'Authorication',
            get: function(key) {
              return this[key];
            },
          },
          name: 'Bearer',
          value: tokenData,
        },
        token: {},
        isValid: true,
      });
    }

    const openBtn = document.querySelector('btn authorize unlocked');
    if (openBtn) {
      openBtn.addEventListener('click', function() {
        setTimeout(function() {
          const authBtn = document.querySelector('btn modal-btn auth authorize button');
          authBtn.addEventListener('click', function(e) {
            const tokenInput = document.querySelector('input:not([class])');
            if (tokenInput && tokenInput.value) {
              sessionStorage.setItem(TOKEN_NAME, tokenInput.value);
              console.log('Token vas successfully saved!!!');
            }
          });
        }, 1000);
      });
    }
  }, 1000);
})();

  window.ui = ui
}
  -->
    //  * @OA\Delete(
    //  *      path="/projects/{id}",
    //  *      operationId="deleteProject",
    //  *      tags={"Projects"},
    //  *      security={
    //  *          {"passport": {}},
    //  *      },
    //  *      summary="Delete existing project",
    //  *      description="Deletes a record and returns no content",
    //  *      @OA\Parameter(
    //  *          name="id",
    //  *          description="Project id",
    //  *          required=true,
    //  *          in="path",
    //  *          @OA\Schema(
    //  *              type="integer"
    //  *          )
    //  *      ),
    //  *      @OA\Response(
    //  *          response=204,
    //  *          description="Successful operation",
    //  *          @OA\JsonContent()
    //  *       ),
    //  *      @OA\Response(
    //  *          response=401,
    //  *          description="Unauthenticated",
    //  *      ),
    //  *      @OA\Response(
    //  *          response=403,
    //  *          description="Forbidden"
    //  *      ),
    //  *      @OA\Response(
    //  *          response=404,
    //  *          description="Resource Not Found"
    //  *      )
    //  * )
    //  */
    <!-- 

         *      @OA\RequestBody(
        *       required=true,
        *       description="detail required data address book",
        *       @OA\JsonContent(
        *                  @OA\Property(property="name", type="string"),
        *                  @OA\Property(property="details", type="string"),
        *                  @OA\Property(property="address", type="string"),
        *                  @OA\Property(property="contact", type="string"),
        *                  @OA\Property(property="phone", type="string")
        *       ),
        *     ),
     -->
    // /**
    //  * @OA\Put(
    //  *      path="/projects/{id}",
    //  *      operationId="updateProject",
    //  *      tags={"Projects"},
    //  *      security={
    //  *          {"passport": {}},
    //  *      },
    //  *      summary="Update existing project",
    //  *      description="Returns updated project data",
    //  *      @OA\Parameter(
    //  *          name="id",
    //  *          description="Project id",
    //  *          required=true,
    //  *          in="path",
    //  *          @OA\Schema(
    //  *              type="integer"
    //  *          )
    //  *      ),
    //  *      @OA\RequestBody(
    //  *          required=true,
    //  *          @OA\JsonContent(ref="#/components/schemas/UpdateProjectRequest")
    //  *      ),
    //  *      @OA\Response(
    //  *          response=202,
    //  *          description="Successful operation",
    //  *          @OA\JsonContent(ref="#/components/schemas/Project")
    //  *       ),
    //  *      @OA\Response(
    //  *          response=400,
    //  *          description="Bad Request"
    //  *      ),
    //  *      @OA\Response(
    //  *          response=401,
    //  *          description="Unauthenticated",
    //  *      ),
    //  *      @OA\Response(
    //  *          response=403,
    //  *          description="Forbidden"
    //  *      ),
    //  *      @OA\Response(
    //  *          response=404,
    //  *          description="Resource Not Found"
    //  *      )
    //  * )
    //  */

    //   /**
//      * @OA\Get(
//      *      path="/projects/{id}",
//      *      operationId="getProjectById",
//      *      tags={"Projects"},
//      *      security={
//      *        {"passport": {}},
//      *      },
//      *      summary="Get project information",
//      *      description="Returns project data",
//      *      @OA\Parameter(
//      *          name="id",
//      *          description="Project id",
//      *          required=true,
//      *          in="path",
//      *          @OA\Schema(
//      *              type="integer"
//      *          )
//      *      ),
//      *      @OA\Response(
//      *          response=200,
//      *          description="Successful operation",
//      *          @OA\JsonContent(ref="#/components/schemas/Project")
//      *       ),
//      *      @OA\Response(
//      *          response=400,
//      *          description="Bad Request"
//      *      ),
//      *      @OA\Response(
//      *          response=401,
//      *          description="Unauthenticated",
//      *      ),
//      *      @OA\Response(
//      *          response=403,
//      *          description="Forbidden"
//      *      )
//      * )
//      */

// /**
    //  * @OA\Post(
    //  *      path="/projects",
    //  *      operationId="storeProject",
    //  *      tags={"Projects"},
    //  *      security={
    //  *          {"passport": {}},
    //  *      },
    //  *      summary="Store new project",
    //  *      description="Returns project data",
    //  *      @OA\RequestBody(
    //  *          required=true,
    //  *          @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")
    //  *      ),
    //  *      @OA\Response(
    //  *          response=201,
    //  *          description="Successful operation",
    //  *          @OA\JsonContent(ref="#/components/schemas/Project")
    //  *       ),
    //  *      @OA\Response(
    //  *          response=400,
    //  *          description="Bad Request"
    //  *      ),
    //  *      @OA\Response(
    //  *          response=401,
    //  *          description="Unauthenticated",
    //  *      ),
    //  *      @OA\Response(
    //  *          response=403,
    //  *          description="Forbidden"
    //  *      )
    //  * )
    //  */

    // /**
    //  * @OA\Get(
    //  *      path="/projects",
    //  *      operationId="getProjectsList",
    //  *      tags={"Projects"},
    //  *      security={
    //  *        {"passport": {}},
    //  *      },
    //  *      summary="Get list of projects",
    //  *      description="Returns list of projects",
    //  *      @OA\Response(
    //  *          response=200,
    //  *          description="Successful operation",
    //  *          @OA\JsonContent(ref="#/components/schemas/ProjectResource")
    //  *       ),
    //  *  )
    //  */

    <!-- virtual schemes resources -->
    /**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 * )
 */

/**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email",
     *     format="email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     title="Email verified at",
     *     description="Email verified at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $email_verified_at;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

    <!--  -->
/**
 * @OA\Schema(
 *     title="Project",
 *     description="Project model",
 *     @OA\Xml(
 *         name="Project"
 *     )
 * )
 */
<!--  -->


/**
        * @OA\Post(
        *      path="/api/v1/oauth/refresh-token",
        *      operationId="Refresh_token",
        *      tags={"Refresh Authorize Token API key"},
        *      summary="Authorization refresh access token <client_id> <client_secret> <token>",
        *      description="Returns Refresh access token",
        *      @OA\RequestBody(
        *       required=true,
        *       description="Refresh API access all with scope",
        *       @OA\JsonContent(
        *          @OA\Property(property="client_id", type="string"),
        *                  @OA\Property(property="client_secret", type="string"),
        *                  @OA\Property(property="token", type="string")
        *       ),
        *     ),
        *      @OA\Response(
        *          response=400,
        *          description="Bad Request"
        *      ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      ),
        *      @OA\Response(
        *          response=200,
        *          description="Successful Refresh API Token",
        *          @OA\JsonContent(ref="#/components/schemas/RefreshToken")
        *       ),
        * )
        */
        public function refresh_token(Request $r)
        {
            $http = new \GuzzleHttp\Client;

            $response = $http->post('http://api.3permata.co.id/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => $r->id,
                    'password' => $r->pass,
                    'client_id' => $r->client_id,
                    'client_secret' => $r->client_secret,
                    'provider' => 'customer',
                    // 'refresh_token' => $r->token
                ],
            ]);
            
            return response()->json([
                json_decode((string) $response->getBody(), true)
            ], 200);
    
        }
        
<!--  -->


/**
 * @OA\Schema(
 *     title="OatuhApiKey",
 *     description="Authorization apiKey",
 * )
 */
 
/**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=10
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Password",
     *     example="123456"
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *     title="Provider driver api",
     *     description="definition provider for api customer/user",
     *     example="customer { required to fill in the customer }",
     * )
     *
     * @var string
     */
    private $provider;

    /**
     * @OA\Property(
     *     title="Access Token Customer API",
     *     description="Personal access token",
     *     example="nPUppmDaO75MX0Px9B5Xsvni_Tvxg_IqaTANM8b6Mj3gxCeXMsBtXA4uuwXpsMneAOxO8bxcqtGPKweV_ZPyRTWSR7Ol",
     * )
     *
     * @var string
     */
    private $access_token;

    /**
     * @OA\Property(
     *     title="Scopes Access API",
     *     description="Personal access token",
     *     example="shipment-view create-address",
     * )
     *
     * @var string
     */
    private $scopes;


<!--  -->

/**
 * @OA\SecurityScheme(
 *     securityScheme="apiKey",
 *     in="header",
 *     type="apiKey",
 *     description="Oauth2 security",
 *     name="X-3PS-KEY",
 *     scheme="http",
 *     bearerFormat="bearer",
 * )
 */

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="bearer",
 *     securityScheme="apiAuth",
 * )
 */
 <!--  -->

/**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new project",
     *      example="A nice project"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new project",
     *      example="This is new project's description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @OA\Property(
     *      title="Author ID",
     *      description="Author's id of the new project",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $author_id;


    /**
     * @OA\Property(
     *     title="Author",
     *     description="Project author's user model"
     * )
     *
     * @var \App\Virtual\Models\User
     */
    private $author;

<!--  -->
/**
 * @OA\Schema(
 *      title="Store Project request",
 *      description="Store Project request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

/**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new project",
     *      example="A nice project"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="description",
     *      description="Description of the new project",
     *      example="This is new project's description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="author_id",
     *      description="Author's id of the new project",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $author_id;

    <!--  -->

    /**
 * @OA\Schema(
 *      title="Update Project request",
 *      description="Update Project request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
/**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new project",
     *      example="A nice project"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="description",
     *      description="Description of the new project",
     *      example="This is new project's description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="author_id",
     *      description="Author's id of the new project",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    public $author_id;
<!--  -->

/**
         * @OA\SecurityScheme(
         *     type="apiKey",
         *     in="header",
         *     securityScheme="api_key",
         *     name="Authorization"
         * )
         */

         <!--  -->
         /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      tags={"User"},
     *      security={
     *        {"passport": {}},
     *      },
     *      summary="Get list of User",
     *      description="Returns list of User",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/UsersResource")
     *       ),
     *  )
     */
     <!--  -->