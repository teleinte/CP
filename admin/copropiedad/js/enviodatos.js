function envioFormulario(arr,url,params,metodo,direccion,nombre){		
        const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
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
                   	window.location = '../../index.html';
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

function envioFormularioDos(arr,url,metodo){        
        const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
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
                    window.location = '../../index.html';
                }
                if(mensaje.status)
                {                  
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato insertado Correctamente.</div>')                    
                    window.location = 'copropiedad.html'
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
                    window.location = '../../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        $('#tableContainer > tbody:last').append('<tr><td>'+y['nombre']+'</td><td>'+y['direccion']+'</td><td>'+y['telefono']+'</td><td>'+y['nit']+'</td><td><a class="btn editar solo inline" href="copropiedad-editar.html?idt='+idMongoFinal.$id+'"></a><a class="btn borrar solo inline" href="copropiedad-eliminar.html?idt='+idMongoFinal.$id+'"></a></td></tr>')
                    })
                }                
            }
        });
}

function pintarModulos()
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+"modulos",
            type: 'POST',
            //data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var res='';
                var nombre='';
                var valor='';
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                //var datos = JSON.parse(msgDivididoDos);
                datos=msgDivididoDos;                
                var res = datos.split("|");
                for (i in res) 
                {                    
                    var ress = res[i].split(",");
                    nombre=ress[1].replace('"','');
                    valor=ress[0].replace('"','');
                    //alert(ress[0]);
                    $('#tableModules > tbody:last').append('<tr><td>'+nombre+' <input type="checkbox" id="modulos[]" name="namemodules[]" value="'+valor+'"></td></tr>')   
                }                
            }
        });
}
function traerDatosModificables(arr,url,params)
{
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../../index.html';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {                            
                            $("input[name='namemodules[]']").each(function ()
                            {
                                sleep(500)
                                var datos = JSON.stringify(y['modulos_activos']);
                                var endata =  JSON.parse(datos);                                
                                for (i in endata)
                                {                                    
                                    if($(this).val() == endata[i])
                                    {
                                         $(this).prop("checked", true)                                         
                                     }
                                }
                            });
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#nombre').val(y['nombre']);
                            $('#direccion').val(y['direccion']);
                            $('#telefono').val(y['telefono']);
                            $('#nit').val(y['nit']);
                            $('#email').val(y['email']);
                            $('#tipocopropiedad').val(y['tipocopropiedad']);
                            $('#porteria').prop("checked", y['tiene_porteria']);
                            $('#ascensor').prop("checked", y['tiene_acensor']);
                            $('#zona_ddq').prop("checked", y['tiene_zona_ddq']);
                            $('#piscina').prop("checked", y['tiene_piscina']);
                            $('#gimnasio').prop("checked", y['tiene_gimnasio']);
                            $('#sauna').prop("checked", y['tiene_sauna']);
                            $('#turco').prop("checked", y['tiene_turco']);
                            $('#jardin').prop("checked", y['tiene_jardin']);                           
                            $('#estadp').val(y['estadp']);
                            $('#modulos').val(y['modulos_activos']);                            
                            $('#color > option[value="'+y['color']+'"]').attr('selected', 'selected');
                        }                    
                    })
                }                
            }
        });

function sleep(milliseconds) { 
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
}

function traerModificablesEnteros(arr,url,params)
{
    const rutaAplicatico = "http://aws02.sinfo.co/api/admin/copropiedad/";
    $.ajax(
        {
            url: rutaAplicatico+url,
            type: 'POST',
            data: JSON.stringify(arr),
            cache: false,
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
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> NO PUDO LISTAR POR TOKEN, Solicitando un nuevo token por favor espere.</div>')
                    window.location = '../../index.html';                      
                }
                else
                {
                    $.each(datos, function(x , y) {               
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);               
                        if(idMongoFinal.$id==params['idt'])
                        {                            
                            $('#id_crm_persona').val(y['id_crm_persona']);
                            $('#fecha_creacion').val(y['fecha_creacion']);
                            $('#nombre').val(y['nombre']);
                            $('#direccion').val(y['direccion']);
                            $('#telefono').val(y['telefono']);
                            $('#nit').val(y['nit']);
                            $('#email').val(y['email']);
                            $('#tipocopropiedad').val(y['tipocopropiedad']);
                            $('#porteria').prop("checked", y['tiene_porteria']);
                            $('#ascensor').prop("checked", y['tiene_acensor']);
                            $('#zona_ddq').prop("checked", y['tiene_zona_ddq']);
                            $('#piscina').prop("checked", y['tiene_piscina']);
                            $('#gimnasio').prop("checked", y['tiene_gimnasio']);
                            $('#sauna').prop("checked", y['tiene_sauna']);
                            $('#turco').prop("checked", y['tiene_turco']);
                            $('#jardin').prop("checked", y['tiene_jardin']);                           
                            $('#estadp').val(y['estadp']);
                            $('#modulos').val(y['modulos_activos']);                            
                            $('#color').val(y['color']);                            
                        }                    
                    })
                }                
            }
        });

function sleep(milliseconds) { 
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
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