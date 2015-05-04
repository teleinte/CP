	$(document).ready(function(){
		$("#nuevos").click(function(){
			$("#new-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
	});	
	$(document).ready(function(){
		$("#pendientes").click(function(){
			$("#pending-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
	});
	$(document).ready(function(){
		$("#aplicacionesDos").click(function(){
			$("#app-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
	});




