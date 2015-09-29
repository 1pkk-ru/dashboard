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
use Laraflock\Dashboard\Exceptions\RolesException;

interface RoleRepoInterface
{
    /**
     * Return column headers for index page.
     *
     * @return array
     */
    public function columns();

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
     *
     * @return mixed
     *
     * @throws FormValidationException
     * @throws RolesException
     */
    public function create(array $data);

    /**
     * Update role.
     *
     * @param int   $id
     * @param array $data
     *
     * @throws FormValidationException
     * @throws RolesException
     */
    public function update($id, array $data);

    /**
     * Delete role.
     *
     * @param int $id
     *
     * @throws RolesException
     */
    public function delete($id);
}