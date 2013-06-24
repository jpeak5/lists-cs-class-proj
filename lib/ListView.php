<?php

/**
 * ListView is a presentation class for The Lists and ListItem classes
 *
 * @author jpeak5
 */
class ListView {

    /**
     * returns markup as a string
     * @param type $list an array of ListItem
     */
    public static function RenderList($list = NULL) {
        
        if (empty($list)) {
            return false;
        }
        $storeList = array();
        foreach ($list as $store => $items) {
//        echo sprintf('store = %s, items = %s',$store,var_dump($items));
            if(!array_key_exists($store, $storeList)){
                $storeList[$store] = array();
            }

            foreach($items as $item){
                if(!array_key_exists($item->who, $storeList[$store])){
                    $storeList[$store][$item->who] = array();
                    $storeList[$store][$item->who]['total'] = 0;
                }
                $storeList[$store][$item->who]['items'][] = $item;
                $storeList[$store][$item->who]['total'] += $item->price_estimate;
            }
            
        }
        var_dump($storeList);
        return self::getListMarkup($storeList);   
    }
    
    public static function tag($tag,$content, array $attrs=null){
        $out = "<".$tag;
        $attributes = "";
        if(!empty($attrs)){
            foreach($attrs as $k=>$v){
                $attributes.=" ".$k."=\"".$v."\"";
            }
            $out.=$attributes;
        }
        return $out.">".$content."</".$tag.">";
        
    }
    
    public static function getListMarkup($items){
        
        $ul = function($items,$attrs=null){
           $out = "<ul>";
           foreach($items as $li){
               $out.="<li>".$li."</li>";
           }
            return $out."<ul>";
        };

        $out = "";
        $stores = array_keys($items);
        $storeLists = "";
        foreach($stores as $store){
            $people = array_keys($items[$store]);
            $peopleLists = "";
            foreach($people as $person){
                
                $personHeader = self::tag('span',$person, array('class'=>'person'));
                $peopleLists.=
                
                $liBucket = "";
                foreach($items[$store][$person]['items'] as $li){
                    $liBucket.= self::tag('li',$li->toHTML());
                }
                $peopleLists.= self::tag('ul',$liBucket);
            }
            $storeLists.= self::tag('li',($peopleLists));
        }
        return self::tag('ul',($storeLists));
    }


    public static function RenderTodoList($list = null) {
        $todoList = null;
        if (!empty($list)) {
            foreach ($list as $doer => $todos) {
                //	echo "\$store";
                //	krumo($store);

                $doerTotal = 0;
                $listHead = "";
                $listHead.="<span class=\"heading\"><strong>" . $doer;
                $listBody = "<ul>";
                foreach ($todos as $todo) {
                    $listBody.="<li class=\"litem\"><strong>{$todo->item}</strong> &nbsp;({$todo->duration})";
                    $listBody.="&nbsp;<a class=\"deleteme\" href=\"javascript:confirmDelete('delete.php?TodoList=" . urlencode($todo->id) . "')\">delete</a>";
                    $listBody.="&nbsp;<a class=\"editme\" href=\"index.php?TodoList=" . urlencode($todo->id) . "\">edit</a>";
                    $doerTotal+=isset($todo->duration) ? $todo->duration : 0;
                    $listBody.=(strlen($todo->description) > 0) ? "<br/><span class=\"description\">" . $todo->description . "</span>" : "";
                    $listBody.="</li>";
                }
                $listHead.="</strong><span class=\"workAggregate\">&nbsp;&nbsp;(" . $doerTotal . ")</span></span>";
                $listBody.="</ul>";
                $todoList.=$listHead . $listBody;
            }
        }
        return $todoList;
    }

}

?>
