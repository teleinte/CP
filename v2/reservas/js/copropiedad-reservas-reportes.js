$(document).ready(function($) {
    $("#btnreportereservas").click(function(){
        if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
         {  
            window.location = '../index.html';
            return false;
         }
         else
         {
            popularReporte($("#ddrecursos").val(),  $("#fechainicio").val(), $("#fechafin").val());
         }
    });

    $("#fechainicio").datepicker({ dateFormat: "yy-mm-dd" });
    $("#fechafin").datepicker({ dateFormat: "yy-mm-dd" });
    $("#fechainicio").val(new Date().toISOString().split("T")[0]);
    var date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    $("#fechafin").val(date.toISOString().split("T")[0]);
});

function popularReporte(inmueble, start, end)
{
    var rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/inmueble/fecha/";
    var totalHoras = new Array(0);
    var totalValor = new Array(0);
    var contador = 0;
    if(inmueble.indexOf("Zonas ") != 0)
    {
        rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/inmueble/fecha/"; 
        var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),id_inmueble:inmueble,fecha_fin:end,fecha_inicio:start}};
    }
    else
    {
        rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/listar/grupo/fecha/"; 
        var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),grupo:inmueble,fecha_fin:end,fecha_inicio:start} };
    }
    //var data = JSON.stringify(arr);
    $.post(rutaAplicativo, JSON.stringify(arr))
            .done(function(msg){
                var reservasCalendario = [];
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);    
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    var t = $('#listareporte').DataTable();
                    t.clear();
                    var costos = new Array();
                    var nombres = new Array();
                    $.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
                    {
                        costos[y['id_inmueble']] = y['valor_reserva'];
                        totalHoras[y["id_inmueble"]] = 0;
                        totalValor[y["id_inmueble"]] = 0;
                        nombres[y['id_inmueble']] = y['nombre_despliegue'];
                    });
                    if(!$.isEmptyObject(datos))
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);
                        var datestart = new Date(y['fecha_inicio'].replace("COT","T"));
                        var dateend = new Date(y['fecha_fin'].replace("COT","T"));
                        var datecreacion = new Date(y['fecha_creacion']).toISOString();
                        var user = y['usuario'].split("|")[1];
                        var costo = calculaCosto(y['fecha_inicio'].replace("COT","T"), y['fecha_fin'].replace("COT","T"), costos[y["id_inmueble"]]);
                        totalHoras[y["id_inmueble"]] = totalHoras[y["id_inmueble"]] + parseInt(costo.split("@@@")[0]);
                        totalValor[y["id_inmueble"]] = totalValor[y["id_inmueble"]] + parseInt(costo.split("@@@")[1]);
                        var costofinal = parseInt(costo.split("@@@")[1]).toLocaleString('es-CO', { style: 'currency', currency: 'COP' });
                        t.row.add(['',nombres[y["id_inmueble"]],datestart.toLocaleString(),dateend.toLocaleString(),y['grupo'],user,costofinal]).draw();
                        contador++;
                    })
                }
                $("#ddrecursos").val(inmueble);
                $("#reporte-title").html("<h2>Reservas para " + $("#ddrecursos option:selected").text() + "</h2>");
                generaInforme(start, end, inmueble, contador, totalHoras, totalValor, nombres);
            });
}

function calculaCosto(start, end, costo)
{
    var startdate = new Date(start);
    var enddate = new Date(end);
    var datestart = startdate.getTime();
    var dateend = enddate.getTime();
    var diff = dateend - datestart;
    var diff_final = Math.floor(diff/60000);
    return diff_final/60 + "@@@" + costo * diff_final/60;
}

function generaInforme(fechai, fechaf, inmueblename, reservasCantidad, reservasHoras, reservasCosto, nombres)
{
    var reservasHorasTotal = 0;
    var reservasValorTotal = 0;
    var reservasHorasProm = 0;
    var reservasValorProm = 0;
    for(inmueble in reservasHoras){
        reservasHorasTotal = reservasHorasTotal + reservasHoras[inmueble];
    }
    for(inmueble in reservasCosto){
        reservasValorTotal = reservasValorTotal + reservasCosto[inmueble];
    }
    $("#consolidado").html("");
    if(inmueblename.indexOf("Zonas ") != 0)
    {
        $("#consolidado").html('<input type="submit" class="btn" value="Version para imprimir" id="btnprint" style="margin:5px 0px;"/><div id="consolidado-print"><h2>Informe consolidado de reservas</h2><p><h3>Fechas del reporte: ' + fechai + ' a ' + fechaf + '</h3></p><p><h3>Inmueble/Grupo solicitado: ' + nombres[inmueblename] + '</h3></p> <p><h3>Cantidad de reservas: ' + reservasCantidad + ' reservas</h3></p> <p><h3>Cantidad de horas reservadas: ' + reservasHorasTotal + ' hora(s)</h3></p> <p><h3>Costo promedio por reserva: ' + Math.round(reservasValorTotal/reservasCantidad).toLocaleString('es-CO', { style: 'currency', currency: 'COP' }) + '</h3></p> <p><h3>Duración promedio de reserva: ' + Math.round(reservasHorasTotal/reservasCantidad) + ' horas(s)</h3></p></div>'); 
    }
    else
    {
        $("#consolidado").html('<input type="submit" class="btn" value="Version para imprimir" id="btnprint" style="margin:5px 0px;"/><div id="consolidado-print"><h2>Informe consolidado de reservas</h2><p><h3>Fechas del reporte: ' + fechai + ' a ' + fechaf + '</h3></p><p><h3>Inmueble/Grupo solicitado: ' + inmueblename + '</h3></p> <p><h3>Cantidad de reservas: ' + reservasCantidad + ' reservas</h3></p> <p><h3>Cantidad de horas reservadas: ' + reservasHorasTotal + ' hora(s)</h3></p> <p><h3>Costo promedio por reserva: ' + Math.round(reservasValorTotal/reservasCantidad).toLocaleString('es-CO', { style: 'currency', currency: 'COP' }) + '</h3></p> <p><h3>Duración promedio de reserva: ' + Math.round(reservasHorasTotal/reservasCantidad) + ' horas(s)</h3></p></div>');
    }

    $("#btnprint").click(function(){
        $("#consolidado-print").prepend('<div class="logo" id="printlogo" style="width:100%; height:70px;"><img src="../images/logo-home.png" style="diplay:inline-block; float:left;"/><h1 style="display:inline-block; float:left; width:500px; margin:30px 0px 0px 20px;">Reporte generado por Copropiedad.co</h1></div><div style="clear:both;></div>"');
        $("#consolidado-print").print();
        $("#printlogo").remove();
    });
}