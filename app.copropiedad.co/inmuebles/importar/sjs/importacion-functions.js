function uploadFileSI(data)
{
  var reader = new FileReader();
  reader.onload = function(event) {
    data = event.target.result;



    var cargador = new Array();
    var contador = 0;
    var arr = Array();
    var separador = "";
    var stringEnviado="";
    var errores=0;
    var valorFinal=0;
    var filador=1;
    var malos ="";
    $.each(data.split(/\n?\r/),function(k,p){
      var totalData= ((data.split(/\n?\r/)).length);
      if(separador==","){valorFinal=totalData}else{valorFinal=totalData-1}
      //alert(totalData);
      
      if(contador != 0 && contador != valorFinal)
      {
        var nombre_inmueble = p.split(separador)[0];
        var encargado = p.split(separador)[6];
        //alert(encargado);
        if(encargado!=undefined)
        {
          if ((encargado.toLowerCase())=="si")
          {
            cargador+=[nombre_inmueble];
          }  
        }
        
      }
      else
      {
        var check = p.split(";");
        if(check[1] != null || check[1] != undefined)
          separador = ";";
        else
          separador = ",";
          //console.warn(separador);
          check = p.split(separador);
          //console.warn(check);
          contador ++;        
      } 

    });

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
        var nombre_inmueble = v.split(separador)[0];
        var nombre_contacto = v.split(separador)[1];
        var apellido_contacto = v.split(separador)[2];
        var telefono = v.split(separador)[3];
        var email = v.split(separador)[4];
        var grupo = v.split(separador)[5];
        var encargado = v.split(separador)[6];
        
        //verificando tamaños
        if(nombre_inmueble.length > 2 && nombre_contacto.length > 2 && apellido_contacto.length > 2 && telefono.length > 2 && email.length > 2 && grupo.length > 2 && encargado.length > 0)
        {

          //verifico si tiene un encargado o no lo tiene         
          if(cargador.indexOf(nombre_inmueble)!=-1)
          {
            if(grupo.toLowerCase() != "residente" && grupo.toLowerCase() != "consejo" && grupo.toLowerCase() != "asamblea")
            {
              //$("#alertas").append('<div class="alert alert-error alert-dismissable"  ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br> '+obtenerTerminoLenguage('ale','55') +contador+'</div>');
              $("#agregar_campos > tbody:last-child").append('<tr><td>'+filador+'</td><td>'+nombre_inmueble+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td><td>'+grupo+'</td><td>'+encargado+'</td></tr>');
              malos+=filador+",";
              filador++;
              errores++;
            }
            else
            {
              if(encargado.toLowerCase()!="si" && encargado.toLowerCase()!="no")
              {
                //$("#alertas").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br>'+obtenerTerminoLenguage('ale','56')+contador+obtenerTerminoLenguage('ale','57')+'</div>');
                $(document).renderme('co');
                $("#agregar_campos > tbody:last-child").append('<tr><td>'+filador+'</td><td>'+nombre_inmueble+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td><td>'+grupo+'</td><td>'+encargado+'</td></tr>');
                malos+=filador+",";
                errores++;
                filador++;
              }
              else
              {
                $("#agregar_campos > tbody:last-child").append('<tr><td>'+filador+'</td><td>'+nombre_inmueble+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td><td>'+grupo+'</td><td>'+encargado+'</td></tr>');
                  stringEnviado+=nombre_inmueble+","+nombre_contacto+","+apellido_contacto+","+telefono+","+email+","+grupo+","+encargado+"|";
                filador++;
              }            
            }
          }
          else
          {
            //$("#alertas").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br>'+obtenerTerminoLenguage('ale','56')+contador+obtenerTerminoLenguage('ale','57')+'</div>');
            $(document).renderme('co');
            $("#agregar_campos > tbody:last-child").append('<tr><td>'+filador+'</td><td>'+nombre_inmueble+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td><td>'+grupo+'</td><td>'+encargado+'</td></tr>');
            malos+=filador+",";
            errores++;
            filador++;            
          }
        }
        else
        {
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+filador+'</td><td>'+nombre_inmueble+'</td><td>'+nombre_contacto+'</td><td>'+apellido_contacto+'</td><td>'+telefono+'</td><td>'+email+'</td><td>'+grupo+'</td><td>'+encargado+'</td></tr>');
          //$("#alertas").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br>'+obtenerTerminoLenguage('ale','58')+contador+'</div>');
          $(document).renderme('co');
          malos+=filador+",";
          errores++;
          filador++
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
          //console.warn(separador);
          check = v.split(separador);
          //console.warn(check);
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
        /*$("#buttons").html('<div class="botones-form"><label><strong>'+obtenerTerminoLenguage('in','69')+valorFinal+obtenerTerminoLenguage('in','70')+'</strong></label><input type="submit" class="btn ttip" id="subirArchivo" teid="in:val:71, in:title:72"/><input type="button" class="btn ttip" id="reload" teid="pr:val:60, pr:title:61"/></div>');*/
        $("#agregar_campos > tbody:last-child").append('<tr><td colspan="7"><div class="botones-form" style="text-align:left !important;"><label><strong>'+obtenerTerminoLenguage('in','69')+valorFinal+obtenerTerminoLenguage('in','70')+'</strong></label><input type="submit" class="btn ttip" id="subirArchivo" teid="in:val:71, in:title:72"/><input type="button" class="btn ttip" id="reload" teid="pr:val:60, pr:title:61"/></div><td><tr>');
        $("#reload").click(function(){
          location.reload();
        });

        
        $(document).renderme('co');
        $("#formEnvio").submit(function(){$("#cpImportando").show();});
      }
      else
      {
        malos = malos.substring(0, malos.length-1);
        $("#alertaserror").append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br> '+obtenerTerminoLenguage('ale','59')+malos+obtenerTerminoLenguage('ale','135')+'<big><big><big><strong><a href="./">'+obtenerTerminoLenguage('ale','139')+'</a></strong></big></big></big>'+obtenerTerminoLenguage('ale','140')+'</div>');
        //$("#agregar_campos > tbody:last-child").append('<tr><td colspan="7"><div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong><br>'+obtenerTerminoLenguage('ale','59')+'</div><td><tr>');
        $(document).renderme('co');
      }

    //console.warn(JSON.stringify(arr));
    $("#importado").attr('esimportado',"si");

    if(contador < 1){
      $("#alertas"). html('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em></em></strong> <br> '+obtenerTerminoLenguage('ale','60')+'</div>'); 
      $(document).renderme('co');
    }
    else{
      $("#status").html(obtenerTerminoLenguage('co','103') + String(Number(contador) - 1) + obtenerTerminoLenguage('co','104'));
    }
    $(document).renderme('co');    
    //console.warn(arr);
  }
  reader.readAsText(data,"csisolatin1");
  //reader.readAsText(data);
  $(document).renderme('co');

}