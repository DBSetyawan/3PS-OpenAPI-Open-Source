<?php

namespace App;

use RuntimeException;
use Illuminate\Hashing\HashManager;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Authenticator
{

    protected $hasher;

    public function __construct(HashManager $hasher)
    {
        $this->hasher = $hasher->driver();
    }

    public function attempt(
        string $customer_id,
        string $password,
        string $provider
    ): ?Authenticatable {
        if (! $model = config('auth.providers.'.$provider.'.model')) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        /** @var Authenticatable $user */
        if (! $user = (new $model)->where('customer_id', $customer_id)->first()) {
            return null;
        }

        if (! $this->hasher->check($password, $user->getAuthPassword())) {
            return null;
        }

        return $user;
    }
}