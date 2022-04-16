<?php

namespace NewsletterPluginApi\V1\Subscribers\Traits;

use NewsletterPluginApi\Entities\Subscriber;

/**
 * Trait CommonConditionsSubscriber
 *
 * @package NewsletterPluginApi\V1\Subscribers\Traits
 */
trait CommonConditionsSubscriber
{
    /**
     * Verify that the request has a subject assigned.
     *
     * @param Subscriber $Subscriber
     *
     * @return bool
     */
    private function haveEmail(Subscriber $Subscriber)
    {
        return !empty($Subscriber->getEmail());
    }

    /**
     * Verify that the request has a message assigned.
     *
     * @param Subscriber $Subscriber
     *
     * @return bool
     */
    private function existsEmail(Subscriber $Subscriber)
    {
        return !count(Subscriber::where("email", $Subscriber->getEmail())->get()) > 0;
    }
}
