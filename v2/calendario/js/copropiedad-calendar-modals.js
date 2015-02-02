$(function() {
			$( "#tabs" ).tabs();
		  });
		$(function() {  
		  	$( ".modal" ).dialog({
				autoOpen: false,
				modal: true
				})
			$( "#borrartarea" ).dialog({
				buttons: {
					"No, cancelar": function() {
					  $( this ).dialog( "close" );
					},
					"Si, borrarla": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			$( "#open-borrartarea" ).click(function() {
			  $( "#borrartarea" ).dialog( "open" );
			});
			$( "#detallestarea" ).dialog({
				width: 420, //Cambiar ancho del modal. Por defecto es 300
				buttons: {
					"Completar Tarea": function() {
					  $( this ).dialog( "close" );
					},
					"Editar Tarea": function() {
					  $( this ).dialog( "close" );
					}
				  },
				open:function () {// Agregarle al primer botón la clase icono completar
						$(this).closest(".ui-dialog")
						.find(".ui-button:first") 
						.addClass("icono completar");
					}
				});
			$( "#open-detallestarea" ).click(function() {
			  $( "#detallestarea" ).dialog( "open" );
			});
			$( "#creartarea" ).dialog({
				width: 500, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form
				buttons: [ { text: "Crear Tarea", click: function() { $( this ).trigger("add-alerts", [
				  {
					message: "Elemento creado satisfactoriamente",
					priority: "success"
				  } ]); } } ,
				  { text: "Cerrar", click: function() { $( this ).dialog( "close" ); } } 
				  ]
				});
			$( "#open-creartarea" ).click(function() {
			  $( "#creartarea" ).dialog( "open" );
			});
		});