<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use Laraflock\Dashboard\Contracts\RoleRepoInterface;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Models\Role;
use Laraflock\Dashboard\Traits\UpdateTrait;
use Laraflock\Dashboard\Traits\ValidateTrait;


class RoleRepo implements RoleRepoInterface
{
    use UpdateTrait;
    use ValidateTrait;

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id'      => trans('dashboard::dashboard.table.id'),
            'name'    => trans('dashboard::dashboard.table.name'),
            'slug'    => trans('dashboard::dashboard.table.slug'),
            'actions' => trans('dashboard::dashboard.table.actions'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Role::all();
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return Sentinel::findRoleById($id);
    }

    /**
     * {@inheritDoc}
     */
    public function slug($slug)
    {
        return Sentinel::findRoleBySlug($slug);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'slug' => 'required|alpha_dash|unique:roles',
            'name' => 'required|alpha_dash|unique:roles',
        ];

        // Run validation.
        $this->validate($data);

        // Convert the checkbox values of "1" to true, so permission checking works with Sentinel.
        if (isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission => $value) {
                $data['permissions'][$permission] = true;
            }
        }

        try {
            $role = Sentinel::getRoleRepository()
                ->createModel()
                ->create($data);
        } catch (QueryException $e) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.create'));
        }

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data)
    {
        if (!$model = $this->find($id)) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
        }

        if ($model->name != $data['name']) {
            $this->rules['name'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['name'] = 'required|alpha_dash';
        }

        if ($model->slug != $data['slug']) {
            $this->rules['slug'] = 'required|alpha_dash|unique:roles';
        } else {
            $this->rules['slug'] = 'required|alpha_dash';
        }

        // Run validation.
        $this->validate($data);

        // Convert the checkbox values of "1" to true, so permission checking works with Sentinel.
        if (isset($data['permissions'])) {
            foreach ($data['permissions'] as $permission => $value) {
                $data['permissions'][$permission] = true;
            }
        } else {
            $data['permissions'] = [];
        }

        $this->updateAttributes($model, $data);

        $model->name        = $data['name'];
        $model->slug        = $data['slug'];
        $model->permissions = $data['permissions'];
        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$role = $this->find($id)) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
        }

        $role->delete();

        return true;
    }

    /**
     * Update the permissions of the model.
     *
     * @param Role $model
     * @param array        $data
     */
    protected function permissions($model, array &$data)
    {

    }
}