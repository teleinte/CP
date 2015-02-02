$(document).ready(function(e) {   
    try {
      var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona:sessionStorage.getItem('id_crm'),}};
      TraerCopropiedadDrop(arr,"copropiedad/usuarioCopropiedad", parseInt(sessionStorage.getItem('id_crm')));  
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          sessionStorage.setItem("cp", val)           
          window.open("#"+val,'_parent');
          location.reload()
        }
          sessionStorage.setItem("cp", val)
          window.open("#"+val,'_parent');
          location.reload() 
        }}}).data("dd");
    } catch(e) {
      //console.log(e); 
    }
    
    $("#ver").html(msBeautify.version.msDropdown);
  });

function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    const rutaAplicatico = "http://aws02.sinfo.co/api/"; 

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
                location.href="../index.html"
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

function fecha()
{
    var d = new Date();
    var n = d.toISOString(); 
    return n;
}  

function obtenerInmuebles()
{
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_copropiedad : sessionStorage.getItem('cp'),
        id_inmueble : ""                   
      }
    }; 

    var response  = new Array();

    const rutaAplicativo = "http://aws02.sinfo.co/api/reservas/reservas/inmuebles/lista/";    
    $.ajax(
        {
            url: rutaAplicativo,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
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
                    var grupos = new Array();
                    var inmuebles = new Array();
                    var colores = new Array();
                    var grupoinmueble = new Array();
                    sessionStorage.setItem("inmueblesReservables",JSON.stringify(datos));  
                    $.each(JSON.parse(sessionStorage.getItem("inmueblesReservables")), function(x , y) 
                    {
                        grupos.push(y['grupo']);
                        inmuebles.push(y["nombre_despliegue"] + "$$" +y['grupo'] + "@@" + y["id_inmueble"]);
                    });
                    $.each(grupos, function(index){
                        var curr_grupo = grupos[index];
                        grupoinmueble.push('<optgroup label="' + curr_grupo + '">');
                        grupoinmueble.push('<option value="' + curr_grupo + '">' + "&nbsp;Todos los recursos del grupo " + curr_grupo + "</option>");
                        $.each(inmuebles, function(index){
                            if(inmuebles[index].split("@@")[0].split("$$")[1] == curr_grupo)
                            {
                                var style = document.createElement('style');
                                style.type = 'text/css';
                                color = Math.floor(Math.random()*16777215).toString(16);
                                style.innerHTML = '.cn'+inmuebles[index].split("@@")[1] +' { border: 1px solid #'+color+'!important; background-color: #'+color+'!important; }';
                                document.getElementsByTagName('head')[0].appendChild(style);
                                var el = document.getElementsByClassName("cn"+inmuebles[index].split("@@")[1]);
                                colores[inmuebles[index].split("@@")[1]] = '#'+color;
                                grupoinmueble.push('<option value="' + inmuebles[index].split("@@")[1] + '">' + "&nbsp;" + inmuebles[index].split("@@")[0].split("$$")[0] + "</option>");
                            }
                        });
                        grupoinmueble.push('</optgroup>');
                    });
                    $.each(grupoinmueble,function(index){$("#ddrecursos").append(grupoinmueble[index])});
                    sessionStorage.setItem("inmueblesReservablesColores",JSON.stringify(colores));  
                    $("#fecha-reserva").datepicker({ dateFormat: "yy-mm-dd" });
                    $("#fecha-reserva").val(new Date(sessionStorage.getItem("reservaFechaRequerida")).toISOString().split("T")[0]);
                    $("#ddrecursos")[0].selectedIndex = 0;
                }
                return false;
            }
        });
}