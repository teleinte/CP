$(document).ready(function() {
    traerDatos("tareas/getlist");

    $(document).ready(function(){
    $("#nuevos").click(function(){
       $("#new-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#new-panel').length) {
            if($('#new-panel').is(":visible")) {
                    $('#new-panel').hide();
                    $('#nuevos').toggleClass("active");
                    }
            }        
        });
  });
  $(document).ready(function(){
    $("#aplicaciones").click(function(){
			$("#app-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
		$(document).click(function(event) { 
		if(!$(event.target).closest('#app-panel').length) {
			if($('#app-panel').is(":visible")) {
				$('#app-panel').hide();
				$('#aplicaciones').toggleClass("active");
				}
			}        
		});
  });
  $(document).ready(function(){
   $("#pendientes").click(function(){
            $("#pending-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#pending-panel').length) {
            if($('#pending-panel').is(":visible")) {
                    $('#pending-panel').hide();
                    $('#pendientes').toggleClass("active");
                    }
            }        
        });
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

    $("#btnEditarAnuncio").click(function(ev){
      var ParamFecha=fecha();

      if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
       {  
          window.location = '../index.php';
          return false
       }
       else
       {
          if($('#editnombre').val()=='')
          {
            $('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>Debe poner un titulo al anuncio.</div>');
            return false
          }
          if($('#editnotas').val()=='')
          {
               $('#alertasEditar').html('<div class="alert alert-error"><strong>ERROR: </strong>Debe poner una descripcion al anuncio.</div>');
               return false
          }
          if($('#editvigencia').val()=='')
          {
               $('#alertasEditar').html('<div class="alert alert-error"><strong>ERROR: </strong>Debe poner una fecha de vigencia del anuncio.</div>');
               return false
          }
          else 
          {
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              {
                id:$('#editmongoid').val(),
                id_copropiedad : sessionStorage.getItem('cp'),
                creador: sessionStorage.getItem('id_crm'),
                fecha_creacion:ParamFecha,
                tipo:"cartelera",
                estado:"1",
                vigencia:new Date($("#editvigencia").val()).toISOString(),
                nombre:$('#editnombre').val(),                   
                notas:$('#editnotas').val()
              }
            }; 
            var url = "tareas/list";
            //alert(JSON.stringify(arr));
            envioFormulario(arr,url,ev,'PUT');
            return false;
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
          if($('#nombreventa').val()=='')
          {
             alert('Debe poner un titulo a la venta'); 
            //$('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>Debe poner un titulo a la venta.</div>');
            return false
          }
          if($('#notasventa').val()=='')
          {
             alert('Debe poner una descripcion a la venta.'); 
            //$('#alertas').html('<div class="alert alert-error"><strong>ERROR: </strong>Debe poner una descripcion a la venta.</div>');
            return false
          }  

          else {
             
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
              valor:$('#valorventa').val(),                  
              foto:$('#filepath').val(),
              notas:$('#notasventa').val()
            }
          }; 
          var url = "tareas/list";
          envioFormularioVenta(arr,url,'POST', ev);
          }
        }
    });

    $("#btnEditarAnuncionVenta").click(function(ev){
        
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
                    foto:$('#editventafotonueva').val(),                
                    notas:$('#editventanotas').val()
                  }
                };
                //alert("paso"+JSON.stringify(arr));
                var url = "tareas/list";
                envioFormulario(arr,url,ev,'PUT');
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

    //$("#vigenciaventa").datepicker({dateFormat: "yy-mm-dd"},{maxDate: "2015/03/10"});
    var d = new Date();
    var mes=d.getMonth()+1;
    //$("#vigenciaventa").datepicker( "option", "minDate", new Date(d.getFullYear(), mes - 1, d.getDate()),{dateFormat: "yy-mm-dd" } );
    $("#vigenciaventa").datepicker( {minDate: "mes/d.getDate()/d.getFullYear()"} );
    $("#vigencia").datepicker( {minDate: "mes/d.getDate()/d.getFullYear()"} );
    $("#editvigencia").datepicker( {minDate: "mes/d.getDate()/d.getFullYear()"} );
    $("#editventavigencia").datepicker({minDate: "mes/d.getDate()/d.getFullYear()"});
    //$("#editventavigencia").datepicker({ dateFormat: "yy-mm-dd" } );

    
    //$("#editventavigencia").datepicker();
    

    $("#fileuploader").uploadFile({
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
        //alert(data["message"]["ResultadoGeneral"]);
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