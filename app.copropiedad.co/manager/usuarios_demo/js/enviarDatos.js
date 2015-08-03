function envioFormulario(arr,url,params,metodo)
{       
    var rutaAplicatico = "https://aws02.sinfo.co/api/managercp/";
    $.ajax(
    {
        url: rutaAplicatico+url,
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
                setTimeout(refreshWindow, 4000);
                //window.location = '../../index.php';
            }
            if(mensaje.status)
            {                  
                var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona: sessionStorage.getItem('id_crm'),id_copropiedad:mensaje.mensaje,direccion:direccion,nombre:nombre,rol:"administrador"}};
                var url = "rol";
                envioFormularioDos(arr,url,'POST')
            }
            else {$('#resultado').html(mensaje.error);}
        }
    })        
}

function limpiaForm(miForm) {

$(':input', miForm).each(function() {
var type = this.type;
var tag = this.tagName.toLowerCase();

if (type == 'text' || tag == 'textarea')
this.value = "";

else if (type == 'checkbox')
this.checked = false;

});
}

function refreshWindow()
{
    window.location = 'index.php';
}

function traerDatos(arr,url,params)
{
    var rutaAplicatico = "https://aws02.sinfo.co/api/managercp/";
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
                    window.location = '../../index.php';
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
                                y['name_client'],
                                y['cc_client'],
                                y['email_client'],
                                y['tel_client'],
                                y['id_crm_persona'],
                                y['origin_client'],
                                y['pais_client'],
                                y['ciudad_client'],
                                y['fecha_registro'],
                                y['fecha_fin'],
                                '<a class="btn" href="edit_client.php?idt='+idMongoFinal.$id+'">Editar</a> <a class="btn" href="del_client.php?idt='+idMongoFinal.$id+'">Eliminar</a>'//'<a id="open-editarcopripiedad" class="btn" href="nueva_ref.php?idt='+idMongoFinal.$id+'"></a>',//<a class="btn borrar solo inline" href="tarea-eliminar.php?idt='+idMongoFinal.$id+'"></a>'
                            ] ).draw();                    
                    })
                }                
            }
        });
}


