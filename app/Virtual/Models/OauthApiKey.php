<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Definition scope access user(customer)",
 *     description="Authorization access token apiKey",
 * )
 */
class OauthApiKey
{
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
    
}