<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Item Customers",
 *     description="Item Customers model",
 * )
 */
class ItemCustomers
{
 
    /**
     * @OA\Property(
     *     title="Code Customer",
     *     description="Get code from first register",
     *     example="CS0607203200271"
     * )
     *
     * @var string
     */
    private $customer_id;

    /**
     * @OA\Property(
     *     title="Company",
     *     format="int64",
     *     description="Company",
     *     example="29",
     * )
     *
     * @var string
     */
    private $company;

    /**
     * @OA\Property(
     *     title="name",
     *     description="Name",
     *     format="string",
     *     example="PT. VIE LIE XANG"
     * )
     *
     * @var string
     */
    private $name;

    
    /**
     * @OA\Property(
     *      title="Status ID",
     *      description="Author's id of the new project",
     *      format="int64",
     *      example=4
     * )
     *
     * @var integer
     */
    private $status_id; 
    
}