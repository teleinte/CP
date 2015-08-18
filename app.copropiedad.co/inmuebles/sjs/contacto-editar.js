$(document).ready(function(){

  $(document).renderme('in');

  // Traer los datos de los contactos a modificar
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/usuario/personaid", arr);
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['rg']}};
  var inmueble = traerDatosSync("unidad/unidad/copropiedadid/", arr);
  // alert(JSON.stringify(datos));
  // Popula los datos en los campos del formulario para cambiarlos
  popularDatosUsuario(datos, inmueble);

// envia los nuevos cambios al WS para insertarlos
$("#modificar-usuario").submit(function(event){  
  event.preventDefault();
	var ParamFecha=fecha();  
  $('input[type=submit]').attr('disabled',true);
  if($('#principal').val()=="true"){ var principal = true}
  if($('#principal').val()=="false"){ var principal = false}
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      id:$('#id_usuario').val(),
      creado_por:$('#creado_por').val(),
      fecha_creacion:$('#fecha_creacion').val(),
      id_copropiedad:$('#id_copropiedad').val(),
      id_crm_persona:$('#id_crm_persona').val(),
      nombre:$('#nombre').val(),                                                    
      telefono:$('#telefono').val(),      
      email:$('#email').val(),      
      unidad:$('#unidad').val(),
      perfil:$('#perfil').val(),
      tipo:$('#tipo').val(),
      estado:parseInt($('#estado').val()),
      grupo:$('#grupo').val(),
      principal:principal
    }
  };
  var url = "admin/copropiedad/usuario/";  
  var response = envioFormularioSync(url,arr,'PUT');
  if(response)
  {
      var pagina="inmueble-editar.php?idt="+params['rg'];
      setTimeout(refreshWindow(pagina),1000);
  }
  });

  $(document).renderme('in');
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



