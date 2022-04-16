<?php

namespace NewsletterPluginApi\V1\Newsletters\Services;

use NewsletterPluginApi\V1\Contracts\ConditionContract;
use NewsletterPluginApi\V1\Newsletters\Operations\Create as CreateNewsletter;

class CreateNewsletterByCondition
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
     * @return \NewsletterPluginApi\Entities\Newsletter
     */
    public function __invoke(array $dataRequest)
    {
        return CreateNewsletter::of($dataRequest, $this->Condition)->run();
    }
}
