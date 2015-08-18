$(document).ready(function(){

  $(document).renderme('ctp');
  
  // Traer los datos de los contactos a eliminar
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datos = traerDatosSync("unidad/unidad/copropiedadid", arr);
  // Popula los datos en los campos del formulario para cambiarlos
  popularDatosModificables(datos);

// envia los datos a eliminaral WS
$("#usuario_form_eliminar").submit(function(event){ 
  event.preventDefault();
	var ParamFecha=fecha();
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  $('input[type=submit]').attr('disabled',true);

  if($('#opcion').val()=="NO"){var pagina="index.php";setTimeout(refreshWindow(pagina),1000);return false;}
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      id:params['idt'],
      id_copropiedad: $('#id_copropiedad').val(),
      id_crm_persona:$('#id_crm_persona').val(),
      tipo_documento : "proveedor",
      tipo_unidad:$('#tipo_unidad').val(),
      nombre_inmueble:$('#nombre_inmueble').val(),      
      estado:2,
      nit:$('#nit').val(),
      fecha_creacion:$('#fecha_creacion').val()
    }
  };
  var url = "unidad/unidad";  
  var response = envioFormularioSync(url,arr,'PUT');
  if(response)
  {
      var pagina="index.php";
      setTimeout(refreshWindow(pagina),1000);
  }
});
  $(document).renderme('ctp');
  $(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});