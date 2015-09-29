<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\QueryException;
use Laraflock\Dashboard\Contracts\AuthRepoInterface;
use Laraflock\Dashboard\Exceptions\AuthenticationException;
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Traits\ValidateTrait;

class AuthRepo implements AuthRepoInterface
{
    use ValidateTrait;

    /**
     * {@inheritDoc}
     */
    public function getActiveUser()
    {
        return Sentinel::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function check()
    {
        return Sentinel::check();
    }

    /**
     * {@inheritDoc}
     */
    public function authenticate(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $remember = false;

        if (isset($data['remember'])) {
            $remember = $data['remember'];
        }

        // Run validation.
        $this->validate($data);

        if (!$user = Sentinel::authenticate($data, $remember)) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.incorrect'));
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function register(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        // Run validation.
        $this->validate($data);

        if (!config('laraflock.dashboard.activations')) {
            $this->registerAndActivate($data, false);

            return true;
        }

        try {
            $user = Sentinel::register($data);
        } catch (QueryException $e) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.create'));
        }

        if (!isset($data['role'])) {
            $data['role'] = config('laraflock.dashboard.defaultRole');
        }

        if (!$role = Sentinel::findRoleBySlug($data['role'])) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
        }

        $role->users()
            ->attach($user);

        if (!$activation = Activation::create($user)) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.activation.create'));
        }

        return $activation;
    }

    /**
     * {@inheritDoc}
     */
    public function registerAndActivate(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        // Run validation.
        $this->validate($data);

        $user = Sentinel::registerAndActivate($data);

        if (!isset($data['role'])) {
            $data['role'] = config('laraflock.dashboard.defaultRole');
        }

        if (!$role = Sentinel::findRoleBySlug($data['role'])) {
            throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
        }

        $role->users()
            ->attach($user);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function activate(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'email'           => 'required|email',
            'activation_code' => 'required',
        ];

        // Run validation.
        $this->validate($data);

        $user = $this->findByCredentials(['login' => $data['email']]);

        if (!Activation::complete($user, $data['activation_code'])) {
            throw new AuthenticationException(trans('dashboard::dashboard.errors.auth.activation.complete'));
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function findByCredentials(array $data)
    {
        return Sentinel::findByCredentials($data);
    }

    /**
     * {@inheritDoc}
     */
    public function login($user)
    {
        return Sentinel::login($user);
    }

    /**
     * {@inheritDoc}
     */
    public function logout()
    {
        return Sentinel::logout();
    }
}