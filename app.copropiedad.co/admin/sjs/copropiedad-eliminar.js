$(document).ready(function(){

  $(document).renderme('ccp');

  $('#alertas').html('<div class="alert alert-dismissable alert-warning" style="height:405x;" teid="ale:html:130"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:129"></strong> </div>')
  $(document).renderme('ale');


// Proceso para traer los datos de los inmuebles creados
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt'],tipo:"tarea"}};


  //var arr = {token:sessionStorage.getItem('token'),body:{id_unidad:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/copropiedad/getlistFilter", arr);
  
  //llenando la tabla popular
  popularDatosModificables(datos);

  $("#copropiedad_form_editar").submit(function(event){
    $("#cpEliminando").show();
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    event.preventDefault();
    if($("#opcion").val()=="NO")
    {
        var pagina="index.php";
        setTimeout(refreshWindow(pagina),1000);
        return false;
    }
    event.preventDefault();
    var ParamFecha=fecha();
    $('input[type=submit]').attr('disabled',true);
    //Paso numero uno. traer los usuarios de esa copropiedad

    var url = "admin/copropiedad/usuario/copropiedad/";
    var arr = {token:sessionStorage.getItem('token'),body:{ id_copropiedad:params['idt']}};
    var response = envioFormularioMessageSync(url,arr,'POST');
    //var datos=JSON.stringify(response); 
    var usuarios=Array();
    var email=Array();
    //alert(JSON.stringify(response["message"]));
    if(response["message"]!=null)
    {
      $.each(response["message"], function(x , y)
      {
        //eliminando de rolCP los datos
        var arr1 = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_crm_persona:parseInt(y["id_crm_persona"]),
            id_unidad:y["unidad"]
          }
        };
        var url = "admin/copropiedad/usuario/persona/eliminar"; 
        var response = envioFormularioMessageSync(url,arr1,'DELETE');
        //esta es la de usuario CP

        var url = "admin/copropiedad/usuario/personamasa/eliminar/";
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            personas:y["id_crm_persona"],
            id_unidad:y["unidad"]
          }
        };        
        var response = envioFormularioSync(url,arr,'PUT');

        //en este pedaso hay que meter el cambio de rol si se necesita o sino seguir igual que antes
        var estado= verificarEstadoCP(y["email"],sessionStorage.getItem('token'))
        var contadorResidente=0;
        var contadorAdmin=0;
        if(estado==2)
        {
          var perfiles=checkPerfilesUser(traerDireccion(),y["email"])
          console.log(perfiles)
          $.each(perfiles, function(b , c){
            $.each(c, function(gamma , delta){        
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
            var arr = {token:sessionStorage.getItem("token"), body:{email:y["email"],estado:1,id_crm_persona:parseInt(y["id_crm_persona"])}};
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
                  var paso="";                                             
                }
            });
          }
          if(contadorResidente>0 && contadorAdmin<=0 )
          {
            var arr = {token:sessionStorage.getItem("token"), body:{email:y["email"],estado:3,id_crm_persona:parseInt(y["id_crm_persona"])}};
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
                  var paso="";
                }
            });
          }
        }

        
        //////////////////////////////////////////////////////////////////////////////////

        $.each(y, function(alfa , beta)
          {
            if(alfa=="id_crm_persona")
            {
              usuarios.push(beta);                          
            }
            if(alfa=="email")
            {
              email.push(beta);            
            }
          }
        );
      });
      enviocorreoDespedida("https://appdes.copropiedad.co", email, $('#nombre').val())
      enviocorreoDespedidaCopropiedad("https://appdes.copropiedad.coo", "copropiedad.eliminada@copropiedad.co", $('#nombre').val(),params['idt'])

       
      //eliminando la copropiedad ///////////////////////////
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
      var checked = [1,2,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];        
      var arr = 
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          id:params['idt'],
          id_crm_persona: $('#id_crm_persona').val(),
          fecha_creacion:$('#fecha_creacion').val(),
          nombre:$('#nombre').val(),
          direccion:$('#direccion').val(),
          telefono:$('#telefono').val(),
          nit:$('#nit').val(),
          ciudad:$('#ciudad').val(),        
          estado:2,
          modulos_activos:checked,
          referencia : $('#referencia').val(),
          vigencia : $('#vigencia').val(),
          pagosonline : $('#pagosonline').val()        
        }
      }; 
      var url = "copropiedad";
      var response = envioFormularioSync("admin/copropiedad/copropiedad/",arr,"PUT");
      if(response)
      {
          var pagina="index.php";
          setTimeout(refreshWindow(pagina),1000);
      }
      
    }
    else
    {
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
        var checked = [1,2,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];        
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id:params['idt'],
            id_crm_persona: $('#id_crm_persona').val(),
            fecha_creacion:$('#fecha_creacion').val(),
            nombre:$('#nombre').val(),
            direccion:$('#direccion').val(),
            telefono:$('#telefono').val(),
            nit:$('#nit').val(),
            ciudad:$('#ciudad').val(),        
            estado:2,
            modulos_activos:checked,
            referencia : $('#referencia').val(),
            vigencia : $('#vigencia').val(),
            pagosonline : $('#pagosonline').val()        
          }
        }; 
        var url = "copropiedad";
        enviocorreoDespedidaCopropiedad("https://appdes.copropiedad.co", "copropiedad.eliminada@copropiedad.co"," "+ $('#nombre').val()+" Telefono: "+$('#telefono').val(),params['idt'])
        var response = envioFormularioSync("admin/copropiedad/copropiedad/",arr,"PUT");
        if(response)
        {
            var pagina="index.php";
            setTimeout(refreshWindow(pagina),1000);
        }
    }
    

    });

  $(document).renderme('ccp');
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