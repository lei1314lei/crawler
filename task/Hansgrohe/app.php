<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/13/17
 * Time: 16:46
 * This file is used to define some setting for current task
 */

?>
<?php
define("_BASE_DIR_",dirname(dirname(dirname(__FILE__))));
require_once (_BASE_DIR_."/setting.php");

$include_path[]= realpath(dirname(dirname(__FILE__)));
set_include_path(implode(PS,$include_path) .PS.get_include_path());

define("_DATA_DIR_",dirname(__FILE__).DS."data");
define("DATA_DOWNLOAD_DIR",dirname(__FILE__).DS."download");
define("CURRENT_DIR",dirname(__FILE__));
?>
