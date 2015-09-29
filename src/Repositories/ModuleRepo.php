<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @author      Daniel Klabbers <daniel@hyn.me>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Repositories;

use Illuminate\Support\Collection;
use Laraflock\Dashboard\Contracts\ModuleInterface;
use Laraflock\Dashboard\Contracts\ModuleRepoInterface;

class ModuleRepo implements ModuleRepoInterface
{

    /**
     * @var Collection
     */
    protected $modules;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->modules = new Collection();
    }

    /**
     * Registers a dashboard module into the ecosystem
     *
     * @param ModuleInterface $module
     * @return bool
     */
    public function register(ModuleInterface $module)
    {
        $this->modules->put(get_class($module), $module);
    }

    /**
     * Loads all registered dashboard modules
     *
     * @return array
     */
    public function getRegistered()
    {
        return $this->modules;
    }

    /**
     * Verify whether a module has been registered
     *
     * @param ModuleInterface $module
     * @return mixed
     */
    public function isRegistered(ModuleInterface $module)
    {
        return $this->modules->offsetExists(get_class($module));
    }
}