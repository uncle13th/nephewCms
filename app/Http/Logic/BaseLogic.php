<?php
namespace App\Http\Logic;

class BaseLogic
{
    public $errorCode = 0;
    public $errorMessage = '';

    protected static $_instances = array();

    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }

}