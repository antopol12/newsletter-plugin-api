<?php

namespace NewsletterPluginApi\V1\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface ValidatorContract
 *
 * @package NewsletterPluginApi\V1\Contracts
 */
interface ValidatorContract
{
    /**
     * Verifica cuales son las validaciones que se cumplen
     * y en caso de no cumplirla devuelve el error encontrado.
     *
     * @param Model $Model
     *
     * @return mixed
     */
    public function validateRequiredFieldsByCondition(Model $Model);
}
