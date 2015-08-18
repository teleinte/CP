function traerDatosPagos(referencias)
{
    var url = traerDireccion();
    var datos = checkVigencia(url);

    if(datos)
    {
        var admins = 1;
        $.each(datos, function(x , y) 
        {
            var curdate = new Date(y['vigencia']);
            var now = new Date();
            //alert(y['id_copropiedad']);
            if(curdate < now)
            {
                $("#copropiedadescart").append('<tr id="prod' + admins + '" class="alert-error"><td></td><td>' + y['nombre'] + '</td><td>' + y['referencia'] + '</td><td>' + y['vigencia'] + '</td><td>' + generarbotones(referencias, admins, y['_id']['$id'],true,y['nombre']) + '</td><td><span id="val' + admins + '">$0</span></td><td><span id="des' + admins + '">$0</span></td></tr>');
            }
            else
            {
                $("#copropiedadescart").append('<tr id="prod' + admins + '"><td></td><td>' + y['nombre'] + '</td><td>' + y['referencia'] + '</td><td>' + y['vigencia'] + '</td><td>' + generarbotones(referencias, admins, y['_id']['$id'],false,y['nombre']) + '</td><td><span id="val' + admins + '">$0</span></td><td><span id="des' + admins + '">$0</span></td></tr>');
            }
            admins++;
        });
    }

      $("#copropiedadescart").DataTable({
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
        exclude: [ 0, 1 ],
        exclude: [ 0, 4 ]
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
   sessionStorage.removeItem('shop');
}

function traerDatosPerfil()
{
    if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
    {                      
        $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')            
            window.location = '../';
    }
    var arr = { token:sessionStorage.getItem('token'),body:{id_crm:sessionStorage.getItem('id_crm')}};        
    var rutaAplicativo = traerDireccion()+"api/perfil/info";    
    $.ajax(
        {
            url: rutaAplicativo,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);               
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    var admins = 0;
                    $.each(datos, function(x , y) 
                    {
                        if(y['rol'] == "administrador")
                            admins++;

                        if(y['imagen'])
                            $("#foto").attr("src",y['imagen']);
                        else
                            $("#foto").attr("src","img/user.png");
                        
                        $("#pagar").attr("cpid",y['id_crm_persona']);
                    });
                    $("#cpnumber").html(admins);
                    $("#pagar").attr("cpnumber",admins);
                    $("#pagar").attr("token",sessionStorage.getItem('token'));
                    $("#pagar").attr("documento",sessionStorage.getItem('documento'));
                    $("#pagar").attr("nombre",sessionStorage.getItem('nombreCompleto'));
                    $("#pagar").attr("uid",sessionStorage.getItem('uid'));
                }                
            }
        });
    $("#nombre").val(sessionStorage.getItem('nombre'));
    $("#apellido").val(sessionStorage.getItem('apellido'));
    $("#email").html(sessionStorage.getItem('email').replace('cp-',''));
    $("#fechanac").val('01/01/1901');
    $("#idioma").val(sessionStorage.getItem('idioma'));
    $("#pais").val(sessionStorage.getItem('paisNacimiento'));
}

function TraerUsuarioCopropiedad(arr,url,metodo)
{
    var rutaAplicativo = traerDireccion()+"admin/copropiedad/";    
    $.ajax(
        {
            url: rutaAplicativo+url,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);                
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        var idmongo= JSON.stringify(y['_id']);
                        var idMongoFinal = JSON.parse(idmongo);                        
                        $('#responsable').append('<option value="'+y['email']+'">'+y['nombre']+'</option>')
                        
                        
                    })               
                }
                return false;
            }
        });
}

