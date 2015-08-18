$(document).ready(function(){  
  $(document).renderme('in');
  $("#descargarwindows").click(function(){
      window.location = "plantillas/ProveedoresWindows.csv";
  });
  $("#descargarmac").click(function(){
      window.location = "plantillas/ProveedoresMac.csv";
  });
  $("#cargar").change(function() {
      $("#agregar_campos").show();
      $("#agregar_campos").html('<tr style="text-align:center;"> <td width="17%" class="titulo-campos">Linea</td><td width="17%" class="titulo-campos" teid="pr:html:48"></td> <td width="17%" class="titulo-campos" teid="pr:html:49"></td> <td width="17%" class="titulo-campos" teid="pr:html:50"></td> <td width="16%" class="titulo-campos" teid="pr:html:51"></td> <td width="17%" class="titulo-campos" teid="pr:html:52"></td><td width="17%" class="titulo-campos">Nit</td></tr>'); uploadFileSI(this.files[0]);
  });
  $("#id_copropiedad").val(sessionStorage.getItem('cp'));
  $("#id_crm").val(sessionStorage.getItem('id_crm'));
  $("#ncp").val(sessionStorage.getItem('ncp'));
  $('#alertas').html('<div class="alert alert-dismissable alert-info" style="width:520px; height:180px; overflow:auto;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h2><strong style="text-align:center"><p>'+obtenerTerminoLenguage('ale','61')+'</p></strong></h2><p>'+obtenerTerminoLenguage('ale','49')+'</p><p>'+obtenerTerminoLenguage('ale','50')+'</p><p>'+obtenerTerminoLenguage('ale','116')+'</p><p>'+obtenerTerminoLenguage('ale','107')+'</p><p>'+obtenerTerminoLenguage('ale','108')+'</p><p>'+obtenerTerminoLenguage('ale','109')+'</p><p>'+obtenerTerminoLenguage('ale','110')+'</p><p>'+obtenerTerminoLenguage('ale','111')+'</p><p>'+obtenerTerminoLenguage('ale','112')+'</p><p>'+obtenerTerminoLenguage('ale','113')+'</p><p>'+obtenerTerminoLenguage('ale','114')+'</p><p>'+obtenerTerminoLenguage('ale','115')+'</p></div>');
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
    $('#incr').append(obtenerTerminoLenguage('pr','38')+params['tu']);
    $('#cocr').append(obtenerTerminoLenguage('pr','39')+params['tc']);
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
});