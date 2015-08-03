function popularPuc(datos)
{   $(document).renderme('co');
  	$.each(datos, function(x , y) 
    {
        var idmongo= JSON.stringify(y['_id']);
        var idMongoFinal = JSON.parse(idmongo);
        var tabla = $('#puc').DataTable( {
            responsive: {
              details: {
                        type: 'column'
                    }
            },
            columnDefs: [ {
                    className: 'control',
                    orderable: false,
                    targets:0
                } ],
           
            columns: [
                  null,
                  { orderDataType: "dom-text", type: 'string' },
                  { orderDataType: "dom-text-numeric" },                  
                  { orderDataType: "dom-select" }
              ],
            "colVis": {
                "buttonText": obtenerTerminoLenguage('ta','20'),
                exclude: [ 0, 1 ],
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
            }
          } );
        
        $.each(y, function(a , b)
        {
            if(a=="puc")
            {
                $.each(b, function(e , r)
                {
                    
                    entrada=JSON.stringify(r)                    
                    var entradaDos=JSON.parse(entrada);                    
                    if(entradaDos['editar'] && entradaDos['agregar'])
                    {
                        var acciones ='<a href="agregar-cuenta.php?idt='+entradaDos['cuenta']+'&base='+e+'&idm='+idMongoFinal.$id+'">Agregar sub-cuenta        |</a><a href="editar-cuenta.php?idt='+entradaDos['cuenta']+'&base='+e+'&idm='+idMongoFinal.$id+'&n='+encodeURIComponent(entradaDos['nombre'])+'"> Cambiar nombre</a>';
                    }
                    if(entradaDos['editar'] && !entradaDos['agregar'])
                    {
                        var acciones ='<a href="editar-cuenta.php?idt='+entradaDos['cuenta']+'&base='+e+'&idm='+idMongoFinal.$id+'&n='+encodeURIComponent(entradaDos['nombre'])+'">Cambiar nombre</a>';
                    }
                    if(!entradaDos['editar'] && entradaDos['agregar'])
                    {
                        var acciones ='<a href="agregar-cuenta.php?idt='+entradaDos['cuenta']+'&base='+e+'&idm='+idMongoFinal.$id+'">Agregar sub-cuenta </a>';
                    }
                    if(!entradaDos['editar'] && !entradaDos['agregar'])
                    {
                        var acciones ='';
                    }
                    tabla.row.add( [
                    '',
                    entradaDos['cuenta'],
                    entradaDos['nombre'],                                        
                    acciones,                                        
                    ] ).draw();
                })
            }
        })
        tabla.column( '0:visible' ).order("asc");
        tabla.draw();
        $(document).renderme('co');
    })
}