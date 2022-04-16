<?php

namespace NewsletterPluginApi\V1\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface OperationContract
 *
 * @package NewsletterPluginApi\V1\Contracts
 */
interface OperationContract
{
    /**
     * Genera una nueva instancia de esta misma clase.
     *
     * @param array $data
     * @param ConditionContract $Condition
     *
     * @return mixed
     */
    public static function of(array $data, ConditionContract $Condition);

    /**
     * Devuelve la instancia del elemento del Model.
     *
     * @return Model
     */
    public function getInstance();

    /**
     * Ejecuta la persistencia del modelo y devuelve el objeto guardado.
     *
     * @return Model
     */
    public function run();
}
