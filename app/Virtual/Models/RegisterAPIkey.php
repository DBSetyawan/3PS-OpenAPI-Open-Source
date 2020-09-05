<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Register API token",
 *     description="Authorization apiKey",
 * )
 */
class RegisterAPIkey
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="string",
     *     example=10
     * )
     *
     * @var string
     */
    private $code_customer;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Password",
     *     example="930291"
     * )
     *
     * @var string
     */
    private $password;
    
}