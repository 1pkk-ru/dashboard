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

interface AuthRepoInterface
{
    /**
     * Get active user.
     *
     * @return mixed
     */
    public function getActiveUser();

    /**
     * Check if user is logged in.
     *
     * @return mixed
     */
    public function check();

    /**
     * Authenticate the user.
     *
     * @param array $data
     *
     * @throws AuthenticationException
     * @throws FormValidationException
     *
     * @return mixed
     */
    public function authenticate(array $data);

    /**
     * Register a user.
     *
     * @param array $data
     *
     * @throws AuthenticationException
     * @throws FormValidationException
     * @throws RolesException
     *
     * @return mixed
     */
    public function register(array $data);

    /**
     * Register and activate user if activations are false.
     *
     * @param array $data
     *
     * @throws AuthenticationException
     * @throws FormValidationException
     * @throws RolesException
     *
     * @return mixed
     */
    public function registerAndActivate(array $data);

    /**
     * Activate a user.
     *
     * @param array $data
     *
     * @throws AuthenticationException
     *
     * @return mixed
     */
    public function activate(array $data);

    /**
     * Find user by login credentials.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function findByCredentials(array $data);

    /**
     * Login the user.
     *
     * @param $user
     *
     * @return mixed
     */
    public function login($user);

    /**
     * Logout the user.
     *
     * @return mixed
     */
    public function logout();
}