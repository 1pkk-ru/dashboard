<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Events;

use Cartalyst\Sentinel\Reminders\EloquentReminder;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Queue\SerializesModels;

class ForgotPassword
{
    use SerializesModels;

    /**
     * EloquentUser model.
     *
     * @var EloquentUser
     */
    public $user;

    /**
     * EloquentReminder model.
     *
     * @var EloquentReminder
     */
    public $reminder;

    /**
     * The constructor.
     *
     * @param EloquentUser     $user
     * @param EloquentReminder $reminder
     */
    public function __construct(EloquentUser $user, EloquentReminder $reminder)
    {
        $this->user     = $user;
        $this->reminder = $reminder;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}