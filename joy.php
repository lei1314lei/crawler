<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 5/16/2016
 * Time: 11:03 AM
 */
class joy
{
    static $_instance;

    /**
     * Singleton pattern implementation
     *
     * @return Varien_Autoload
     */
    static public function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new joy();
        }
        return self::$_instance;
    }

    /**
     * Register SPL autoload function
     */
    static public function register()
    {
        spl_autoload_register(array(self::instance(), 'autoload'));
    }

    /**
     * Load class source code
     *
     * @param string $class
     */
    public function autoload($class)
    {
        $classFile = str_replace(' ', DIRECTORY_SEPARATOR, str_replace('_', ' ', $class));
        $classFile .= '.php';
        //echo $classFile;die();
        return include $classFile;
    }
}

?>