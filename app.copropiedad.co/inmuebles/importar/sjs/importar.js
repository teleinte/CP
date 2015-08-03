$(document).ready(function(){ 
  $("#token").val(sessionStorage.getItem('token')); 
  $(document).renderme('in');

  $("#descargarwindows").click(function(){
      window.location = "plantillas/ContactosWindows.csv";
  });

  $("#descargarmac").click(function(){
      window.location = "plantillas/ContactosMac.csv";
  });

  $("#cargar").change(function() {
      //console.warn(this.files[0])
      $("#agregar_campos").show();
      $("#agregar_campos").html('<tr><td width="15%" class="titulo-campos">Linea</td><td width="15%" class="titulo-campos">Nombre Inmueble</td><td width="15%" class="titulo-campos">Nombre Contacto</td><td width="14%" class="titulo-campos">Apellido Contacto</td> <td width="14%" class="titulo-campos">Telefono</td> <td width="14%" class="titulo-campos">Correo</td> <td width="14%" class="titulo-campos">Grupo</td> <td width="14%" class="titulo-campos">Principal</td> </tr>');
      uploadFileSI(this.files[0]);
  });


  $("#id_copropiedad").val(sessionStorage.getItem('cp'));
  $("#id_crm").val(sessionStorage.getItem('id_crm'));
  $("#ncp").val(sessionStorage.getItem('ncp'));
  $("#nombrecompleto").val(sessionStorage.getItem('nombreCompleto'));
  $('#alertas').html('<div class="alert alert-dismissable alert-info" style="width:520px; height:180px; overflow:auto;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h2><strong style="text-align:center"><p>'+obtenerTerminoLenguage('ale','48')+'</p></strong></h2><p>'+obtenerTerminoLenguage('ale','49')+'</p><p>'+obtenerTerminoLenguage('ale','50')+'</p><p>'+obtenerTerminoLenguage('ale','51')+'</p><p>'+obtenerTerminoLenguage('ale','52')+'</p><p>'+obtenerTerminoLenguage('ale','53')+'</p><p>'+obtenerTerminoLenguage('ale','54')+'</p><p>'+obtenerTerminoLenguage('ale','84')+'</p><p>'+obtenerTerminoLenguage('ale','85')+'</p><p>'+obtenerTerminoLenguage('ale','97')+'</p><p>'+obtenerTerminoLenguage('ale','98')+'</p><p>'+obtenerTerminoLenguage('ale','99')+'</p> <p>'+obtenerTerminoLenguage('ale','100')+'</p><p>'+obtenerTerminoLenguage('ale','101')+'</p><p>'+obtenerTerminoLenguage('ale','102')+'</p><p>'+obtenerTerminoLenguage('ale','103')+'</p><p>'+obtenerTerminoLenguage('ale','104')+'</p><p>'+obtenerTerminoLenguage('ale','105')+'</p><p>'+obtenerTerminoLenguage('ale','106')+'</p></div>');
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

  if(params['err']==1)
  {
    $('#msg').html();
    var sumador=parseInt(params['ms'])+2;
    $('#incr').append(obtenerTerminoLenguage('in','59')+sumador+obtenerTerminoLenguage('in','60'));
    $(document).renderme('in');
    $('#cocr').append(params['tc']);
  }

  if(params['err']==2)
  {
    $('#msg').html();
    var sumador=parseInt(params['ms'])+2;
    $('#incr').append(obtenerTerminoLenguage('in','59')+sumador+obtenerTerminoLenguage('in','61'));
    $(document).renderme('in');
    $('#cocr').append(params['tc']);
  }

  if(params['idr']==1)
  {
    $('#msg').html(obtenerTerminoLenguage('in','44'));
    $('#incr').append(obtenerTerminoLenguage('in','73')+params['tu']);
    $('#cocr').append(obtenerTerminoLenguage('in','74')+params['tc']);
  }
  if(params['idr']==2)
  {
    $('#msg').html(obtenerTerminoLenguage('in','45'))
    $('#incr').append(params['tu']);
    $('#cocr').append(params['tc']);
  }

  if(params['idr']==3)
  {
    $('#msg').html(obtenerTerminoLenguage('in','46'))
    $('#incr').append('0')
    $('#cocr').append('0')
  }
  if(params['idr']==4)
  {
    $('#msg').html(obtenerTerminoLenguage('in','47'))
    $('#incr').append('N/A')
    $('#cocr').append('N/A')
  }
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