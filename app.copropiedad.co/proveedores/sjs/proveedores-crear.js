$(document).ready(function(){

    $(document).renderme('pr');

 // funcion de la creacion automatica de usuarios para un inmueble 
  var iCnt = 0;
  // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
  var container = $(document.createElement('div')).css({
  padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
  });
  $('#btAdd').click(function() {
      if (iCnt <= 19) {
          iCnt = iCnt + 1;
          // ADD TEXTBOX.
          $(container).append('<div id="pregunta' + iCnt + '" class="clearfix" style="padding: 20px 10px 0; border:3px solid #eee; margin-bottom:10px;"><table><tr><td><label for="nombre' + iCnt + '" teid="pr:html:9"></label><input type="text" id="nombre' + iCnt + '" name="nombre' + iCnt + '" required></td><td><label for="apellido' + iCnt + '" teid="pr:html:10"></label><input type="text" id="apellido' + iCnt + '" name="apellido' + iCnt + '" required></td><td><label for="telefono' + iCnt + '" teid="pr:html:11"></label><input type="tel" id="telefono' + iCnt + '" name="telefono' + iCnt + '" required></td></td><td><label for = "email' + iCnt + '" teid="pr:html:12"></label><input type = "email" id="email' + iCnt + '" name="email' + iCnt + '" required></td></tr></table></div>');
          $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
          $('#btRemove').attr('class', 'btn icono agregar ttip');
          $('#pregunta0').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            $(document).renderme('pr');
      }
      else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
          $(container).append('<label class="limite-preg" teid="pr:html:16"></label>');
          $(document).renderme('pr');
          $('#btAdd').attr('class', 'btn icono agregar disabled ttip'); 
          $('#btAdd').attr('disabled', 'disabled');
      }
  });
  $('#btRemove').click(function() 
  {   // REMOVE ELEMENTS ONE PER CLICK.
      if (iCnt != 0) 
      { 
        $('#pregunta' + iCnt).remove(); 
        iCnt = iCnt - 1; 
        $('.limite-preg').remove();
        $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
        $('#btRemove').attr('class', 'btn icono agregar ttip'); 

      }
      if (iCnt == 0) 
      { 
        $(container).empty(); 
        $(container).remove();
        $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
        $('#btRemove').attr('class', 'btn icono agregar ttip'); 

      }
      if (iCnt <= 20) 
      {
        $('#btAdd').removeAttr('disabled');
        $('#btAdd').attr('class', 'btn icono agregar ttip positivo');
      }
  });

// funcion para envio de formulario y creacion de usuarios
$("#proveedor_form").submit(function(event){
  event.preventDefault();
  var ParamFecha=fecha();
    //  crear el inmueble de la copropiedad
    $('input[type=submit]').attr('disabled',true);
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_copropiedad: sessionStorage.getItem('cp'),        
        id_crm_persona:sessionStorage.getItem('id_crm'),
        tipo_documento:"proveedor",
        tipo_unidad:"privada",
        nombre_inmueble:$('#nombre_inmueble').val(),
        estado:1,
        nit:$('#nit').val(),
        fecha_creacion:ParamFecha,
      }
    }; 

    var url = "unidad/unidad";
    var response = envioFormularioMessageSync(url,arr,'POST');    
    var msgDividido = JSON.stringify(response);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message);    
    
    if(response)
    {
        $.each(mensaje.message, function(x , y){ sessionStorage.setItem("insertado",y);});
        retornado=sessionStorage.getItem("insertado");
        //creamos el usuario en copropiedad
        var id_crm=Math.floor((Math.random() * 100000000000) + 1);
        sessionStorage.setItem('id_crmPro',id_crm)
        var url = "admin/copropiedad/usuario";
        var tipo="";
        if($('#proveedor').prop('checked')){tipo = "proveedor";}else{tipo = "residente";}
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            creado_por: sessionStorage.getItem('id_crm'),
            fecha_creacion:ParamFecha,
            id_copropiedad:sessionStorage.getItem('cp'),
            id_crm_persona:id_crm,
            nombre:$('#nombre0').val()+" "+$('#apellido0').val(),
            telefono:$('#telefono0').val().replace(' ',''),       
            email:$('#email0').val().replace(' ','').toLowerCase(),
            unidad:retornado,
            perfil:"proveedor",
            grupo:"proveedor",
            tipo:"proveedor",
            estado:1,
          }
        };

        var responseUsuario = envioFormularioMessageSync(url,arr,'POST');
        var msgDividido = JSON.stringify(responseUsuario);
        var mensaje =  JSON.parse(msgDividido);
        var msgDivididoDos = JSON.stringify(mensaje.message);
        $.each(mensaje.message, function(x , y){ sessionStorage.setItem("insertadoUsuario",y);});
        var retornadoUsuario=sessionStorage.getItem("insertadoUsuario");

        //registramos el rol de la persona creada:
        var arr = 
        {
            token:sessionStorage.getItem('token'),
            body:
            {
                id_crm_persona: id_crm,
                id_copropiedad:sessionStorage.getItem('cp'),
                correo:$('#email0').val().replace(' ','').toLowerCase(),
                nombre:sessionStorage.getItem('ncp'),
                rol:"proveedor",
                imagen:""
            }
        };
        var url = "admin/copropiedad/rol";        
        var personalrol = envioFormularioSync(url,arr,'POST');
        
        // creamos los usuarios automaticos        
        for (j=1;j<20;j++)
        {
            if(!$('#nombre'+j).val())
            {
                break;
            }

            var id_crm=Math.floor((Math.random() * 1000) + 1);
            sessionStorage.setItem('id_crmPro',id_crm)
            //registramos el rol de la persona creada:
            var arr = 
            {
                token:sessionStorage.getItem('token'),
                body:
                {
                    id_crm_persona: id_crm,
                    id_copropiedad:sessionStorage.getItem('cp'),
                    correo:$('#email'+j).val().toLowerCase(),
                    nombre:sessionStorage.getItem('ncp'),
                    rol:"proveedor",
                    imagen:""
                }
            };
            var url = "admin/copropiedad/rol";        
            var personalrol = envioFormularioSync(url,arr,'POST');          
            // regostramos la nueva persona creada
            var url = "admin/copropiedad/usuario";
            var tipo="";
            if($('#proveedor').prop('checked')){tipo = "proveedor";}else{tipo = "residente";}
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                creado_por: sessionStorage.getItem('id_crm'),
                fecha_creacion:ParamFecha,
                id_copropiedad:sessionStorage.getItem('cp'),
                id_crm_persona:id_crm,
                nombre:$('#nombre'+j).val()+" "+$('#apellido'+j).val(),
                telefono:$('#telefono'+j).val(),                
                email:$('#email'+j).val().toLowerCase(),                
                unidad:retornado,
                perfil:"proveedor",
                tipo:"proveedor",
                estado:1,
                grupo:"proveedor"
              }
            };
            envioFormularioMessageSync(url,arr,'POST');
        }
        var pagina="index.php";
        setTimeout(refreshWindow(pagina),1000);
    }
    else
    {      
      $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
    }
  });

  $(document).renderme('pr');
  $(document).renderme('ale');
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


