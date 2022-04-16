<?php

namespace NewsletterPluginApi\V1\Newsletters\Traits;

use NewsletterPluginApi\Entities\Newsletter;
use NewsletterPluginApi\V1\Contracts\ConditionContract;

/**
 * Trait OperationNewsletter
 * @package NewsletterPluginApi\V1\Newsletters\Traits
 */
trait OperationNewsletter
{
    /**
     * @return string[]
     */
    protected function mapperKeysNewsletters()
    {
        return [
            "subject"       => "subject",
            "html_content"  => "message",
            "plain_content" => "message_text",
            "lists"         => "query",
            "status"        => "status",
            "send_on"       => "send_on"
        ];
    }

    /**
     * Mantiene una instancia de Newsletter.
     *
     * @var Newsletter
     */
    protected Newsletter $Newsletter;

    /**
     * Mantiene un array con las clases que validaran las
     * diferentes condiciones necesarias para poder
     * realizar la persistencia de los datos de
     * Newsletter.
     *
     * @var ConditionContract
     */
    protected ConditionContract $condition;

    /**
     * Devuelve la instancia del elemento de Newsletter.
     *
     * @return Newsletter
     */
    public function getInstance()
    {
        return $this->getNewsletter();
    }

    /**
     * Configura un conjunto de atributos a la
     * instancia de Newsletter que sera
     * creada
     *
     * @param array $data
     *
     * @return $this
     */
    protected function setAttributes(array $data = [])
    {
        $this->setNewsletter(Newsletter::create($data, $this->condition));

        return $this;
    }

    /**
     * Devuelve la implementacion de Newsletter.
     *
     * @return Newsletter
     */
    protected function getNewsletter()
    {
        return $this->Newsletter;
    }

    /**
     * Configura una nueva instancia de Newsletter
     * para la instancia actual.
     *
     * @param Newsletter $Newsletter
     *
     * @return $this
     */
    protected function setNewsletter(Newsletter $Newsletter)
    {
        $this->Newsletter = $Newsletter;

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
     * Ejecuta la persistencia del modelo Newsletter
     * y devuelve el objeto guardado.
     *
     * @return Newsletter
     */
    public function run()
    {
        $Newsletter = $this->getNewsletter();
        $Newsletter->save();

        return $this->getInstance();
    }

    /**
     * Valida los atributos para Newsletter
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
     * Valida campos obligatorios de Newsletter para crear
     * la instancia correspondiente.
     *
     * @return $this
     */
    protected function validateAttributesByCondition()
    {
        $Newsletter = $this->getNewsletter();

        $this->getCondition()->validateRequiredFieldsByCondition($Newsletter);

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
        foreach ($this->mapperKeysNewsletters() as $key => $value) {
            if (in_array($key, array_keys($data))) {
                $cleanFields[$value] = $data[$key];
            }
        }

        return $cleanFields;
    }
}
