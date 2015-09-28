<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

namespace Laraflock\Dashboard\Traits;

use Illuminate\Support\Facades\Cache;

trait UpdateTrait
{
    /**
     * Non-Required Attributes
     *
     * @var array
     */
    protected $nonRequiredAttributes;

    /**
     * Update model attributes from a request.
     *
     * @param       $model
     * @param array $data
     *
     * @return bool
     */
    protected function updateAttributes(&$model, array &$data)
    {
        if (empty($data)) {
            return false;
        }

        // Get mass assignment columns of the model.
        $massAssign = $model->getFillable();

        foreach ($data as $attribute => $value) {

            if (!in_array($attribute, $massAssign)) {
                continue;
            }

            if (in_array($attribute, $this->nonRequiredAttributes)) {
                $model->$attribute = $value;
            }

            if (empty($value)) {
                continue;
            }

            // Hash password if its passed through.
            if ($attribute == 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            $model->$attribute = $value;
        }

        return true;
    }
}