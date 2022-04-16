<?php

namespace NewsletterPluginApi\V1\Subscribers\Operations;

use NewsletterPluginApi\Entities\Subscriber;
use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Contracts\OperationContract;
use NewsletterPluginApi\V1\Subscribers\Traits\OperationSubscriber;

/**
 *
 */
class Create implements OperationContract
{
    use OperationSubscriber;

    /**
     * Create construct.
     *
     * @param array             $attributes
     * @param ConditionContract $Condition
     */
    protected function __construct(array $attributes, ConditionContract $Condition)
    {
        $this->setCondition($Condition)
            ->validateAttributes($attributes);

        return $this;
    }

    /**
     * Genera una nueva instancia de esta misma clase.
     *
     * @param array             $data
     * @param ConditionContract $Condition
     *
     * @return Create|static
     */
    public static function of(array $data, ConditionContract $Condition)
    {
        return new static($data, $Condition);
    }
}