function generarbotones(referencias, cnt, idcp, vencido, nombrecp)
{
    var ref = "";
    if((referencias != null || referencias != undefined) && referencias.length > 0)
    for (var i = referencias.length - 1; i >= 0; i--) 
    {
        if(referencias[i].split("^")[1] != "12")
            ref = ref + '<input type="button" id="select' + cnt + '" value="' + referencias[i].split("^")[1] + '" class="btn shop shop' + cnt + '" valor="' + referencias[i].split("^")[2] + '" ref="' + referencias[i].split("^")[0] + '" idcp="' + idcp + '" cnt="' + cnt + '" act="add" vencido="' + vencido + '" vigencia="' + referencias[i].split("^")[1] + '" nombre="' + nombrecp + '" dto="0"/> ';
        else
            ref = ref + '<input type="button" id="select' + cnt + '" value="12" class="btn promo shop shop' + cnt + '" valor="' + referencias[i].split("^")[2] + '" ref="' + referencias[i].split("^")[0] + '" idcp="' + idcp + '" cnt="' + cnt + '" act="add" vencido="' + vencido + '" vigencia="' + referencias[i].split("^")[1] + '" nombre="' + nombrecp + '" dto="120000"/> ';

    };
    return ref;
}

function traerReferencias()
{
    var arr = { token:sessionStorage.getItem('token'),body:{id_crm:sessionStorage.getItem('id_crm')}};        
    var rutaAplicativo = traerDireccion()+"api/managercp/referencias/getlist/";
    var refs = new Array();
    $.ajax(
        {
            url: rutaAplicativo,
            type: 'POST',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);               
                if (datos=="Token invalido")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-error" teid="ale:html:12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong></div>')                  
                    window.location = '../index.html';
                }
                else
                {
                    $.each(datos, function(x , y) 
                    {
                        refs.push(y['id_ref'] + "^" + y['time_ref'] + "^" + y['valor_ref']);
                        refs.sort(function(a,b){
                            var itema = a.split("^")[1];
                            var itemb = b.split("^")[1];
                            return itemb - itema;
                        });
                    });
                }                
            }
        });
        return refs;
}

function validate()
{
    var res = new Array();
    for (var i = 1; i < arguments.length; i++) 
    {
        if(!!arguments[i])
            continue;
        else
            res.push(arguments[0][i-1]);
    }
    return res;
}

function updateLogin()
{
    var _nombre = $("#nombre").val();
    var _apellido = $("#apellido").val();
    var _fechaNacimiento = '01/01/1901';
    var arr = { token:sessionStorage.getItem('token'),body:{email:sessionStorage.getItem('email'),nombre:_nombre,apellido:_apellido,fechaNacimiento:_fechaNacimiento}};       
    var rutaAplicativo = "https://auth.sinfo.co/auth/information";
    var result = false; 
    $.ajax(
        {
            url: rutaAplicativo,
            type: 'PUT',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);               
                if (datos=="Token invalido")
                {               
                    window.location = '../';
                }
                else
                {
                    result = mensaje['status'];      
                }                
            }
        });

    return result;
}

function updatePwd()
{
    var pwd = $("#pwd").val();
    var arr = { token:sessionStorage.getItem('token'),body:{email:"cp-" + sessionStorage.getItem('email').replace('cp-',''),password:pwd}};
    var result = false; 
    var rutaAplicativo = "https://auth.sinfo.co/auth/pwd";    
    $.ajax(
        {
            url: rutaAplicativo,
            type: 'PUT',
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: false,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                var msgDivididoDos = JSON.stringify(mensaje.message);
                var datos = JSON.parse(msgDivididoDos);               
                if (datos=="Token invalido")
                {
                    window.location = '../';
                }
                else
                {
                    result = mensaje['status']; 
                }                
            }
        });

    return result;
}

function traerDatosEmpresa()
{
    var url = "contabilidad/infoempresa/ver/";
    var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
    var datosempresa = envioFormularioMessageSync(url, arr, 'POST');//['message'][0];
    //console.warn(datosempresa);

    if(datosempresa['message'] != null || datosempresa['message'] != undefined)
    {
        var datos = datosempresa['message'][0];
        //console.warn(datos);
        $("#nit").val(datos['nit']);
        $("#nombre_empresa").val(datos['nombre_empresa']);
        $("#direccion").val(datos['direccion']);
        $("#ciudad").val(datos['ciudad']);
        $("#telefono").val(datos['telefono']);
        $("#sitio_web").val(datos['sitio_web']);
        $("#email").val(datos['email']);
        $("#regimen").val(datos['regimen']);
        $("#mongoid").val(datos["_id"]["$id"]);
        return true;
    }

    return false;
}