<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AntispamValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        // REGEX.
        if(!preg_match('/^[a-zA-Z]+$/', $value, $matches)){

            $this->context->buildViolation($constraint->message)
                ->setParameters(array('%string%' => $value))
                ->addViolation();
        }
    }
}