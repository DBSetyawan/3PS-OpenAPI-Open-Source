<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="UsersResource",
 *     description="Project resource",
 *     @OA\Xml(
 *         name="UsersResource"
 *     )
 * )
 */
class UsersResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\User[]
     */
    private $data;
}
