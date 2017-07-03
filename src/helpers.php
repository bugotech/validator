<?php

if (! function_exists('validator')) {
    /**
     * Estrutura de validação.
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Validation\Factory|\Illuminate\Validation\Validator
     */
    function validator($data = null, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $validator = app('validator');

        if (is_null($data)) {
            return $validator;
        }

        return $validator->make($data, $rules, $messages, $customAttributes);
    }
}