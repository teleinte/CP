function envioFormulario(arr,url,params,metodo)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
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
                $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                window.location = '../index.php';
            }
            if(mensaje.status)
            {
                if(url=="tareas/list" && metodo=="POST")
                    {
                        enviocorreo();
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Tarea creada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="tareas/list" && metodo=="PUT")
                    {
                        enviocorreo();
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                        setTimeout(refreshWindow, 1000);
                    }    
                if(url=="eventos/evento/" && metodo=="POST")
                    {
                        enviocorreo();
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Evento creado satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="eventos/evento/" && metodo=="PUT")
                    {
                        enviocorreo();
                        $('#alertas').html('<div class="alert alert-dismissable alert-success" style="height:10px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Cambio satisfactorio.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
            }
            else
            {
                $('#resultado').html(mensaje.error);
            }
        }
    })        
}
function traerDatos(arr,url,params)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
                        var inicio = y['fecha_inicio'].split("T")[0] + " a las " + y['fecha_inicio'].split("T")[1].replace(":00+00:00","");
                        var fin = y['fecha_fin'].split("T")[0] + " a las " + y['fecha_fin'].split("T")[1].replace(":00+00:00","");
                        if(y['estado']=="Completada")
                        {
                            t.row.add( [
                            '',                            
                            y['nombre'],
                            y['notas'],
                            inicio,
                            fin,
                            y['estado'],
                            ''
                        ] ).draw();

                        }
                        if(y['estado']!="Cerrada")
                        {
                           t.row.add( [
                            '',                            
                            y['nombre'],
                            y['notas'],
                            inicio,
                            fin,
                            y['estado'],
                            '<a id="open-editarcopropiedad" class="btn editar solo inline" href="evento-editar.php?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="evento-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                        ] ).draw();
                        }
                        //$('#example tr:last').after('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')                        
                    })
                }                
            }
        });
        sessionStorage.setItem("referer","../evento/");
}
function traerEventosModificables(arr,url,params)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo); 
                        var horainicio="";
                        var fecha_inicio="";
                        var horafin="";
                        var fecha_fin="";
                        var frec = "";
                        var comp_cop = false;
                        if(y['frecuencia'].length < 2){frec = "Ninguna";};     
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#creador').val(y['creador']);
                            $('#fecha_creacione').val(y['fecha_creacion']);
                            $('#nombree').val(y['nombre']);
                            horainicio=y['fecha_inicio'].replace("Z",'');
                            fecha_inicio=y['fecha_inicio'].split("T")[0];
                            hora_inicio=y['fecha_inicio'].split("T")[1].replace(":00+00:00","");
                            fecha_fin=y['fecha_fin'].split("T")[0];
                            hora_fin=y['fecha_fin'].split("T")[1].replace(":00+00:00","");
                            $('#datepicker3').val(fecha_inicio);
                            $('#starttimee').val(hora_inicio);
                            $('#datepicker4').val(fecha_fin);
                            $('#endtimee').val(hora_fin);                            
                            $('#compartir_maile').val(y['compartir_mail']);
                            $('#frecuenciae').val(y['frecuencia']);
                            $('#ver_copropiedade').prop("checked", y['cal_copropiedad']);
                            $('#datepicker5').val(y['frecordatorio']);
                            $('#recordatorio_maile').prop("checked", y['recordatorio_mail']);
                            $('#recordatorio_cpe').prop("checked", y['recordatorio_cp']);                            
                            $('#notase').val(y['notas']);
                        }                    
                    })
                }                
            }
        });
}
function traerDatosModificables(arr,url,params)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);  
                        var frec = "";
                        if(y['frecuencia'].lenght > 2){frec = "Ninguna";};             
                        if(idMongoFinal.$id==params['idt'])
                        {
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#creador').val(y['creador']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#nombre').val(y['nombre']);
                            $('#estado').val(y['estado']);
                            $('#responsable').val(y['responsable']);
                            $('#fecha_fin').val(y['fecha_fin']);
                            $('#prioridad').val(y['prioridad']);
                            $('#datepicker2').val(y['deadline']);
                            $('#notas').val(y['notas']);                            
                            $('#frecuenciae').val(frec);
                            $('#datepicker').val(y['frecordatorio']);
                            $('#recordatorio_mail').prop("checked", y['recordatorio_mail']);
                            $('#recordatorio_cp').prop("checked", y['recordatorio_cp']);                            
                            $('#compartir_mail').val(y['compartir_mail']);
                        }                    
                    })
                }                
            }
        });
}
function traerDatosEliminables(arr,url,params)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";    
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../index.php';
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {
                            //alert(y['recordatorio_cp']);
                            $('#id_copropiedad').val(y['id_copropiedad']);
                            $('#creador').val(y['creador']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#tipo').val(y['tipo']);
                            $('#nombre').val(y['nombre']);
                            $('#estado').val(y['estado']);
                            $('#responsable').val(y['responsable']);
                            $('#finicio').val(y['fecha_inicio']);
                            $('#prioridad').val(y['prioridad']);
                            $('#ffin').val(y['fecha_fin']);
                            $('#notas').val(y['notas']);                            
                            $('#frecuencia').val(y['frecuencia']);
                            $('#frecordatorio').val(y['frecordatorio']);
                            $('#recordatorio_mail').val(y['recordatorio_mail']);
                            $('#recordatorio_cp').val(y['recordatorio_cp']);
                            $('#compartir_mail').val(y['compartir_mail']);
                        }                    
                    })
                }                
            }
        });
}
function TraerUsuarioCopropiedad(arr,url,metodo)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/admin/copropiedad/";    
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
                        
                        
                    })               
                }
                return false;
            }
        });
}
function refreshWindow()
{
    if(sessionStorage.getItem("referer").lenght < 2){window.location = 'index.php'}else{window.location = sessionStorage.getItem("referer");};
}
function TraerModulosCopropiedad(arr,url,metodo){ 
    //alert("Ahora Si");
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
                        sessionStorage.setItem("cp", idMongoFinal.$id);
                        var datos = JSON.stringify(y['modulos_activos']);
                        sessionStorage.setItem("modulos",y['modulos_activos'])
                        var endata =  JSON.parse(datos);                                                
                        //$('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}