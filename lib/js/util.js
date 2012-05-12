/* attach a submit handler to the form */
$("#toggle").click(function(event){
    console.log("beginning the script");
    
    /* stop form from submitting normally */
    event.preventDefault();
    
    /* get some values from elements on the page: */
    var $currentState = $(this), 
	state = $currentState.attr("class"), 
	url = "form.php";
    console.log("currentState= "+$currentState.attr("class"));
    
    /* Send the data using post and put the results in a div */
    $.post(url, {
        form: state
    }, function(data){
        var content = $(data);
        $("#mutableForm").empty().html(content);
		if($currentState.attr("class")=="shopping"){
			$currentState.attr("class", "todo")
			$currentState.html("TODOs")
		}else{
			$currentState.attr("class", "shopping")
			$currentState.html("Shopping")
		}
		
    });
	
});