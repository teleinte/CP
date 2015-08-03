$(document).ready(function(){

  $(document).renderme('in');

// Proceso para traer los datos de los inmuebles creados
  $('#alertas').html('<div class="alert alert-dismissable alert-warning" style="height:405x;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Advertencia: Tenga en cuenta que los contactos asociados al inmueble dejarán de ver la información de la copropiedad si no están asociados a otro inmueble.</div>')
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datosUsuario = traerDatosSync("unidad/unidad/copropiedadid", arr);
  // popula los datos de usuario para poderlos modificar en tabla
  popularDatosModificables(datosUsuario);
  $(document).renderme('in');


  $("#form-inmueble-eliminar").submit(function(event){
    $("#cpEliminando").show();
    if($("#opcion").val()=="NO"){var pagina="index.php";setTimeout(refreshWindow(pagina),1000);return false;}
    event.preventDefault();
    var ParamFecha=fecha();
    $('input[type=submit]').attr('disabled',true);

    //Paso numero uno. traer los usuarios de dicho inmueble si los tiene

    var url = "admin/copropiedad/usuario/unidad/";
    var arr = {token:sessionStorage.getItem('token'),body:{ id_unidad:$('#id_unidad').val()}};
    var response = envioFormularioMessageSync(url,arr,'POST');
    //var datos=JSON.stringify(response);
    //alert(JSON.stringify(response))
    var usuarios=Array();    
    $.each(response["message"], function(x , y)
    {
      var correo=y["email"];
      $.each(y, function(alfa , beta) 
        {

          if(alfa=="id_crm_persona")
          {
            usuarios.push(beta);
            //eliminando de rolCP los datos
            var arr1 = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id_crm_persona:parseInt(beta),
                id_unidad:$('#id_unidad').val()
              }
            };
            var url = "admin/copropiedad/usuario/persona/eliminar"; 
            var response = envioFormularioMessageSync(url,arr1,'DELETE');


            //paso para eliminando datos pasa a estado dos de la usuarioCP
            var url = "admin/copropiedad/usuario/personamasa/eliminar/";
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                personas:beta,
                id_unidad:$('#id_unidad').val()
              }
            };
            var response = envioFormularioSync(url,arr,'PUT');





            
            /// aqui debo verificar para el cambio de estado en cp en caso de que lo necesite aqui ya va pasando por usuario

            //en este pedaso hay que meter el cambio de rol si se necesita o sino seguir igual que antes
            var estado= verificarEstadoCP(correo,sessionStorage.getItem('token'))
            var contadorResidente=0;
            var contadorAdmin=0;
            if(estado==2)
            {
              var perfiles=checkPerfilesUser(traerDireccion(),correo)
              console.log(perfiles)
              $.each(perfiles, function(a , b){
                $.each(b, function(gamma , delta){                  
                  if(delta["rol"]=="residente")
                  {
                    contadorResidente++;
                  }
                  if(delta["rol"]=="administrador")
                  {
                    contadorAdmin++;
                  }
                });
              });
              if(contadorResidente<=0 && contadorAdmin>0 )
              {
                var arr = {token:sessionStorage.getItem("token"), body:{email:correo,estado:1,id_crm_persona:parseInt(beta)}};
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
                      var nada="";                                             
                    }
                });
              }
              if(contadorResidente>0 && contadorAdmin<=0 )
              {
                var arr = {token:sessionStorage.getItem("token"), body:{email:correo,estado:3,id_crm_persona:parseInt(beta)}};
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
                      var nada="";
                    }
                });
              }
            }  
            };
          });
      });
    //});

    
    if (response="Okay")
    {
        //cambiar el estado a la unidad en unidades por estado 2
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id:$('#id_unidad').val(),
            id_copropiedad: $('#id_copropiedad').val(),
            id_crm_persona:$('#id_crm_persona').val(),
            tipo_documento : "inmueble",
            tipo_unidad:$('#tipo_unidad').val(),
            nombre_inmueble:$('#nombre_inmueble').val(),      
            estado:"2",
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
    $(document).renderme('in');
});