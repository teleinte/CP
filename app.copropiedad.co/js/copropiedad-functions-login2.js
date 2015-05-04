function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    var rutaAplicatico = "https://app.copropiedad.co/api/"; 

    var arr = {body:{autkey:AutDeUsuario,user:usuario}};            
    $.ajax({
        url: rutaAplicatico+'tareas/token',
        type: 'POST',
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: true,
        success: function(msg) {
            var msgDividido = JSON.stringify(msg);                    
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if (mensaje.status==false)
            {
                location.href="../index.php"
            }                
            var datos = JSON.parse(msgDivididoDos);
            $.each(datos, function(x , y) 
            {                     
                 sessionStorage.setItem(x, y);
                 location.reload()                    
            }                
            )
          }
        })    
}
function CreaTokenLogin(AutDeUsuario, usuario)
{
    //definicion de constantes
    var rutaAplicatico = "https://app.copropiedad.co/api/"; 
    var arr = {body:{autkey:AutDeUsuario,user:usuario}};    
    $.ajax({
        url: rutaAplicatico+'tareas/token',
        type: 'POST',
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        async: true,
        success: function(msg) {
            var msgDividido = JSON.stringify(msg);                    
            var mensaje =  JSON.parse(msgDividido);
            var msgDivididoDos = JSON.stringify(mensaje.message);
            if (mensaje.status==false)
            {
                alert("No se puede crear el token de seguridad")
                location.href="index.php"
            }                
            var datos = JSON.parse(msgDivididoDos);
            $.each(datos, function(x , y) 
            {
                 sessionStorage.setItem(x, y);
                 //location.href="dashboard/dashboard.php";
                 location.href="usuario/ingreso.php?crm="+sessionStorage.getItem("email")+"&stk="+btoa(sessionStorage.getItem("token"));

            }                
            )
          }
        })    
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