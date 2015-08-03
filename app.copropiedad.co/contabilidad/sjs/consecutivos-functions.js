function popularCifras(datos)
{

  $('#titulador').html('Asignación números consecutivos iniciales');
  $.each(datos, function(x , y) 
	{
	    var idmongo= JSON.stringify(y['_id']);
	    var idMongoFinal = JSON.parse(idmongo);
	    $('#cc').val(y['cc']);
	    $('#rc').val(y['rc']);
	    $('#fv').val(y['fv']);
	    $('#ce').val(y['ce']);
	    $('#nc').val(y['nc']);
	    $('#fc').val(y['fc']);
	    $('#id').val(y['_id']['$id']);
	    if(y['cc']!=1 || y['rc']!=1 || y['fv']!=1 || y['ce']!=1 || y['nc']!=1 || y['fc']!=1)
	    {
	    	$('#guardarNumeracion').css("display", "none")
		    $('#guardarNumeracion').attr("disabled", true);
		    $('#titulador').html('Consecutivos');
	    	$('#cc').prop('disabled', true);
		    $('#rc').prop('disabled', true);
		    $('#fv').prop('disabled', true);
		    $('#ce').prop('disabled', true);
		    $('#nc').prop('disabled', true);
		    $('#fc').prop('disabled', true);
	    }
	});
}