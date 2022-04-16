<?php

namespace NewsletterPluginApi\V1\Subscribers\Traits;

use Illuminate\Http\Response;
use NewsletterPluginApi\Entities\Subscriber;
use NewsletterPluginApi\V1\Contracts\ConditionContract;

/**
 * Trait OperationSubscriber
 * @package NewsletterPluginApi\V1\Subscribers\Traits
 */
trait OperationSubscriber
{
    /**
     * @return string[]
     */
    protected function mapperKeysSubscribers()
    {
        return [
            "email"      => "email",
            "first_name" => "name",
            "last_name"  => "surname",
            "country"    => "country",
            "region"     => "region",
            "city"       => "city",
            "gender"     => "sex",
            "status"     => "status",
            "lists"      => "lists",
        ];
    }

    /**
     * Mantiene una instancia de Subscriber.
     *
     * @var Subscriber
     */
    protected Subscriber $Subscriber;

    /**
     * Mantiene un array con las clases que validaran las
     * diferentes condiciones necesarias para poder
     * realizar la persistencia de los datos de
     * Subscriber.
     *
     * @var ConditionContract
     */
    protected ConditionContract $condition;

    /**
     * Devuelve la instancia del elemento de Subscriber.
     *
     * @return Subscriber
     */
    public function getInstance()
    {
        return $this->getSubscriber();
    }

    /**
     * Configura un conjunto de atributos a la
     * instancia de Subscriber que sera
     * creada
     *
     * @param array $data
     *
     * @return $this
     */
    protected function setAttributes(array $data = [])
    {
        $this->setSubscriber(Subscriber::create($data));

        return $this;
    }

    /**
     * Devuelve la implementacion de Subscriber.
     *
     * @return Subscriber
     */
    protected function getSubscriber()
    {
        return $this->Subscriber;
    }

    /**
     * Configura una nueva instancia de Subscriber
     * para la instancia actual.
     *
     * @param Subscriber $Subscriber
     *
     * @return $this
     */
    protected function setSubscriber(Subscriber $Subscriber)
    {
        $this->Subscriber = $Subscriber;

        return $this;
    }

    /**
     * Retorna la condicion para el funcionamiento en Operacion Crear.
     *
     * @return ConditionContract
     */
    protected function getCondition()
    {
        return $this->condition;
    }

    /**
     * Configura la Condition que se va a ejecutar.
     *
     * @param ConditionContract $Condition
     *
     * @return $this
     */
    protected function setCondition(ConditionContract $Condition)
    {
        $this->condition = $Condition;

        return $this;
    }

    /**
     * Ejecuta la persistencia del modelo Subscriber
     * y devuelve el objeto guardado.
     *
     * @return Subscriber
     */
    public function run()
    {
        $Subscriber = $this->getSubscriber();
        $Subscriber->save();

        return $this->getInstance();
    }

    /**
     * Valida los atributos para Subscriber
     *
     * @param $data
     *
     * @return $this
     */
    protected function validateAttributes($data)
    {
        $this->setAttributes($this->clearFields($data))
            ->validateAttributesByCondition();

        return $this;
    }

    /**
     * Valida campos obligatorios de Subscriber para crear
     * la instancia correspondiente.
     *
     * @return $this
     */
    protected function validateAttributesByCondition()
    {
        $Subscriber = $this->getSubscriber();

        $this->getCondition()->validateRequiredFieldsByCondition($Subscriber);

        return $this;
    }

    /**
     * @para
     *
     * @param $data
     *
     * @return array
     */
    protected function clearFields($data)
    {
        $cleanFields = [];
        foreach ($this->mapperKeysSubscribers() as $key => $value) {
            if (in_array($key, array_keys($data))) {
                $cleanFields[$value] = $data[$key];
            }
        }

        return $cleanFields;
    }
}
