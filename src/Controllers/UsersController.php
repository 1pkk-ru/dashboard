<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\UsersException;

class UsersController extends BaseDashboardController
{
    /**
     * Roles.
     *
     * @var static
     */
    protected $roles;

    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = $this->role->all()->lists('name', 'slug');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->all();

        return $this->view('users.index')->with(['users' => $users]);
    }

    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('users.create')->with('roles', $this->roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->user->create($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
                ->route('users.create')
                ->withErrors($e->getErrors())
                ->withInput();
        }

        Flash::success(trans('dashboard::dashboard.flash.user.create.success'));

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!$user = $this->user->find($id)) {
            Flash::error(trans('dashboard::dashboard.errors.user.found'));

            return redirect()->route('users.index');
        }

        $currentRoles = $user->getRoles()->lists('name');

        if (empty($currentRoles)) {
            $currentRoles = new Collection(['name' => 'Not Available']);
        }

        $currentRoles->sortBy('name');
        $currentRoles = implode(', ', $currentRoles->toArray());

        $roles = $this->role->all()->lists('name', 'slug');

        return $this->view('users.edit')
            ->with(['user' => $user, 'currentRoles' => $currentRoles, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->user->update($id, $request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
                ->route('users.edit', ['id' => $id])
                ->withErrors($e->getErrors())
                ->withInput();
        } catch (UsersException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('users.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.user.edit.success'));

        return redirect()->route('users.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $this->user->delete($id);
        } catch (UsersException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('users.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.user.delete.success'));

        return redirect()->route('users.index');
    }
}