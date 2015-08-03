  //calendario datepicker
$(function() {
    var d = new Date();
    var mes=d.getMonth()+1;
    
    $( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd",minDate: "d.getFullYear()-mes-d.getDate()" });
    $( "#datepicker2" ).datepicker({dateFormat: "yy-mm-dd",minDate: "d.getFullYear()-mes-d.getDate()" });
    $( "#datepicker3" ).datepicker({dateFormat: "yy-mm-dd",minDate: "d.getFullYear()-mes-d.getDate()" });
    $( "#datepicker4" ).datepicker({dateFormat: "yy-mm-dd",minDate: "d.getFullYear()-mes-d.getDate()" });
    $( "#datepicker5" ).datepicker({dateFormat: "yy-mm-dd",minDate: "d.getFullYear()-mes-d.getDate()" });
  }); 

$(document).ready(function(e) {   
    //no use
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
      
    //convert
    //$("select").msDropdown({roundedBorder:false});
    //createByJson();
    
  });

function CreaToken(AutDeUsuario, usuario)
{
    //definicion de constantes
    var rutaAplicatico = rutaAplicatico+"api/"; 

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
    // var fecha = new Date();
    // var ParamFecha = fecha.getFullYear()+"-"+fecha.getMonth()+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
    // return ParamFecha;
    var d = new Date();
    var n = d.toISOString(); 
    return n;
}  