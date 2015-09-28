<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

interface UserRepoInterface
{
    /**
     * Return all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all();

    /**
     * Get user by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Create user.
     *
     * @param array $data
     *
     * @return bool
     * @throws \Laraflock\Dashboard\Exceptions\AuthenticationException
     */
    public function create(array $data);

    /**
     * Update user.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws \Laraflock\Dashboard\Exceptions\FormValidationException
     * @throws \Laraflock\Dashboard\Exceptions\RolesException
     * @throws \Laraflock\Dashboard\Exceptions\UsersException
     */
    public function update($id, array $data);

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @throws \Laraflock\Dashboard\Exceptions\UsersException
     */
    public function delete($id);
}