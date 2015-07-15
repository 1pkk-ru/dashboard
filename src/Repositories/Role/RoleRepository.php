<?php

/**
 * @package     Dashboard
 * @version     1.0.0
 * @author      Ian Olson <ian@odotmedia.com>
 * @license     MIT
 * @copyright   2015, Odot Media LLC
 * @link        https://odotmedia.com
 */

namespace Odotmedia\Dashboard\Repositories\Role;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\QueryException;
use Odotmedia\Dashboard\Exceptions\RolesException;
use Odotmedia\Dashboard\Repositories\Base\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * EloquentRole instance.
     *
     * @var \Cartalyst\Sentinel\Roles\EloquentRole
     */
    protected $role;

    /**
     * Sentinel instance.
     *
     * @var \Cartalyst\Sentinel\Sentinel
     */
    protected $sentinel;

    public function __construct(EloquentRole $role, Sentinel $sentinel)
    {
        $this->role     = $role;
        $this->sentinel = $sentinel;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->role->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getById($id)
    {
        return $this->sentinel->findRoleById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getBySlug($slug)
    {
        return $this->sentinel->findRoleBySlug($slug);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data, $validate = true)
    {
        $this->rules = [
          'slug' => 'required|alpha_dash|unique:roles',
          'name' => 'required|alpha_dash|unique:roles',
        ];

        if ($validate) {
            $this->validate($data);
        }

        try {
            $role = $this->sentinel->getRoleRepository()
                                   ->createModel()
                                   ->create($data);
        } catch (QueryException $e) {
            throw new RolesException('Role could not be created.');
        }

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, $id, $validate = true)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException('Role could not be found.');
        }

        if ($role->name != $data['name']) {
            $this->rules['name'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['name'] = 'required|alpha_dash';
        }

        if ($role->slug != $data['slug']) {
            $this->rules['slug'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['slug'] = 'required|alpha_dash';
        }

        if ($validate) {
            $this->validate($data);
        }

        if (!isset($data['permissions'])) {
            $data['permissions'] = [];
        }

        $role->name        = $data['name'];
        $role->slug        = $data['slug'];
        $role->permissions = $data['permissions'];
        $role->save();

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$role = $this->getById($id)) {
            throw new RolesException('Role could not be found.');
        }

        $role->delete();

        return true;
    }
}