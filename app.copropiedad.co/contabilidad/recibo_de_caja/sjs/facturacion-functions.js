function FormatearCategoriasContables()
{
	var res = "";
	var cats = $.parseJSON(sessionStorage.getItem('puc'));
	var pucfinal = new Array();
	$.each(cats,function(x,y){
    if(y['cuenta'].length > 4)
      pucfinal.push(y['cuenta'] + "@" + y['cuenta'] + " - " + y['nombre']);
	});
	$.each(pucfinal,function(x,y){
		var key = y.split("@")[0];
		var val = y.split("@")[1];
		res = res + '<option value="' + key + '">' + val + '</option>';
	});	
	return res; 
}

function totalizarDebitos(actualid)
  {
    var result = 0;
    for (var i = 1; i <= actualid; i++) 
    {
        result = Number(result) + Number($("#debitos" + i).val());
    }
    return result;
  }

  function totalizarCreditos(actualid)
  {
    var result = 0;
    for (var i = 1; i <= actualid; i++) 
    {
        result = Number(result) + Number($("#creditos" + i).val());
    }
    return result;
  }
function obtenerContactos(datos)
{
	var personas = new Array();
  if(datos.length > 0)
      $.each(datos,function(x,y){

        if (y['tipo']=="residente" && y['principal']==true)
        {
          //tengo que traer el nombre de la unidad 
          var arr={token:sessionStorage.getItem('token'),body:{_id : y['unidad']}}
          var datosUnidad = traerDatosSync("unidad/unidad/copropiedadid",arr);
          var nombreInmueble="";
          var nit="";
          $.each(datosUnidad,function(alfa,beta){nit=beta["nombre_inmueble"];nombreInmueble=beta["nombre_inmueble"];return nombreInmueble;});          
          personas.push('<option value="' + y['id_crm_persona'] + '" cpemail="' + y['email'] + '" cpidcrm="' + y['id_crm_persona'] + '"cpnombre="' + y['nombre'] + '" cptelefono="' + y['telefono'] + '"nit="' + nit + '">'+ y['nombre'] +' - '+nombreInmueble +'</option>');
        };
        if (y['tipo']=="proveedor")
        {
          //tengo que traer el nombre de la unidad
          var arr={token:sessionStorage.getItem('token'),body:{_id : y['unidad']}}
          var datosUnidad = traerDatosSync("unidad/unidad/copropiedadid",arr);
          var nombreInmueble="";
          var nit="";
          $.each(datosUnidad,function(alfa,beta){nit=beta["nit"];nombreInmueble=beta["nombre_inmueble"];return nombreInmueble;});          
          personas.push('<option value="' + y['id_crm_persona'] + '" cpemail="' + y['email'] + '" cpidcrm="' + y['id_crm_persona'] + '"cpnombre="' + y['nombre'] + '" cptelefono="' + y['telefono'] + '"nit="' + nit + '">'+ y['nombre'] +' - '+nombreInmueble +'</option>');
        };  
      });
  result = personas;
	return result;
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

function obtenerConsecutivos(tipo, datos)
{
	// var msgDividido = JSON.stringify(msg);
	// var mensaje =  JSON.parse(msgDividido);
	// var msgDivididoDos = JSON.stringify(mensaje.message);
	// var datos = JSON.parse(datos);                	            
	result = datos[0][tipo];
	return result;
}
function crearDocumento(contador, consecutivo, nombretercero, emailtercero, concepto_documento, notas_documento, documento_relacionado, tipo_transaccion, id_tercero, nit)
{
    try
    {
        crearTransaccion(consecutivo, nombretercero, emailtercero, concepto_documento, notas_documento, documento_relacionado, tipo_transaccion, id_tercero, nit);
        for (var i = 1; i <= contador; i++)
        {
            var option = $("option:selected",$('#dc_fila' + i));
            var cuenta = $("option:selected",$('#categoria_fila' + i));
            var montod = $("#debitos" + i).val();
            var montoc = $("#creditos" + i).val();
            if(option.val() == "credito")
              crearRegistro(consecutivo, tipo_transaccion, cuenta.val(), "C", montoc, concepto_documento, id_tercero);
            else
              crearRegistro(consecutivo, tipo_transaccion, cuenta.val(), "D", montod, concepto_documento, id_tercero);
        }
        aumentaConsecutivos(tipo_transaccion.toLowerCase());
        return true;
    }
    catch(ex)
    {
        return false;
    }
}
function aumentaConsecutivos(tipodocumento)
{
    var rutaAplicatico = traerDireccion()+"api/"; 
    var arr = 
    {  
    token:sessionStorage.getItem('token'),
    body: 
        {  
           id_copropiedad : sessionStorage.getItem('cp'),
           tipodoc: tipodocumento
        }
    }

    var url = "contabilidad/actualiza/consecutivo";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'PUT',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:24"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="co:html:1"></strong></div>')
                    $(document).renderme('co');
                    window.location = '../../index.html';
                }
                else
                {
                  return datos['status'];    
                }       
            }
        });
}

