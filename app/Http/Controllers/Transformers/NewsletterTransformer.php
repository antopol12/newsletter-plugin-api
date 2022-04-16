<?php

namespace App\Http\Controllers\Transformers;

use League\Fractal\TransformerAbstract;
use NewsletterPluginApi\Entities\Newsletter;

/**
 *
 */
class NewsletterTransformer extends TransformerAbstract
{
    /**
     * @param Newsletter $Newsletter
     *
     * @return array
     */
    public function transform(Newsletter $Newsletter)
    {
        return [
            "id"            => $Newsletter->id,
            "subject"       => $Newsletter->getSubject(),
            "html_content"  => $Newsletter->getMessage(),
            "plain_content" => $Newsletter->getMessageText(),
            "lists"         => $Newsletter->getLists(),
            "status"        => $Newsletter->getStatus(),
            "send_on"       => $Newsletter->getDateSend()
        ];
    }
}
