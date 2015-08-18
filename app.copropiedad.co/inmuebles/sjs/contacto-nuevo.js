$(document).ready(function(){

  $(document).renderme('in');
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var inmueble = traerDatosSync("unidad/unidad/copropiedadid/", arr);
  popularNuevoUsuario(inmueble);
  // en via el formulario para crear un nuevo contacto
  $("#nuevo-usuario").submit(function(event)
  {
    //carga de variables
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
    event.preventDefault();
    var ParamFecha=fecha();        
    var id_crm= Math.floor((Math.random() * 100000000000) + 1);      
    var tipo="";
    //paso uno verificar si el usuario existe en el ldap
    var verificaLDAP;
    verificaLDAP = existeLDAP($('#email').val().toLowerCase(),sessionStorage.getItem('token'));
    //alert("inicio"+verificaLDAP);
    if(verificaLDAP)
    {      
      // Paso cero registarlo en copropiedad en usuarioCP
      var crm = verificarEstadoCRM($('#email').val().toLowerCase(), sessionStorage.getItem('token'));

      var arr0 = 
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          creado_por: sessionStorage.getItem('id_crm'),
          fecha_creacion:ParamFecha,
          id_copropiedad:sessionStorage.getItem('cp'),
          id_crm_persona:crm,
          nombre:$('#nombre').val()+" "+$('#apellido').val(),
          telefono:$('#telefono').val().replace(' ',''),       
          email:$('#email').val().replace(' ','').toLowerCase(),
          unidad:params['idt'],
          perfil:"residente",
          tipo:"residente",
          estado:1,
          grupo:$('#grupo').val(),
          principal:$('#principal').is(':checked')
        }
      }; 
      var url = "admin/copropiedad/usuario";
      var responseUsuario = envioFormularioSync(url,arr0,'POST');

      //paso 1 valido el usuario de estado entro de copropiedad
      var responseEstado = verificarEstadoCP($('#email').val().toLowerCase(), sessionStorage.getItem('token'));
      if(responseEstado==1)
      {
        //Si el usuario es admintrador debo enviar un toquen con toda la informacion del rol para si acepta asignarlo        
        //solicito un toque por un año
        var crm = verificarEstadoCRM($('#email').val().toLowerCase(), sessionStorage.getItem('token'));
        var arrToquen={body:{autkey:$('#email').val().toLowerCase(),user:crm,tiempo:"+1 year"}}
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
            correo:$('#email').val().toLowerCase(),
            nombre:sessionStorage.getItem('ncp'),
            rol:"residente",
            id_unidad:params['idt'],
            nombre_unidad:atob(params['nin']),
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
            email:$('#email').val().toLowerCase(),
            id_crm_persona:crm,
            estado:2
          }
        };
        var estadoNuevo= JSON.stringify(arr012);
        enviocorreoNotificacionAdmin("https://appdes.copropiedad.co",$('#email').val().toLowerCase(),envioRolCp,estadoNuevo);
        var pagina="inmueble-editar.php?idt="+params['idt'];
        setTimeout(refreshWindow(pagina),1000);
      }      
      if (responseEstado==2)
      {
        // 0.1 registrando usuario en rolCP con idunidad
        var crm = verificarEstadoCRM($('#email').val().toLowerCase(), sessionStorage.getItem('token'));
        var arr01 = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_crm_persona: crm,
            id_copropiedad:sessionStorage.getItem('cp'),
            correo:$('#email').val().toLowerCase(),
            nombre:sessionStorage.getItem('ncp'),
            rol:"residente",
            id_unidad:params['idt'],
            nombre_unidad:atob(params['nin']),
            imagen:""
          }
        };
        var url = "admin/copropiedad/rol";        
        var personalrol = envioFormularioSync(url,arr01,'POST');
        enviocorreoNotificacionNoAdmin("https://appdes.copropiedad.co",$('#email').val().toLowerCase());
        var pagina="inmueble-editar.php?idt="+params['idt'];
        setTimeout(refreshWindow(pagina),1000);
        //0.2 notifico que le fue agregada otro inmueble para adminisitrar
      }
      if (responseEstado==3)
      {
        //si es solo invitado tengo solo que agregarle la copropiedad en rolCP para que pueda iniciar a administrarla como recidente
        // 0.1 registrando usuario en rolCP con idunidad
        var crm = verificarEstadoCRM($('#email').val().toLowerCase(), sessionStorage.getItem('token'));
        var arr01 = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_crm_persona: crm,
            id_copropiedad:sessionStorage.getItem('cp'),
            correo:$('#email').val().toLowerCase(),
            nombre:sessionStorage.getItem('ncp'),
            rol:"residente",
            id_unidad:params['idt'],
            nombre_unidad:atob(params['nin']),
          }
        };
        var url = "admin/copropiedad/rol";
        var personalrol = envioFormularioSync(url,arr01,'POST');
        //informar que se le metio por detras otra inmueble no activar con toque ni nada link a recuperar clave
        enviocorreoNotificacionNoAdmin("https://app.copropiedad.co",$('#email').val().toLowerCase());
        var pagina="inmueble-editar.php?idt="+params['idt'];
        setTimeout(refreshWindow(pagina),1000);
      };
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
          nombre:$('#nombre').val()+" "+$('#apellido').val(),
          telefono:$('#telefono').val().replace(' ',''),       
          email:$('#email').val().replace(' ','').toLowerCase(),
          unidad:params['idt'],
          perfil:"residente",
          tipo:"residente",
          estado:1,
          grupo:$('#grupo').val(),
          principal:$('#principal').is(':checked')
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
          correo:$('#email').val().toLowerCase(),
          nombre:sessionStorage.getItem('ncp'),
          rol:"residente",
          id_unidad:params['idt'],
          nombre_unidad:atob(params['nin']),
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
          nombre:$('#nombre').val(),
          apellido:$('#apellido').val(),
          email:$('#email').val().replace(' ','').toLowerCase(),
          telefono:$('#telefono').val().replace(' ',''),
          estado:0,
          id_crm_persona:id_crm
        }
      };
      var url = "estados/estados";
      var personalrol = envioFormularioSync(url,arr1,'POST');

      //preparar el objeto para envio al ldap y para pasarlo al correo bienbenida
      //solicito un toque por un año
      var arrToquen={body:{autkey:$('#email').val().toLowerCase(),user:id_crm,tiempo:"+1 year"}}
      url="estados/token";
      var responseToken = envioFormularioMessageBodySync(url,arrToquen,'PUT');
      var arr = 
      {
        token:responseToken.token,
        body:
        {
          nombre:$('#nombre').val(),
          estado:"1",
          apellido:$('#apellido').val(),
          email:"cp-" + $('#email').val().toLowerCase(),
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
      //alert("esta es la cosa esta");
      enviocorreobienvenida("https://appdes.copropiedad.co",$('#email').val().toLowerCase(),JSON.stringify(arr),responseToken.token);
      var pagina="inmueble-editar.php?idt="+params['idt'];
      setTimeout(refreshWindow(pagina),1000);

    }
  });
});