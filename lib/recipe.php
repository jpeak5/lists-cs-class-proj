<?php
interface food_group {
    
}

interface container {

}

/**
 * @class recipe 
 * a recipe combines multiple components
 * a foreword (once more into thte breech)
 * a list or dependencies
 * a set of instructions
 * A recipe is an intersection of taste, economics, logistics
 */
class recipe {

    public string   $foreword;
    public array    $dependencies;
    public array    $instructions;

}


class recipe_dependency extends pantry_item implements pantry_item_category {

    

}

?>
