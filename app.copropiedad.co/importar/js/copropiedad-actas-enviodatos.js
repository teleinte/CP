function envioFormulario(arr,url,params,metodo)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/";
    $.ajax(
    {
        url: rutaAplicativo+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: true,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message=="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                window.location = '../index.php';
            }
            if(mensaje.status)
            {
                if(url=="documentos/list" && metodo=="POST")
                {
                    $('#alertas').html('<div class="alert alert-success" style="height:10px;">Documento creado!.</div>');
                    setTimeout(refreshWindow, 1000);
                }
                if(url=="documentos/list" && metodo=="PUT")
                {
                    $('#alertas').html('<div class="alert alert-success" style="height:10px;">Documento Modificado!.</div>');
                    setTimeout(refreshWindow, 1000);
                }
            }
            else
            {
                $('#resultado').html(mensaje.error);
            }
        }
    });
}

function envioFormularioEliminado(arr,url,params,metodo)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/";
    $.ajax(
    {
        url: rutaAplicativo+url,
        type: metodo,
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: true,
        success: function(msg) 
        {
            var msgDividido = JSON.stringify(msg);
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if(mensaje.message=="Token invalido")
            {
                $('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                window.location = '../index.php';
            }
            if(mensaje.status)
            {
                if(url=="documentos/list" && metodo=="PUT")
                {
                    $('#alertas').html('<div class="alert alert-success" style="height:10px;">Documento Eliminado correctamente!.</div>');
                    setTimeout(refreshWindow, 1000);
                }
            }
            else
            {
                $('#resultado').html(mensaje.error);
            }
        }
    });
}




function traerDatos(arr,url,params)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/";
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var t = $('#example').DataTable();                        
                        
                            t.row.add( [
                            '',
                            y['nombre'],
                            y['descripcion'],
                            y['fecha_creacion'].replace("T",' ').replace("Z",''),                            
                            '<a class="btn descargar solo inline" title="Descargar" href="'+y['enlace']+'"></a><a id="open-editarcopripiedad" class="btn editar solo inline" href="acta-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="acta-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        ] ).draw();
                        
                        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
                    })
                }                
            }
        });
}


function traerDatosModificables(arr,url,params)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/";
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        $('#nombrearchivo').val(y['nombre']);
                        $('#nombremostrar').append(y['nombre']);
                        $('#observacion').val(y['descripcion']);
                        $('#filepath').val(y['enlace']);
                        $('#tipo').val(y['tipo']);
                        $('#estado').val(y['estado']);
                        $('#fecha_creacion').val(y['fecha_creacion']);                        
                        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
                    });
                }                
            }
        });
}

function TraerUsuarioCopropiedad(arr,url,metodo)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                        
                        $('#responsable').append('<option value="'+y['email']+'">'+y['nombre']+'</option>')
                        
                        
                    });               
                }
                return false;
            }
        });
}

function refreshWindow()
{
    window.location = 'index.php';
}

function TraerModulosCopropiedad(arr,url,metodo)
{ 
    var rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {                    
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                       
                        sessionStorage.setItem("cp", idMongoFinal.$id);
                        var datos = JSON.stringify(y['modulos_activos']);
                        sessionStorage.setItem("modulos",y['modulos_activos'])
                        var endata =  JSON.parse(datos);                                                
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    });
                }                
            }
        });
}