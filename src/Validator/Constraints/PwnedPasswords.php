<?php

namespace R\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PwnedPasswords
 * @Annotation
 */
class PwnedPasswords extends Constraint
{
    /**
     * @var string
     **/
    public $message = 'The password has been in a password breach.';
}
