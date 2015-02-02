// STYLESHEET SWITCHER
/*$(document).ready(function($)
	{
		//  All Alternate stylesheets Selector
		var $links = $('link[rel*=alternate][title]');
		
		$('#contenido-principal').append('<div id="toolbar" style="text-align:center; margin-top:20px;"><select id="css-selector"></select></div>');
		var options= '<option value="">Seleccione hoja de estilos:</option>';
		$links.each(function(index,value){
			options +='<option value="'+$(this).attr('href')+'">'+$(this).attr('title')+'</option>';
		});
		$links.remove();
		
		$('#css-selector').append(options)
			.bind('change',function(){
			$('link[rel*=jquery]').remove();
			$('head').append('<link rel="stylesheet jquery" href="'+$(this).val()+'" type="text/css" />');
		});
		
	}
)(jQuery);*/

$(document).ready(function($)
	{
		cambioEstilos();
		
		$(".selector-copropiedad li").click(function() {
			cambioEstilos();
		});
	}
)(jQuery);

function cambioEstilos(){
			$("img[src*='color1']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color1.css" type="text/css" />');
				}
			});
			$("img[src*='color2']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color2.css" type="text/css" />');
				}
			});
			$("img[src*='color3']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color3.css" type="text/css" />');
				}
			});
			$("img[src*='color4']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color4.css" type="text/css" />');
				}
			});
			$("img[src*='color5']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color5.css" type="text/css" />');
				}
			});
			$("img[src*='color6']").each(function () {
				if($(this).parent().attr('id')  == "copropiedad_title") {
					$('head').append('<link rel="stylesheet jquery" href="css/color6.css" type="text/css" />');
				}
			});
}