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

interface Module
{
    /**
     * A user-friendly name for your module
     *
     * @return string
     */
    public function getName();

    /**
     * A user-friendly explanation of what your module exactly does
     *
     * @return string|void
     */
    public function getDescription();

    /**
     * A unique string Id identifying your module
     *
     * @info can only contain digits, alphabet characters, dashes and underscores
     * @info recommended is the package name
     *
     * @return string
     */
    public function getId();

    /**
     * An array containing the necessary menu elements to be generated in the views
     *
     * @see https://github.com/laraflock/dashboard/wiki
     *
     * @return array
     */
    public function getMenuItems();
}