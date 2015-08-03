function popularSelect(datos)
{
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) 
    {
        $.each(y, function(alpha , beta) 
        {
            if(alpha=="_id")
            {
                $.each(beta, function(unico , dosico) 
                {
                    idmongo=dosico;
                });
            }
            if (alpha=="nombre_inmueble")
            {
                $("#inmueble").append('<option value="'+beta+'|'+idmongo+'">'+beta+'</option>');    
            }
        });
    });
}

function popularCargos(datos)
{
    if(datos != null || datos != undefined)
    {
        var numeroCargos="";
        $.each(datos, function(x , y) 
        {
            try
            {
                var idmongo= JSON.stringify(y['_id']);
                var idMongoFinal = JSON.parse(idmongo);
                $("#tablaCuentas tbody ").append('<tr><td style="width:25%"><input type="checkbox" name="cargos" id="' + y['identificador'] + '" value="' + y['identificador'] + '"></td><td style="width:25%">' + y['cargo'] + '</td><td style="width:25%">' + y['Activo_Pasivo'] + '</td><td style="width:25%">' + y['cuenta_ingreso'] + '</td></tr>'); 
                sessionStorage.setItem(y['identificador'],y['identificador']+"|"+y['cargo']+"|"+y['Activo_Pasivo']+"|"+y['cuenta_ingreso']);
                numeroCargos+=y['identificador']+",";
            }
            catch(e)
            {
                $("#numeradores").val(numerador);
            } 
        });
        sessionStorage.setItem("cargos",numeroCargos.substring(0, numeroCargos.length-1));   
    }    
    
}

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
            $("#tablaCuentas tbody ").append('<tr><td width="20%" class="titulo-campos">'+y['cargo']+'</td><td width="20%" class="titulo-campos">'+y['Activo_Pasivo']+'</td><td width="20%" class="titulo-campos">'+y['cuenta_ingreso']+'</td><td width="20%" class="titulo-campos"><a class="btn editar solo inline ttip" teid="co:title:35" href="editar-cargo.php?idt='+idMongoFinal.$id+'"></a> <a class="btn borrar solo inlinettip" teid="co:title:81" href="eliminar-cargo.php?idt='+idMongoFinal.$id+'"></a></td></tr>');
        });
        $("#numeradores").val(numerador);                       
    }catch(e)
    {
        $("#numeradores").val(numerador);
    } 
}

function traerCargosModificable(datos)
{
    $.each(datos, function(x , y) 
    {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        $('#cargo').val(y['cargo']);
        $('#cargoMostrar').html(obtenerTerminoLenguage('co','82')+y['cargo']);
        $('#Activo_Pasivo').val(y['Activo_Pasivo']);
        $('#cuenta_ingreso').val(y['cuenta_ingreso']);
        $('#indicesfinales').val(y['identificador']);
    })
}