<?php

namespace App\Validators;

use Exception;
use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

class ValidatorBase
{
    /**
     * Execute validation
     * 
     * @param Validator $validator
     * @param object $data
     *
     * @return void
     * @throws Exception
     */
    protected static function validate(Validator $validator, $data)
    {
        try {
            $validator->assert($data);
        } catch (NestedValidationException $e) {
            throw new Exception(
                json_encode($e->getMessages())
            );
        }
    }
}
