<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @author      Daniel Klabbers <daniel@hyn.me>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Contracts;

interface ModuleRepo
{
    /**
     * Registers a dashboard module into the ecosystem
     *
     * @param Module $module
     * @return bool
     */
    public function register(Module $module);

    /**
     * Loads all registered dashboard modules
     *
     * @return array
     */
    public function getRegistered();

    /**
     * Verify whether a module has been registered
     *
     * @param Module $module
     * @return mixed
     */
    public function isRegistered(Module $module);
}