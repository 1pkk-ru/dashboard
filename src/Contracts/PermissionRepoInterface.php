<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\PermissionsException;

interface PermissionRepoInterface
{
    /**
     * Return column headers for index page.
     *
     * @return array
     */
    public function columns();

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
     *
     * @return static
     * @throws FormValidationException
     */
    public function create(array $data);

    /**
     * Update permission.
     *
     * @param array $data
     * @param int   $id
     *
     * @throws FormValidationException
     * @throws PermissionsException
     */
    public function update($id, array $data);

    /**
     * Delete permission.
     *
     * @param int $id
     *
     * @throws PermissionsException
     */
    public function delete($id);
}