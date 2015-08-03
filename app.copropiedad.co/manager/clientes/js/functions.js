$(document).ready(function() 
{// Función que suma o resta días a la fecha indicada
    sumaFecha = function(d, fecha)
    {
        var Fecha = new Date();
        var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
        var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
        var aFecha = sFecha.split(sep);
        var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
        fecha= new Date(fecha);
        fecha.setDate(fecha.getDate()+parseInt(d));
        var anno=fecha.getFullYear();
        var mes= fecha.getMonth()+1;
        var dia= fecha.getDate();
        mes = (mes < 10) ? ("0" + mes) : mes;
        dia = (dia < 10) ? ("0" + dia) : dia;
        var fechaFinal = dia+sep+mes+sep+anno;
        return (fechaFinal);
     }

    function fecha()
    {
        // var fecha = new Date();
        // var ParamFecha = fecha.getFullYear()+"-"+fecha.getMonth()+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
        // return ParamFecha;
        var d = new Date();
        var n = d.toISOString(); 
        return n;
    }  
});