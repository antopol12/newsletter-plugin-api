<?php

namespace NewsletterPluginApi\V1\Newsletters\Conditions;

use NewsletterPluginApi\Entities\Newsletter;
use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Contracts\ValidatorContract;
use NewsletterPluginApi\V1\GeneralTraits\Validator;
use NewsletterPluginApi\V1\Newsletters\Traits\CommonConditionsNewsletter;

/**
 * Class ByLists
 *
 * @package NewsletterPluginApi\V1\Newsletters\Conditions
 */
class ByLists implements ValidatorContract, ConditionContract
{
    use Validator,
        CommonConditionsNewsletter;

    /**
     * Mantiene la relacion entre la validacion en la que deberia
     * caer Newsletter cuando dicha validacion no se cumpla.
     *
     * @var array
     */
    protected $validations = [
        'haveSubject',
        'haveMessageHtmlOrMessageText',
        'haveLists',
        'haveDateSend'
    ];

    /**
     * Mapping de errores segun la validacion a la cual corresponde.
     *
     * @var array
     */
    protected $mistakes = [
        'haveSubject'                  => 'The request does not have the subject key.',
        'haveMessageHtmlOrMessageText' => 'The request does not have the any message key.',
        'haveLists'                    => 'The request does not have the lists key.',
        'haveDateSend'                 => 'The request does not have the send_on key.'
    ];

    /**
     * Verify that the request has a lists assigned.
     *
     * @param Newsletter $Newsletter
     *
     * @return bool
     */
    private function haveSubject(Newsletter $Newsletter)
    {
        return !empty($Newsletter->getLists());
    }
}
