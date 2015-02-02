function envioFormulario(arr,url,metodo){
    $.post( url, arr)
    .done(function(data)
    {             
        $.each(data, function(x , y) {
            if (x=="status" && y===false)
            {
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><strong>Error:</strong>Usuario o clave invalidos.</div>')
                return false
            }
            else
            {
                if (x=="message")
                {
                    $.each(y, function(nombre , dato)
                    {
                        sessionStorage.setItem(nombre, dato);
                    })
                }
            }
           CreaTokenLogin(sessionStorage.getItem('id_crm'), sessionStorage.getItem('nombre'));           
        }
        );
        return false
     });
}

function TraerModulosCopropiedad(arr,url,metodo){
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
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
                        sessionStorage.setItem("cp", idMongoFinal.$id);
                        var datos = JSON.stringify(y['modulos_activos']);
                        var endata =  JSON.parse(datos);                        
                        for (i in endata)
                        {                                    
                            if(endata[i]==1)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="tareas/tareas.html" id="tarea"><img src="images/tareas.png" /><h6>Tareas</h6></a></div></div></div>')     
                            }
                            else if (endata[i]==2)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                            }
                            else if (endata[i]==3)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                            }
                            else if (endata[i]==4)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                        }
                        return false
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}

function TraerCopropiedadDrop(arr,url,metodo){
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";    
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
                        if (idMongoFinal.$id==sessionStorage.getItem('cp'))
                        {
                            $('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" selected>'+y['nombre']+'</option>')
                        }
                        else
                        {
                            $('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" >'+y['nombre']+'</option>')    
                        }
                    })               
                }
                return false;
            }
        });
}