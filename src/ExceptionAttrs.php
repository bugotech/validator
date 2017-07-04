<?php namespace Bugotech\Validator;

use Exception;
use Bugotech\Foundation\Application;

class ExceptionAttrs extends Exception
{
    /**
     * Lista de mensagens por atributos.
     * @var array
     */
    protected $attrs = [];

    /**
     * Lista de mensagens por atributo com o o key traduzido.
     * @var array
     */
    protected $attrsCustom = [];

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param string $message
     * @param int $code
     * @param array $attrs
     * @param array $attrsCustom
     * @param Exception $previous
     */
    public function __construct($message = '', $code = 0, array $attrs = [], array $attrsCustom = [], \Exception $previous = null)
    {
        $this->app = app();
        $this->attrs = $attrs;
        $this->attrsCustom = (count($attrsCustom) == 0) ? $attrs : $attrsCustom;

        $message = $this->app->runningInConsole() ? self::makeMsgs($message, $this->attrsCustom) : $message;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Retorna as mensagens dos atributos.
     *
     * @return array
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * Retorna as mensagens dos atributos.
     *
     * @return array
     */
    public function getAttrsCustom()
    {
        return $this->attrsCustom;
    }

    /**
     * Retornar a mensagem com as mensagens dos campos se houver.
     *
     * @return string
     */
    public function toMessageStr()
    {
        return $this->app->runningInConsole() ? $this->getMessage() : self::makeMsgs($this->getMessage(), $this->getAttrsCustom());
    }

    /**
     * Monta a mensagem com os atributos.
     *
     * @param $message
     * @param $attrs
     * @return string
     */
    protected static function makeMsgs($message, $attrs)
    {
        $lines = [];
        foreach ($attrs as $attr => $msgs) {
            $lines[] = sprintf("%s: %s\r\n", $attr, implode('. ', $msgs));
        }

        return sprintf("%s\r\n%s", $message, implode("\r\n", $lines));
    }
}