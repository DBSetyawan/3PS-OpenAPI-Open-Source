<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="ShipmentResources",
 *     description="Create Shipment resource",
 *     @OA\Xml(
 *         name="ShipmentResources"
 *     )
 * )
 */
class ShipmentResources
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\ShipmentModels[]
     */
    private $data;
}
