<?php
require_once '/var/www/html/lists/lib/ListView.php';

class ListView_testcase extends PHPUnit_Framework_TestCase{
    
    public function test_tag(){
        $tags = array("", " ", 'a','h1','p','ul');
        $content = array('this is some sample content','');
        $attrs = array('class'=>'test leftalign');
        $i = rand(0, count($tags)-1);
        $j = rand(0,count($attrs)-1);
        $sample = ListView::tag($tags[$i], $content[$j], $attrs);
        
        
        $dom = new DOMDocument;
        $dom->loadHTML($sample); // see docs for load, loadXml, loadHtml and loadHtmlFile
        $this->assertTrue($dom->validate());
        
    }
    
}
?>
