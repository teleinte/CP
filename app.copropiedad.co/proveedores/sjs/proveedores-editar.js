$(document).ready(function(){

  $(document).renderme('pr');

// Proceso para traer los datos de los inmuebles creados
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
  var arr = {token:sessionStorage.getItem('token'),body:{id_unidad:params['idt']}};
  var datos = traerDatosSync("admin/copropiedad/usuario/unidad", arr);
  // parametros de las tablas de inmuebles
  $('#contactos_tabla').DataTable( {
    responsive: {
      details: {
                type: 'column'
            }
    },
    columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": obtenerTerminoLenguage('ta','20'),
        exclude: [ 0, 1 ]
      },
    "language": {
      "sProcessing":     obtenerTerminoLenguage('ta','2'),
      "sLengthMenu":     obtenerTerminoLenguage('ta','3'),
      "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
      "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
      "sInfo":           obtenerTerminoLenguage('ta','6'),
      "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
      "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
      "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
      "sSearch":         obtenerTerminoLenguage('ta','10'),
      "sUrl":            obtenerTerminoLenguage('ta','11'),
      "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
      "sLoadingRecords": obtenerTerminoLenguage('ta','13'),
      "oPaginate": {
        "sFirst":    obtenerTerminoLenguage('ta','14'),
        "sLast":     obtenerTerminoLenguage('ta','15'),
        "sNext":     obtenerTerminoLenguage('ta','16'),
        "sPrevious": obtenerTerminoLenguage('ta','17')
      },
      "oAria": {
        "sSortAscending":  obtenerTerminoLenguage('ta','18'),
        "sSortDescending": obtenerTerminoLenguage('ta','19')
      }
    }  
  });
  
  $("div.toolbar").html('<a href="contacto-nuevo.php?idt='+params['idt']+'" class="btn ttip positivo" teid="pr:html:22, pr:title:27"></a>');
  
  $(document).renderme('pr');
  //llenando la tabla popular
  popularTablaContactos(datos);  
  var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
  var datosUsuario = traerDatosSync("unidad/unidad/copropiedadid", arr);
  // popula los datos de usuario para poderlos modificar en tabla
  popularDatosModificables(datosUsuario);

  $("#form-cliente-editar").submit(function(event){
    
    event.preventDefault();
    var ParamFecha=fecha();
    $('input[type=submit]').attr('disabled',true);
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id:$('#id_unidad').val(),
        id_copropiedad: $('#id_copropiedad').val(),
        id_crm_persona:$('#id_crm_persona').val(),
        tipo_documento : "proveedor",
        tipo_unidad:$('#tipo_unidad').val(),
        nombre_inmueble:$('#nombre_inmueble').val(),      
        estado:parseInt($('#estado').val()),
        nit:parseInt($('#nit').val()),
        fecha_creacion:$('#fecha_creacion').val()
      }
    };
    var url = "unidad/unidad";  
    var response = envioFormularioSync(url,arr,'PUT');
    if(response)
    {
        var pagina="index.php";
        setTimeout(refreshWindow(pagina),1000);
    }
  });

  $(document).renderme('pr');
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