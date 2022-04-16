<?php

namespace App\Http\Controllers\Transformers;

use League\Fractal\TransformerAbstract;
use NewsletterPluginApi\Entities\Subscriber;

/**
 *
 */
class SubscriberTransformer extends TransformerAbstract
{
    /**
     * @param Subscriber $Subscriber
     *
     * @return array
     */
    public function transform(Subscriber $Subscriber)
    {
        return [
            "id"       => $Subscriber->id,
            "email"    => $Subscriber->getEmail(),
            "name"     => $Subscriber->getName(),
            "lastname" => $Subscriber->getSurname(),
            "gender"   => $Subscriber->getSex(),
            "region"   => $Subscriber->getRegion(),
            "city"     => $Subscriber->getCity(),
            "status"   => $Subscriber->getStatus(),
            "lists"    => $Subscriber->getLists(),
            "language" => $Subscriber->getLanguage(),
            "created"  => $Subscriber->getCreated(),
            "updated"  => $Subscriber->getUpdated()
        ];
    }
}
