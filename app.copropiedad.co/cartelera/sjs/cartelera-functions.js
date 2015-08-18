function crearPopupBorrado(mongoid)
{
    $("#anuncioBorrar").dialog({ modal: true, autoOpen: false });
    $("#anuncioBorrar").dialog('open');
    $("#mongoid").val(mongoid);
}

function crearPopupBorradoVenta(mongoid)
{
    $("#borraranuncioventa").dialog({ modal: true, autoOpen: false });
    $("#borraranuncioventa").dialog('open');
    $("#mongoidventa").val(mongoid);
}

function crearPopupEditar(mongoid, titulo, notas, vigencia, valor, foto)
{
    $("#editaranuncio").dialog({ modal: true, autoOpen: false });
    $("#editaranuncio").dialog('open');
    $("#editnombre").val(titulo);
    $("#editmongoid").val(mongoid);
    $("#editnotas").val(notas);
    $("#editvigencia").val(vigencia);
    $("#filepathedita").val(foto);
    $("#fileuploaderedita").html(obtenerTerminoLenguage('ca','18'));
    if(foto != null || foto != undefined)
    {
        $("#editimagea").html('<img id="fotoventaa" src="' + foto + '" style="height:100px; width:auto; float:right;"/>'); 
    }
    else
    {
        $("#editimagea").html('');
    }
}

function crearPopupEditarVenta(mongoid, titulo, notas, vigencia, valor, foto)
{
    $("#editaranuncioventa").dialog({ modal: true, autoOpen: false });
    $("#editaranuncioventa").dialog('open');
    $("#editventamongoid").val(mongoid);
    $("#editventanombre").val(titulo);
    $("#editventanotas").val(notas);
    $("#editventavigencia").val(vigencia);
    $("#editventavalor").val(valor);
    $("#filepathedit").val(foto);
    $("#fileuploaderedit").html(obtenerTerminoLenguage('ca','18'));
    if(foto != null || foto != undefined)
    {
        $("#editimage").html('<img id="fotoventa" src="' + foto + '" style="height:100px; width:auto; float:right;"/>'); 
    }
    else
    {
        $("#editimage").html('');
    }
}

