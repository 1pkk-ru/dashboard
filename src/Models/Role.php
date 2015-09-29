<?php

namespace Laraflock\Dashboard\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    /**
     * Get delete route attribute.
     *
     * @return string
     */
    public function getDeleteRouteAttribute()
    {
        return route('roles.delete', ['id' => $this->id]);
    }

    /**
     * Get edit route attribute.
     *
     * @return string
     */
    public function getEditRouteAttribute()
    {
        return route('roles.edit', ['id' => $this->id]);
    }
}