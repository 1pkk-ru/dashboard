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
use Laraflock\Dashboard\Exceptions\RolesException;
use Laraflock\Dashboard\Exceptions\UsersException;
use Laraflock\Dashboard\Contracts\AuthRepoInterface;
use Laraflock\Dashboard\Contracts\RoleRepoInterface;
use Laraflock\Dashboard\Contracts\UserRepoInterface;
use Laraflock\Dashboard\Models\User;
use Laraflock\Dashboard\Traits\UpdateTrait;
use Laraflock\Dashboard\Traits\ValidateTrait;

class UserRepo implements UserRepoInterface
{
    use UpdateTrait;
    use ValidateTrait;

    /**
     * Auth interface.
     *
     * @var AuthRepoInterface
     */
    protected $auth;

    /**
     * Role interface.
     *
     * @var RoleRepoInterface
     */
    protected $role;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->auth = app()->make('Laraflock\Dashboard\Contracts\AuthRepoInterface');
        $this->role = app()->make('Laraflock\Dashboard\Contracts\RoleRepoInterface');
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id'         => trans('dashboard::dashboard.table.id'),
            'first_name' => trans('dashboard::dashboard.table.first_name'),
            'last_name'  => trans('dashboard::dashboard.table.last_name'),
            'email'      => trans('dashboard::dashboard.table.email'),
            'actions'    => trans('dashboard::dashboard.table.actions'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return User::with('roles')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return User::with('roles')->where('id', $id)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data)
    {
        // Setup validation rules.
        $this->rules = [
            'email'                 => 'required|unique:users',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        // Run validation.
        $this->validate($data);

        // Register and activate.
        $this->auth->registerAndActivate($data);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $data)
    {
        if (!$user = $this->find($id)) {
            throw new UsersException(trans('dashboard::dashboard.errors.user.found'));
        }

        if ($user->email != $data['email']) {
            $this->rules['email'] = 'required|email|unique:users';
        } else {
            $this->rules['email'] = 'required|email';
        }

        // Run validation.
        $this->validate($data);

        // Update user.
        Sentinel::update($user, $data);

        if (isset($data['role'])) {

            if (!$role = $this->role->getBySlug($data['role'])) {
                throw new RolesException(trans('dashboard::dashboard.errors.role.found'));
            }

            if (!$user->inRole($role)) {
                $role->users()
                    ->attach($user);
            }
        }

        $user->save();

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function updatePassword(array $data)
    {
        $user = $this->auth->authenticate($data);

        // Setup validation rules.
        $this->rules = [
            'new_password'              => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ];

        // Run validation.
        $this->validate($data);

        // Setup new password.
        $updatedData = [
            'password' => $data['new_password'],
        ];

        // Update user.
        Sentinel::update($user, $updatedData);

        return;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        if (!$user = $this->find($id)) {
            throw new UsersException(trans('dashboard::dashboard.errors.user.found'));
        }

        $user->delete();

        return;
    }
}