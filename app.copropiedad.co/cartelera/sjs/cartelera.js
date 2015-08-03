$(document).ready(function()
{ 
  $(document).renderme('ca');
  $('#editventanotas').attr('title', obtenerTerminoLenguage('val','13'));
  $('#editnotas').attr('title', obtenerTerminoLenguage('val','13'));
  $('#editventanotas').attr('title', obtenerTerminoLenguage('val','13'));
  $('#notasventa').attr('title', obtenerTerminoLenguage('val','13'));
  $('#notas').attr('title', obtenerTerminoLenguage('val','13'));
   
  if(!Modernizr.inputtypes.date){
      $("#vigencia").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
      });
  }
  else
  {
    var d = new Date();
    var da = d.toISOString().split("T")[0];
    $('input[type=date]').attr('min',da);
  }
  if(!Modernizr.inputtypes.date){
      $("#editvigencia").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
      });
  }
  else
  {
    var d = new Date();
    var da = d.toISOString().split("T")[0];
    $('input[type=date]').attr('min',da);
  }
  if(!Modernizr.inputtypes.date){
      $("#editventavigencia").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
      });
  }
  else
  {
    var d = new Date();
    var da = d.toISOString().split("T")[0];
    $('input[type=date]').attr('min',da);
  }
  if(!Modernizr.inputtypes.date){
      $("#vigenciaventa").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd'
      });
  }
  else
  {
    var d = new Date();
    var da = d.toISOString().split("T")[0];
    $('input[type=date]').attr('min',da);
  }
	popularCartelera();


    $( "#crearanuncio" ).dialog({
      resizable: false,
      autoOpen: false,
      title: obtenerTerminoLenguage('ca','5')      
    });

    $( "#crearanuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: obtenerTerminoLenguage('ca','10')
    });

    $( "#editaranuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: obtenerTerminoLenguage('ca','17')
    });

    $( "#editaranuncio" ).dialog({
      resizable: false,
      autoOpen: false,
      title: obtenerTerminoLenguage('ca','26')
    });

    $( "#borraranuncioventa" ).dialog({
      resizable: false,
      autoOpen: false,
      title: obtenerTerminoLenguage('ca','27')
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
        title: obtenerTerminoLenguage('ca','23')
    });

    $("#fileuploader").uploadFile({
      url:traerDireccion()+"api/archivos/archive",
      uploadButtonClass:"btn ajax-file-upload",
      fileName:"archivo",
      autoUpload:false,
      multiple: false,
      showStatusAfterSuccess:false,
      dragDropStr: '<div style="display:none"></div>',
      abortStr: obtenerTerminoLenguage('ca','36'),
      cancelStr: obtenerTerminoLenguage('ca','37'),
      doneStr: obtenerTerminoLenguage('ca','38'),
      maxFileSize: 320000,
      maxFileCount: 1,
      allowedTypes: "jpg,png,gif",
      returntype: "json",
      multiDragErrorStr: obtenerTerminoLenguage('ca','39'),
      extErrorStr: obtenerTerminoLenguage('ca','40'),
      sizeErrorStr: obtenerTerminoLenguage('ca','41'),
      uploadErrorStr: obtenerTerminoLenguage('ca','42'),
      formData: {"token":sessionStorage.getItem('token'),"id_copropiedad":sessionStorage.getItem('cp'),"usuario":sessionStorage.getItem('id_crm'),"tipo":obtenerTerminoLenguage('ca','43')},
      onSuccess:function(files,data,xhr)
      {
        $("#filepath").val(data["message"]["ResultadoGeneral"]);
        $(".btn.ajax-file-upload").html(obtenerTerminoLenguage('ca','45'));
        $(".btn.ajax-file-upload").addClass('ajax-file-upload-green');
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

    $("#crearanuncio_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
    	var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad : sessionStorage.getItem('cp'),
                    creador: sessionStorage.getItem('id_crm'),
                    fecha_creacion:fecha(),
                    tipo: obtenerTerminoLenguage('ca','44'),
                    estado:obtenerTerminoLenguage('ca','46'),
                    vigencia:new Date($("#vigencia").val()).toISOString(),
                    nombre:$('#nombre').val(),                   
                    notas:$('#notas').val()
                  }
                };
    	var url = "tareas/list";
    	var response = envioFormularioSync(url,arr,'POST');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#crearanuncio").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:16"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
        $(document).renderme('ca');
    	}
    });

    $("#crearanuncioventa_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
    	var arr = 
    	          {
    	            token:sessionStorage.getItem('token'),
    	            body:
    	            {
    	              id_copropiedad : sessionStorage.getItem('cp'),
    	              creador: sessionStorage.getItem('id_crm'),
    	              fecha_creacion:fecha(),
    	              tipo:obtenerTerminoLenguage('ca','43'),
    	              estado: obtenerTerminoLenguage('ca','46'),
    	              vigencia:new Date($("#vigenciaventa").val()).toISOString(),//$("#vigenciaventa").val() + "T00:00:00-05:00",
    	              nombre:$('#nombreventa').val(), 
    	              valor:$('#valorventa').val(),                  
    	              foto:$('#filepath').val(),
    	              notas:$('#notasventa').val()
    	            }
    	          }; 
    	var url = "tareas/list";
    	var response = envioFormularioSync(url,arr,'POST');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#crearanuncioventa").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error"  teid="ale:html:16"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong> </div>');
        $(document).renderme('ca');
    	}
    });

    $("#editaranuncioventa_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
    	var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad : sessionStorage.getItem('cp'),
                    creador: sessionStorage.getItem('id_crm'),
                    fecha_creacion:fecha(),
                    id:$('#editventamongoid').val(),
                    tipo: obtenerTerminoLenguage('ca','43'),
                    estado:obtenerTerminoLenguage('ca','46'),
                    vigencia:$("#editventavigencia").val() + "T00:00:00-05:00",
                    nombre:$('#editventanombre').val(),  
                    valor:$('#editventavalor').val(),
                    foto:$('#filepathedit').val(),                
                    notas:$('#editventanotas').val()
                  }
                };
        //alert("paso"+JSON.stringify(arr));
        var url = "tareas/list";
    	var response = envioFormularioSync(url,arr,'PUT');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#editaranuncioventa").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:17"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
        $(document).renderme('ca');
    	}
    });

    $("#editaranuncio_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
    	var arr = 
    	            {
    	              token:sessionStorage.getItem('token'),
    	              body:
    	              {
    	                id:$('#editmongoid').val(),
    	                id_copropiedad : sessionStorage.getItem('cp'),
    	                creador: sessionStorage.getItem('id_crm'),
    	                fecha_creacion:fecha(),
    	                tipo:obtenerTerminoLenguage('ca','44'),
    	                estado: obtenerTerminoLenguage('ca','46'),
    	                vigencia:new Date($("#editvigencia").val()).toISOString(),
    	                nombre:$('#editnombre').val(),                   
    	                notas:$('#editnotas').val()
    	              }
    	            }; 
    	var url = "tareas/list"; 
    	var response = envioFormularioSync(url,arr,'PUT');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#editaranuncio").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:18"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
        $(document).renderme('ca');
    	}
    });

    $("#borraranuncio_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id : $("#mongoid").val(),
            tipo: obtenerTerminoLenguage('ca','44')
          }
        }; 
        var url = "tareas/list/cartelera";
    	var response = envioFormularioSync(url,arr,'DELETE');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#anuncioBorrar").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:19"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
        $(document).renderme('ca');
    	}
    });

    $("#borraranuncioventa_form").submit(function(event){
    	event.preventDefault();
    	$('input[type=submit]').attr('disabled',true);
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id : $("#mongoidventa").val(),
            tipo: obtenerTerminoLenguage('ca','44')
          }
        }; 
        var url = "tareas/list/cartelera";
    	var response = envioFormularioSync(url,arr,'DELETE');
    	if(response)
    	{
    	  setTimeout(refreshWindow('index.php'),1000);
    	}
    	else
    	{
    	  $("#borraranuncioventa").dialog("close");
    	  $("#alertas").html('<div class="alert alert-dismissable alert-error" teid="ale:html:20"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>');
        $(document).renderme('ca');
    	}
    });

    $("#filedeleter").click(function(){$("#filepathedit").val('');$("#fotoventa").attr('src','')});

    $("#fileuploaderedit").uploadFile({
      url:traerDireccion()+"api/archivos/archive",
      uploadButtonClass:"btn ajax-file-upload",
      fileName:"archivo",
      autoUpload:false,
      multiple: false,
      showStatusAfterSuccess:false,
      dragDropStr: '<div style="display:none"></div>',
      abortStr: obtenerTerminoLenguage('ca','36'),
      cancelStr:obtenerTerminoLenguage('ca','37'),
      doneStr:obtenerTerminoLenguage('ca','38'),
      maxFileSize: 320000,
      maxFileCount: 1,
      allowedTypes: "jpg,png,gif",
      returntype: "json",
      multiDragErrorStr: obtenerTerminoLenguage('ca','39'),
      extErrorStr: obtenerTerminoLenguage('ca','40'),
      sizeErrorStr: obtenerTerminoLenguage('ca','41'),
      uploadErrorStr: obtenerTerminoLenguage('ca','42'),
      formData: {"token":sessionStorage.getItem('token'),"id_copropiedad":sessionStorage.getItem('cp'),"usuario":sessionStorage.getItem('id_crm'),"tipo": obtenerTerminoLenguage('ca','43')},
      onSuccess:function(files,data,xhr)
      {
        $("#filepathedit").val(data["message"]["ResultadoGeneral"]);
        $(".btn.ajax-file-upload").html( obtenerTerminoLenguage('ca','45'));
        $(".btn.ajax-file-upload").addClass('ajax-file-upload-green');
      }
    });

    $(document).renderme('ca');
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