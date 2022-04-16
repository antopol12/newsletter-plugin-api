<?php

namespace NewsletterPluginApi\V1\Newsletters\Traits;

use NewsletterPluginApi\Entities\Newsletter;

/**
 * Trait CommonConditionsNewsletter
 *
 * @package NewsletterPluginApi\V1\Newsletters\Traits
 */
trait CommonConditionsNewsletter
{
    /**
     * Verify that the request has a subject assigned.
     *
     * @param Newsletter $Newsletter
     *
     * @return bool
     */
    private function haveSubject(Newsletter $Newsletter)
    {
        return !empty($Newsletter->getSubject());
    }

    /**
     * Verify that the request has a message assigned.
     *
     * @param Newsletter $Newsletter
     *
     * @return bool
     */
    private function haveMessageHtmlOrMessageText(Newsletter $Newsletter)
    {
        return !empty($Newsletter->getMessage()) || !empty($Newsletter->getMessageText());
    }

    /**
     * Verify that the request has a date assigned.
     *
     * @param Newsletter $Newsletter
     *
     * @return bool
     */
    private function haveDateSend(Newsletter $Newsletter)
    {
        return !empty($Newsletter->getDateSend());
    }
}
