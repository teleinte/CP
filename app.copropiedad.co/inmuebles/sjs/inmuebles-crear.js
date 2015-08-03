$(document).ready(function(){

  $(document).renderme('in');
  $(document).renderme('ale');

 // funcion de la creacion automatica de usuarios para un inmueble 
  var iCnt = 0;
  // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
  var container = $(document.createElement('div')).css({
  padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
  });
  $(document).renderme('in');
  $('#btAdd').click(function() {
          
      if (iCnt <= 19) {
          iCnt = iCnt + 1;
          // ADD TEXTBOX.
          $(container).append('<div id="pregunta' + iCnt + '" class="clearfix" style="padding: 20px 10px 0; border:3px solid #aaa; margin-bottom:10px; background-color:#eee"><table><tr><td><label for="nombre' + iCnt + '" teid="in:html:9"></label> <input type="text" id="nombre' + iCnt + '" name="nombre' + iCnt + '" required></td><td><label for="apellido' + iCnt + '" teid="in:html:10"></label> <input type="text" id="apellido' + iCnt + '" name="apellido' + iCnt + '" required></td></tr><tr></tr><tr><td><label for="telefono' + iCnt + '" teid="in:html:11"></label><input type="number" id="telefono' + iCnt + '" name="telefono' + iCnt + '" required="" style="width:95%" pattern="(\+?\d[- .]*){7,13}" class="tooltip" data-hasqtip="3" oldtitle="Este campo debe contener solo numeros, con longitud de 7 a 10 caracteres" aria-describedby="qtip-3"></td><td><label for = "email' + iCnt + '" teid="in:html:12"></label><input type = "email" id="email' + iCnt + '" name="email' + iCnt + '" required></td></tr><tr><td><label for="grupo' + iCnt + '" teid="in:html:13"></label> <select name="grupo' + iCnt + '" id="grupo' + iCnt + '"> <option value="residente" teid="in:html:14"></option> <option value="consejo" teid="in:html:15"></option> <option value="asamblea" teid="in:html:16"></option> </select></td><td><label for="principal' + iCnt + '" teid="in:html:17"></label><input type="radio" name="principal0" id = "principal' + iCnt + '"></td></tr></table></div>');
          $('#btAdd').attr('class', 'btn icono agregar ttip positivo'); 
          $('#btRemove').attr('class', 'btn icono agregar ttip'); 

          $('#pregunta0').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
          $(document).renderme('in');
      }
      else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
          $(container).append('<label class="limite-preg" teid="in:html:21"></label>');
          $(document).renderme('in'); 
          $('#btAdd').attr('class', 'btn icono agregar disabled ttip'); 
          $('#btAdd').attr('disabled', 'disabled');
      }
  });
  $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
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
  if (iCnt <= 20) {
  $('#btAdd').removeAttr('disabled');
  $('#btAdd').attr('class', 'btn icono agregar ttip positivo');
      }
  });

