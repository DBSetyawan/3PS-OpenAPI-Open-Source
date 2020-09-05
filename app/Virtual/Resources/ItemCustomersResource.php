<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="ItemCustomers Resource",
 *     description="Item customers resource",
 *     @OA\Xml(
 *         name="ItemCustomersResource"
 *     )
 * )
 */
class ItemCustomersResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\ItemCustomers[]
     */
    private $data;
}
