<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name',
      'slug',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get delete route attribute.
     *
     * @return string
     */
    public function getDeleteRouteAttribute()
    {
        return route('permissions.delete', ['id' => $this->id]);
    }

    /**
     * Get edit route attribute.
     *
     * @return string
     */
    public function getEditRouteAttribute()
    {
        return route('permissions.edit', ['id' => $this->id]);
    }
}