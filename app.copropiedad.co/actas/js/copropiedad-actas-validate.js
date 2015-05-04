$(document).ready(function() {
  $("#btn_enviar").click(function(){

    if ($('#nombrearchivo').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe poner un nombre de archivo.</div>')
      return false;
    }
    if ($('#observacion').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe poner una descripción.</div>')
      return false;
    }
    if ($('#filepath').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe adjuntar un archivo.</div>')
      return false;
    }
    else{   
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var ParamFecha=fecha();

         if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.php';
            return false;
         }
         else
         {
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                fecha_creacion:ParamFecha,
                tipo:"acta",
                estado:"activo",
                nombre:$('#nombrearchivo').val(),                   
                descripcion:$('#observacion').val(),
                enlace:$("#filepath").val()
              }
            }; 
            var url = "documentos/list";
            //alert(JSON.stringify(arr));
            envioFormulario(arr,url,params,'POST');
         }
        }

  });


    $("#btn_eliminar").click(function(){

        if ($('#opcion').val()==''){
        $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe seleccionar una opción.</div>')
          return false
        }
        
        else{        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var ParamFecha=fecha();
        if ($('#opcion').val()=="NO")
        {
            //alert("paso por este lado");
            $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminado.</div>')                    
            window.location = 'index.php';
            return false;
        }        
        if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.php';
            return false;
         }
         else
         {
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id:params['idt'],
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                fecha_creacion:$('#fecha_creacion').val(),
                tipo:$('#tipo').val(),
                estado:'eliminado',
                nombre:$('#nombrearchivo').val(),                   
                descripcion:$('#observacion').val(),
                enlace:$("#filepath").val()
              }
            }; 
            var url = "documentos/list";
            //alert(JSON.stringify(arr));
            envioFormularioEliminado(arr,url,params,'PUT');
            
         }
        }
    });
    
    /*$("#acta_form_eliminar").validate(
    {
        rules: {
            opcion: {required: true},            
        },
        messages: {
            nombre: "Debe seleccionar una opción",            
        },
        submitHandler: function(form){        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var ParamFecha=fecha();
        if ($('#opcion').val()=="NO")
        {
            //alert("paso por este lado");
            $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminado.</div>')                    
            window.location = 'index.php';
            return false;
        }        
        if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.php';
            return false;
         }
         else
         {
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id:params['idt'],
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                fecha_creacion:$('#fecha_creacion').val(),
                tipo:$('#tipo').val(),
                estado:'eliminado',
                nombre:$('#nombrearchivo').val(),                   
                descripcion:$('#observacion').val(),
                enlace:$("#filepath").val()
              }
            }; 
            var url = "documentos/list";
            //alert(JSON.stringify(arr));
            envioFormularioEliminado(arr,url,params,'PUT');
         }
        }
    });*/
    $("#btn_enviar_editar").click(function(){

    if ($('#nombrearchivo').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe poner un nombre de archivo.</div>')
      return false
    }
    if ($('#observacion').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe poner una descripción.</div>')
      return false
    }
    if ($('#filepath').val()==''){
      $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>Debe adjuntar un archivo.</div>')
      return false
    }
    else{   
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var ParamFecha=fecha();

        if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.php';
            return false;
         }
         else
         {
          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          var ParamFecha=fecha();

          var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id:params['idt'],
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                fecha_creacion:$('#fecha_creacion').val(),
                tipo:$('#tipo').val(),
                estado:$('#estado').val(),
                nombre:$('#nombrearchivo').val(),                   
                descripcion:$('#observacion').val(),
                enlace:$("#filepath").val()
              }
            }; 
            var url = "documentos/list";
            //alert(JSON.stringify(arr));
            envioFormulario(arr,url,params,'PUT');
          }
        }
        
      });
    
    /*$("#editaracta_form").validate(
    {
        rules: {
            nombrearchivo: {required: true},
            observacion: { required: true},
        },
        messages: {
            nombre: "Debe poner un nombre de archivo",
            observacion : "Debe poner una descripcion",
        },
        submitHandler: function(form){        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var ParamFecha=fecha();

        if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.php';
            return false;
         }
         else
         {
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id:params['idt'],
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                fecha_creacion:$('#fecha_creacion').val(),
                tipo:$('#tipo').val(),
                estado:$('#estado').val(),
                nombre:$('#nombrearchivo').val(),                   
                descripcion:$('#observacion').val(),
                enlace:$("#filepath").val()
              }
            }; 
            var url = "documentos/list";
            //alert(JSON.stringify(arr));
            envioFormulario(arr,url,params,'PUT');
         }
        }
    });*/
    

    
    $("#fileuploader").uploadFile(            
      {        
      url:"https://app.copropiedad.co/api/archivos/archive",
      fileName:"archivo",
      autoUpload:false,
      multiple: false,
      dragDropStr: '<div style="display:none"></div>',
      abortStr:"Cancelar",
      cancelStr:"Cancelar",
      doneStr:"Listo!",
      maxFileSize: 320000,
      maxFileCount: 1,
      allowedTypes: "doc,docx,jpg,png,gif,txt,jpeg,pdf,zip,xls,xlsx,ppt,ppts",
      returntype: "json",
      multiDragErrorStr: "No es posible emplear arrastrar y soltar para cargar archivos",
      extErrorStr:"No es posible cargar el archivo, no está en las extensiones autorizadas.",
      sizeErrorStr:" El archivo excede el tamaño máximo permitido de ",
      uploadErrorStr:"No es posible realizar la carga",
      //showStatusAfterSuccess: false,
      formData: {
          "token":sessionStorage.getItem('token'),
          "id_copropiedad":sessionStorage.getItem('cp'),
          "usuario":sessionStorage.getItem('id_crm'),
          "tipo":"acta"
      },
      onSuccess:function(files,data,xhr)
      {
        $("#filepath").val(data["message"]["ResultadoGeneral"]);
        //$("#previewFileDiv").css("display", "block");
        //$("#previewFileDiv").show();
        //$("#previewFile").attr("src",data["message"]["ResultadoGeneral"]);
        $(".ajax-file-upload").hide();
        $(".ajax-upload-dragdrop").hide();
      }
    });
});