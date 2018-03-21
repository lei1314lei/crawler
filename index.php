<p>This is one useful tool that integrated phpQuery, zend and phpexcel, which support extract data from
    one website.</p>

<p>phpQuery is one excellent extension, that you can extract web data once you know jQuery, for example
    <br>
    $html= file_get_contents("http://www.baidu.com");
    <br>
    phpQuery::newDocumentHTML($html,$this->charset);
    <br>
    pq(".body")->html()
</p>
<p>zend is optional, if you have no plan to use "ajax" feature, just remove in from lib/zend.
    Phpexcel is also optional. But it is really useful for convert file from excel to csv without any character
    corrupted
    such as chinese with utf-8, may be you will use this extension once you extract data finished. function excelToCsv
    has
    been declared in functions.php file.</p>

<p>Before any further development, please must be include setting.php first.</p>

<p>There is one example, that extract all products data from www.duravit.cn, please check code and document in
    /task/maunufacuturer/</p>

<p>Any problems, please contact fifteenjoy@gmail.com</p>