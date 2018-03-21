# datacollection
This is one useful tool that integrat phpQuery, zend and phpexcel, which support extract data from
    one website.

phpQuery is one excellent extension, that you can extract web data once you know jQuery, for example

    $html= file_get_contents("http://www.baidu.com");

    phpQuery::newDocumentHTML($html,$this->charset);

    pq(".body")->html()

zend is optional, if you have no plan to use "ajax" feature, just remove in from lib/zend.
    Phpexcel is also optional. But it is really useful for convert file from excel to csv without any character
    corrupted
    such as chinese with utf-8, may be you will use this extension once you extract data finished. function excelToCsv
    has
    been declared in functions.php file.

Before any further development, please must be include setting.php first.

There is one example, that extract all products data from www.duravit.cn, please check code and document in
    /task/maunufacuturer/

Any problems, please contact fifteenjoy@gmail.com
