$(document).ready(function(){
	var thisURL = "https://appdes.copropiedad.co";

  sessionStorage.setItem('hello','1');

  if(sessionStorage.getItem('message') != null || sessionStorage.getItem('message') != undefined)
  {
    var tipo = "";
    if(sessionStorage.getItem('tipo') == null || sessionStorage.getItem('tipo') == undefined)
      $('#alertas').html('<div class="alert alert-dismissable alert-info">'+sessionStorage.getItem('message')+'</div></div>');
    else
      $('#alertas').html('<div class="alert alert-dismissable alert-' + sessionStorage.getItem('tipo') + '">'+sessionStorage.getItem('message')+'</div></div>');

    sessionStorage.removeItem('message');
    sessionStorage.removeItem('tipo');
  }
    
    $('#login').submit(function(event){
      $('input[type=submit]').val('Iniciando Sesión...');
      $('input[type=submit]').attr('disabled',true);
      event.preventDefault();
      var loginr = doLogin(thisURL);
      if(Boolean(loginr))
      {
      	var tk = getLoginToken(thisURL + "/api/userflow/");
      	if(tk)
      	{
          var estadoCP = verificarEstadoCP($("#usr").val(),tk);
          sessionStorage.setItem('estadoCP',parseInt(estadoCP));
          var cps = checkPerfiles(thisURL + "/");

          if(cps != null)
          {
            if(setupIngreso(estadoCP,cps))
            {
              var admin = cleanArray(sessionStorage.getItem('cp_admin').split(','));
              var otros = cleanArray(sessionStorage.getItem('cp_otros').split(','));
              //console.warn(admin, otros);
              //console.warn(admin.length, otros.length);
              if(estadoCP == 1 || estadoCP == 2)
              {
                if(estadoCP == 2)
                {
                  if(admin.length == 0)
                  {
                    idcp = otros[0].split("@@@")[0];
                    loginr = loginr + "cp=" + idcp + "&cp_otros=" + otros + "&token=" + tk;
                    //console.warn(loginr);
                    location.href = "review.php?token=" + btoa(loginr);
                  }
                  else
                  {
                    idcp = admin[0].split("@@@")[0];
                    sessionStorage.setItem('cp',idcp);
                    loginr = loginr + "cp=" + idcp + "&cp_otros=" + otros + "&token=" + tk;
                    location.href = "review.php?token=" + btoa(loginr);
                  }
                }
                else
                {
                  if(admin.length > 0)
                  {
                    idcp = admin[0].split("@@@")[0];
                    sessionStorage.setItem('cp',idcp);
                    location.href = thisURL + "/inicio";
                  }
                  else
                  {
                    location.href = thisURL + "/inicio";
                  }
                }
              }
              else if(estadoCP == 3)
              {
                if((sessionStorage.getItem('userdata') != null || sessionStorage.getItem('userdata') != undefined) && (sessionStorage.getItem('isAdmin') != null || sessionStorage.getItem('isAdmin') != undefined) && (sessionStorage.getItem('newSt') != null || sessionStorage.getItem('newSt') != undefined))
                {
                  var userData = JSON.parse(atob(sessionStorage.getItem('userdata')));
                  var isAdmin= sessionStorage.getItem('isAdmin');   
                  var newSt= JSON.parse(atob(sessionStorage.getItem('newSt')));
                  newSt["body"]["id_crm_persona"] = parseInt(sessionStorage.getItem('id_crm'));
                  sessionStorage.removeItem('userdata');
                  sessionStorage.removeItem('isAdmin');
                  sessionStorage.removeItem('newSt');

                  var rutaAplicativoCP= "https://appdes.copropiedad.co/api/estados/estados/";
                  $.ajax({
                      url: rutaAplicativoCP,
                      type: "PUT",
                      data: JSON.stringify(newSt),
                      contentType: 'application/json; charset=utf-8',
                      dataType: 'json',
                      async: false,
                      success: function(data) 
                      {
                        var msgDividido2 = JSON.stringify(data);
                        var mensaje2 =  JSON.parse(msgDividido2);
                        var msgDivididoDos2 = JSON.stringify(mensaje2.message);
                        if(mensaje2.status)
                        {
                          var _nombre = userData["nombre"];
                          var _apellido = userData["apellido"];
                          var _email = userData['email'];
                          var _fecha = userData['telefono'];
                          var arr = {token:sessionStorage.getItem('token'),body:{email:"cp-" + _email,nombre:_nombre,apellido:_apellido,fechaNacimiento:_fecha}};
                          var rutaAplicativo = "https://auth.sinfo.co/auth/information";
                          var result = false; 
                          $.ajax({
                              url: rutaAplicativo,
                              type: 'PUT',
                              data: JSON.stringify(arr),
                              contentType: 'application/json; charset=utf-8',
                              dataType: 'json',
                              async: false,
                              success:function(data)
                              {
                                sessionStorage.setItem('nombre',_nombre);
                                sessionStorage.setItem('apellido',_apellido);
                                sessionStorage.setItem('nombreCompleto',_nombre + " " + _apellido);
                                location.href = thisURL + '/inicio';
                              }
                          });
                        }
                        else
                        {
                          $('#alertas').html('<div class="alert alert-error" style="height:auto; margin:5px auto;">Ha ocurrido un error actualizando su usuario, por favor <a class="btn alertaserror" href="../contacto">contacte con nuestro departamento de servicio al cliente</a></div>');
                        }
                      }
                  });
                }
                else
                {
                  if(otros.length > 0)
                  {
                    idcp = otros[0].split("@@@")[0];
                    loginr = loginr + "cp=" + idcp + "&cp_otros=" + otros + "&token=" + tk;
                    sessionStorage.clear();
                    location.href = "https://mi.copropiedad.co/inicio/index.php?token=" + btoa(loginr);
                  }
                  else
                  {
                    location.reload();
                    sessionStorage.clear();
                    sessionStorage.setItem('message','Su usuario no tiene copropiedades vigentes o perfiles activos en el sistema. Para cualquier consulta comuníquese con su Administrador de Propiedad Horizontal.');
                    sessionStorage.setItem('tipo','error');
                  }
                }
              }
            }
            else
            {
              location.reload();
              sessionStorage.clear();
              sessionStorage.setItem('message','Su usuario no tiene copropiedades vigentes o perfiles activos en el sistema. Para cualquier consulta comuníquese con su Administrador de Propiedad Horizontal.');
              sessionStorage.setItem('tipo','error');
            }
          }
          else
          {
            if(estadoCP == 1)
            {
              location.href = thisURL + '/inicio';
            }
            else
            {
              location.reload();
              sessionStorage.clear();
              sessionStorage.setItem('message','Su usuario no tiene copropiedades vigentes o perfiles activos en el sistema. Para cualquier consulta comuníquese con su Administrador de Propiedad Horizontal.');
              sessionStorage.setItem('tipo','error');
            }
          }
      	}
      }
      else
      {
      	$('input[type=submit]').attr('disabled',false);
      	$('input[type=submit]').val('Iniciar Sesión');
      }
    });

    $('input[type=text]').attr('pattern','[a-zA-Z0-9]+.{3,}');
    $('input[type=text]').attr('title','Este campo no puede ir vacio');
    $('input[type=text]').addClass('tooltip');
    $('input[type=password]').attr('pattern','[a-zA-Z0-9]+.{3,}');
    $('input[type=password]').attr('title','Este campo no puede ir vacio');
    $('input[type=password]').addClass('tooltip');
    $('input[type=email]').attr('pattern','[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,3}$');
    $('input[type=email]').attr('title','Este campo debe tener el formato usuario@dominio.com');
    $('input[type=email]').addClass('tooltip');
    $('input[type=checkbox]').attr('title','Debe seleccionar este campo para continuar');
    $('input[type=checkbox]').addClass('tooltip');
});