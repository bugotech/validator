<?php namespace Bugotech\Validator;

use Illuminate\Validation\ValidationServiceProvider;

class ValidatorServiceProvider extends ValidationServiceProvider
{
    /**
     * Rules lista.
     * @var array
     */
    protected $extendRules = [
        'id' => ['rule' => 'Bugotech\Validator\Rules@id', 'messageid' => 'validation.id'],
        'route' => ['rule' => 'Bugotech\Validator\Rules@route', 'messageid' => 'validation.route'],
        'domain' => ['rule' => 'Bugotech\Validator\Rules@domain', 'messageid' => 'validation.domain'],
        'dbname' => ['rule' => 'Bugotech\Validator\Rules@database', 'messageid' => 'validation.dbname'],
        'checkpass' => ['rule' => 'Bugotech\Validator\Rules@checkpass', 'messageid' => 'validation.checkpass'],
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->alias('validator', 'Illuminate\Contracts\Validation\Factory');
    }

    /**
     * Boot do Provider.
     */
    public function boot()
    {
        parent::boot();

        // Registrar novas regras
        foreach ($this->extendRules as $name => $info) {
            validator()->extend($name, $info['rule'], trans($info['messageid']));
        }
    }
}
