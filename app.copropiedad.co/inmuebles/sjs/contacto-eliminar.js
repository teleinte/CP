$(document).ready(function(){

  $(document).renderme('ct');

  // Traer los datos de los contactos a eliminar
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/usuario/personaid", arr);
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['rg']}};
  var inmueble = traerDatosSync("unidad/unidad/copropiedadid/", arr);
  // Popula los datos en los campos del formulario para cambiarlos
  popularDatosUsuario(datos, inmueble);

// envia los datos a eliminaral WS
$("#usuario_form_eliminar").submit(function(event){ 
  $("#cpEliminando").show();
  event.preventDefault();
	var ParamFecha=fecha();  
  $('input[type=submit]').attr('disabled',true);
  if($('#opcion').val()=="NO"){var pagina="inmueble-editar.php?idt="+params['rg'];setTimeout(refreshWindow(pagina),1000);return false;}
  //cambio de estado en la coleccion usuario CP
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
      estado:2,
      grupo:$('#grupo').val(),
      principal:$('#principal').val()
    }
  };
  var url = "admin/copropiedad/usuario/"; 
  var response = envioFormularioMessageSync(url,arr,'PUT');
  //tengo que eliminar con cuidado el usuario de RolCP pilas solo ese usuario eliminarlo  
  var arr1 = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      id_crm_persona:parseInt($('#id_crm_persona').val()),
      id_unidad:$('#unidad').val()      
    }
  };
  var url = "admin/copropiedad/usuario/persona/eliminar"; 
  var response = envioFormularioMessageSync(url,arr1,'DELETE');
  

  //en este pedaso hay que meter el cambio de rol si se necesita o sino seguir igual que antes
  var estado= verificarEstadoCP($('#email').val(),sessionStorage.getItem('token'))
  var contadorResidente=0;
  var contadorAdmin=0;
  if(estado==2)
  {
    var perfiles=checkPerfilesUser(traerDireccion(),$('#email').val())
    console.log(perfiles)    
    $.each(perfiles, function(x , y){
      $.each(y, function(alfa , beta){        
        if(beta["rol"]=="residente")
        {
          contadorResidente++;
        }
        if(beta["rol"]=="administrador")
        {
          contadorAdmin++;
        }
      });
    });
    if(contadorResidente<=0 && contadorAdmin>0 )
    {
      var arr = {token:sessionStorage.getItem("token"), body:{email:$('#email').val().toLowerCase(),estado:1,id_crm_persona:parseInt($('#id_crm_persona').val())}};
      var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/estados/";
      $.ajax({
          url: rutaAplicativoCP,
          type: "PUT",
          data: JSON.stringify(arr),
          contentType: 'application/json; charset=utf-8',
          dataType: 'json',
          async: false,
          success: function(data) 
          {
            var pagina="inmueble-editar.php?idt="+params['rg'];
            setTimeout(refreshWindow(pagina),1000);                                             
          }
      });
      var pagina="inmueble-editar.php?idt="+params['rg'];
      setTimeout(refreshWindow(pagina),1000);
    }    
    if(contadorResidente>0 && contadorAdmin<=0 )
    {
      var arr = {token:sessionStorage.getItem("token"), body:{email:$('#email').val().toLowerCase(),estado:3,id_crm_persona:parseInt($('#id_crm_persona').val())}};
      var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/estados/";
      $.ajax({
          url: rutaAplicativoCP,
          type: "PUT",
          data: JSON.stringify(arr),
          contentType: 'application/json; charset=utf-8',
          dataType: 'json',
          async: false,
          success: function(data) 
          {
            var pagina="inmueble-editar.php?idt="+params['rg'];
            setTimeout(refreshWindow(pagina),1000);
          }
      });
      var pagina="inmueble-editar.php?idt="+params['rg'];
      setTimeout(refreshWindow(pagina),1000);
    }
    var pagina="inmueble-editar.php?idt="+params['rg'];
    setTimeout(refreshWindow(pagina),1000);
    
  }
  else
  {
    var pagina="inmueble-editar.php?idt="+params['rg'];
    setTimeout(refreshWindow(pagina),1000);
  }
  });
  //////////////////////////////////////////////////////////////////////////////////
  $(document).renderme('in');
});