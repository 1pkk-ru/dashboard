<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

use Laraflock\Dashboard\Exceptions\AuthenticationException;
use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Exceptions\UsersException;

interface UserRepoInterface
{
    /**
     * Return column headers for index page.
     *
     * @return array
     */
    public function columns();

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
     * @throws AuthenticationException
     */
    public function create(array $data);

    /**
     * Update user.
     *
     * @param array $data
     * @param int   $id
     * @param bool  $validate
     *
     * @throws FormValidationException
     * @throws RolesException
     * @throws UsersException
     */
    public function update($id, array $data);

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @throws UsersException
     */
    public function delete($id);
}