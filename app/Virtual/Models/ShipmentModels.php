<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Shipment Models",
 *     description="Shipment model",
 * )
 */
class ShipmentModels
{
    /**
     * @OA\Property(
     *     title="Item transport",
     *     description="ID item transport customer",
     *     format="int64",
     *     example=2
     * )
     *
     * @var integer
     */
    private $item_transport;

    /**
     * @OA\Property(
     *     title="address origin",
     *     format="int64",
     *     description="detail address origin",
     *     example=1
     * )
     *
     * @var integer
     */
    private $address_origin_id;

    /**
     * @OA\Property(
     *     title="address destination",
     *     format="int64",
     *     description="detail address destination",
     *     example=5,
     * )
     *
     * @var integer
     */
    private $address_destination_id;

    /**
     * @OA\Property(
     *     title="ETD",
     *     description="Estimated time of delivery",
     *     format="string",
     *     example="2020-07-12 02:05"
     * )
     *
     * @var string
     */
    private $estimated_time_of_delivery;

    /**
     * @OA\Property(
     *      title="Origin",
     *      description="detail address book",
     *      format="string",
     *      example="Pergudangan Industri 1.31.1.1"
     * )
     *
     * @var string
     */
    private $origin;

    /**
     * @OA\Property(
     *      title="Origin",
     *      description="detail address book",
     *      format="string",
     *      example="Kantor Industri 1.31.1.1"
     * )
     *
     * @var string
     */
    private $destination;

    /**
     * @OA\Property(
     *      title="ETA",
     *      description="estima ted_time_of_arrival",
     *      format="string",
     *      example="2020-07-08 01:05"
     * )
     *
     * @var string
     */
    private $estimated_time_of_arrival; 

     /**
     * @OA\Property(
     *      title="Times",
     *      description="Time zone",
     *      format="string",
     *      example="WIB WITA"
     * )
     *
     * @var string
     */
    private $time_zone;

    /**
     * @OA\Property(
     *      title="Collie",
     *      description="detail collie",
     *      format="int64",
     *      example=21
     * )
     *
     * @var string
     */
    private $collie;

    /**
     * @OA\Property(
     *      title="Quantity",
     *      description="detail qty",
     *      format="int64",
     *      example=42
     * )
     *
     * @var string
     */
    private $quantity;

    /**
     * @OA\Property(
     *      title="Harga",
     *      description="detail harga",
     *      format="string",
     *      example="15000"
     * )
     *
     * @var string
     */
    private $harga;

    /**
     * @OA\Property(
     *      title="Volume",
     *      description="detail volume",
     *      format="int64",
     *      example=120
     * )
     *
     * @var string
     */
    private $volume;


    /**
     * @OA\Property(
     *      title="Actual_weight",
     *      description="detail actual_weight",
     *      format="int64",
     *      example=51
     * )
     *
     * @var string
     */
    private $actual_weight;

    /**
     * @OA\Property(
     *      title="Actual_weight",
     *      description="detail actual_weight",
     *      format="string",
     *      example="51"
     * )
     *
     * @var string
     */
    private $chargeable_weight;

    /**
     * @OA\Property(
     *      title="Notes",
     *      description="detail notes",
     *      format="string",
     *      example="51"
     * )
     *
     * @var string
     */
    private $notes;


    /**
     * @OA\Property(
     *      title="Origin Address",
     *      description="detail origin address",
     *      format="string",
     *      example="Jl. pondok sedati asri"
     * )
     *
     * @var string
     */
    private $origin_address;

    /**
     * @OA\Property(
     *      title="Destination Address",
     *      description="detail destination address",
     *      format="string",
     *      example="Jl. pondok sedati asri"
     * )
     *
     * @var string
     */
    private $destination_address;

    /**
     * @OA\Property(
     *      title="PIC name origin",
     *      description="detail PIC name",
     *      format="string",
     *      example="daniel 1"
     * )
     *
     * @var string
     */
    private $pic_name_origin;

    /**
     * @OA\Property(
     *      title="PIC name destination",
     *      description="detail PIC name",
     *      format="string",
     *      example="daniel 2"
     * )
     *
     * @var string
     */
    private $pic_name_destination;

    /**
     * @OA\Property(
     *      title="PIC phone origin",
     *      description="detail PIC phone",
     *      format="string",
     *      example="0813423391"
     * )
     *
     * @var string
     */
    private $pic_phone_origin;

    /**
     * @OA\Property(
     *      title="PIC phone destination",
     *      description="detail PIC phone",
     *      format="string",
     *      example="08932483831"
     * )
     *
     * @var string
     */
    private $pic_phone_destination;
    
    
}