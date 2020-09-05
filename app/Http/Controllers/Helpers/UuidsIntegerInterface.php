<?php

namespace App\Http\Controllers\Helpers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

class UuidsIntegerInterface extends UuidFactory
{
    /**
     * https://uuid.ramsey.dev/en/latest/rfc4122.html
     */
    public $uuid1;

    public function uuid1($node = null, ?int $clockSeq = null): UuidInterface
    {
        return $this->uuid1;
    }

    public function tellTime(UuidV1 $uuid): string
    {
        return $uuid->getDateTime()->format('Y-m-d H:i:s');
    }
}