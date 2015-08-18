$(document).ready(function(e) {  
  $(document).renderme('gd');

  $("#fileuploader").uploadFile({
    url:traerDireccion()+"api/archivos/archive",
    uploadButtonClass:"btn ajax-file-upload",
    fileName:"archivo",
    autoUpload:false,
    multiple: false,
    showStatusAfterSuccess:false,
    dragDropStr: '<div style="display:none"></div>',
    abortStr: obtenerTerminoLenguage('gd','29'),
    cancelStr: obtenerTerminoLenguage('gd','30'),
    doneStr: obtenerTerminoLenguage('gd','31'),
    maxFileSize: 320000,
    maxFileCount: 1,
    allowedTypes: "jpg,png,gif,pdf,doc,txt,docx,xls,xlsx,ppt,pptx,zip, rar",
    returntype: "json",
    multiDragErrorStr: obtenerTerminoLenguage('gd','32'),
    //extErrorStr: obtenerTerminoLenguage('gd','35'),
    sizeErrorStr:obtenerTerminoLenguage('gd','34'), 
    uploadErrorStr: obtenerTerminoLenguage('gd','35'), 
    formData: {"token":sessionStorage.getItem('token'),"id_copropiedad":sessionStorage.getItem('cp'),"usuario":sessionStorage.getItem('id_crm'),"tipo":"gestion"},
    onSuccess:function(files,data,xhr)
    {
      $("#filepath").val(data["message"]["ResultadoGeneral"]);
      $(".btn.ajax-file-upload").html(obtenerTerminoLenguage('gd','36')); 
      $(".btn.ajax-file-upload").addClass('ajax-file-upload-green');
    }
  });

  $("#uploaddoc").submit(function(event){
    event.preventDefault();
    if($("#filepath").val() != "none")
    {
      $('input[type=submit]').attr('disabled',true);
      var arr = 
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          id_copropiedad : sessionStorage.getItem('cp'),
          id_crm_persona: sessionStorage.getItem('id_crm'),
          fecha_creacion:fecha(),
          tipo:$("#tipo").val(),
          estado:"activo",
          nombre:$('#nombre').val(),                   
          descripcion:$('#comentario').val(),
          enlace:$("#filepath").val()
        }
      }; 
      var url = "documentos/list";
      var response = envioFormularioSync(url,arr,'POST');
      if(response)
      {
        var arre = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            idcopropiedad : sessionStorage.getItem('cp'),
            grupo: $('#invitados').val()
          }
        }; 
        var invitmenoados = $('#invitados').val();
        $(document).renderme('ma');
      var body = '<h4 style="color:#666 !important;">'+ sessionStorage.getItem('nombreCompleto') + obtenerTerminoLenguage('ma','1') + sessionStorage.getItem('ncp')+ obtenerTerminoLenguage('ma','85') + '</h4>' + '<p><strong><i>' + $("#nombre").val() + '</i></strong></p><p>' + obtenerTerminoLenguage('ma','86') + obtenerTerminoLenguage('ma','5') + '</p><a href="' + traerDireccion() + '" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">' + obtenerTerminoLenguage('ma','6') + '</a></p>';
      $(document).renderme('ma');
        if($("#odestinatario").val().length > 10)       
        {
          $(document).renderme('ma');
          enviocorreoSync($('#odestinatario').val(), obtenerTerminoLenguage('ma','87'), body, traerDireccion());
          $(document).renderme('ma');
        }
        if(invitados != 'ninguno')
        {
          var correos = "";
          var urle = "eventos/usuario/grupo/";
          console.warn(arre);
          var responsee = traerDatosSync(urle,arre,'POST');
          if(responsee!=null)
          {
            $.each(responsee,function(k,v)
            {
              correos = correos + "," + v;
            });
            $(document).renderme('ma');
            enviocorreoSync(correos.substring(1), obtenerTerminoLenguage('ma','87'), body, traerDireccion());
            $(document).renderme('ma');
          }
        }
        setTimeout(refreshWindow('index.php'),1000);
      }
      else
      {
        $('input[type=submit]').attr('disabled',false);
        $(document).renderme('gd');
      }
    }
    else
    {
      $('#alertas').html('<div class="alert alert-error" ale:html:21>por favor adjunte un documento para continuar.</div>');
    }
  });
  $("#alertas").html('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:28"></strong><h4 teid="ale:html:47"></h4></div> ');
  $(document).renderme('gd');
  $(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});