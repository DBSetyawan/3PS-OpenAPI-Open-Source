<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="ItemCustomers Resource",
 *     description="Item customers resource",
 *     @OA\Xml(
 *         name="AddressBookResources"
 *     )
 * )
 */
class AddressBookResources
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\AddressBooks[]
     */
    private $data;
}
