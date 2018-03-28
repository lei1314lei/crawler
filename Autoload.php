<?php

$include_path[] = _PLUGINS_;
$include_path[] = _LIB_DIR_;
$include_path[] = _INCLUDE_DIR_;
set_include_path(implode(PS,$include_path) .PS.get_include_path());

class Autoload
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
            self::$_instance = new Autoload();
        }
        return self::$_instance;
    }

    /**
     * Register SPL autoload function
     */
    static public function register()
    {
        spl_autoload_register(array(self::instance(), 'doAutoload'));
    }

    /**
     * Load class source code
     *
     * @param string $class
     */
    public function doAutoload($class)
    {
        $classFile = str_replace(' ', DIRECTORY_SEPARATOR, str_replace('_', ' ', $class));
        $classFile .= '.php';
        //echo $classFile;die();
        return include $classFile;
    }
}
Autoload::register();