<?php

namespace NewsletterPluginApi\V1\Subscribers\Services;

use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Subscribers\Operations\Create as CreateSubscriber;

class CreateSubscriberByCondition
{
    /**
     *
     */
    public function __construct(ConditionContract $Condition)
    {
        $this->Condition = $Condition;
    }

    /**
     * @param array $dataRequest
     *
     * @return \NewsletterPluginApi\Entities\Subscriber
     */
    public function __invoke(array $dataRequest)
    {
        return CreateSubscriber::of($dataRequest, $this->Condition)->run();
    }
}
