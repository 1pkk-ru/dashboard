<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Laraflock\Dashboard\Contracts\AuthRepoInterface as Auth;
use Laraflock\Dashboard\Contracts\ModuleRepoInterface as Module;
use Laraflock\Dashboard\Contracts\PermissionRepoInterface as Permission;
use Laraflock\Dashboard\Contracts\RoleRepoInterface as Role;
use Laraflock\Dashboard\Contracts\UserRepoInterface as User;

class BaseDashboardController extends Controller
{
    /**
     * Auth interface.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Permission interface.
     *
     * @var Permission
     */
    protected $permission;

    /**
     * Module interface.
     *
     * @var Module
     */
    protected $module;

    /**
     * Role interface.
     *
     * @var Role
     */
    protected $role;

    /**
     * User interface.
     *
     * @var User
     */
    protected $user;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        $this->auth       = app()->make('Laraflock\Dashboard\Contracts\AuthRepoInterface');
        $this->permission = app()->make('Laraflock\Dashboard\Contracts\PermissionRepoInterface');
        $this->module     = app()->make('Laraflock\Dashboard\Contracts\ModuleRepoInterface');
        $this->role       = app()->make('Laraflock\Dashboard\Contracts\RoleRepoInterface');
        $this->user       = app()->make('Laraflock\Dashboard\Contracts\UserRepoInterface');

        $user = $this->auth->getActiveUser();

        view()->share([
            'activeUser'    => $user,
            'viewNamespace' => $viewNamespace,
            'modules'       => $this->module
        ]);
    }

    /**
     * Parses a view, using the package view namespace
     *
     * @param       $view
     * @param array $data
     *
     * @return \Illuminate\View\View
     */
    public function view($view, $data = [])
    {
        return view(sprintf("%s::%s", config('laraflock.dashboard.viewNamespace'), $view), $data);
    }
}