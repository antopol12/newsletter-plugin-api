<?php

namespace NewsletterPluginApi\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NewsletterPluginApi\V1\Contracts\ConditionContract;

class Newsletter extends Model
{
    use HasFactory;

    protected $table = 'wp_newsletter_emails';
    protected $guarded = [];
    const CREATED_AT = 'created';
    const UPDATED_AT = null;

    /**
     * Retorna el subject del NewsLetter.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Configura la propiedad subject del NewsLetter.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Retorna el message del NewsLetter.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Configura la propiedad message del NewsLetter.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Retorna el message_text del NewsLetter.
     *
     * @return string
     */
    public function getMessageText()
    {
        return $this->message_text;
    }

    /**
     * Configura la propiedad message_text del NewsLetter.
     *
     * @param string $message_text
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;
    }

    /**
     * Retorna el lists del NewsLetter.
     *
     * @return array
     */
    public function getLists()
    {
        $arrayLists = [];
        $matches = preg_split("/(list_)/", $this->query);
        unset($matches[0]);
        foreach ($matches as $matche)
            $arrayLists[] = [
                "id" => substr($matche, 0, strpos($matche, "="))
            ];

        return $arrayLists;
    }

    /**
     * Configura la propiedad lists del NewsLetter.
     *
     * @param array $lists
     */
    public function setLists($lists)
    {
        foreach ($lists as $key => $idList) {
            $stringLists .= $key == 0 ?
                "list_{$idList}=1" : " or list_{$idList}=1";
        }

        $this->query = "select * from wp_newsletter where status='C' and ({$stringLists})";
    }

    /**
     * @return void
     */
    public function setEmptyList()
    {
        for ($idList = 1; $idList <= 40; $idList++) {
            $SubscriberLists = SubscriberList::where("list_" . $idList, 1)->get();
            if (count($SubscriberLists) <= 0)
                break;
        }

        $this->query = "select * from wp_newsletter where status='C' and (list_{$idList}=1)";
    }

    /**
     * Retorna el status del NewsLetter.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Configura la propiedad status del NewsLetter.
     *
     * @param string $status
     */
    public function setStatus($status = "sending")
    {
        $this->status = $status;
    }

    /**
     * Retorna el send_on del NewsLetter.
     *
     * @return string
     */
    public function getDateSend()
    {
        return date("Y-m-d H:i:s", $this->send_on);
    }

    /**
     * Configura la propiedad send_on del NewsLetter.
     *
     * @param $send_on
     */
    public function setDateSend($send_on)
    {
        $this->send_on = strtotime($send_on);
    }

    /**
     * Retorna el type del NewsLetter.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Configura la propiedad type del NewsLetter.
     *
     * @param string $type
     */
    public function setType($type = "message")
    {
        $this->type = $type;
    }

    /**
     * Retorna el token del NewsLetter.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set a random token of the specified size (or 10 characters if size is not specified).
     *
     * @param int $size
     */
    public function setToken($size = 10)
    {
        $this->token = substr(md5(rand()), 0, $size);
    }

    /**
     * @return int
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     *
     * @param int $editor
     */
    public function setEditor($editor = 1)
    {
        $this->editor = $editor;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return unserialize($this->optiona);
    }

    /**
     *
     * @param array $options
     */
    public function setOptions(array $data)
    {
        $options = [
            "lists_operator" => "or",
            "wp_users"       => "0",
            "status"         => "C",
            "lists"          => $data["query"]
        ];

        $this->options = serialize($options);
    }

    /**
     *
     * @param array             $data
     * @param ConditionContract $Condition
     *
     * @return Newsletter
     * @TODO ARREGLAR
     */
    public static function create(array $data, ConditionContract $Condition)
    {
        $Newsletter = new Newsletter();
        $Newsletter->setSubject($data['subject']);
        $Newsletter->setMessage($data['message']);
        //$Newsletter->setMessageText($data['message_text']);
        $Newsletter->setDateSend($data['send_on']);
        class_basename($Condition) == "ByEmptyList" ? $Newsletter->setEmptyList() :
            $Newsletter->setLists($data['query']);
        $data['query'] = array_column($Newsletter->getLists(),"id");
        $Newsletter->setOptions($data);
        $Newsletter->setStatus($data['status']);
        $Newsletter->setEditor();
        $Newsletter->setToken();
        $Newsletter->setType();

        return $Newsletter;
    }
}