function crearTransaccion(consecutivo, nombretercero, emailtercero, concepto_documento, notas_documento, documento_relacionado, tipo_transaccion, idcrmtercero, nit)
{
  var d = new Date();
  var today = d.toISOString();
  
  var d = new Date($("#datepicker1").val());
  var newdate = convertUTCDateToLocalDate(d);
  var _year = newdate.getFullYear();
  var _month = newdate.getMonth(newdate.setMonth(newdate.getMonth() + 1));
  var _day = newdate.getDate();

  if(_month < 10)
    _month = "0" + _month;

    var rutaAplicatico = traerDireccion()+"api/"; 
    var arr = 
    {  
     token:sessionStorage.getItem('token'),
     body: 
          {  
            id_copropiedad : sessionStorage.getItem('cp'),
            id_crm_persona:sessionStorage.getItem('id_crm'),
            fecha_creacion:today,
            year:_year,
            mes:_month,
            day:_day,
            tipo:tipo_transaccion,
            idtransaccion:tipo_transaccion + consecutivo,
            nombre_tercero:nombretercero,
            email_tercero:emailtercero,
            id_crm_tercero:idcrmtercero,
            nit:nit,
            concepto_documento:concepto_documento,
            moneda:"COP",
            vendedor_fv:"",
            forma_pago:"",
            notas:notas_documento,
            anulado:"NO",
            tipo_documento:"transaccion",
            docrelacionado: documento_relacionado,
            conciliado:false
          }
    } 
    //console.log(arr);
    var url = "contabilidad/transaccion";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"teid="co:html:24"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="co:html:1"></strong></div>')
                    $(document).renderme('co');
                    window.location = '../../index.html';
                }
                else
                {
                  return datos['status'];    
                }       
            }
    });
}

function crearRegistro(consecutivo, tipo_transaccion, cuenta, tipo, monto, concepto, id_tercero)
{
  var d = new Date();
  var today = d.toISOString();
  
  var d = new Date($("#datepicker1").val());
  var newdate = convertUTCDateToLocalDate(d);
  var _year = newdate.getFullYear();
  var _month = newdate.getMonth(newdate.setMonth(newdate.getMonth() + 1));
  var _day = newdate.getDate();

  if(_month < 10)
    _month = "0" + _month;

    var rutaAplicatico = traerDireccion()+"api/"; 
    var arr = 
    {  
     token:sessionStorage.getItem('token'),
     body: 
          {  
             id_copropiedad : sessionStorage.getItem('cp'),
             id_transaccion:tipo_transaccion + consecutivo,
             fecha_movimiento:today,
             cuenta_puc:cuenta,
             tipo:tipo,
             monto:monto,
             concepto:concepto,
             id_tercero:id_tercero,
             year:_year,
             month:_month,
             day:_day,
             estado:"A",
             tipo_documento:"registrocontable"
          }
    }
  //console.log(arr);
  var url = "contabilidad/registro";
  $.ajax(
      {
          url: rutaAplicatico+url,
          type: 'POST',
          data: JSON.stringify(arr),
          contentType: 'application/json; charset=utf-8',
          dataType: 'json',
          async: false,
          success: function(msg) 
          {
              var msgDividido = JSON.stringify(msg);
              var mensaje =  JSON.parse(msgDividido);
              var msgDivididoDos = JSON.stringify(mensaje.message);
              var datos = JSON.parse(msgDivididoDos);                
              if (datos=="Token invalido")
              {
                  $('#alertas').html('<div class="alert alert-dismissable alert-error"teid="co:html:24"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="co:html:1"></strong></div>')
                    $(document).renderme('co');
                  window.location = '../../index.html';
              }
              else
              {
                return datos['status'];    
              }       
          }
  });
}
