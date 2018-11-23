<?php

namespace R\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class PwnedPasswordsValidator
 */
class PwnedPasswordsValidator extends ConstraintValidator
{
    const API_URL = 'https://api.pwnedpasswords.com/range/';
    /**
     * validate
     *
     * @param string     $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        $hash = strtoupper(sha1($value));

        $range = substr($hash, 0, 5);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, self::API_URL.$range);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (200 === $code) {
            if (false !== ($pos = strpos($result, substr($hash, 5)))) {
                // found, get count
                $colonAt = $pos+(strlen($hash)-5)+1;
                $occurences = substr($result, $colonAt, strpos($result, "\n", $colonAt)-$colonAt);

                $this->context->buildViolation($constraint->message)
                    ->addViolation()
                    ;
            }
        }
    }
}
