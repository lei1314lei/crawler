<?php
/**
 * Created by PhpStorm.
 * User: joy.zhu
 * Date: 04/13/17
 * Time: 16:42
 * This script is used to extract products from manufacturer official website
 */
?>
<?php
require_once ('local.php');

// TODO make a abstract class
class Joy_Shell extends Shell{


    protected $_manufucturers;
    /**
     * Initialize application and parse input parameters
     *
     */
    public function __construct($manufucture)
    {
        parent::__construct();
        $this->_manufucturers = $manufucture;
    }

    public function run() {

        if($this->getVar("info")) {
            $this->fetchInfo($this->getVar("info"));
        } elseif($this->getVar("url")){
            $this->fetchAllProductsUrl($this->getVar("url"));
        } elseif($this->getVar("help")) {
            echo $this->usageHelp();
        } elseif($this->getVar("all")) {
            foreach($this->_manufucturers as $v) {
                $this->fetchInfo($v);
            }
        } else {
            echo "Invalid parameters,please type help to ger more help!";
        }

    }

    public function fetchAllProductsUrl($manufacturer) {
        $fileName = $manufacturer."products.csv";
        $dir = DATA_DOWNLOAD_DIR . DS . $manufacturer;
        if(is_file($dir .DS.$fileName)) {
            echo $dir .DS.$fileName . " Already exsit, not need to fetch again!";
            return $dir .DS.$fileName;
        }
        $class = uc_words($manufacturer)."_CategoryPage";
        $category = new $class($dir);
        // $duravit_category->product_urls_log_dir = ;
        $category->getAllProductUrl($fileName);
        echo "get {$manufacturer} product urls done" . "\n";
        return $dir .DS.$fileName;

    }

    
    public function fetchInfo($manufacturer) {
        
        // check manufacuturer first
        if(!in_array(strtolower($manufacturer),$this->_manufucturers)) {
            die ("Valid " .$manufacturer . "\n");

        }
        $file = $this->fetchAllProductsUrl($manufacturer);

        $urls = csvToarray($file);
        $urls = array_column($urls,0);
        $class = uc_words($manufacturer)."_ProductPage";
        $productpage = new $class(NULL,$urls);
        unset($urls);
        $productpage->_data_download_dir = DATA_DOWNLOAD_DIR . DS . $manufacturer;
        $productpage->loadProductInfo();
        echo "get {$manufacturer} product information done" . "\n";
        return;

    }

    public function usageHelp() {
        return <<<USAGE
Usage:  php -f indexer.php -- [options]
  --info <manufacturer> fetch <manufacturer> Data 
  --url  <manufacturer>  fetch all manufacturers product urls data
  all    fetch all <manufacturer> Data
  help                          This help
USAGE;
    }

}

$shell = new Joy_Shell($manufucturer);
$shell->run();

?>
