function popularCartera(datos)
{   
    var t = $('#cartera').DataTable({
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

    if(datos != null || datos != undefined)
      if(Array.isArray(datos))
        $.each(datos,function(k,v){
            //console.warn(k,v);
            t.row.add(['',v['copropietario'],v['inmueble'],v['documento'],accounting.formatMoney(accounting.toFixed(v['valor'],2),"$ ",0),accounting.formatMoney(accounting.toFixed(v['total'],2),"$ ",0)]);
            t.draw();   
        });
}