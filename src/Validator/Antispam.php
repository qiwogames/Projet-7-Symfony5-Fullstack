<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * Class Antispam
 * @package App\Validator
 * @Annotation
 */

class Antispam extends Constraint
{
    public $message = "<p class='alert alert-danger'>Le champ est trop court</p>";
}