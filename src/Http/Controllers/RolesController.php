<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laracasts\Flash\Flash;
use Laraflock\Dashboard\Exceptions\FormValidationException;
use Laraflock\Dashboard\Exceptions\RolesException;

class RolesController extends BaseDashboardController
{
    /**
     * Permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|static[]
     */
    protected $permissions;

    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->permissions = $this->permission->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $columns = $this->role->columns();
        $models = $this->role->all();

        return $this->view('roles.index', compact('columns', 'models'));
    }

    /**
     * Create a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $createRoute = route('roles.create');
        $permissions = $this->permissions;

        return $this->view('roles.create', compact('createRoute', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function store(Request $request)
    {
        try {
            $this->role->create($request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('roles.create')
              ->withErrors($e->getErrors())
              ->withInput();
        }

        Flash::success(trans('dashboard::dashboard.flash.role.create.success'));

        return redirect()->route('roles.index');
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
        if (!$model = $this->role->find($id)) {
            Flash::error(trans('dashboard::dashboard.errors.role.found'));

            return redirect()->route('roles.index');
        }

        $permissions = $this->permissions;

        return $this->view('roles.edit', compact('model', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->role->update($id, $request->all());
        } catch (FormValidationException $e) {
            Flash::error($e->getMessage());

            return redirect()
              ->route('roles.edit', ['id' => $id])
              ->withErrors($e->getErrors())
              ->withInput();
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('roles.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.role.edit.success'));

        return redirect()->route('roles.edit', ['id' => $id]);
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
            $this->role->delete($id);
        } catch (RolesException $e) {
            Flash::error($e->getMessage());

            return redirect()->route('roles.index');
        }

        Flash::success(trans('dashboard::dashboard.flash.role.delete.success'));

        return redirect()->route('roles.index');
    }
}