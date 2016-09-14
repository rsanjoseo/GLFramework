<?php
/**
 *     GLFramework, small web application framework.
 *     Copyright (C) 2016.  Manuel Muñoz Rosa
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Created by PhpStorm.
 * User: manus
 * Date: 14/03/16
 * Time: 13:08
 */

namespace GLFramework;


use Psr\Log\AbstractLogger;

class Log extends AbstractLogger
{

    private static $instance;

    /**
     * Log constructor.
     */
    public function __construct()
    {
        self::$instance = $this;
    }

    /**
     * @return Log
     */
    public static function getInstance()
    {
        if(self::$instance == null) self::$instance = new Log();
        return self::$instance;
    }



    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
        if(!in_array('events', $context))
            Events::fire('onLog', array($message, $level));
    }

    public static function em($message, array $context = array())
    {
        self::getInstance()->emergency($message, $context); // TODO: Change the autogenerated stub
    }

    public static function a($message, array $context = array())
    {
        self::getInstance()->alert($message, $context); // TODO: Change the autogenerated stub
    }

    public static function c($message, array $context = array())
    {
        self::getInstance()->critical($message, $context); // TODO: Change the autogenerated stub
    }

    public static function e($message, array $context = array())
    {
        self::getInstance()->error($message, $context); // TODO: Change the autogenerated stub
    }

    public static function w($message, array $context = array())
    {
        self::getInstance()->warning($message, $context); // TODO: Change the autogenerated stub
    }

    public static function n($message, array $context = array())
    {
        self::getInstance()->notice($message, $context); // TODO: Change the autogenerated stub
    }

    public static function i($message, array $context = array())
    {
        self::getInstance()->info($message, $context); // TODO: Change the autogenerated stub
    }

    public static function d($message, array $context = array())
    {
        self::getInstance()->debug($message, $context); // TODO: Change the autogenerated stub
    }


}