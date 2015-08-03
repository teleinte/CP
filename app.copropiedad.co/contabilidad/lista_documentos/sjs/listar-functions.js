function traerTransacciones(datos)
{   
    if(datos != null)
    $.each(datos, function(x , y){
        var idmongo= JSON.stringify(y['_id']['$id']);
        var idMongoFinal = JSON.parse(idmongo);
        var tipos = {CE:"Comprobante de egreso", RC:"Recibo de caja", CN:"Comprobante de Nomina", NC:"Nota de contabilidad", CC:"Cuenta de Cobro", FV:"Factura de venta", FC:"Factura de compra"};
        var tabla = $('#listaTabla').DataTable();
        var acciones ='<button type="button" title="Ir a detalles" class="btn ver solo inline btneditar ttip" id="ver' + idMongoFinal + '" mongoid="' + idMongoFinal + '" anulado="' + y['anulado'] + '" concepto_documento="' + y['concepto_documento'] + '" conciliado="' + y['conciliado'] + '" fecha="' + y['day'] + '/' + elmes(y) + '/' + y['year'] + '" docrel="' + y['docrelacionado'] + '" email="' + y['email_tercero'] + '" fechacreacion="' + y['fecha_creacion'] + '" consecutivo="' + y['idtransaccion'] + '" nombre_tercero="' + y['nombre_tercero'] + '" tipo_documento="' + tipos[y['tipo']] + '"></button>';
        tabla.row.add( [
        '',
        tipos[y['tipo']],
        y['idtransaccion'],
        y['nombre_tercero'],
        y['day'] + "/" + elmes(y) + "/" + y['year'],
        y['concepto_documento'],
        y['anulado'],
        acciones,
        ] ).draw();
    });
}

function obtenerCuentasPorTransaccion(idtx, tercero)
{
    //console.warn(idtx);
    var rutaAplicatico = traerDireccion()+"api/";    
    var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'), idtransaccion:idtx}};
    datos = traerDatosSync("contabilidad/obtener/registros/",arr);
    var cuentas=""
    if(datos!=null)
    {
        var totald = 0;
        var totalc = 0;
        $.each(datos, function(x , y){
            //alert(y["tipo"]);
            cuentas = cuentas + '<tr><td width="20%">' + y['tipo'] + '</td><td width="20%">' + y["cuenta_puc"] + '</td><td width="20%">' + tercero + '</td><td width="20%">'+ y["monto"] + '</td></tr>';
            //cuentas[x] = {tipomov:y['tipo'],cuenta:y['cuenta_puc'],monto:y['monto']};
            if(y["tipo"] == "C")
              totalc = Number(totalc) + Number(y["monto"]);
            else
              totald = Number(totald) + Number(y["monto"]);
        });
        cuentas = cuentas + "^" + totalc + "," + totald;
    }
    return cuentas;
}

function imprimirDocumento()
{
    //$("#editarpopup").print();
    printDiv("editarpopup");
    location.href = 'index.php';
}

function anularDocumento(item)
{
    var consecutivo = $("#mongoidborrar").val();
    var rutaAplicatico = traerDireccion()+"api/"; 
    var d = new Date();
    var today = d.toISOString();
    var _year = d.getFullYear();
    var _month = d.getMonth()+1;
    var _day = d.getDate();
    var arr={token:sessionStorage.getItem('token'),body:{id_copropiedad : sessionStorage.getItem('cp'),year : _year,mes : _month,mongoid : consecutivo}};    
    var response = envioFormularioSync("contabilidad/anular/transaccion",arr,'PUT');    
    //$('#alertas').html('<div class="alert alert-dismissable alert-success"><strong>OK</strong> Documento anulado con exito.</div>');
    setTimeout(function(){location.reload();},1000);    
}

function elmes(y)
{
    if(y['mes'] != null || y['mes'] != undefined)
    {
        return y['mes'];
    }
    else
    {
        return y['month'];
    }
}