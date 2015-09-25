<?php

namespace Laraflock\Dashboard\Repositories\Module;

use Illuminate\Support\Collection;

class ModuleRepo implements ModuleRepo
{

    /**
     * @var Collection
     */
    protected $modules;

    public function __construct()
    {
        $this->modules = new Collection();
    }

    /**
     * Registers a dashboard module into the ecosystem
     *
     * @param Module $module
     * @return bool
     */
    public function register(Module $module)
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
     * @param Module $module
     * @return mixed
     */
    public function isRegistered(Module $module)
    {
        return $this->modules->offsetExists(get_class($module));
    }
}