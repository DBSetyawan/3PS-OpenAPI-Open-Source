<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Address book",
 *     description="Address book model",
 * )
 */
class AddressBooks
{
 
    /**
     * @OA\Property(
     *     title="name",
     *     format="string",
     *     description="Name address book for customer",
     *     example="Pergudangan street 1",
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="Detail",
     *     description="Detail name address book customer",
     *     format="string",
     *     example="Jl. Selandia baru"
     * )
     *
     * @var string
     */
    private $details;

    
    /**
     * @OA\Property(
     *      title="Address",
     *      description="Address book for customer",
     *      format="string",
     *      example=4
     * )
     *
     * @var string
     */
    private $address; 

    /**
     * @OA\Property(
     *      title="Contact",
     *      description="Contact Address book for customer",
     *      format="string",
     *      example=031341203
     * )
     *
     * @var string
     */
    private $contact; 

    /**
     * @OA\Property(
     *      title="City",
     *      description="City Address book for customer",
     *      format="string",
     *      example=1109
     * )
     *
     * @var string
     */
    private $city_id; 

    
    /**
     * @OA\Property(
     *      title="Phone",
     *      description="Phone Address book for customer",
     *      format="string",
     *      example=08134378432
     * )
     *
     * @var string
     */
    private $phone; 


      /**
     * @OA\Property(
     *      title="PIC origin name",
     *      description="PIC origin name Address book for customer",
     *      format="string",
     *      example="Syaifuddin"
     * )
     *
     * @var string
     */
    private $pic_name_origin; 

    /**
     * @OA\Property(
     *      title="PIC destination name",
     *      description="PIC destination name Address book for customer",
     *      format="string",
     *      example="Mikael"
     * )
     *
     * @var string
     */
    private $pic_name_destination; 

    /**
     * @OA\Property(
     *      title="PIC phone",
     *      description="PIC phone origin name Address book for customer",
     *      format="string",
     *      example="08148938245"
     * )
     *
     * @var string
     */
    private $pic_phone_origin;

    /**
     * @OA\Property(
     *      title="PIC phone",
     *      description="PIC phone destination name Address book for customer",
     *      format="string",
     *      example="08138943823"
     * )
     *
     * @var string
     */
    private $pic_phone_destination;
    
}