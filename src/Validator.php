<?php namespace Bugotech\Validator;

class Validator
{
    /**+
     * Validar valores pela regra.
     *
     * @param array $values
     * @param array $rules
     * @param array $customAttributes
     * @return bool
     * @throws ExceptionAttrs
     */
    public static function validate(array $values, array $rules, array $customAttributes = [])
    {
        // Carregar lista de regras com as variaveis
        $rules = self::getRules($values, $rules);

        // Traduzir custom attributes
        foreach ($customAttributes as $k => $v) {
            $customAttributes[$k] = trans($v);
        }

        // Processar regras
        $validator = validator()->make($values, $rules, [], $customAttributes);
        if ($validator->fails()) {
            $messages = $validator->messages();
            $items = $messages->toArray();

            // Traduzxir

            throw new ExceptionAttrs(trans('validation.errors.attributes'), 0, $items);
        }

        return true;
    }

    /**
     * Retorna lista de regras para validacao com variaveis.
     *
     * @param array $values
     * @param array $rules
     * @return array
     */
    private static function getRules($values, $rules)
    {
        $list = [];

        // Tratar variaveis da regra
        foreach ($rules as $field => $expr) {
            preg_match_all('/{([a-zA-Z0-9_]+)+}/', $expr, $vars, PREG_PATTERN_ORDER);
            foreach ($vars[1] as $i => $var_id) {
                $var_old = $vars[0][$i];
                $var_new = array_key_exists($var_id, $values) ? $values[$var_id] : 'null';
                $expr = str_replace($var_old, $var_new, $expr);
            }

            $list[$field] = $expr;
        }

        return $list;
    }
}