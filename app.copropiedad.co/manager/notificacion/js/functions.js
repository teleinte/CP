$(document).ready(function() 
{
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