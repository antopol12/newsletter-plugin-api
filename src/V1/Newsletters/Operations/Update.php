<?php

namespace NewsletterPluginApi\V1\Newsletters\Operations;

use NewsletterPluginApi\Entities\Newsletter;
use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Contracts\OperationContract;
use NewsletterPluginApi\V1\Newsletters\Traits\OperationNewsletter;

/**
 * Class Update
 *
 * @package NewsletterPluginApi\V1\Newsletters\Operations
 */
class Update implements OperationContract
{
    use OperationNewsletter;

    /**
     * Update construct.
     *
     * @param array             $data
     * @param ConditionContract $Condition
     */
    protected function __construct(array $data, ConditionContract $Condition)
    {
        $this->loadInstanceNewsletter($data['id'])
            ->setCondition($Condition)
            ->validateAttributes($data);

        return $this;
    }

    /**
     * Genera una nueva instancia de esta misma clase.
     *
     * @param array             $data
     * @param ConditionContract $Condition
     *
     * @return mixed|static
     */
    public static function of(array $data, ConditionContract $Condition)
    {
        return new static($data, $Condition);
    }

    /**
     * Crea una nueva instancia de Newsletter para la instancia actual de creacion.
     *
     * @return $this
     * @TODO: Dar soporte para update
     */
    protected function loadInstanceNewsletter($idNewsletter)
    {
        if (is_null($this->getNewsletter()))
            $this->setNewsletter(new Newsletter());

        return $this;
    }
}
