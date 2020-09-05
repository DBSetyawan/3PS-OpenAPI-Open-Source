<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Transport_orders",
 *     description="Transport_orders model",
 * )
 */
class Transport_orders
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=111
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="ItemID_accurate",
     *     description="ItemID_accurate",
     *     example="CS0607203200271"
     * )
     *
     * @var string
     */
    private $ItemID_accurate;

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