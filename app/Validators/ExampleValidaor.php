<?php

namespace App\Validators;

use CQ\Validators\v;
use CQ\Validators\Validator;

class DemoValidator extends Validator
{
    // DOCS: https://respect-validation.readthedocs.io/en/2.0/

    /**
     * Validate json submission
     *
     * @param object $data
     *
     * @return void
     */
    public static function create($data)
    {
        $v = v::attribute('alphanumerical', v::alnum()->length(1, 64))
            ->attribute('optional_alphanumerical', v::optional(v::alnum()->length(32, 64)))
            ->attribute('string', v::stringType()->length(1, 256));

        self::validate($v, $data);
    }
}
