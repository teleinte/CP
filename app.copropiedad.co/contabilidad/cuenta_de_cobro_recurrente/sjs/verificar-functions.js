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
        $("#tch").append('<td></td><td>Inmueble</td>'); 
        $.each(datos, function(x , y) 
        {
            try
            {
                var idmongo= JSON.stringify(y['_id']);
                var idMongoFinal = JSON.parse(idmongo);
                $("#tch").append('<td>' + y['cargo'] + '</td>'); 
            }
            catch(e)
            {
                $("#numeradores").val(numerador);
            }
        });
        sessionStorage.setItem("cargos",numeroCargos.substring(0, numeroCargos.length-1));   
    }
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
            $("#tablaCuentas tbody ").append('<tr><td width="20%" class="titulo-campos">'+y['cargo']+'</td><td width="20%" class="titulo-campos">'+y['Activo_Pasivo']+'</td><td width="20%" class="titulo-campos">'+y['cuenta_ingreso']+'</td><td width="20%" class="titulo-campos"><a class="btn editar solo inlinettip" teid="co:title:35" href="editar-cargo.php?idt='+idMongoFinal.$id+'"></a> <a class="btn borrar solo inlinettip" teid="co:title:81" href="eliminar-cargo.php?idt='+idMongoFinal.$id+'"></a></td></tr>');
        });
        $("#numeradores").val(numerador);                       
    }catch(e)
    {
        $("#numeradores").val(numerador);
    } 
}

function popularFacturables(datos)
{
    if(datos != null || datos != undefined)
        if(datos.length > 0 )
            $.each(datos,function(k,v){
                var thisCargo = "";
                $.each(v['cargos'].split(','),function(x,y){
                    var cargo = y.split('|');
                    thisCargo += cargo[4] + " ";
                });
                //console.warn(thisCargo);
                var arrc = Array('',v['nombre_inmueble']);
                $.each(thisCargo.split(' '),function(x,y){
                    arrc.push(accounting.formatMoney(y, "$ ", 0));
                });
                //console.warn(arrc);
                var t = $("#cargos").DataTable();
                t.row.add(arrc);
                t.draw();   
            });
}