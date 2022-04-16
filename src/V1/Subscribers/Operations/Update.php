<?php

namespace NewsletterPluginApi\V1\Subscribers\Operations;

use NewsletterPluginApi\Entities\Subscriber;
use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Contracts\OperationContract;
use NewsletterPluginApi\V1\Subscribers\Traits\OperationSubscriber;

/**
 * Class Update
 *
 * @package NewsletterPluginApi\V1\Subscribers\Operations
 */
class Update implements OperationContract
{
    use OperationSubscriber;

    /**
     * Update construct.
     *
     * @param array             $data
     * @param ConditionContract $Condition
     */
    protected function __construct(array $data, ConditionContract $Condition)
    {
        $this->loadInstanceSubscriber($data['id'])
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
     * Crea una nueva instancia de Subscriber para la instancia actual de creacion.
     *
     * @return $this
     * @TODO: Dar soporte para update
     */
    protected function loadInstanceSubscriber($idSubscriber)
    {
        if (is_null($this->getSubscriber()))
            $this->setSubscriber(new Subscriber());

        return $this;
    }
}
