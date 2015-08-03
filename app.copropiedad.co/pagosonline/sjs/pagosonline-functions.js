//funcion para popular la tabla de pagos realizados por copropiedad
function popularTabla(datos)
{
  if(datos!= null || datos!= undefined)
    $.each(datos, function(x , y) 
    {
      if(y['id_crm_persona'])
      { 
        var idmongo= JSON.stringify(y['id_copropiedad']);
        var id_pago= y['referenceCode'];
        //alert(idmongo);
        var id_copropiedadFinal = JSON.parse(idmongo);
        //alert(id_copropiedadFinal);
        var t = $('#pagostable').DataTable();
                       
        t.row.add( 
          [
          '',                            
          y['referenceCode'],
          y['buyerEmail'],
          y['description'],
          y['estado'],
          y['amount'],
          y['fecha_creacion']
          //' <a class="btn" href="del_client.php?idt='+idMongoFinal.$id+'">Eliminar</a>'//'<a id="open-editarcopripiedad" class="btn" href="nueva_ref.php?idt='+idMongoFinal.$id+'"></a>',//<a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
          ] ).draw();
      }
    })
}

//funcion para popular las credenciales de pago
function popularCredenciales(datos)
{
  if(datos!= null || datos!= undefined)
  {
    $.each(datos, function(x , y) 
      {
        $('#nombre').val(y['nombre']);
        $('#apikey').val(y['apikey']);
        $('#apikey_login').val(y['apikey_login']);
        $("#llave_publica").val(y['llave_publica']),
        $('#merchantId').val(y['merchantId']);
        $('#accountId').val(y['accountId']);
        $('#tipo').val('1');
        /*if($('#tipo').val()=="0")
          {
            $('#btn_submit').attr("teid", "pa:val:42, pa:title:44");
          }
          else
          {
            $('#btn_submit').attr("teid", "pa:val:43, pa:title:44");
          }*/
      });
    $("#btn_submit").hide();
  }
}

//CALCULA LA BASE SI EL MONTO LLEVA IVA INCLUIDO
function calcularImpuestos(tasa, monto, incluido)
{
  if(incluido)
  {
      if(tasa==16){ var iva=1.16; }
      if(tasa==5){ var iva=1.05; }
      var valorSinIva = (monto/iva);
      var valorDelIva = valorSinIva*(tasa/100);        
      var Base=[((Math.round(valorSinIva*100))/100),((Math.round(valorDelIva*100))/100)];
      return Base;
  }
  else
  {
      var valorDelIva = monto*(tasa/100);
      var Base= [monto,valorDelIva];
      return Base;
  }                
}
//DA FORMATO A FECHA DE CREACION
function fecha()
{
  var d = new Date();
  var n = (d.getMonth() + 1) + "-" + d.getDate() + "-" + d.getFullYear()+"  "+d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds(); 
  return n;
} 