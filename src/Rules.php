<?php namespace Bugotech\Validator;

class Rules
{
    /**
     * Validacao ID.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return int
     */
    public function id($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z]+[a-z0-9]*$/i', $value);
    }

    /**
     * Validacao Route.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return int
     */
    public function route($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z]+[a-z0-9]*$/', $value);
    }

    /**
     * Validacao: DOMAIN.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return int
     */
    public function domain($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z]+[a-z0-9._]*$/', $value);
    }

    /**
     * Validacao DATABASE name.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return int
     */
    public function database($attribute, $value, $parameters)
    {
        return preg_match('/^[a-z]+[a-z0-9_]*$/', $value);
    }

    /**
     * Validacao: checkpass.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return int
     */
    public function checkpass($attribute, $value, $parameters)
    {
        if (auth()->check() != true) {
            return false;
        }

        // Validar
        $user = auth()->user();
        $credentials = ['email' => $user->email, 'password' => $value];

        return auth()->validate($credentials);
    }
}