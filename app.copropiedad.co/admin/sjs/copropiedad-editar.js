  $(document).ready(function(){
  $(document).renderme('ccp');
// Proceso para traer los datos de los inmuebles creados
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt'],tipo:"tarea"}};


  //var arr = {token:sessionStorage.getItem('token'),body:{id_unidad:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/copropiedad/getlistFilter", arr);
  
  //llenando la tabla popular
  popularDatosModificables(datos); 


  $("#copropiedad_form_editar").submit(function(event){
    event.preventDefault();

    var ParamFecha=fecha();
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
    //var checked = [1,2,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];  
    var pagos = ($('#pagosonline').val() === 'true');
    /*console.warn($('#pagosonline').val());
    console.warn(Boolean($('#pagosonline').val()));
    console.warn(pagos);*/
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id:params['idt'],
        id_crm_persona: $('#id_crm_persona').val(),
        fecha_creacion:$('#fecha_creacion').val(),
        nombre:$('#nombre').val(),
        direccion:$('#direccion').val(),
        telefono:$('#telefono').val(),
        nit:$('#nit').val(),
        ciudad:$('#ciudad').val(),        
        estado:1,
        //modulos_activos:checked,
        referencia : $('#referencia').val(),
        vigencia : $('#vigencia').val(),
        pagosonline : pagos
      }
    }; 
    var url = "copropiedad";
    var response = envioFormularioSync("admin/copropiedad/copropiedad/",arr,"PUT");
    if(response)
    {
        var pagina="index.php";
        setTimeout(refreshWindow(pagina),1000);
    }
    }
    );
    $(document).renderme('ccp');
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