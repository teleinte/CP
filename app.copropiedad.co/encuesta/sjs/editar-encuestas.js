$(document).ready(function() {
    $(document).renderme('en');

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
      exclude: [ 0, 5 ]
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
        $("div.toolbar").html('<a href="nueva-pregunta.php?idt='+params['idt']+'" class="btn ttip" teid="en:html:44, en:title:32"></a>');
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};

        var response = traerDatosSync("encuestas/encuesta/copropiedad/filtro", arr, sessionStorage.getItem('cp'));
        traerCabecerasModificables(response);


        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("encuestas/encuesta/pregunta/listar",arr);
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
                      tipo:obtenerTerminoLenguage('en','29'),
                      fecha_fin:$('#datepicker').val(),
                      nombre:$('#nombre').val(),
                      descripcion:$('#descripcion').val(),
                      estado:$('#estado').val(),
                      invitados:$('#invitados').val(),
                      invitados_externos:$('#odestinatario').val()
                  }
              }

          response= envioFormularioSync("encuestas/encuesta",arr,'PUT');
          if(response)
          {
            $(document).renderme('ale');
            location.href='index.php';
            //$("#alertas").html('<div class="alert alert-dismissable alert-success" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:136"></strong></div>');
            $(document).renderme('ale');
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
            if($('#tipo_pregunta0').val()!="Abierta")
            {
                for (i in partido) 
                {
                    resultado+=letras[i]+"|"+partido[i]+","                    
                } 
            } 
            if($('#obligatoria0').is(':checked')){
                obligatorio=obtenerTerminoLenguage('en','30');
            } else {                        
                obligatorio=obtenerTerminoLenguage('en','31');
            }
            var arrPregunta = 
            {                        
                token:sessionStorage.getItem('token'),
                body:
                {
                    //id:params['idt'],
                    id_encuesta:params['idt'],
                    pregunta:$('#enunciado_pregunta0').val(),
                    tipo:$('#tipo_pregunta0').val(),
                    opciones:resultado,
                    obligatorio:obligatorio
                }
            }
            response= envioFormularioSync("encuestas/encuesta/pregunta",arrPregunta,'POST');
            //alert(arrPregunta);
            if(response)
            {
              //$("#alertas").html('<div class="alert alert-dismissable alert-success" teid="ale:html:4"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Encuesta modificada</strong></div>');
              var pagina="encuesta-editar.php?idt="+params["idt"];
              setTimeout(refreshWindow(pagina),1000); 
            }
                 
          });

        $(document).renderme('en');
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