// funcion para envio de formulario y creacion de usuarios
$("#unidad_form").submit(function(event){
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
        tipo_documento:"inmueble",
        tipo_unidad:"privada",
        nombre_inmueble:$('#nombre_inmueble').val(),
        estado:1,
        fecha_creacion:ParamFecha,
      }
    };
    var url = "unidad/unidad";
    var response = envioFormularioMessageSync(url,arr,'POST');    

    var msgDividido = JSON.stringify(response);
    var mensaje =  JSON.parse(msgDividido);
    var msgDivididoDos = JSON.stringify(mensaje.message); 
    $.each(mensaje.message, function(x , y){ sessionStorage.setItem("insertado",y);});
  	retornado=sessionStorage.getItem("insertado");

    //creamos el usuario en copropiedad
		var id_crm= Math.floor((Math.random() * 100000000000) + 1);
		sessionStorage.setItem('id_crmPro',id_crm);    		
    // creamos los usuarios automaticos
    var counter = 0;
    principal=false;
    for (j=0;j<20;j++)
    {
      counter++;
    }        
    
    for (j=0;j<20;j++)
    {

    
        if(!$('#nombre'+j).val()){break;}
        if(counter==1){principal=true}
        else{principal=$('#principal'+j).is(':checked');}


        var id_crm= Math.floor((Math.random() * 100000000000) + 1);
        sessionStorage.setItem('id_crmPro',id_crm)

        //paso uno verificar si el usuario existe en el ldap
        var verificaLDAP;
        verificaLDAP = existeLDAP($('#email'+j).val().toLowerCase(),sessionStorage.getItem('token'));

        if(verificaLDAP)
        { 
          // Paso cero registarlo en copropiedad en usuarioCP
          var crm = verificarEstadoCRM($('#email'+j).val().toLowerCase(), sessionStorage.getItem('token'));
          var arr0 = 
          {
            token:sessionStorage.getItem('token'),
            body:
            {
              creado_por: sessionStorage.getItem('id_crm'),
              fecha_creacion:ParamFecha,
              id_copropiedad:sessionStorage.getItem('cp'),
              id_crm_persona:crm,
              nombre:$('#nombre'+j).val()+" "+$('#apellido'+j).val(),
              telefono:$('#telefono'+j).val(),                
              email:$('#email'+j).val().toLowerCase(),                
              unidad:retornado,
              perfil:"residente",
              tipo:"residente",
              estado:1,
              grupo:$('#grupo'+j).val(),
              principal:principal
            }
          }; 
          var url = "admin/copropiedad/usuario";
          var responseUsuario = envioFormularioSync(url,arr0,'POST');

          //paso 1 valido el usuario de estado entro de copropiedad
          var responseEstado = verificarEstadoCP($('#email'+j).val().toLowerCase(), sessionStorage.getItem('token'));
          if(responseEstado==1)
          {
            //Si el usuario es admintrador debo enviar un toquen con toda la informacion del rol para si acepta asignarlo
            //solicito un toque por un año

            var crm = verificarEstadoCRM($('#email'+j).val().toLowerCase(), sessionStorage.getItem('token'));
            var arrToquen={body:{autkey:$('#email'+j).val().toLowerCase(),user:crm,tiempo:"+1 year"}}
            url="estados/token";
            var responseToken = envioFormularioMessageBodySync(url,arrToquen,'PUT');          
            // esto es para preparar el rol en la copropiedad

            var arr01 = 
            {
              token:responseToken.token,          
              body:
              {
                id_crm_persona: crm,
                id_copropiedad:sessionStorage.getItem('cp'),
                correo:$('#email'+j).val().toLowerCase(),
                nombre:sessionStorage.getItem('ncp'),
                rol:"residente",
                id_unidad:retornado,
                nombre_unidad:$('#nombre_inmueble').val(),
                imagen:""
              }
            };
            var envioRolCp= JSON.stringify(arr01);
            // esta informacion es para cambiarlo a estado dos en caso de que acepte el cambio de lo contrario no y para enviarlo en el token tambien
            var arr012 = 
            {
              token:responseToken.token,          
              body:
              {
                email:$('#email'+j).val().toLowerCase(),
                id_crm_persona:crm,
                estado:2
              }
            };
            var estadoNuevo= JSON.stringify(arr012);
            enviocorreoNotificacionAdmin("https://appdes.copropiedad.co",$('#email'+j).val().toLowerCase(),envioRolCp,estadoNuevo);            
          }
          if (responseEstado==2)
          {
            // 0.1 registrando usuario en rolCP con idunidad
            var crm = verificarEstadoCRM($('#email'+j).val().toLowerCase(), sessionStorage.getItem('token'));
            var arr01 = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id_crm_persona: crm,
                id_copropiedad:sessionStorage.getItem('cp'),
                correo:$('#email'+j).val(),
                nombre:sessionStorage.getItem('ncp'),
                rol:"residente",
                id_unidad:retornado,
                nombre_unidad:$('#nombre_inmueble').val(),
                imagen:""
              }
            };
            var url = "admin/copropiedad/rol";        
            var personalrol = envioFormularioSync(url,arr01,'POST');
            enviocorreoNotificacionNoAdmin("https://appdes.copropiedad.co",$('#email'+j).val().toLowerCase());            
          }
          if (responseEstado==3)
          {
            //si es solo invitado tengo solo que agregarle la copropiedad en rolCP para que pueda iniciar a administrarla como recidente
            // 0.1 registrando usuario en rolCP con idunidad
            var crm = verificarEstadoCRM($('#email'+j).val().toLowerCase(), sessionStorage.getItem('token'));
            var arr01 = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id_crm_persona: crm,
                id_copropiedad:sessionStorage.getItem('cp'),
                correo:$('#email'+j).val(),
                nombre:sessionStorage.getItem('ncp'),
                rol:"residente",
                id_unidad:retornado,
                nombre_unidad:$('#nombre_inmueble').val(),
              }
            };
            var url = "admin/copropiedad/rol";
            var personalrol = envioFormularioSync(url,arr01,'POST');
            //informar que se le metio por detras otra inmueble no activar con toque ni nada link a recuperar clave
            enviocorreoNotificacionNoAdmin("https://appdes.copropiedad.co",$('#email'+j).val().toLowerCase());              
          }
        }
        else
        {
          // Paso cero registarlo en copropiedad en usuarioCP
          var arr0 = 
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
              perfil:"residente",
              tipo:"residente",
              estado:1,
              grupo:$('#grupo'+j).val(),
              principal:principal
            }
          }; 
          var url = "admin/copropiedad/usuario";
          var responseUsuario = envioFormularioSync(url,arr0,'POST');
          // 0.1 registrando usuario en rolCP con idunidad
          var arr01 = 
          {
            token:sessionStorage.getItem('token'),
            body:
            {
              id_crm_persona: id_crm,
              id_copropiedad:sessionStorage.getItem('cp'),
              correo:$('#email'+j).val().toLowerCase(),
              nombre:sessionStorage.getItem('ncp'),
              rol:"residente",
              id_unidad:retornado,
              nombre_unidad:$('#nombre_inmueble').val(),
              imagen:""
            }
          };
          var url = "admin/copropiedad/rol";        
          var personalrol = envioFormularioSync(url,arr01,'POST');
          //primer paso lo registro en copropiedad con los datos que me pasaron y lo registro como tipo 0 y con un idcrmpersona
          var arr1 = 
          {
            token:sessionStorage.getItem('token'),
            body:
            {
              creado_por: sessionStorage.getItem('id_crm'),
              fecha_creacion:ParamFecha,
              nombre:$('#nombre'+j).val(),
              apellido:$('#apellido'+j).val(),
              email:$('#email'+j).val().toLowerCase(),
              telefono:$('#telefono'+j).val(),
              estado:0,
              id_crm_persona:id_crm
            }
          };
          var url = "estados/estados";
          var personalrol = envioFormularioSync(url,arr1,'POST');

          //preparar el objeto para envio al ldap y para pasarlo al correo bienbenida
          //solicito un toque por un año
          var arrToquen={body:{autkey:$('#email'+j).val().toLowerCase(),user:id_crm,tiempo:"+1 year"}}
          url="estados/token";
          var responseToken = envioFormularioMessageBodySync(url,arrToquen,'PUT');
          var arr = 
          {
            token:responseToken.token,
            body:
            {
              nombre:$('#nombre'+j).val(),
              estado:"1",
              apellido:$('#apellido'+j).val(),
              email:"cp-" + $('#email'+j).val().toLowerCase(),
              genero:" ",
              nacionalidad:" ",
              lugarNacimiento:" ",
              paisNacimiento:"CO",
              fechaNacimiento:"01/01/1901",
              idioma:"es-CO",
              id_crm: id_crm,
              password:"19283uj9qwnoa98ndfnsdf",
              tipoDocumento:"CC",
              numeroDocumento:"123465789"
            }
          };
          //paso el correo electronico de verificacion de usuario
          enviocorreobienvenida("https://appdes.copropiedad.co",$('#email'+j).val().toLowerCase(),JSON.stringify(arr),responseToken.token);
        }
    }

    var pagina="index.php";
    setTimeout(refreshWindow(pagina),1000);

  });

  $(document).renderme('in');
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


