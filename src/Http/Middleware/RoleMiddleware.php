<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Repositories\AuthRepo as Auth;
use Laraflock\Dashboard\Repositories\RoleRepo as Role;

class RoleMiddleware
{
    /**
     * Auth interface.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Role interface.
     *
     * @var Role
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
     * Check if user belongs to the specified role.
     *
     * @param Request      $request
     * @param Closure      $next
     * @param string|array $role
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$user = $this->auth->getActiveUser()) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));

            return redirect()->route('auth.login');
        }

        if (!$role = $this->role->slug($role)) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));

            // Redirect back to the previous page where request was made.
            return redirect()->back();
        }

        if (!$user->inRole($role)) {
            Flash::error(trans('dashboard::dashboard.flash.access_denied'));

            // Redirect back to the previous page where request was made.
            return redirect()->back();
        }

        return $next($request);
    }
}