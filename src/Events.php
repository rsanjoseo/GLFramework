<?php
/**
 * Created by PhpStorm.
 * User: manus
 * Date: 2/03/16
 * Time: 9:57
 */

namespace GLFramework;


class Events
{
    private static $instance;
    private $handlers = array();

    /**
     * Events constructor.
     */
    public function __construct()
    {
        self::$instance = $this;
    }

    /**
     * @return Events
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Se pone a la escucha de un evento, se puede añadir en la configuración del módulo
     *  dentro de *app:listeners*
     * @param $event
     * @param $fn
     */
    public function listen($event, $fn)
    {
        if(!isset($this->handlers[$event]))
        {
            $this->handlers[$event] = array();
        }
        $this->handlers[$event][] = $fn;

    }

    /**
     *
     * Publica un evento al sistema, devuelve
     *      0 si no hay nadie que lo procese,
     *      true si almenos alguien devuelve true
     *      false si todos devuelven false
     * @param $event
     * @param array $args
     * @return bool|int|string
     */
    public static function fire($event, $args = array())
    {
        return self::getInstance()->_fire($event, $args);
    }

    public function _fire($event, $args = array())
    {
        $buffer = false;
        if(!is_array($args)) $args = array($args);
        if(isset($this->handlers[$event]) && count(($this->handlers[$event])) > 0)
        {
            $handlers = $this->handlers[$event];
            foreach($handlers as $fn)
            {
                if(is_callable($fn))
                {
                    $result = call_user_func_array($fn, $args);
                    if($result === true)
                    {
                        return true;
                    }
                    else if(is_string($result))
                    {
                        $buffer .= $result;
                    }
                }
                else
                {
                    Log::getInstance()->error("Can not call event: " . $event . " function: " . print_r($fn, true), array('events'));
                }
            }
            return $buffer;
        }
        return 0;
    }
}