$(document).ready(function() {
    $(document).renderme('vo');
        $('#res-encuesta').DataTable( {
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
    "dom": 'lfrtp',
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
  } );


        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("encuestas/encuesta/VotantesTotales",arr);
        traerElectores(response);


        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
        var response = traerDatosSync("votacion/encuesta/copropiedad/filtro",arr);
        traerCabecerasRersultados(response);


        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("votacion/encuesta/resultadosTotales",arr);
        traerPreguntasResultado(response);
        
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var url = "encuestas/encuestaEnvio/listar";
        var responseEnvio = traerDatosSync(url, arr,"POST");
        traerElectantes(responseEnvio);
        
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        var response = traerDatosSync("votacion/encuesta/pregunta/listarIdEncuestas",arr);
        traerSetPreguntas(response);
        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});          
        url="votacion/encuesta/resultadosPorPregunta";  
        rutaAplicativo = traerDireccion()+"api/";        
        var idps = sessionStorage.getItem("idp"); 
        var aidps = idps.split("|");        
        for(valores in aidps)
        {
            var arr = {token:sessionStorage.getItem('token'),body:{id_pregunta:aidps[valores]}};            
            $.ajax(
            {
                url: rutaAplicativo+url,
                type: 'POST',
                data: JSON.stringify(arr),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                async: false,
                success: function(msg) 
                {
                    var msgDividido = JSON.stringify(msg);
                    var mensaje =  JSON.parse(msgDividido);
                    var msgDivididoDos = JSON.stringify(mensaje.message);
                    var datos = JSON.parse(msgDivididoDos);                    
                    var contador = 1;
                    $.each(datos, function(x , y) 
                    {
                        if (y['tipo']==="mr")
                        {
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"> .</div>');
                            $("#"+aidps[valores]).append('<canvas id="canvas'+aidps[valores]+'" width="640" height="450">');                            
                            var parametros = {};
                            var variables = [];
                            var votos = [];
                            
                            $.each(y[0], function(alpha , beta) {
                                var sumador = [];
                                sumador.push(beta);
                                votos.push(sumador);
                                variables.push(alpha);                                
                            });                            
                            var jsonVotos = JSON.stringify(votos);
                            parametros = {
                            'y' : 
                                {
                                  'vars' : variables,
                                  'smps' : [y['enunciado']],
                                  'data' : JSON.parse(jsonVotos)
                                }
                            };
                            
                            var cx4 = new CanvasXpress
                            (
                                "canvas"+aidps[valores],parametros,
                                  {
                                    'title':y['enunciado'],
                                    "titleHeight": 60,
                                    'setMinX':0,
                                    "smpTitleScaleFontFactor": 1,
                                    'axisTickScaleFontFactor': 1.5,
                                    'axisTitleScaleFontFactor': 1.5,
                                    'fontStyle': 'bold italic',
                                    'graphOrientation': 'vertical',
                                    'graphType': 'Bar',
                                    'background': '#f9f9f9',
                                    'legendBox': false,
                                    'legendScaleFontFactor': 1.2,
                                    'plotByVariable': true,
                                    'showSampleNames': false,//Este es para quitar la leyenda 'Pregunta3' de la parte inferior
                                        //'smpLabelFontStyle': 'italic',
                                        //'smpLabelInterval': 2,
                                        //'smpLabelRotate': 45,
                                        //'smpLabelScaleFontFactor': 0.8,
                                    'xAxis2Show': false,
                                    'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
                                    'disableMenu': true,
                                    'disableToolbar': true
                                }
                            );
                        }
                        
                        if (y['tipo']==="ur")
                        {   
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"></div>');
                            $("#"+aidps[valores]).append('<canvas id="canvas'+aidps[valores]+'" width="640" height="450">');
                            var parametros = {};
                            var variables = [];
                            var votos = [];
                            $.each(y[0], function(alpha , beta) {
                                var sumador = [];                                
                                sumador.push(beta);
                                votos.push(sumador);
                                variables.push(alpha);                                
                            });                            
                            var jsonVotos = JSON.stringify(votos);
                            parametros = {
                            'y' : 
                                {
                                  'vars' : variables,
                                  'smps' : [y['enunciado']],
                                  'data' : JSON.parse(jsonVotos)
                                }
                            };
                            var cx3 = new CanvasXpress(
                            "canvas"+aidps[valores],parametros,
                              {
                                'graphType': 'Pie',
                                'title':y['enunciado'],
                                'titleHeight': 60,
                                'pieSegmentLabels': 'outside',
                                'pieSegmentPrecision': 1,
                                'pieSegmentSeparation': 2,
                                'pieType': 'solid',
                                'background': '#f9f9f9',
                                'legendBox': false,
                                'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
                                'disableMenu': true,
                                'disableToolbar': true}
                            );
                            
                        }
                        if (y['tipo']==="A")
                        {
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"></div>');
                            $("#"+aidps[valores]).append('<table id="'+contador+aidps[valores]+'" class="stripe" cellspacing="0" width="100%"><thead><tr><th></th><th>#</th><th>Respuesta</th></tr></thead>');                            
                            $("#"+contador+aidps[valores]).DataTable( {
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
                                            "dom": 'lfrtp',
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
                                    } );                                  
                            var res = y['opiniones'].split("|");                            
                            var i=0;
                            var t = $("#"+contador+aidps[valores]).DataTable();
                            while(i<res.length)
                            {                                
                                t.row.add( [
                                '',
                                i,                            
                                res[i]
                                ] ).draw();
                                i++;
                            }                            
                        contador++;
                        }
                    });                
                }
            });
        }





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