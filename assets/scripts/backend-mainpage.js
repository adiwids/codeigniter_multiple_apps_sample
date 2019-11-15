$(document).ready(
	function()
	{
		//$(window).bind("resize", fit_to_viewport());
	}
);

//function initpage(){}

function fit_to_viewport()
{
	var viewport = $(window);
	var toolbar = $(".toolbar");
	var sidepanel = $(".sidepanel");
	var center = $(".center");
	
	var content_height = viewport.height() - toolbar.height();
	
	sidepanel.height(content_height);
	center.height(content_height);
}
