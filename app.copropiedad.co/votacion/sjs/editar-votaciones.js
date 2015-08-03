$(document).ready(function() {
    $(document).renderme('vo');

    $("#opciones-pregunta0").attr('minlength','3');

    $('#tablaPreguntas').DataTable({
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
      exclude: [ 0, 1 ],
      exclude: [ 0, 3 ]
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
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})                            
        
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};

        var response = traerDatosSync("votacion/encuesta/copropiedad/filtro", arr, sessionStorage.getItem('cp'));
        traerCabecerasModificables(response);


        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("votacion/encuesta/pregunta/listar",arr);
        traerPreguntas(response);



        $("#form-encuesta-editar").submit(function(event){
           event.preventDefault();
           var ParamFecha=fecha();

          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
          var ParamFecha=fecha();                
          var arr = 
              {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                      id:params['idt'],
                      id_copropiedad:$('#id_copropiedad').val(),
                      id_crm_persona:$('#id_crm_persona').val(),
                      fecha_creacion:$('#fecha_creacion').val(),
                      tipo:"votacion",
                      fecha_fin:$('#datepicker').val(),
                      nombre:$('#nombre').val(),
                      descripcion:$('#descripcion').val(),
                      estado:$('#estado').val(),
                      invitados:$('#invitados').val(),
                      invitados_externos:$('#odestinatario').val()
                  }
              }

          response= envioFormularioSync("votacion/encuesta",arr,'PUT');
          if(response)
          {
            //$("#alertas").html('<div class="alert alert-dismissable alert-success" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Encuesta modificada</strong></div>');
            var pagina="index.php";
            setTimeout(refreshWindow(pagina),1000);
            $(document).renderme('vo');
          }
               
        });

         $("#form-pregunta-nueva").submit(function(event){
            event.preventDefault();
            var ParamFecha=fecha();
            var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
            
            var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            var resultado = "";
            var partido = [];
            var arrPregunta={};
            partido = $('#opciones_pregunta0').val().split("\n");
           
                for (i in partido) 
                {
                    resultado+=letras[i]+"|"+partido[i]+","                    
                } 
           
            
            var arrPregunta = 
            {                        
                token:sessionStorage.getItem('token'),
                body:
                {
                    //id:params['idt'],
                    id_encuesta:params['idt'],
                    pregunta:$('#enunciado_pregunta0').val(),
                    tipo:"seleccion_multiple_unica_respuesta",
                    opciones:resultado,
                    obligatorio:"SI"
                }
            }
            response= envioFormularioSync("votacion/encuesta/pregunta",arrPregunta,'POST');
            if(response)
            {
              //$("#alertas").html('<div class="alert alert-dismissable alert-success" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Encuesta modificada</strong></div>');
              var pagina="votacion-editar.php?idt="+params["idt"];
              setTimeout(refreshWindow(pagina),1000); 
            }
                 
          });

        $(document).renderme('vo');
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