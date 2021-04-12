<?php

declare(strict_types=1);

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

class ExampleValidator extends Validator
{
    /**
     * Validate json submission.
     */
    public static function create(object $data): void
    {
        $v = v::attribute('string', v::alnum(' ', '-')->length(1, 64));

        self::validate($v, $data);
    }

    /**
     * Validate json submission.
     */
    public static function update(object $data): void
    {
        $v = v::attribute('string', v::optional(v::alnum()->length(1, 64)));

        self::validate($v, $data);
    }
}
