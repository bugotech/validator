<?php namespace Bugotech\Validator;

trait Validates
{
    /**
     * Lista de regras.
     * @var array
     */
    public $validates = [];

    /**
     * Executar validacao no model.
     *
     * @param array $values
     * @param array $customAttributes
     * @return bool
     */
    protected function validateRules(array $values, array $customAttributes = [])
    {
        // Verificar se foi definido alguma validacao
        if (count($this->validates) == 0) {
            return true;
        }

        return Validator::validate($values, $this->validates, $customAttributes);
    }
}