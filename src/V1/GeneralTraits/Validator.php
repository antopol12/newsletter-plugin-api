<?php

namespace NewsletterPluginApi\V1\GeneralTraits;

use Illuminate\Database\Eloquent\Model;
use NewsletterPluginApi\Exceptions\Repositories\ValidatorException;

/**
 * Trait Validator
 *
 * @package ModelPluginApi\V1\Models\Traits
 */
trait Validator
{
    /**
     * Verifica cuales son las validaciones que se cumplen
     * y en caso de no cumplirla devuelve el error encontrado.
     *
     * @param Model $Model
     *
     * @return void
     * @throws \Exception
     */
    public function validateRequiredFieldsByCondition(Model $Model)
    {
        foreach ($this->validations as $metodo) {
            $validacion = $this->{$metodo}($Model);
            if (!$validacion && !is_null($validacion)) {
                throw new ValidatorException($this->mistakes[$metodo]);
            }
        }
    }
}
