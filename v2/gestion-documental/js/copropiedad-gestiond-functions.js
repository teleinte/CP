$(function(){

	var filemanager = $('.filemanager'),
		breadcrumbs = $('.breadcrumbs'),
		fileList = filemanager.find('.data');

	// Start by fetching the file data from scan.php with an AJAX request

	$.get(obtenerArchivos(), function(data) {

		var response = [data],
			currentPath = '',
			breadcrumbsUrls = [];

		var folders = [],
			files = [];

		// This event listener monitors changes on the URL. We use it to
		// capture back/forward navigation in the browser.

		$(window).on('hashchange', function(){

			goto(window.location.hash);

			// We are triggering the event. This will execute 
			// this function on page load, so that we show the correct folder:

		}).trigger('hashchange');


		// Hiding and showing the search box

		filemanager.find('.search').click(function(){

			var search = $(this);

			search.find('span').hide();
			search.find('input[type=search]').show().focus();

		});


		// Listening for keyboard input on the search field.
		// We are using the "input" event which detects cut and paste
		// in addition to keyboard input.

		filemanager.find('input').on('input', function(e){

			folders = [];
			files = [];

			var value = this.value.trim();

			if(value.length) {

				filemanager.addClass('searching');

				// Update the hash on every key stroke
				window.location.hash = 'search=' + value.trim();

			}

			else {

				filemanager.removeClass('searching');
				window.location.hash = encodeURIComponent(currentPath);

			}

		}).on('keyup', function(e){

			// Clicking 'ESC' button triggers focusout and cancels the search

			var search = $(this);

			if(e.keyCode == 27) {

				search.trigger('focusout');

			}

		}).focusout(function(e){

			// Cancel the search

			var search = $(this);

			if(!search.val().trim().length) {

				window.location.hash = encodeURIComponent(currentPath);
				search.hide();
				search.parent().find('span').show();

			}

		});


		// Clicking on folders

		fileList.on('click', 'li.folders', function(e){
			e.preventDefault();

			var nextDir = $(this).find('a.folders').attr('href');

			if(filemanager.hasClass('searching')) {

				// Building the breadcrumbs

				breadcrumbsUrls = generateBreadcrumbs(nextDir);

				filemanager.removeClass('searching');
				filemanager.find('input[type=search]').val('').hide();
				filemanager.find('span').show();
			}
			else {
				breadcrumbsUrls.push(nextDir);
			}

			window.location.hash = encodeURIComponent(nextDir);
			currentPath = nextDir;
		});


		// Clicking on breadcrumbs

		breadcrumbs.on('click', 'a', function(e){
			e.preventDefault();

			var index = breadcrumbs.find('a').index($(this)),
				nextDir = breadcrumbsUrls[index];

			breadcrumbsUrls.length = Number(index);

			window.location.hash = encodeURIComponent(nextDir);

		});


		// Navigates to the given hash (path)

		function goto(hash) {

			hash = decodeURIComponent(hash).slice(1).split('=');

			if (hash.length) {
				var rendered = '';

				// if hash has search in it

				if (hash[0] === 'search') {

					filemanager.addClass('searching');
					rendered = searchData(response, hash[1].toLowerCase());

					if (rendered.length) {
						currentPath = hash[0];
						render(rendered);
					}
					else {
						render(rendered);
					}

				}

				// if hash is some path

				else if (hash[0].trim().length) {

					rendered = searchByPath(hash[0]);

					if (rendered.length) {

						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);

					}
					else {
						currentPath = hash[0];
						breadcrumbsUrls = generateBreadcrumbs(hash[0]);
						render(rendered);
					}

				}

				// if there is no hash

				else {
					currentPath = data.path;
					breadcrumbsUrls.push(data.path);
					render(searchByPath(data.path));
				}
			}
		}

		// Splits a file path and turns it into clickable breadcrumbs

		function generateBreadcrumbs(nextDir){
			var path = nextDir.split('/').slice(0);
			for(var i=1;i<path.length;i++){
				path[i] = path[i-1]+ '/' +path[i];
			}
			return path;
		}


		// Locates a file by path

		function searchByPath(dir) {
			var path = dir.split('/'),
				demo = response,
				flag = 0;

			for(var i=0;i<path.length;i++){
				for(var j=0;j<demo.length;j++){
					if(demo[j].name === path[i]){
						flag = 1;
						demo = demo[j].items;
						break;
					}
				}
			}

			demo = flag ? demo : [];
			return demo;
		}


		// Recursively search through the file tree

		function searchData(data, searchTerms) {

			data.forEach(function(d){
				if(d.type === 'folder') {

					searchData(d.items,searchTerms);

					if(d.name.toLowerCase().match(searchTerms)) {
						folders.push(d);
					}
				}
				else if(d.type === 'file') {
					if(d.name.toLowerCase().match(searchTerms)) {
						files.push(d);
					}
				}
			});
			return {folders: folders, files: files};
		}


		// Render the HTML for the file manager

		function render(data) {

			var scannedFolders = [],
				scannedFiles = [];

			if(Array.isArray(data)) {

				data.forEach(function (d) {

					if (d.type === 'folder') {
						scannedFolders.push(d);
					}
					else if (d.type === 'file') {
						scannedFiles.push(d);
					}

				});

			}
			else if(typeof data === 'object') {

				scannedFolders = data.folders;
				scannedFiles = data.files;

			}


			// Empty the old result and make the new one

			fileList.empty().hide();

			if(!scannedFolders.length && !scannedFiles.length) {
				filemanager.find('.nothingfound').show();
			}
			else {
				filemanager.find('.nothingfound').hide();
			}

			if(scannedFolders.length) {

				scannedFolders.forEach(function(f) {

					var itemsLength = f.items.length,
						name = escapeHTML(f.name),
						icon = '<span class="icon folder"></span>';

					if(itemsLength) {
						icon = '<span class="icon folder full"></span>';
					}

					if(itemsLength == 1) {
						itemsLength += ' item';
					}
					else if(itemsLength > 1) {
						itemsLength += ' items';
					}
					else {
						itemsLength = 'Empty';
					}

					var folder = $('<li class="folders"><a href="'+ f.path +'" title="'+ f.path +'" class="folders">'+icon+'<span class="name">' + name + '</span> <span class="details">' + itemsLength + '</span></a></li>');
					folder.appendTo(fileList);
				});

			}

			if(scannedFiles.length) {

				scannedFiles.forEach(function(f) {

					var fileSize = bytesToSize(f.size),
						name = escapeHTML(f.name),
						fileType = name.split('.'),
						icon = '<span class="icon file"></span>';

					fileType = fileType[fileType.length-1];

					icon = '<span class="icon file f-'+fileType+'">.'+fileType+'</span>';

					var file = $('<li class="files"><a href="'+ f.path+'" title="'+ f.path +'" class="files">'+icon+'<span class="name">'+ name +'</span> <span class="details">'+fileSize+'</span></a></li>');
					file.appendTo(fileList);
				});

			}


			// Generate the breadcrumbs

			var url = '';

			if(filemanager.hasClass('searching')){

				url = '<span>Search results: </span>';
				fileList.removeClass('animated');

			}
			else {

				fileList.addClass('animated');

				breadcrumbsUrls.forEach(function (u, i) {

					var name = u.split('/');

					if (i !== breadcrumbsUrls.length - 1) {
						url += '<a href="'+u+'"><span class="folderName">' + name[name.length-1] + '</span></a> <span class="arrow">→</span> ';
					}
					else {
						url += '<span class="folderName">' + name[name.length-1] + '</span>';
					}

				});

			}

			breadcrumbs.text('').append(url);


			// Show the generated elements

			fileList.animate({'display':'inline-block'});

		}


		// This function escapes special html characters in names

		function escapeHTML(text) {
			return text.replace(/\&/g,'&amp;').replace(/\</g,'&lt;').replace(/\>/g,'&gt;');
		}


		// Convert file sizes from bytes to human readable units

		function bytesToSize(bytes) {
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
			if (bytes == 0) return '0 Bytes';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
		}

	});
});

function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    const rutaAplicatico = "http://aws02.sinfo.co/api/"; 

    var arr = {body:{autkey:AutDeUsuario,user:usuario}};            
    $.ajax({
        url: rutaAplicatico+'tareas/token',
        type: 'POST',
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: true,
        success: function(msg) {
            var msgDividido = JSON.stringify(msg);                    
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if (mensaje.status==false)
            {
                alert("No se puede crear el token de seguridad")
                location.href="../index.html"
            }                
            var datos = JSON.parse(msgDivididoDos);
            $.each(datos, function(x , y) 
            {                     
                 sessionStorage.setItem(x, y);
                 location.reload()                    
            }                
            )
          }
        })    
}

function fecha()
{
    // var fecha = new Date();
    // var ParamFecha = fecha.getFullYear()+"-"+fecha.getMonth()+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
    // return ParamFecha;
    var d = new Date();
    var n = d.toISOString(); 
    return n;
}  

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