function popularCartelera()
{
  $('#cartelera-board').masonry({
    columnWidth: '.ancho-contenedor',
    itemSelector: '.item'
  });

  var url = "tareas/getlist";
  var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"cartelera", id_crm:sessionStorage.getItem('id_crm')}};
  var datos = envioFormularioMessageSync(url, arr, 'POST')['message'];

  if(datos != null || datos != undefined)
  {
    $.each(datos,function(x , y) 
    {
          var idmongo= JSON.stringify(y['_id']);
          var idMongoFinal = JSON.parse(idmongo);
          //console.warn(y['fecha_creacion'].split("T")[0]);
          if(y['tipo'] == "cartelera")
          {
            if((y['foto'] != undefined || y['foto'] != null || y['foto'] != "undefined") && y['foto'].length > 10)
            {
               $("#cartelera-board").append('<div class="item"><table width="100%"><tr><td width="80%"><h2>' + y['nombre'] + '</h2></td><td width="20%">Publicado:<br/>'+y['fecha_creacion'].split("T")[0]+'</td><td width="20%">Publicado por: <br/>'+y['creador']+'</td></tr></table><a class="fancybox" href="'+y['foto']+'"><img src="'+y['foto']+'"/></a><p>' + y['notas'] + '</p><input type="submit" teid="ca:title:34" class="btn borrar solo inline btnborraanuncio ttip" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" teid="ca:title:35" class="btn editar solo inline btneditaanuncio ttip" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" valor="0" foto="' + y['foto'] + '" value=""/></div>').masonry( 'reloadItems' ); 
              $("#cartelera-board").masonry('layout');
            }
            else
            {
              $("#cartelera-board").append('<div class="item"><table width="100%"><tr><td width="80%"><h2>' + y['nombre'] + '</h2></td><td width="20%">Publicado:<br/>'+y['fecha_creacion'].split("T")[0]+'</td><td width="20%">Publicado por: <br/>'+y['creador']+'</td></tr></table><p>' + y['notas'] + '</p><input type="submit" teid="ca:title:34" class="btn borrar solo inline btnborraanuncio ttip" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" teid="ca:title:35" class="btn editar solo inline btneditaanuncio ttip" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" valor="0" foto="' + y['foto'] + '" value=""/></div>').masonry( 'reloadItems' ); 
             $("#cartelera-board").masonry('layout');   
            }
          }
          else
          {
            if((y['foto'] != undefined || y['foto'] != null || y['foto'] != "undefined") && y['foto'].length > 10)
            {
              $("#cartelera-board").append('<div class="item ventas"><table width="100%"><tr><td width="80%"><h2>' + y['nombre'] + '</h2></td><td width="20%">Publicado:<br/>'+y['fecha_creacion'].split("T")[0]+'</td><td width="20%">Publicado por: <br/>'+y['creador']+'</td></tr></table><a class="fancybox" href="'+y['foto']+'"><img src="'+y['foto']+'" alt="Precio: ' + y['valor']  + ' - Descripción: ' + y['notas'] + '"/></a><p><strong>Valor: ' + accounting.formatMoney(y['valor'],"$",0) + ' </strong> - ' + y['notas'] + '</p><input type="submit" teid="ca:title:34" class="btn borrar solo inline btnborraanuncioventa ttip" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" teid="ca:title:35" class="btn editar solo inline btneditaanuncioventa ttip" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" valor="' + y['valor'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" foto="' + y['foto'] + '" value=""/></div>').masonry( 'reloadItems' ); 
              $("#cartelera-board").masonry('layout');
            }
            else
            {
              $("#cartelera-board").append('<div class="item ventas"><table width="100%"><tr><td width="80%"><h2>' + y['nombre'] + '</h2></td><td width="20%">Publicado:<br/>'+y['fecha_creacion'].split("T")[0]+'</td><td width="20%">Publicado por: <br/>'+y['creador']+'</td></tr></table><p><strong>Valor: ' + accounting.formatMoney(y['valor'],"$",0) + ' </strong> - ' + y['notas'] + '</p><input type="submit" teid="ca:title:34" class="btn borrar solo inline btnborraanuncioventa ttip" mongoid="'+idMongoFinal.$id+'" value=""/>  <input type="submit" teid="ca:title:35" class="btn editar solo inline btneditaanuncioventa ttip" mongoid="'+idMongoFinal.$id+'" titulo="' + y['nombre'] + '" valor="' + y['valor'] + '" notas="' + y['notas'] + '" vigencia="' + y['vigencia'].split("T")[0] + '" foto="' + y['foto'] + '" value=""/></div>').masonry( 'reloadItems' ); 
              $("#cartelera-board").masonry('layout');
            }
          }

          $(".btnborraanuncio").click(function(){
          crearPopupBorrado($(this).attr('mongoid'));
          });

          $(".btnborraanuncioventa").click(function(){
          crearPopupBorradoVenta($(this).attr('mongoid'));
          });

          $(".btneditaanuncio").click(function(){
            crearPopupEditar($(this).attr('mongoid'), $(this).attr('titulo'), $(this).attr('notas'), $(this).attr('vigencia'), $(this).attr('valor'), $(this).attr('foto'));
          });

          $(".btneditaanuncioventa").click(function(){
          crearPopupEditarVenta($(this).attr('mongoid'), $(this).attr('titulo'), $(this).attr('notas'), $(this).attr('vigencia'), $(this).attr('valor'), $(this).attr('foto'));
          });

          $('#cartelera-board').imagesLoaded()
          .always(function(){
            $('#cartelera-board').masonry({
              itemSelector: 'img'
            });
          });
    });
  }
  else
  {
    $("#nodata").html('<h2 teid="ca:title:47"></h2>')
  }
}