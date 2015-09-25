<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Traits;

use Illuminate\Support\Facades\Validator;
use Laraflock\Dashboard\Exceptions\FormValidationException;

trait ValidateTrait
{
    /**
     * Global rules to use for validation.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validate the form submission.
     *
     * @param array $data
     *
     * @throws FormValidationException
     */
    protected function validate(array $data)
    {
        $validator = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            throw new FormValidationException('Fix errors in the form below.', $validator);
        }
    }
}