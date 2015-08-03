function uploadFileSI(data)
{
  var reader = new FileReader();
  reader.onload = function(event) {
    data = event.target.result;
    var contador = 0;
    var arr = Array();
    var separador = "";
    var stringEnviado="";
    var errores=0;
    var valorFinal=0;
    var filador=1;
    var malos ="";
    $.each(data.split(/\n?\r/),function(k,v){
      var totalData= ((data.split(/\n?\r/)).length);
      //alert(totalData);
      if(separador==","){valorFinal=totalData}else{valorFinal=totalData-1}
      if(contador != 0 && contador != valorFinal)
      {
        var nombre_proveedor = v.split(separador)[0];
        var nombre_contacto = v.split(separador)[1];
        var apellido_contacto = v.split(separador)[2];
        var telefono = v.split(separador)[3];
        var email = v.split(separador)[4];

        // var grupo = v.split(separador)[5];
        // var encargado = v.split(separador)[6];
        
        //verificando tamaños
        if(nombre_proveedor.length > 2 && nombre_contacto.length > 2 && apellido_contacto.length > 2 && telefono.length > 2 && email.length > 2)
        {
          $("#agregar_campos > tbody:last-child").append('<tr style="text-align:center;"><td width="15%" class="titulo-campos">'+filador+'</td><td>'+nombre_proveedor+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td></tr>');
            stringEnviado+=nombre_proveedor+","+nombre_contacto+","+apellido_contacto+","+telefono+","+email+",proveedor"+"|";
          filador++;
        }
        else
        {
          $("#agregar_campos > tbody:last-child").append('<tr style="text-align:center;"><td width="15%" class="titulo-campos">'+filador+'</td><td>'+nombre_proveedor+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td></tr>');
          malos+=filador+",";
          $(document).renderme('pr');
          filador++;
          errores++;
        }
        contador ++;
      }
      else
      {
        var check = v.split(";");
        if(check[1] != null || check[1] != undefined)
          separador = ";";
        else
          separador = ",";
          console.warn(separador);
          check = v.split(separador);
          console.warn(check);
          contador ++;        
      }
    });
    if((valorFinal-1)==-1)
    {
      valorFinal=0;
    }
    else
    {
      valorFinal=valorFinal-1; 
    }
    if(errores==0)
      {
        $("#formEnvio").append('<input type="hidden" name="importados" id="importados" value="'+stringEnviado.slice(0,-1)+'"/>');
        //$("#buttons").html('<div class="botones-form"><label><strong>'+obtenerTerminoLenguage('pr','56')+''+valorFinal+obtenerTerminoLenguage('pr','57')+'</strong></label><input type="submit" class="btn guardar icono ttip" id="subirArchivo" teid="pr:val:58, pr:title:59"/><input type="button" class="btn borrar icono ttip" id="reload" teid="pr:val:60, pr:title:61"/></div>');
        $("#agregar_campos > tbody:last-child").append('<tr style="text-align:center;"><td colspan="7"><div class="botones-form"><label><strong>'+obtenerTerminoLenguage('pr','56')+''+valorFinal+obtenerTerminoLenguage('pr','57')+'</strong></label><input type="submit" class="btn guardar icono ttip" id="subirArchivo" teid="pr:val:58, pr:title:59"/><input type="button" class="btn borrar icono ttip" id="reload" teid="pr:val:60, pr:title:61"/></div><td><tr></div><td><tr>');
        $("#reload").click(function(){
          location.reload();
        });  
        $("#formEnvio").submit(function(){$("#cpImportando").show();});      
      }
      else
      { var generaltotal=malos.substring(0, malos.length-1)
        $("#alertaserror").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br> '+obtenerTerminoLenguage('ale','58')+generaltotal+obtenerTerminoLenguage('ale','135')+'</div>');
        //$("#alertas").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br> '+obtenerTerminoLenguage('ale','58')+''+malos+'</div>');
        // $("#alertas").append('<tr style="text-align:center;"><td colspan="7"><div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>'+obtenerTerminoLenguage('ale','59')+'</div><td><tr>');
        $(document).renderme('pr');
      }



    //console.warn(JSON.stringify(arr));
    $("#importado").attr('esimportado',"si");

    if(contador < 1){
      $("#alertas"). html('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br>'+obtenerTerminoLenguage('ale','60')+'</div>'); 
      $(document).renderme('pr');
    }
    else{
      $("#status").html(obtenerTerminoLenguage('co','103') + String(Number(contador) - 1) + obtenerTerminoLenguage('co','104'));
    }
    $(document).renderme('co');    
    //console.warn(arr);
  }
  reader.readAsText(data,"csisolatin1");
  $(document).renderme('co');
}