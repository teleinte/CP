(function( $ ) {
    $.fn.minicart = function( option, aux ) {
    	switch(option)
    	{
    		case "init":
		    	return this.each(function(){
					$(this).append(checkCart("artículos"));	
		    	});
		    break;

		    case "shopify":
    	    	$(document).on("click", this.selector, function (event) {
    	    	    event.preventDefault();
    	    	    
    		       	if(localStorage.getItem("minicart") === null || localStorage.getItem("minicart") === undefined)
    	    		{
    	       			var items = Array();
    	       			var cart = Array();
    	    			var expires = new Date();
    	    			expires.setDate(expires.getDate() + 7);
    	       			cart["expiration"] = expires;

    	    			items[$(event.currentTarget).attr('reference')] =
	    				{
       						name : $(event.currentTarget).attr('name'),
       						price : Number($(event.currentTarget).attr('price')),
       						quantity : Number($(event.currentTarget).attr('quantity'))
       					}
    	       			console.log(JSON.stringify(items));

    	       			localStorage.setItem('minicart',JSON.stringify(cart));
    	    		}
    	    		else
    	    		{
    		       		var cart = JSON.parse(localStorage.getItem('minicart'));
    	    			
    	    			var expires = new Date();
    	    			expires.setDate(expires.getDate() + 7);
    		       		cart["expiration"] = expires;
    		       		
    		       		if(cart["items"][$(event.currentTarget).attr('reference')] === undefined)
    		       		{
    		       			var item =
		    				{
	       						name : $(event.currentTarget).attr('name'),
	       						price : Number($(event.currentTarget).attr('price')),
	       						quantity : Number($(event.currentTarget).attr('quantity'))
	       					}

	       					var ref = $(event.currentTarget).attr('reference');
		   					cart["items"][ref] = [];
			       			cart["items"][ref] = item;
    		       		}
    		       		else
    		       		{
    		       			cart["items"][$(event.currentTarget).attr('reference')]['quantity'] = $(event.currentTarget).attr('quantity') + cart["items"][$(event.currentTarget).attr('reference')]['quantity'];
    		       		}

    		       		localStorage.setItem('minicart',JSON.stringify(cart));
    	     		}
					$(document).find(aux).html(checkCart("artículos"));
    	    	});

    	    	return this;
    	    break;

    	    case "checkout":
    	    	var items = Array();
    	    	var totalqty = 0;
    	    	var totalamo = 0;
    	    	var idx = 0;

    	    	$.each(JSON.parse(localStorage.getItem("minicart"))["items"],function(k,v){
    	    		if(items[v["reference"]] === undefined)
    	    		{
    	    			items[v["reference"]] = v;
    	    			totalqty = totalqty + v["quantity"];
    	    			totalamo = totalamo + v["price"];
    	    		}
    	    		else
    	    		{
    	    			var thisitem = items[v["reference"]];
    	    			thisitem["quantity"] = thisitem["quantity"] + v["quantity"];
    	    			items[v["reference"]] = thisitem;
    	    			totalqty = totalqty + v["quantity"];
    	    			totalamo = totalamo + v["price"];
    	    		}
    	    	});

    	    	var actual = Number(totalamo);
    	    	var convertido = '$ ' + actual.toLocaleString('es-CO', { style: 'currency', currency: 'COP'});

    	    	var info = {"totalqtyref" : calculateArrayLenght(items),"totalitems" : totalqty, "totalamount" : convertido};
    	    	items["info"]= info;

    	    	return items;
    	    break;

    	    case "update":
    	    	$(document).on("click", this.selector, function (event) 
    	    	{
    	    		event.preventDefault();

		       		var cart = JSON.parse(localStorage.getItem('minicart'));
		       		var items = cart["items"];

		       		$.each($(aux),function(){
		       			var mod = $(this).val();
		       			var ref = $(this).attr('ref');
		       			var newitems = Array();
		       			
		       			for (var i = items.length - 1; i >= 0; i--) 
		       			{
		       				if(items[i]['reference'] == ref && mod)
		       				{
		       					newitems.push(items[i]);
		       				}
		       				items.pop(items[i]);
		       			};

		       			console.log(newitems);
		       			console.log(mod);
		       			console.log(ref);
		       			console.log(items);
		       		});

		       		localStorage.setItem('minicart',JSON.stringify(cart));

	    	    });
	    	    
	    	    return this;
    	    break;
    	}
    };

    function checkCart(word)
    {
    	if(localStorage.getItem("minicart") === null || localStorage.getItem("minicart") === undefined)
 		{
 			return "0 " + word;
 		}
 		else
 		{
        	var actualcart = JSON.parse(localStorage.getItem("minicart"));
 			return reviewCart() + word;
 		}
    }

    function reviewCart()
    {
		return 99;JSON.parse(localStorage.getItem("minicart"))["items"].length + " ";
    }

    function calculateArrayLenght(items)
    {
    	Object.size = function(obj) {
    	    var size = 0, key;
    	    for (key in obj) {
    	        if (obj.hasOwnProperty(key)) size++;
    	    }
    	    return size;
    	};

    	// Get the size of an object
    	var size = Object.size(items);
    	return size;
    }
}( jQuery ));