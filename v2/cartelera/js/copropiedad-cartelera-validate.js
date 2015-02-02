$(document).ready(function() {
    traerDatos("tareas/getlist");

    $("#nuevos").click(function(){
      $("#new-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
    $("#pendientes").click(function(){
      $("#pending-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
    $("#aplicaciones").click(function(){
      $("#app-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
    $( ".modal" ).dialog({
      autoOpen: false,
      modal: true
    });
    $( "#crearanuncio" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Crear un anuncio'      
    });
    $( "#crearanuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Iniciar una venta'
    });

    $( "#editaranuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Editar un anuncio de venta'
    });

    $( "#borraranuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Borrar un anuncio de venta'
    });

    $( "#open-crearanuncio" ).click(function() {
          $("#crearanuncio").dialog( "open" );
    });

    $( "#open-crearanuncioventa" ).click(function() {
          $("#crearanuncioventa").dialog( "open" );
    });

    $('#anuncioBorrar').dialog({
        resizable: false,
        autoOpen: false,
        title: 'Borrado de anuncio'
    });

    $("#vigencia").datepicker({ dateFormat: "yy-mm-dd" });
    $("#vigenciaventa").datepicker({ dateFormat: "yy-mm-dd" });
    /*$("#notas").cleditor({
      width: 250, // width not including margins, borders or padding
      height: 250, // height not including margins, borders or padding
      controls: "bold italic underline strikethrough | bullets numbering | outdent " +
              "indent"
    });
    $("#notasventa").cleditor({
      width: 250, // width not including margins, borders or padding
      height: 250, // height not including margins, borders or padding
      controls: "bold italic underline strikethrough | bullets numbering | outdent " +
              "indent"
    });*/

    $("#crearanuncio_form").validate(
    {
        rules: {
            nombre: {required: true},
            notas: { required: true}
        },
        messages: {
            nombre: "Debe poner un titulo al anuncio",
            notas : "Debe poner una descripcion al anuncio"               
        },
        submitHandler: function(form){      
            var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
            var ParamFecha=fecha();

            if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
             {  
                window.location = '../index.php';
                return false
             }
             else
             {
                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad : sessionStorage.getItem('cp'),
                    creador: sessionStorage.getItem('id_crm'),
                    fecha_creacion:ParamFecha,
                    tipo:"cartelera",
                    estado:"1",
                    vigencia:new Date($("#vigencia").val()).toISOString(),
                    nombre:$('#nombre').val(),                   
                    notas:$('#notas').val()
                  }
                }; 
                var url = "tareas/list";
                envioFormulario(arr,url,params,'POST');
             }
        }
    });

    $("#btnborraranuncio_form").click(function(){
          if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
           {  
              window.location = '../index.php';
              return false
           }
           else
           {
              var mid = $("#mongoid").val();
              if(mid.length > 5)
              {
                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id : $("#mongoid").val(),
                    tipo: "cartelera"
                  }
                }; 
                var url = "tareas/list/cartelera";
                var params = "";
                envioFormularioBorrado(arr,url,params,'DELETE');  
              }
           }
    });

    $("#btncrearanuncioventa").click(function(ev){
      var ParamFecha=fecha();

      if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
       {  
          window.location = '../index.php';
          return false
       }
       else
       {
          var arr = 
          {
            token:sessionStorage.getItem('token'),
            body:
            {
              id_copropiedad : sessionStorage.getItem('cp'),
              creador: sessionStorage.getItem('id_crm'),
              fecha_creacion:ParamFecha,
              tipo:"venta",
              estado:"1",
              vigencia:$("#vigenciaventa").val() + "T00:00:00-05:00",
              nombre:$('#nombreventa').val(), 
              valor:$('#valor').val(),                  
              foto:$('#filepath').val(),
              notas:$('#notasventa').val()
            }
          }; 
          var url = "tareas/list";
          envioFormularioVenta(arr,url,'POST', ev);
       }
    });

    $("#editaranuncioventa_form").validate({
        rules: {
            nombre: {required: true},
            notas: { required: true},
            vigencia: { required: true}
        },
        messages: {
            nombre: "Debe poner un titulo al anuncio",
            notas : "Debe poner una descripcion al anuncio",
            vigencia: "Debe poner una vigencia"            
        },
        submitHandler: function(form){   
            var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
            var ParamFecha=fecha();

            if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
             {  
                window.location = '../index.php';
                return false
             }
             else
             {
                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad : sessionStorage.getItem('cp'),
                    creador: sessionStorage.getItem('id_crm'),
                    fecha_creacion:ParamFecha,
                    id:$('#editventamongoid').val(),
                    tipo:"venta",
                    estado:"1",
                    vigencia:$("#editventavigencia").val() + "T00:00:00-05:00",
                    nombre:$('#editventanombre').val(),  
                    valor:$('#editventavalor').val(),
                    foto:$('#editventafoto').val(),                
                    notas:$('#editventanotas').val()
                  }
                }; 
                var url = "tareas/list";
                envioFormulario(arr,url,params,'PUT');
             }
        }
    });

    $("#btnborraranuncioventa_form").click(function(){
          if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
           {  
              window.location = '../index.php';
              return false
           }
           else
           {
              var mid = $("#mongoidventa").val();
              if(mid.length > 5)
              {
                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id : $("#mongoidventa").val(),
                    tipo: "venta"
                  }
                }; 
                var url = "tareas/list/cartelera";
                var params = "";
                envioFormularioBorrado(arr,url,params,'DELETE');  
              }
           }
    });

    $("#vigenciaventa").datepicker({ dateFormat: "yy-mm-dd" });

    $("#fileuploader").uploadFile({
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
        $("#filepath").val(data["message"]["ResultadoGeneral"]);
        //$("#previewFileDiv").css("display", "block");
        $("#previewFileDiv").show();
        $("#previewFile").attr("src",data["message"]["ResultadoGeneral"]);
        $(".ajax-file-upload").hide();
        $(".ajax-upload-dragdrop").hide();
      }
    });

    $(".fancybox").fancybox({
      openEffect  : 'elastic',
      closeEffect : 'elastic',

      helpers : {
        title : {
          type : 'outside'
        }
      },
      beforeShow : function() {
              var alt = this.element.find('img').attr('alt');
              this.inner.find('img').attr('alt', alt);
              this.title = alt;
          }
    });

    $("#previewFileDiv").hide();
    $("#editpreviewFileDiv").hide();
});