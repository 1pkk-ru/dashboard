<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories;

use Laraflock\Dashboard\Contracts\PermissionRepoInterface;
use Laraflock\Dashboard\Exceptions\PermissionsException;
use Laraflock\Dashboard\Models\Permission;
use Laraflock\Dashboard\Traits\UpdateTrait;
use Laraflock\Dashboard\Traits\ValidateTrait;


class PermissionRepo implements PermissionRepoInterface
{
    use UpdateTrait;
    use ValidateTrait;

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Permission::all();
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return Permission::find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data)
    {
        // Setup validation rules.
        $this->rules = [
          'name' => 'required',
          'slug' => 'required|unique:permissions',
        ];

        // Run validation.
        $this->validate($data);

        // Create model instance.
        $model = new Permission();

        // Update mass assignable attributes.
        $this->updateAttributes($model, $data);

        // Save model instance.
        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data)
    {
        if (!$model = $this->find($id)) {
            throw new PermissionsException(trans('dashboard::dashboard.errors.permission.found'));
        }

        // Setup validation rules.
        $this->rules = [
          'name' => 'required',
          'slug' => 'required|alpha_dash',
        ];

        // Slug validation rules conditional.
        if ($model->slug != $data['slug']) {
            $this->rules['slug'] = 'required|alpha_dash|unique:permissions';
        }

        // Run validation.
        $this->validate($data);

        // Update mass assignable attributes.
        $this->updateAttributes($model, $data);

        // Save model instance.
        $model->save();

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$model = $this->find($id)) {
            throw new PermissionsException(trans('dashboard::dashboard.errors.permission.found'));
        }

        $model->delete();

        return true;
    }
}