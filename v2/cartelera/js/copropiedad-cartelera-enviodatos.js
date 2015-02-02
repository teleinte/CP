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
                $('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')
                window.location = '../index.php';
            }
            if(mensaje.status)
            {
                if(url=="tareas/list" && metodo=="POST")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Publicación creada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="tareas/list/cartelera" && metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Cambio satisfactorio.</div>');
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

function envioFormularioBorrado(arr,url,params,metodo,ev)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
    //ev.preventDefault(); 
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
                if(url=="tareas/list" && metodo=="POST")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Publicación creada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="tareas/list/cartelera" && metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Cambio satisfactorio.</div>');
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

function envioFormularioVenta(arr,url,metodo, ev)
{
    const rutaAplicativo = "http://aws02.sinfo.co/api/";
    ev.preventDefault();        
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
                if(url=="tareas/list" && metodo=="POST")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Publicación creada satisfactoriamente.</div>');
                        setTimeout(refreshWindow, 1000);
                    }
                if(url=="tareas/list/cartelera" && metodo=="DELETE")
                    {
                        $('#alertas').html('<div class="alert alert-success" style="height:10px;">Cambio satisfactorio.</div>');
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

function traerDatos(url,params)
{
    $('#cartelera-board').masonry({
      columnWidth: '.ancho-contenedor',
      itemSelector: '.item'
    });

    if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
    {                      
        $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
            window.location = '../index.html';
    }
    var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"cartelera"}};        
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
                    if(y['tipo'] == "cartelera"){
                        $("#cartelera-board").append('<div class="item"><h2>' + y['nombre'] + '</h2><p>' + y['notas'] + '</p><input type="submit" class="btn borrar solo inline btnborraanuncio" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" class="btn editar solo inline btneditaanuncio" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" valor="' + y['valor'] + '" value=""/></div>').masonry( 'reloadItems' ); 
                         $("#cartelera-board").masonry('layout');   
                    }
                    else{
                        $("#cartelera-board").append('<div class="item ventas"><h2>' + y['nombre'] + '</h2><a class="fancybox" href="'+y['foto']+'"><img src="'+y['foto']+'" alt="Precio: ' + y['valor']  + ' - Descripción: ' + y['notas'] + '"/></a><p>' + y['notas'] + '</p><input type="submit" class="btn borrar solo inline btnborraanuncioventa" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" class="btn editar solo inline btneditaanuncioventa" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" valor="' + y['valor'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" foto="' + y['foto'] + '" value=""/></div>').masonry( 'reloadItems' ); 
                        $("#cartelera-board").masonry('layout');   
                    }
                    })

                    $(".btnborraanuncio").click(function(){
                        crearPopupBorrado($(this).attr('mongoid'));
                    });

                    $(".btnborraanuncioventa").click(function(){
                        crearPopupBorradoVenta($(this).attr('mongoid'));
                    });

                    $(".btneditaanuncio").click(function(){
                        crearPopupEditar($(this).attr('mongoid'), $(this).attr('titulo'), $(this).attr('notas'), $(this).attr('vigencia'), $(this).attr('valor'));
                    });


                    $(".btneditaanuncioventa").click(function(){
                        crearPopupEditarVenta($(this).attr('mongoid'), $(this).attr('titulo'), $(this).attr('notas'), $(this).attr('vigencia'), $(this).attr('valor'),$(this).attr('foto'));
                    });

                    $('#cartelera-board').imagesLoaded()
                        .always(function(){
                          $('#cartelera-board').masonry({
                            itemSelector: 'img'
                          });
                        });
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
    window.location = 'index.php';
}

function TraerModulosCopropiedad(arr,url,metodo)
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

function crearPopupBorrado(mongoid)
{
    $("#anuncioBorrar").dialog({ modal: true });
    $("#anuncioBorrar").dialog('open');
    $("#mongoid").val(mongoid);
}

function crearPopupBorradoVenta(mongoid)
{
    $("#borraranuncioventa").dialog({ modal: true });
    $("#borraranuncioventa").dialog('open');
    $("#mongoidventa").val(mongoid);
}

function crearPopupEditar(mongoid, titulo, notas, vigencia)
{
    $("#editaranuncio").dialog({ modal: true });
    $("#editaranuncio").dialog('open');
    $("#editnombre").val(titulo);
    $("#editmongoid").val(mongoid);
    $("#editnotas").val(notas);
    $("#editvigencia").val(vigencia);
}

function crearPopupEditarVenta(mongoid, titulo, notas, vigencia, valor, foto)
{
    $("#editaranuncioventa").dialog({ modal: true });
    $("#editaranuncioventa").dialog('open');
    $("#editventamongoid").val(mongoid);
    $("#editventanombre").val(titulo);
    $("#editventanotas").val(notas);
    $("#editventavigencia").val(vigencia);
    $("#editventavalor").val(valor);
    if(foto.length > 5)
    {
        $("#editimage").html('<img src="' + foto + '"/> <div style="width:150px; height:80px;" id="editpreviewFileDiv"><img id="editpreviewFile"/></div><br/> <div id="fileuploadereditventa">  Cargar Foto</div> <input type="hidden" id="editventafotonueva" value=""/>'); 
    }
    else
    {
        $("#editimage").html('<div style="width:150px; height:80px;" id="editpreviewFileDiv"><img id="editpreviewFile"/></div><br/> <div id="fileuploadereditventa">  Cargar Foto</div> <input type="hidden" id="editventafotonueva" value=""/>');
    }

    $("#fileuploadereditventa").uploadFile({
      url:"http://aws02.sinfo.co/api/archivos/archive",
      fileName:"archivo",
      autoUpload:false,
      multiple: false,
      dragDropStr: '<div style="display:none"></div>',
      abortStr:"Cancelar",
      cancelStr:"Cancelar",
      doneStr:"Listo!",
      maxFileSize: 320000,
      maxFileCount: 1,
      allowedTypes: "jpg,png,gif,txt,xml,jpeg,pdf,zip",
      returntype: "json",
      multiDragErrorStr: "No es posible emplear arrastrar y soltar para cargar archivos",
      extErrorStr:"No es posible cargar el archivo, no está en las extensiones autorizadas.",
      sizeErrorStr:" El archivo excede el tamaño máximo permitido de ",
      uploadErrorStr:"No es posible realizar la carga",
      //showStatusAfterSuccess: false,
      formData: {"token":sessionStorage.getItem('token'),"id_copropiedad":sessionStorage.getItem('cp'),"usuario":sessionStorage.getItem('id_crm'),"tipo":"venta"},
      onSuccess:function(files,data,xhr)
      {
        $("#editventafotonueva").val(data["message"]["ResultadoGeneral"]);
        $("#editpreviewFileDiv").show();
        $("#editpreviewFile").attr("src",data["message"]["ResultadoGeneral"]);
        $(".ajax-file-upload").hide();
        $(".ajax-upload-dragdrop").hide();
      }
    });
}