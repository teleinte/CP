$(document).ready(function(){
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
  var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"tarea"}};
  var datos = traerDatosSync("tareas/getlist", arr, sessionStorage.getItem('cp'));
  //sessionStorage.setItem('referer','../tarea');
  
  $(document).renderme('tar');

  $("#dialog_eliminar").dialog({
    resizable: false,
    autoOpen: false,
    width: 400,
    modal: true,
    title: obtenerTerminoLenguage('tar','39'),
    buttons:{
      "Cancelar" : function(){
        $(this).dialog("close");
      },
      "Aceptar" : function(){
        $(this).dialog("close");
        tareaDelete($("#elmongoid").val(),$("#elcreacion").val(),$("#elnombre").val(),$("#eldeadline").val(),$("#elfrecuencia").val(),$("#elnotas").val());
      }
    }
  });

  $("#completar_tarea").click(function(){
    sessionStorage.setItem('referer','../tarea');
    $("#dialog_completar").dialog("open");
    // $("#comongoid").val($(this).attr('mongoid'));
    // $("#cocreacion").val($(this).attr('creacion'));
    // $("#conombre").val($(this).attr('nombre'));
    // $("#codeadline").val($(this).attr('deadline'));
    // $("#cofrecuencia").val($(this).attr('frecuencia'));
    // $("#conotas").val($(this).attr('notas'));
    //$("#cotext_tarea").val($(this).attr('nombre'));
    //tareaCompletar($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
  });

  $('#dialog_completar').dialog({
    resizable: false,
    autoOpen: false,
    width: 400,
    modal: true,
    title: obtenerTerminoLenguage('tar','39'),
    buttons:{
      "Cancelar" : function(){
        $(this).dialog("close");
      },
      "Aceptar" : function(){
        $(this).dialog("close");
        tareaCompletar($("#comongoid").val(),$("#cocreacion").val(),$("#conombre").val(),$("#codeadline").val(),$("#cofrecuencia").val(),$("#conotas").val());
      }
    }
  });
  
  $("#creartarea").dialog({
    title : obtenerTerminoLenguage('tar','8')
  });

  $('#tareas').DataTable({
    columnDefs: [{
            className: 'control',
            orderable: false,
            targets:   0
        }],
    responsive: {
      details: {
                type: 'column'
      }
    },
    order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": obtenerTerminoLenguage('ta','20'),
      exclude: [ 0, 1 ],
      exclude: [ 0, 4 ]
    },
    "drawCallback": function( settings ) {
            $(".btnr_eliminar_tarea").click(function(){
              $("#dialog_eliminar").dialog("open");
              $("#elmongoid").val($(this).attr('mongoid'));
              $("#elcreacion").val($(this).attr('creacion'));
              $("#elnombre").val($(this).attr('nombre'));
              $("#eldeadline").val($(this).attr('deadline'));
              $("#elfrecuencia").val($(this).attr('frecuencia'));
              $("#elnotas").val($(this).attr('notas'));
              sessionStorage.setItem('referer','../tarea');
              //$("#eltext_tarea").val($(this).attr('nombre'));
              //tareaDelete($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
            });

          $(".btnr_completar_tarea").click(function(){
            $("#dialog_completar").dialog("open");
            $("#comongoid").val($(this).attr('mongoid'));
            $("#cocreacion").val($(this).attr('creacion'));
            $("#conombre").val($(this).attr('nombre'));
            $("#codeadline").val($(this).attr('deadline'));
            $("#cofrecuencia").val($(this).attr('frecuencia'));
            $("#conotas").val($(this).attr('notas'));
            //$("#cotext_tarea").val($(this).attr('nombre'));
            //tareaCompletar($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
          });

          $(".btnr_editar_tarea").click(function(){
            var elem = 
            {
              id:$(this).attr('mongoid'),
              fecha_creacion:$(this).attr('creacion'),
              tipo:"tarea",
              nombre:$(this).attr('nombre'),
              estado:$(this).attr('estado'),
              deadline:$(this).attr('deadline'),
              notas:$(this).attr('notas'),
              frecuencia:$(this).attr('frecuencia')
            }
            sessionStorage.setItem('acelem',JSON.stringify(elem));
            sessionStorage.setItem('referer','../tarea');
            window.location = "../calendario/editar-tarea.php";
          });
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

  popularTabla(datos);

  $("div.toolbar").html('<a href="../calendario/crear-tarea.php"  class="btn ttip positivo" id ="open-creartarea" style="margin-right:5px;" teid="tar:html:8, tar:title:31"></a>');
  
  $(document).renderme('tar');

  $( "#open-creartarea" ).click(function() {
    sessionStorage.setItem('referer','../tarea');
    var d = new Date();
    d.setHours(d.getHours() - 5);
    sessionStorage.setItem('new-eventStart',d.toISOString());
    sessionStorage.setItem('new-eventEnd',d.toISOString())
  });

  $(".btnr_editar_tarea").click(function(){
    var elem = 
    {
      id:$(this).attr('mongoid'),
      fecha_creacion:$(this).attr('creacion'),
      tipo:"tarea",
      nombre:$(this).attr('nombre'),
      estado:$(this).attr('estado'),
      deadline:$(this).attr('deadline'),
      notas:$(this).attr('notas'),
      frecuencia:$(this).attr('frecuencia')
    }
    sessionStorage.setItem('acelem',JSON.stringify(elem));
    sessionStorage.setItem('referer','../tarea');
    window.location = "../calendario/editar-tarea.php";
  });

  $(".btnr_eliminar_tarea").click(function(){
    $("#dialog_eliminar").dialog("open");
    $("#elmongoid").val($(this).attr('mongoid'));
    $("#elcreacion").val($(this).attr('creacion'));
    $("#elnombre").val($(this).attr('nombre'));
    $("#eldeadline").val($(this).attr('deadline'));
    $("#elfrecuencia").val($(this).attr('frecuencia'));
    $("#elnotas").val($(this).attr('notas'));
    sessionStorage.setItem('referer','../tarea');
    //$("#eltext_tarea").val($(this).attr('nombre'));
    //tareaDelete($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
  });

  $(".btnr_completar_tarea").click(function(){
    $("#dialog_completar").dialog("open");
    $("#comongoid").val($(this).attr('mongoid'));
    $("#cocreacion").val($(this).attr('creacion'));
    $("#conombre").val($(this).attr('nombre'));
    $("#codeadline").val($(this).attr('deadline'));
    $("#cofrecuencia").val($(this).attr('frecuencia'));
    $("#conotas").val($(this).attr('notas'));
    //$("#cotext_tarea").val($(this).attr('nombre'));
    //tareaCompletar($(this).attr('mongoid'),$(this).attr('creacion'),$(this).attr('nombre'),$(this).attr('deadline'),$(this).attr('frecuencia'),$(this).attr('notas'));
  });

  $(document).renderme('tar');
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