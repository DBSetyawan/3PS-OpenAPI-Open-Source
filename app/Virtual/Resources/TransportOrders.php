<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="TransportOrders",
 *     description="Project resource",
 *     @OA\Xml(
 *         name="ProjectResource"
 *     )
 * )
 */
class TransportOrders
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Transport_orders[]
     */
    private $data;
}
