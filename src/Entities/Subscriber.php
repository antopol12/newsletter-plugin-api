<?php

namespace NewsletterPluginApi\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NewsletterPluginApi\V1\Contracts\ConditionContract;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'wp_newsletter';
    protected $guarded = [];
    const CREATED_AT = 'created';
    const UPDATED_AT = null;

    /**
     * @var string[]
     */
    protected $arrayStatus = [
        "confirmed"     => "C",
        "not_confirmed" => "S",
        "unsubscribed"  => "C",
        "bounced"       => "B",
        "complained"    => "P"
    ];

    /**
     * Retorna el email del subscriber.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Configura la propiedad email del subscriber.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Retorna el name del subscriber.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Configura la propiedad name del subscriber.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retorna el surname del subscriber.
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Configura la propiedad surname del subscriber.
     *
     * @param string $surname
     *
     * @return void
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * Retorna el sex del subscriber.
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Configura la propiedad sex del subscriber.
     *
     * @param string $sex
     *
     * @return void
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * Retorna el region del subscriber.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Configura la propiedad region del subscriber.
     *
     * @param string $region
     *
     * @return void
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Retorna el city del subscriber.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Configura la propiedad city del subscriber.
     *
     * @param string $city
     *
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Retorna el country del subscriber.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Configura la propiedad country del subscriber.
     *
     * @param string $country
     *
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Retorna el status del subscriber.
     *
     * @return string
     */
    public function getStatus()
    {
        return array_search($this->status, $this->arrayStatus);
    }

    /**
     * Configura la propiedad status del subscriber.
     *
     * @param string $status
     *
     * @return void
     */
    public function setStatus($status = "confirmed")
    {
        $this->status = $this->arrayStatus[$status];
    }

    /**
     * Retorna el status del subscriber.
     *
     * @return array
     */
    public function getLists()
    {
        $lists = [];

        return collect($this->toArray())->mapWithKeys(function ($value, $key) use (&$lists) {
            if (str_contains($key, "list_") && $value == 1) {
                $lists = array_merge($lists, ["id" => substr($key, strlen($key) - (strlen($key) - strlen("list_")))]);

                return $lists;
            } else
                return [];
        })->all();
    }

    /**
     * Configura la propiedad list del subscriber.
     *
     * @param array $arrayIdsList
     *
     * @return void
     */
    public function setLists(array $arrayIdsList)
    {
        foreach ($arrayIdsList as $idList) {
            $lista = "list_{$idList['id']}";
            $this->$lista = 1;
        }
    }

    /**
     * Retorna el language del subscriber.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Configura la propiedad language del subscriber.
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Retorna el token del subscriber.
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
     * @param $size
     *
     * @return void
     */
    public function setToken($size = 10)
    {
        $this->token = substr(md5(rand()), 0, $size);
    }

    /**
     * Retorna el created del subscriber.
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Configura la propiedad created del subscriber.
     *
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Retorna el updated del subscriber.
     *
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Configura la propiedad updated del subscriber.
     *
     * @param string $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     *
     * @param array $data
     *
     * @return Subscriber
     * @TODO ARREGLAR
     */
    public static function create(array $data)
    {
        $Subscriber = new Subscriber();
        $Subscriber->setEmail($data['email']);
        $Subscriber->setName($data['name']);
        $Subscriber->setSurname($data['surname']);
        $Subscriber->setCity($data['city']);
        $Subscriber->setCountry($data['country']);
        $Subscriber->setLists($data['lists']);
        $Subscriber->setSex($data['sex']);
        $Subscriber->setRegion($data['region']);
        $Subscriber->setStatus($data['status']);
        $Subscriber->setToken();

        return $Subscriber;
    }
}
