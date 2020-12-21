$(document).ready(function() 
{
        var winWidth = $(window).width();
        if(winWidth<1000)
        {
          $(".navbar-collapse.collapse ul").css("background-color", "#bedbbb");
        }

        
        $(window).resize(function()
        {
    		var winWidth = $(window).width();
    		console.log(winWidth);
    		var isVisible = $( ".collapse" ).is( ":visible" );
    		console.log(isVisible);
    		if(isVisible && winWidth>1000)
	        {
	        	console.log("Larger Screen");
	        	$(".navbar-collapse.collapse ul").css("background-color", "transparent");
	        	$(".navbar-collapse.collapse .nav-link").css("color", "white"); 
	        }
	        if(!isVisible || winWidth<1000)
	        {
	        	console.log("Smaller screen");
	        	$(".navbar-collapse.collapse ul").css("background-color", "#bedbbb"); //d0e8f2
	        	$(".navbar-collapse.collapse .nav-link").css("color", "black");
	        }

    	});
});