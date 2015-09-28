<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

interface PermissionRepoInterface
{
    /**
     * Return all permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Get permission by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Create permission.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return static
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     */
    public function create(array $data, $validate = true);

    /**
     * Update permission.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\PermissionsException
     */
    public function update(array $data, $id, $validate = true);

    /**
     * Delete permission.
     *
     * @param int $id
     *
     * @throws \Laraflock\Dashboard\Exceptions\PermissionsException
     */
    public function delete($id);
}