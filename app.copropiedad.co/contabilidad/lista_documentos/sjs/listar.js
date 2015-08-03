$(document).ready(function(){
  //$("#selcopropiedades").prop('disabled', true);
    $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
    $(document).renderme('co');

    $("#editarpopup").dialog({
      autoOpen:false,
      modal:true,
      width:'600px',
      open: function(event, ui)
      {
        var doc = $(this).data('button');
        var cuentas = obtenerCuentasPorTransaccion(doc.attr("consecutivo"),doc.attr("nombre_tercero"));
        var tipomov = {C:"Credito",D:"Debito"};
        var cuenta = cuentas.split("^")[0];
        //console.warn(cuentas);
        var totald = cuentas.split("^")[1].split(",")[1];
        var totalc = cuentas.split("^")[1].split(",")[0];
        var documentos = {FC:"Factura de compra", FV:"Factura de venta", RC:"Recibo de caja", CC:"Cuenta de cobro", NC:"Nota de contabilidad", CE:"Comprobante de egreso"};
        var tipod = doc.attr("consecutivo").substring(0,2);
        if(doc.attr("docrel") == undefined || doc.attr("docrel") == "undefined" || doc.attr("docrel") == null)
        {
          doc.attr("docrel") == "N/A";
        }

        if(doc.attr("anulado") == "SI")
        {
            $("#editarpopup").html('<div style="clear:both;"></div><div id="alertas"></div></br><div style="margin:0px auto;"><h1 style="color:red" teid="co:html:145"></h1><h2> ' + documentos[tipod] + ' </h2></div><table> <tr> <td width="25%"><label teid="co:html:108"></label> <p>' + doc.attr("fecha") + '</p><input type="hidden" id="mongoidborrar" value="' + doc.attr("mongoid") + '"></td> <td colspan="2"><label teid="co:html:133"></label> <p>' + doc.attr("nombre_tercero") + '</p></td> <td width="25%"><label teid="co:html:110"></label> <h3 style="color:red;" id="consecutivopopup">' + doc.attr("consecutivo") + '</h3></td> </tr> <tr> <td colspan="4"> <label teid="co:html:112"></label> <h4>' + doc.attr("nombre_tercero") + '</h4></td></tr><tr><td colspan="2"> <label teid="co:html:109"></label> <h4>' + doc.attr("concepto_documento") + '</h4> </td> <td colspan="2"> <label teid="co:html:116"></label> <h4>' + doc.attr("docrel") + '</h4> </td> </tr> <tr> <td width="20%" class="titulo-campos" teid="co:html:48"></td> <td width="20%" class="titulo-campos" teid="co:html:49"></td> <td width="20%" class="titulo-campos" teid="co:html:135"></td> <td width="20%" class="titulo-campos" teid="co:html:146"></td></tr>' + cuenta + '</table>' + '</br><div style="float:right; margin-right:70px;"><table><tr><td colspan="2"></td><td style="text-align: right;" teid="co:html:52"></td><td><h4 style="text-align: right;">D: ' + totald + '</h4></td><td><h4 style="text-align: right;">C: ' + totalc + '</h4></td></tr></table></div>');
            $(document).renderme('co');
        }
        else
        {
            $("#editarpopup").html('<div style="clear:both;"></div><div id="alertas"></div></br><div style="margin:0px auto;"><h2> ' + documentos[tipod] + ' </h2></div><table> <tr> <td width="25%"><label teid="co:html:108"></label> <p>' + doc.attr("fecha") + '</p><input type="hidden" id="mongoidborrar" value="' + doc.attr("mongoid") + '"></td> <td colspan="2"><label teid="co:html:133"></label> <p>' + doc.attr("nombre_tercero") + '</p></td> <td width="25%"><label teid="co:html:110"></label> <h3 style="color:red;" id="consecutivopopup">' + doc.attr("consecutivo") + '</h3></td> </tr> <tr> <td colspan="4"> <label teid="co:html:112"></label> <h4>' + doc.attr("nombre_tercero") + '</h4></td></tr><tr><td colspan="2"> <label teid="co:html:115"></label> <h4>' + doc.attr("concepto_documento") + '</h4> </td> <td colspan="2"> <label teid="co:html:116"></label> <h4>' + doc.attr("docrel") + '</h4> </td> </tr> <tr> <td width="20%" class="titulo-campos" teid="co:html:48"></td> <td width="20%" class="titulo-campos" teid="co:html:49"></td> <td width="20%" class="titulo-campos" teid="co:html:135"></td> <td width="20%" class="titulo-campos" teid="co:html:146"></td></tr>' + cuenta + '</table>' + '</br><div style="float:right; margin-right:70px;"><table><tr><td colspan="2"></td><td style="text-align: right;" teid="co:html:52"></td><td><h4 style="text-align: right;">D: ' + totald + '</h4></td><td><h4 style="text-align: right;">C: ' + totalc + '</h4></td></tr></table></div>');
            $(document).renderme('co');
        }
      }
    });

    $('#listaTabla').DataTable({
      responsive: 
      {
      details: {
                type: 'column'
            }
      },
      columnDefs: 
      [ {
            className: 'control',
            orderable: false,
            targets:   0
      } ],
      order: [ 1, 'asc' ],
      "dom": '<"toolbar">lfCrtip',
      "colVis": 
      {
        "buttonText": obtenerTerminoLenguage('ta','20'),
        exclude: [ 0, 1 ],
        exclude: [ 0, 7 ]
      },
      "drawCallback": function( settings ) {
        //console.warn(settings);
         $(".btneditar").click(function(){
            $("#editarpopup").data('button',$(this));
            if($(this).attr("anulado") == "SI")
            {
                $("#editarpopup").dialog({
                    buttons: {
                        "Imprimir" : function(){$(this).dialog("close");imprimirDocumento();}
                    }
                });
            }
            else
            {
                $("#editarpopup").dialog({
                    buttons: {
                        "Imprimir" : function(){$("#editarpopup").dialog('close');imprimirDocumento();},
                        "Anular" : function(){anularDocumento($(this));}
                    }
                });
            }
            $("#editarpopup").dialog("open");
        });
      },      
      "language": 
      {
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
        "oPaginate": 
        {
          "sFirst":    obtenerTerminoLenguage('ta','14'),
          "sLast":     obtenerTerminoLenguage('ta','15'),
          "sNext":     obtenerTerminoLenguage('ta','16'),
          "sPrevious": obtenerTerminoLenguage('ta','17')
        },
        "oAria": 
        {
          "sSortAscending":  obtenerTerminoLenguage('ta','18'),
          "sSortDescending": obtenerTerminoLenguage('ta','19')
        }
      }
    });
      var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
      var datos = traerDatosSync("contabilidad/obtener/transacciones/",arr);
      traerTransacciones(datos);

    $( ".ttip[title!='']" ).qtip({
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

    $(document).renderme('co');
		
  });