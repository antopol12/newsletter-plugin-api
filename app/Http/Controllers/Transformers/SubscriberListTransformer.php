<?php

namespace App\Http\Controllers\Transformers;

use League\Fractal\TransformerAbstract;
use NewsletterPluginApi\Entities\SubscriberList;

/**
 *
 */
class SubscriberListTransformer extends TransformerAbstract
{
    /**
     * @param SubscriberList $SubscriberList
     *
     * @return array
     */
    public function transform(SubscriberList $SubscriberList)
    {
        return [
            "id"       => $SubscriberList->id,
            "name"     => $SubscriberList->name,
        ];
    }
}
