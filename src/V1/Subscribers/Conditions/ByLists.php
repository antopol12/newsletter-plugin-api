<?php

namespace NewsletterPluginApi\V1\Subscribers\Conditions;

use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Contracts\ValidatorContract;
use NewsletterPluginApi\V1\GeneralTraits\Validator;
use NewsletterPluginApi\V1\Subscribers\Traits\CommonConditionsSubscriber;

/**
 * Class ByEmptyList
 *
 * @package NewsletterPluginApi\V1\Subscribers\Conditions
 */
class ByLists implements ValidatorContract, ConditionContract
{
    use Validator,
        CommonConditionsSubscriber;

    /**
     * Mantiene la relacion entre la validacion en la que deberia
     * caer Subscriber cuando dicha validacion no se cumpla.
     *
     * @var array
     */
    protected $validations = [
        'haveEmail',
        'existsEmail'
    ];

    /**
     * Mapping de errores segun la validacion a la cual corresponde.
     *
     * @var array
     */
    protected $mistakes = [
        'haveEmail'   => 'The request does not have the email key.',
        'existsEmail' => 'The email already exists.'
    ];
}
