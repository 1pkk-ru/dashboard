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
use Laraflock\Dashboard\Repositories\Auth\AuthRepo;
use Laraflock\Dashboard\Repositories\Module\ModuleRepo;
use Laraflock\Dashboard\Repositories\Permission\PermissionRepo;
use Laraflock\Dashboard\Repositories\Role\RoleRepo;
use Laraflock\Dashboard\Repositories\User\UserRepo;

class BaseDashboardController extends Controller
{
    /**
     * Auth interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Auth\AuthRepo
     */
    protected $authRepo;

    /**
     * Permission interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Permission\PermissionRepo
     */
    protected $permissionRepo;

    /**
     * Role interface.
     *
     * @var \Laraflock\Dashboard\Repositories\Role\RoleRepo
     */
    protected $roleRepo;

    /**
     * User interface.
     *
     * @var \Laraflock\Dashboard\Repositories\User\UserRepo
     */
    protected $userRepo;

    /**
     * The constructor.
     *
     * @param \Laraflock\Dashboard\Repositories\Auth\AuthRepo $authRepo
     * @param \Laraflock\Dashboard\Repositories\Permission\PermissionRepo $permissionRepo
     * @param \Laraflock\Dashboard\Repositories\Role\RoleRepo $roleRepo
     * @param \Laraflock\Dashboard\Repositories\User\UserRepo $userRepo
     * @param \Laraflock\Dashboard\Repositories\Module\ModuleRepo $moduleRepo
     */
    public function __construct(
        AuthRepo $authRepo,
        PermissionRepo $permissionRepo,
        RoleRepo $roleRepo,
        UserRepo $userRepo,
        ModuleRepo $moduleRepo
    )
    {
        $viewNamespace = config('laraflock.dashboard.viewNamespace');

        $this->authRepo       = $authRepo;
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo       = $roleRepo;
        $this->userRepo       = $userRepo;

        $user = $this->authRepo->getActiveUser();

        view()->share([
            'activeUser' => $user,
            'viewNamespace' => $viewNamespace,
            'modules' => $moduleRepo
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