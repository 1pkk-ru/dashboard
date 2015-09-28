<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

use Laraflock\Dashboard\Events\ForgotPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordNotification implements ShouldQueue
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        //
    }

    public function handle(ForgotPassword $event)
    {
        Mail::send('emails.reset-pass', ['user' => $event->user, 'code' => $event->reminder->code, 'action_url' => route('password.reset') . '?code=' . $event->reminder->code], function ($m) use ($event) {
            $m->from(config('laraflock.dashboard.system_email_address'), config('laraflock.dashboard.system_email_name'));
            $m->to($event->user->email, "{$event->user->first_name} {$event->user->last_name}");
            $m->subject('Reset password instructions');
        });
    }
}