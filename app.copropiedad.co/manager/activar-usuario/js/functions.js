$( document ).ready(function() {
    CreaToken("copropiedad","activador");
    GetListaUsers();
    GetListaUsersi();
    $("#btn_listausers").click(function() {
        var rutaAplicativo = "http://auth.teleinte.com/auth/getinactiveuserscp/"; 
        var arr = {token:sessionStorage.getItem("token"),body:{}};            
        $.post(rutaAplicativo, JSON.stringify(arr))
         .done(function(data){
             var msgDividido = JSON.stringify(data);
             var mensaje =  JSON.parse(msgDividido);
             var msgDivididoDos = JSON.stringify(mensaje.message);
             $("#usuarioin").html("");
             if(mensaje.status)
             {
                var datos = JSON.parse(msgDivididoDos);console.log(mensaje);
                $.each(datos, function(x , y) 
                {   
                    console.log(datos);
                    $("#usuarioin").append('<form method="POST"><table><tr><td width=300px><h3 style="display:inline;">'+y['nombre']+'</h3><br/><h4 style="display:inline;">'+y['email'].replace("cp-","")+'</h4><input type="hidden" id="email" name="email" value="'+y['email']+'"><input type="hidden" id="token" name="token" value="'+sessionStorage.getItem("token")+'"></td><td width=150px><<input type="submit" class="btn gray" id="activar_user_btn" value="Activar usuario" style="display:inline;"/></td></tr></table></form>');
                });                
             }
             else
             {
                return "notoken";
             }
         });
    });
});
function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    var rutaAplicativo = "http://auth.teleinte.com/token/"; 
    var arr = {body:{autkey:AutDeUsuario,user:usuario}};            
    $.post(rutaAplicativo, JSON.stringify(arr))
     .done(function(data){
         var msgDividido = JSON.stringify(data);
         var mensaje =  JSON.parse(msgDividido);
         var msgDivididoDos = JSON.stringify(mensaje.message);
         if(mensaje.status)
         {
            var datos = JSON.parse(msgDivididoDos);
            $.each(datos, function(x , y) 
            {                     
                sessionStorage.setItem(x, y);              
            });                
         }
         else
         {
            return "notoken";
         }
     });
}
function GetListaUsersi()
{
    var rutaAplicativo = "http://auth.teleinte.com/auth/getinactiveuserscp/"; 
    var arr = {token:sessionStorage.getItem("token"),body:{}};            
    $.post(rutaAplicativo, JSON.stringify(arr))
     .done(function(data){
         var msgDividido = JSON.stringify(data);
         var mensaje =  JSON.parse(msgDividido);
         var msgDivididoDos = JSON.stringify(mensaje.message);
         $("#usuarioin").html("");
         if(mensaje.status)
         {
            var datos = JSON.parse(msgDivididoDos);console.log(mensaje);
            $.each(datos, function(x , y) 
            {
                $("#usuarioin").append('<form method="POST"><table><tr><td width=300px><h3 style="display:inline;">'+y['nombre']+'</h3><br/><h4 style="display:inline;">'+y['email'].replace("cp-","")+'</h4><input type="hidden" id="email" name="email" value="'+y['email']+'"><input type="hidden" id="token" name="token" value="'+sessionStorage.getItem("token")+'"><input type="hidden" id="tipo" name="tipo" value="inactivo"></td><td width=150px><input type="submit" class="btn gray" id="activar_user_btn" value="Activar usuario" style="display:inline;"/></td></tr></table></form>');
            });
         }
         else
         {
            return "notoken";
         }
     });
}
function GetListaUsers()
{
    var rutaAplicativo = "http://auth.teleinte.com/auth/getactiveuserscp/"; 
    var arr = {token:sessionStorage.getItem("token"),body:{}};            
    $.post(rutaAplicativo, JSON.stringify(arr))
     .done(function(data){
         var msgDividido = JSON.stringify(data);
         var mensaje =  JSON.parse(msgDividido);
         var msgDivididoDos = JSON.stringify(mensaje.message);
         $("#usuario").html("");
         if(mensaje.status)
         {
            var datos = JSON.parse(msgDivididoDos);console.log(mensaje);
            $.each(datos, function(x , y) 
            {
                $("#usuario").append('<form method="POST"><table><tr><td width=300px><h3 style="display:inline;">'+y['nombre']+'</h3><br/><h4 style="display:inline;">'+y['email'].replace("cp-","")+'</h4><input type="hidden" id="email" name="email" value="'+y['email']+'"><input type="hidden" id="token" name="token" value="'+sessionStorage.getItem("token")+'"><input type="hidden" id="tipo" name="tipo" value="activo"></td><td width=150px><input type="submit" class="btn gray" id="activar_user_btn" value="Desactivar usuario" style="display:inline;"/></td></tr></table></form>');
            });
         }
         else
         {
            return "notoken";
         }
     });
}