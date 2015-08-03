(function( $ ) {
    $.fn.renderme = function(modid, lang) {
 		return this.each(function(){
	        var PageTexts = "";
	        	if(lang === undefined || lang === null)
	        		PageTexts = JSON.parse(localStorage.getItem($('html').attr('lang')));
	        	else
	        		PageTexts = JSON.parse(localStorage.getItem(lang));

	    	$.each($('[teid]'),function(){
	    		id = $(this).attr('teid');
	    		elem = $(this);
	    		var attribs = id.split(',');
	    		$.each(attribs,function(k,v){
	    			thisPage = v.split(':')[0].trim();
	    			thisType = v.split(':')[1];
	    			thisId = Number(v.split(':')[2]);
                    console.log(thisPage + ":" + thisId + ":" + thisType + ":" + PageTexts[thisPage][thisId]);
    				switch (thisType)
    				{
    					case "html":
                            elem.append(PageTexts[thisPage][thisId]);
    						elem.removeAttr('teid');
    					break;

    					case "val":
    						elem.val(PageTexts[thisPage][thisId]);
    						elem.removeAttr('teid');
    					break;

    					case "title":
    						elem.attr('title',(PageTexts[thisPage][thisId]));
    						elem.removeAttr('teid');
    					break;

    					default:
    						elem.html(PageTexts[thisPage][thisId]);
    					break;
    				}
	    		});
	    	});
	    }); 
    };
}( jQuery ));