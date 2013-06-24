<?php

class ShoppingList extends ListItem{

    public $id;
    public $item;
    public $store="";
    public $description="";
    public $price_estimate=1;
    public $who="";
    public $deadline;
    public $timestamp;



    public function toHTML() {
        $label = "<span class=\"label\">".$this->item."</span>";
        $desc  = "<span class=\"description\">".$this->description."</span>";
        $price = "<span class=\"price\">{".$this->price_estimate.")</span>";
        $spc = "&nbsp;";
        $br = "<br/>";
        return $label.$spc.$price.$spc.$desc;
    }
}