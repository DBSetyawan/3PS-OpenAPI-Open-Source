<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="City",
 *     description="Citys model",
 * )
 */
class Citys
{

     /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1109
     * )
     *
     * @var integer
     */
    private $CityId;

    /**
     * @OA\Property(
     *     title="City",
     *     format="string",
     *     description="City",
     *     example="KABUPATEN SIDOARJO",
     * )
     *
     * @var string
     */
    private $name;
    
}