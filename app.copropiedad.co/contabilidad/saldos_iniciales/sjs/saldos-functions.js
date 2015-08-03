
function totalizarDebitos(actualid)
{
  var result = 0;
  for (var i = 1; i <= actualid; i++) 
  {
      result = Number(result) + Number($("#debitos_fila" + i).val());
  }
  return result;
}

function totalizarCreditos(actualid)
{
  var result = 0;
  for (var i = 1; i <= actualid; i++) 
  {
      result = Number(result) + Number($("#creditos_fila" + i).val());
  }
  return result;
}

function FormatearCategoriasContables()
{
  var res = "";
  var cats = $.parseJSON(sessionStorage.getItem('puc'));
  var pucfinal = new Array();
  $.each(cats,function(x,y){
    pucfinal.push(y['cuenta'] + "@" + y['cuenta'] + " - " + y['nombre']);
  });
  $.each(pucfinal,function(x,y){
    var key = y.split("@")[0];
    var val = y.split("@")[1];
    res = res + '<option value="' + key + '">' + val + '</option>';
  }); 
  return res; 
}

function popularBasicos()
{
  $("#comprador").html(sessionStorage.getItem('ncp') + " - " + sessionStorage.getItem('nombreCompleto'));
  var today = new Date();
  var year = today.getFullYear();
  var month = today.getMonth()+1;
  if(month < 10)
    month = "0" + month;
  var day = today.getDate();
  $("#datepicker1").val(day + "/" + month + "/" + year);
}

function popularSaldos(datos)
{
  //console.warn('test',datos[0]['cuentas']);
  $("#ctrlTable").hide();
  $("#totales").hide();
  $("#guardar").hide();
  $("#fechatr").hide();
  $("#importarsidiv").hide();
  $("#form_saldost").hide();
  $("#messi").attr('disabled',true);
  $("#anosi").attr('disabled',true);
  var lineador=1;
  if(datos != null || datos != undefined)
    
  

  $("#messi").val(datos['0']['mes']);
  $("#anosi").val(datos['0']['ano']);


    $.each(datos['0']['cuentas'],function(k,v){
      //console.warn(v);
      if(v['monto'] > 0)
      {
        $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Débito</td><td>' + v['cuenta_puc'] + '</td><td>' + v['monto'] + '</td><td>0</td></tr>');
        lineador++;
        $(document).renderme('co');
      }
      else
      {
        $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Crédito</td><td>' + v['cuenta_puc'] + '</td><td>0</td><td>' + Number(v['monto'] * -1) + '</td></tr>');
        lineador++;
        $(document).renderme('co');
      }
    });
}

function obtenerSaldos()
{
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      id_copropiedad: sessionStorage.getItem('cp')
    }
  };
  var url = "contabilidad/saldosiniciales/traer/";
  return traerDatosSyncCustom(url,arr,'PUT');
}

function uploadFileSI(data)
{
  var reader = new FileReader();
  reader.onload = function(event) {
    data = event.target.result;
    var contador = 0;
    var arr = Array();
    var separador = "";
    var lineador=1;
    var errores=0;
    $.each(data.split(/\n?\r/),function(k,v){
      if(contador != 0)
      {
        //console.warn(separador);
        var cuenta = v.split(separador)[0];
        var debito = v.split(separador)[1];
        var credito = v.split(separador)[2];        
                
        if(cuenta.length>1 && debito > 0 && credito==0)
        {
          //console.warn("esta es la cuenta--->"+cuenta.length);
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Débito</td><td>'+cuenta+'</td><td>'+debito+'</td><td>0</td></tr>');
          lineador++;
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:debito,tipo:"SI"};
          arr.push(item);          
        }
        else if(cuenta.length>1 && debito > 0 && credito=="")
        {
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Débito</td><td>'+cuenta+'</td><td>'+debito+'</td><td>0</td></tr>');
          lineador++;
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:debito,tipo:"SI"};
          arr.push(item);          
        }
        else if(cuenta.length>1 && debito ==0 && credito > 0)
        {
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Crédito</td><td>'+cuenta+'</td><td>0</td><td>'+credito+'</td></tr>');
          lineador++;
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          arr.push(item);
        }
        else if(cuenta.length>1 && debito =="" && credito > 0)
        {
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Crédito</td><td>'+cuenta+'</td><td>0</td><td>'+credito+'</td></tr>');
          lineador++;
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          arr.push(item);
        }




        else if(cuenta.length==1 && credito ==0 && debito !=0)
        { 
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Débito</td><td>'+cuenta+'</td><td>'+debito+'</td><td>0</td></tr>');
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          $("#alertas"). append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>El campo cuenta esta vacio en la linea '+lineador+'</div>'); 
          lineador++;
          errores++;
          arr.push(item);
        }

        else if(cuenta.length>1 && credito ==0 && debito ==0)
        { 
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td></td><td>'+cuenta+'</td><td></td><td></td></tr>');
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          $("#alertas"). append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>Los campos debito y credito estan vacios o en cero, uno de ellos debe contener un valor superior a cero y el otro debe ser igual a cero verifique este error en la linea '+lineador+'</div>'); 
          lineador++;
          errores++;
          arr.push(item);
        }

        else if(cuenta.length>1 && credito !=0 && debito !=0)
        { 
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td></td><td>'+cuenta+'</td><td></td><td></td></tr>');
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          $("#alertas"). append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>Los campos debito y credito estan mayores a cero los dos, uno de ellos debe contener un valor superior a cero y el otro debe ser igual a cero verifique este error en la linea '+lineador+'</div>'); 
          lineador++;
          errores++;
          arr.push(item);
        }

        else if(cuenta.length==1 && credito !=0 && debito ==0)
        { 
          $("#agregar_campos > tbody:last-child").append('<tr><td>'+lineador+'</td><td>Crédito</td><td>'+cuenta+'</td><td>0</td><td>'+credito+'</td></tr>');
          //$(document).renderme('co');
          var item = {cuenta_puc:cuenta,monto:Number(credito) * -1,tipo:"SI"};
          $("#alertas"). append('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>El campo cuenta esta vacio en la linea '+lineador+'</div>'); 
          lineador++;
          errores++;
          arr.push(item);
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
        /*if(check[0] == "cuenta" && check[1] == "D" && check[2] == "C")
        else
          return false;*/
      }
    });

    //console.warn(JSON.stringify(arr));
    $("#importado").attr('esimportado',"si");     
    if(errores>=1)
    {
       $("#status").html('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"><em> </em></strong><br>El archivo cargado contiene errores, corriga los errore, recargue esta pagina e intentelo de nuevo</div>');
       $("#reload").hide()
       $("#guardar").hide()
    }
    else
    {
      $("#reload").show()
      $("#guardar").show()
      if(contador < 1){
        $("#alertas"). html('<div class="alert alert-error alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  <strong teid="ale:html:1"></strong>'+obtenerTerminoLenguage('ale', '72')+'</div>'); 
      }
      else{
        $("#status").html('<strong>' + obtenerTerminoLenguage('co','103') + String(Number(contador) - 2) + obtenerTerminoLenguage('co','104') + '</strong>');
      }
    }
    
    $(document).renderme('co');
    $("#ctrlTable").hide();
    $("#totales").hide();
    sessionStorage.setItem('si',JSON.stringify(arr));
    //console.warn(arr);
  }
  reader.readAsText(data);
  $(document).renderme('co');
  
}