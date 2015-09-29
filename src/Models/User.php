<?php

namespace Laraflock\Dashboard\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    /**
     * Get delete route attribute.
     *
     * @return string
     */
    public function getDeleteRouteAttribute()
    {
        return route('users.delete', ['id' => $this->id]);
    }

    /**
     * Get edit route attribute.
     *
     * @return string
     */
    public function getEditRouteAttribute()
    {
        return route('users.edit', ['id' => $this->id]);
    }
}