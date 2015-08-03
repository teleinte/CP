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

function traerDatosCargos(datos)
{
	var numerador=2
    try{
        $.each(datos, function(x , y) 
        {
            numerador+=1;
            var idmongo= JSON.stringify(y['_id']);
            var idMongoFinal = JSON.parse(idmongo);
            if(y['cargo']=="Administracion" || y['cargo']=="Cuota Extraordinaria")
            {
              $("#tablaCuentas tbody ").append('<tr><td></td><td width="20%" class="titulo-campos">'+y['cargo']+'</td><td width="20%" class="titulo-campos">'+y['Activo_Pasivo']+'</td><td width="20%" class="titulo-campos">'+y['cuenta_ingreso']+'</td><td width="20%" class="titulo-campos"><a class="btn editar solo inline" teid="co:title:35" href="editar-cargo.php?idt='+idMongoFinal.$id+'"></a></td></tr>');
            }
            else
            {
              $("#tablaCuentas tbody ").append('<tr><td></td><td width="20%" class="titulo-campos">'+y['cargo']+'</td><td width="20%" class="titulo-campos">'+y['Activo_Pasivo']+'</td><td width="20%" class="titulo-campos">'+y['cuenta_ingreso']+'</td><td width="20%" class="titulo-campos"><a class="btn editar solo inline" teid="co:title:35" href="editar-cargo.php?idt='+idMongoFinal.$id+'"></a> <a class="btn borrar solo inline" teid="co:title:81" href="eliminar-cargo.php?idt='+idMongoFinal.$id+'"></a></td></tr>');
            }
        });
        $("#numeradores").val(numerador);                       
    }catch(e)
    {
        //alert("estamos ´por este lado"); //error in the above string(in this case,yes)!
        $("#numeradores").val(numerador);                        
    } 

    $("#tablaCuentas").DataTable({
    columnDefs: [{
            className: 'control',
            orderable: false,
            targets:   0
        }],
    responsive: {
      details: {
                type: 'column'
      }
    },
    order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": obtenerTerminoLenguage('ta','20'),
      exclude: [ 0, 1 ],
      exclude: [ 0, 4 ]
    },
    "language": {
      "sProcessing":     obtenerTerminoLenguage('ta','2'),
      "sLengthMenu":     obtenerTerminoLenguage('ta','3'),
      "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
      "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
      "sInfo":           obtenerTerminoLenguage('ta','6'),
      "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
      "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
      "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
      "sSearch":         obtenerTerminoLenguage('ta','10'),
      "sUrl":            obtenerTerminoLenguage('ta','11'),
      "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
      "sLoadingRecords": obtenerTerminoLenguage('ta','13'),
      "oPaginate": {
        "sFirst":    obtenerTerminoLenguage('ta','14'),
        "sLast":     obtenerTerminoLenguage('ta','15'),
        "sNext":     obtenerTerminoLenguage('ta','16'),
        "sPrevious": obtenerTerminoLenguage('ta','17')
      },
      "oAria": {
        "sSortAscending":  obtenerTerminoLenguage('ta','18'),
        "sSortDescending": obtenerTerminoLenguage('ta','19')
      }
        }
  });
}
function traerCargosModificable(datos)
{
	//alert("estamos por este lado"+JSON.stringify(datos));
	$.each(datos, function(x , y) 
    {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        if(y['cargo']=="Administracion" || y['cargo']=="Cuota Extraordinaria")
        {
          $("#cargo").prop('disabled', true);
          $('#cargo').val(y['cargo']);
        }
        else
        {
          $("#cargo").prop('disabled', false);
          $('#cargo').val(y['cargo']);
        }
        $('#cargoMostrar').html(obtenerTerminoLenguage('co','82')+y['cargo']+'?');
        $('#Activo_Pasivo').val(y['Activo_Pasivo']);
        $('#cuenta_ingreso').val(y['cuenta_ingreso']);
        $('#indicesfinales').val(y['identificador']);                          
        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
    })
}