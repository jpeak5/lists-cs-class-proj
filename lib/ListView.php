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
    public static function RenderShoppingList($list = NULL) {
        $shoppingList = null;
        if (!empty($list)) {
            foreach ($list as $store => $items) {
                //	echo "\$store";
                //	krumo($store);
                $storeTotal = 0;
                $listHead = "";
                $listHead.="<span class=\"heading\"><strong>" . $store;
                $listBody = "<ul>";
                foreach ($items as $item) {
                    $listBody.="<li class=\"litem\"><strong>{$item->item}</strong>&nbsp;(\${$item->price_estimate})";
                    $listBody.="&nbsp;<a class=\"deleteme\" href=\"javascript:confirmDelete('delete.php?ShoppingList=" . urlencode($item->id) . "')\">delete</a>";
                    $listBody.="&nbsp;<a class=\"editme\" href=\"index.php?ShoppingList=" . urlencode($item->id) . "\">edit</a>";
                    $storeTotal+=isset($item->price_estimate) ? $item->price_estimate : 0;
                    $listBody.=(strlen($item->description) > 0) ? "<br/><span class=\"description\"> " . $item->description . "</span>" : "";
                    $listBody.="</li>";
                }
                $listHead.="</strong><span class=\"aggregate\">&nbsp;&nbsp;(\$" . $storeTotal . ")</span></span>";
                $listBody.="</ul>";
                $shoppingList = $listHead . $listBody;
            }
        }
        return $shoppingList;
    }

}

?>
