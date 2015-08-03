function popularSelect(datos)
{
	if(datos != null || datos != undefined)
	$.each(datos, function(x , y) 
    {
        $.each(y, function(alpha , beta) 
        {
            //alert(alpha+" "+beta)
            if(alpha=="_id")
            {
                //alert("esta es la vuelta");
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
            
            try{
                    var idmongo= JSON.stringify(y['_id']);
                    var idMongoFinal = JSON.parse(idmongo);                            
                    $("#tablaContenedora tbody ").append('<tr><td style="text-align:right"><label for="'+y['identificador']+'">'+y['cargo']+':</label></td><td><input type="number" id="'+y['identificador']+'" class="cargo" style="width:85%" required></td></tr>');
                    sessionStorage.setItem(y['identificador'],y['identificador']+"|"+y['cargo']+"|"+y['Activo_Pasivo']+"|"+y['cuenta_ingreso']);
                    numeroCargos+=y['identificador']+",";
                         
            }catch(e)
            {
                $("#numeradores").val(numerador);                        
            } 
        });
        sessionStorage.setItem("cargos",numeroCargos.substring(0, numeroCargos.length-1));   
    }    
    
}

function generarPlantilla(inmuebles, facturables, cargos)
{
    var arr=  {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
    var principales = traerDatosSync("admin/copropiedad/usuario/copropiedad/principales/", arr);
    var out = "id;nombre;contacto principal;";
    var contadorcargos = 0;
    var relleno ="";
    var cargados = Array();
    
    $.each(cargos, function(a,b){
        out += b['cargo'] + "(" + b['cuenta_ingreso'] + "|" + b['Activo_Pasivo'] + "|" + b['identificador'] + ");";
        relleno += "0;";
        contadorcargos ++;
    });

    out = out.slice(0, - 1);
    out += '\n';

    $.each(inmuebles,function(c,d){
        var line = "";
        $.each(principales, function(e,f){
            if(f['unidad'] == d['_id']['$id'])
            {
                line = d['_id']['$id'] + ";" + d['nombre_inmueble'] + ";" + f['nombre'] + ";";
                if(facturables != null || facturables != undefined)
                {
                    $.each(facturables, function(g,h){
                        if(h['id_inmueble'] == d['_id']['$id'])
                        {
                            var thisCargos = h['cargos'].split(',');
                            cargados.push(h['id_inmueble']);
                            $.each(thisCargos, function(i,j){
                                line += j.split('|')[4] + ";";
                            });
                        }
                    });
                }
            }
        });

        var cur = cleanArray(line.split(';'));
        if(cur.length <= 3)
            line += relleno;

        line = line.slice(0, - 1);
        out += line + '\n';
    });
    
    //console.warn(facturables);
    return out;
}

function generarPlantillaMac(inmuebles, facturables, cargos)
{
    var arr=  {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
    var principales = traerDatosSync("admin/copropiedad/usuario/copropiedad/principales/", arr);
    var out = "id,nombre,contacto principal,";
    var contadorcargos = 0;
    var relleno ="";
    var cargados = Array();
    
    $.each(cargos, function(a,b){
        out += b['cargo'] + "(" + b['cuenta_ingreso'] + "|" + b['Activo_Pasivo'] + "|" + b['identificador'] + "),";
        relleno += "0,";
        contadorcargos ++;
    });

    out = out.slice(0, - 1);
    out += '\n';

    $.each(inmuebles,function(c,d){
        var line = "";
        $.each(principales, function(e,f){
            if(f['unidad'] == d['_id']['$id'])
            {
                line = d['_id']['$id'] + "," + d['nombre_inmueble'] + "," + f['nombre'] + ",";
                if(facturables != null || facturables != undefined)
                {
                    $.each(facturables, function(g,h){
                        if(h['id_inmueble'] == d['_id']['$id'])
                        {
                            var thisCargos = h['cargos'].split(',');
                            cargados.push(h['id_inmueble']);
                            $.each(thisCargos, function(i,j){
                                line += j.split('|')[4] + ",";
                            });
                        }
                    });
                }
            }
        });

        var cur = cleanArray(line.split(','));
        if(cur.length <= 3)
            line += relleno;

        line = line.slice(0, - 1);
        out += line + '\n';
    });
    
    //console.warn(facturables);
    return out;
}

function uploadFileCargos(data,crg)
{
    var reader = new FileReader();
    reader.onload = function(event) 
    {
    data = event.target.result;
    var contador = 0;
    var arr = Array();
    var arrc = Array();
    var out = '';
    var cols = "";
    var salida = Array();
    var hiddens = "";
    var separador = "";
    var filador=0;
    $.each(data.split(/\n?\r/),function(k,v){
        if(v.length > 5)
        {
            if(contador == 0)
            {
                out += '<tr><td>Linea</td>';
                hiddens += '<input type="hidden" class="camposimportacion" idimportacion="' + contador + '" campos="';

                var check = v.split(";");
                if(check[1] != null || check[1] != undefined)
                  separador = ";";
                else
                  separador = ",";
                
                $.each(v.split(separador),function(x,y){
                    if(x != 0)
                        out += '<th class="titulo-campos">' + ucfirst(y).split('(')[0] + '</th>';
                    hiddens += y + ";";
                });

                hiddens += '"/>';
                out += '</tr>';
            }
            
            if(contador > 0)
            {
                //console.warn(';');
                out += '<tr><td>'+filador+'</td>';
                hiddens += '<input type="hidden" class="camposimportacion" idimportacion="' + contador + '" campos="';

                $.each(v.split(separador),function(x,y){
                    var line = "";
                    if(x != 0)
                        out += '<td>' + y + '</td>';
                    hiddens += y + ";";
                });

                hiddens += '"/>';
                out += '</tr>';
            }
            contador ++;
        }
        filador++;
    });

    $("#importacion").append('<div id="hiddens">' + hiddens + '</div>');

    $("#cargos").append(out);
    $("#importacion").append('<div class="botones-form" style="width:100%"><input type="button" id="importar" class="btn icono guardar ttip" teid="co:val:151"/><input type="button" class="btn borrar icono ttip" id="reload" teid="pr:val:60, pr:title:61"/></div>');
    
    $("#reload").click(function(){
          location.reload();
        });

    $("#importado").attr('esimportado',"si");
    //console.warn(contador);
    $("#status").html('<strong>' + obtenerTerminoLenguage('co','152') + String(Number(contador) - 1) + obtenerTerminoLenguage('co','153') + '</strong>');
    $(document).renderme('co');
    $("#asignar-cargo").hide();
    $("#importacion").show();
    sessionStorage.setItem('cgs',JSON.stringify(arr));
    $(document).renderme('co');

    $("#importar").click(function(){
        $("#cpImportando").show();
        var importacion = Array();
        var campos = "";
        var cargosarr = Array();
        $('.camposimportacion').each(function(k,v){
            if($(this).attr('idimportacion') == "0")
            {
                var cols = $(this).attr('campos').slice(0, - 1);
                $.each(cols.split(';'),function(x,y){
                    if(x > 2)
                    {
                        var camposimportacion_nombrecargo = y.split('(')[0];
                        var camposimportacion_ingreso = y.split('(')[1].replace(')','').split('|')[0];
                        var camposimportacion_activo = y.split('(')[1].replace(')','').split('|')[1];
                        var camposimportacion_id = y.split('(')[1].replace(')','').split('|')[2];

                        var elem = camposimportacion_id + "|" + camposimportacion_nombrecargo + "|" + camposimportacion_ingreso + "|" + camposimportacion_activo + "|";
                        cargosarr.push(elem);
                    }
                });
            }
        });
        
        //console.warn(cargosarr);

        var actualinmuebles = Array();
        $('.camposimportacion').each(function(k,v){
            if($(this).attr('idimportacion') != "0")
            {   
                var camposactuales = $(this).attr('campos').slice(0, - 1).split(';');

                //console.warn(camposactuales);
                var this_id = camposactuales[0];
                var this_nombre = camposactuales[1];
                var this_principal = camposactuales[2];
                var this_cargos = "";

                for (var i = 0; i <= cargosarr.length -1; i++) 
                {
                    this_cargos += cargosarr[i] + camposactuales[i + 3] + ",";
                };

                this_cargos = this_cargos.slice(0, - 1);

                var arr =  
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad:sessionStorage.getItem('cp'),
                    responsable: this_principal,
                    nombre_inmueble:this_nombre,
                    id_crm_persona:sessionStorage.getItem('id_crm'),
                    fecha_creacion:fecha(),
                    id_inmueble:this_id,
                    cargos:this_cargos
                  }
                };

                actualinmuebles.push(arr);
            }
        });

        //console.warn(actualinmuebles);

        var res = envioFormularioSync("cartera/inmueble/cargos/importar/",actualinmuebles[0],'PUT');
        
        if(res)
            $.each(actualinmuebles,function(a,b){
                var result = envioFormularioSync("cartera/inmueble/cargos/importar/",b,'POST');
                //console.log(result);
                if(result)
                {
                  //$("#alertas").html('<div class="alert alert-dismissable alert-success">Cargos asignados con exito</div>');
                  sessionStorage.setItem('imporresult',obtenerTerminoLenguage('ale','73'));
                  $(document).renderme('co');
                  location.reload();
                  //console.log(result);
                }
                else
                {
                  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
                  $(document).renderme('co');
                }
            });
    });
    }
    reader.readAsText(data);
    $(document).renderme('co');
}