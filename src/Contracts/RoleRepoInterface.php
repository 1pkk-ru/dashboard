<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

interface RoleRepoInterface
{
    /**
     * Return all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Get role by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Get role by slug.
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function slug($slug);

    /**
     * Create role.
     *
     * @param array $data
     * @param bool  $validate
     *
     * @return mixed
     *
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     */
    public function create(array $data, $validate = true);

    /**
     * Update role.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     */
    public function update(array $data, $id, $validate = true);

    /**
     * Delete role.
     *
     * @param int $id
     *
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     */
    public function delete($id);
}