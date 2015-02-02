$(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#usuario_form").validate(
        {
            rules: {
                nombre: {required: true},
                apellido: {required: true},
                telefono: {required:true},
                email: {required: true, email: true},
                empresa: {required: true},
                enombre: {required: true},
                etelefono: {required:true},
                ecorreo: {required: true, email: true},
            },
            messages: {
                nombre: "Debe poner un nombre de usuario.",
                apellido: "El apellido es un campo obligatorio",
                telefono : "Debe poner un telefono.",
                email : "Debe poner un mail Valido.",
                empresa: "Debe escribir el nombre de la empresa",
                enombre: "Debe poner un nombre para los casos de emergencia.",
                etelefono : "Debe poner un telefono para los casos de emergencia.",
                ecorreo : "Debe poner un correo para los casos de emergencia.",
            },
            submitHandler: function(form){
                
                var ParamFecha=fecha();
                
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {                   
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        creado_por: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha, 
                        id_copropiedad:sessionStorage.getItem('cp'),
                        id_crm_persona:"132131231",
                        nombre:$('#nombre').val()+" "+$('#apellido').val(),
                        telefono:$('#telefono').val().replace(' ',''),                        
                        email:$('#email').val().replace(' ',''),
                        empresa:$('#empresa').val(),
                        unidad:$('#unidad').val(),
                        tipo:$('#tipo').val(),
                        estado:1,
                        tiene_ninios:$('#tiene_ninios').prop('checked'),
                        tiene_empleada:$('#tiene_empleada').prop('checked'),
                        tiene_mascota:$('#tiene_mascota').prop('checked'),
                        tiene_bicicleta:$('#tiene_bicicleta').prop('checked'),
                        tiene_vehiculo:$('#tiene_vehiculo').prop('checked'),
                        descripcion:$('#descripcion').val(),
                        grupo:$('#grupo').val(),
                        contanco_emergencia:
                        {
                            enombre:$('#enombre').val(),
                            etelefono:$('#etelefono').val().replace(' ',''),                        
                            ecorreo:$('#ecorreo').val().replace(' ','')
                        }                        
                      }
                    }; 
                    var url = "usuario";
                    envioFormulario(arr,url,params,'POST')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#proveedor_form").validate(
        {
            rules: {
                nombreProveedor: {required: true},
                telefonoProveedor: {required:true},                
                
                emailProveedor: {required: true, email: true},
                nombre1: {required: true},
                telefono1: {required:true},
                mail1: {required: true, email: true}
            },
            messages: {
                nombreProveedor: "Debe poner un nombre de proveedor.",
                telefonoProveedor: "Debe poner un numero de telefono.",                
                emailProveedor: "Debe poner un correo electronico",
                nombre1: "Debe poner un nombre contacto",
                telefono1: "Debe poner un telefono de contacto",
                mail1: "Debe poner un correo de contacto"
            },
            submitHandler: function(form){                
                var ParamFecha=fecha();                
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.php';
                    return false
                 }
                 else
                 {                    
                    var ContactoUno={
                        nombre:$('#nombre1').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono1').val().replace(' ',''),
                        telefonoDos:$('#telefono21').val().replace(' ',''),
                        email:$('#mail1').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                    }
                    if($('#nombre2').val()!="")
                    {                        
                        var ContactoDos={
                        nombre:$('#nombre2').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono2').val().replace(' ',''),
                        telefonoDos:$('#telefono22').val().replace(' ',''),
                        email:$('#mail2').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }
                    if($('#nombre3').val()!="")
                    {                        
                        var ContactoTres={
                        nombre:$('#nombre3').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono3').val().replace(' ',''),
                        telefonoDos:$('#telefono23').val().replace(' ',''),
                        email:$('#mail3').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }                    
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        creado_por: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha, 
                        id_copropiedad:sessionStorage.getItem('cp'),
                        id_crm_persona:"132131231",
                        nombre:$('#nombreProveedor').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefonoProveedor').val().replace(' ',''),
                        telefonoDos:$('#telefonoDosProveedor').val().replace(' ',''),
                        email:$('#emailProveedor').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        estado:1,
                        contactos:{uno:ContactoUno,dos:ContactoDos,tres:ContactoTres}
                      }
                    }; 
                    var url = "usuario";
                    //alert(JSON.stringify(arr))
                    envioFormulario(arr,url,params,'POST')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#usuario_form_editar").validate(
        {
            rules: {
                nombre: {required: true},
                telefono: {required:true},
                email: {required: true, email: true},
                empresa: {required: true},
                enombre: {required: true},
                etelefono: {required:true},
                ecorreo: {required: true, email: true},
            },
            messages: {
                nombre: "Debe poner un nombre de usuario.",
                telefono : "Debe poner un telefono.",
                email : "Debe poner un mail Valido.",
                empresa: "Debe escribir el nombre de la empresa",
                enombre: "Debe poner un nombre para los casos de emergencia.",
                etelefono : "Debe poner un telefono para los casos de emergencia.",
                ecorreo : "Debe poner un correo para los casos de emergencia.",
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.php';
                    return false
                 }
                 else
                 {
                    var checked = []
                    $("input[name='namemodules[]']:checked").each(function ()
                    {
                        checked.push(parseInt($(this).val()));
                    });
                    //alert(checked); 
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        creado_por: $('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),                        
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombre').val(),
                        telefono:$('#telefono').val().replace(' ',''),
                        empresa:$('#empresa').val(),
                        email:$('#email').val().replace(' ',''),
                        unidad:$('#unidad').val(),
                        tipo:$('#tipo').val(),
                        estado:parseInt($('#estado').val()),
                        tiene_ninios:$('#tiene_ninios').prop('checked'),
                        tiene_empleada:$('#tiene_empleada').prop('checked'),
                        tiene_mascota:$('#tiene_mascota').prop('checked'),
                        tiene_bicicleta:$('#tiene_bicicleta').prop('checked'),
                        tiene_vehiculo:$('#tiene_vehiculo').prop('checked'),
                        grupo:$('#grupo').val(),
                        descripcion:$('#descripcion').val(),
                        contanco_emergencia:
                        {
                            enombre:$('#enombre').val(),
                            etelefono:$('#etelefono').val().replace(' ',''),                        
                            ecorreo:$('#ecorreo').val().replace(' ','')
                        } 
                      }
                    }; 
                    var url = "usuario";
                    editaFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });



$(document).ready(function() {        
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#proveedor_form_editar").validate(
        {
            rules: {
                nombreProveedor: {required: true},
                telefonoProveedor: {required:true},                
                
                emailProveedor: {required: true, email: true},
                nombre1: {required: true},
                telefono1: {required:true},
                mail1: {required: true, email: true}
            },
            messages: {
                nombreProveedor: "Debe poner un nombre de proveedor.",
                telefonoProveedor: "Debe poner un numero de telefono.",                
                emailProveedor: "Debe poner un correo electronico",
                nombre1: "Debe poner un nombre contacto",
                telefono1: "Debe poner un telefono de contacto",
                mail1: "Debe poner un correo de contacto"
            },
            submitHandler: function(form){                
                var ParamFecha=fecha();                
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.php';
                    return false
                 }
                 else
                 {                    
                    var ContactoUno={
                        nombre:$('#nombre1').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono1').val().replace(' ',''),
                        telefonoDos:$('#telefono21').val().replace(' ',''),
                        email:$('#mail1').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                    }
                    if($('#nombre2').val()!="")
                    {                        
                        var ContactoDos={
                        nombre:$('#nombre2').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono2').val().replace(' ',''),
                        telefonoDos:$('#telefono22').val().replace(' ',''),
                        email:$('#mail2').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }
                    if($('#nombre3').val()!="")
                    {                        
                        var ContactoTres={
                        nombre:$('#nombre3').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono3').val().replace(' ',''),
                        telefonoDos:$('#telefono23').val().replace(' ',''),
                        email:$('#mail3').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }                    
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        creado_por:$('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombreProveedor').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefonoProveedor').val().replace(' ',''),
                        telefonoDos:$('#telefonoDosProveedor').val().replace(' ',''),
                        email:$('#emailProveedor').val().replace(' ',''),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        estado:parseInt($('#estado').val()),
                        contactos:{uno:ContactoUno,dos:ContactoDos,tres:ContactoTres}
                      }
                    }; 
                    var url = "usuario";
                    //alert(JSON.stringify(arr))
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });


$(document).ready(function() {
        $("#usuario_form_eliminar").validate(
        {
            rules: {
                nombre: {required: true},
                telefono: {required:true},
                email: {required: true, email: true},                
                enombre: {required: true},
                etelefono: {required:true},
                ecorreo: {required: true, email: true},
            },
            messages: {
                nombre: "Debe poner un nombre de usuario.",
                telefono : "Debe poner un telefono.",
                email : "Debe poner un mail Valido.",                
                enombre: "Debe poner un nombre para los casos de emergencia.",
                etelefono : "Debe poner un telefono para los casos de emergencia.",
                ecorreo : "Debe poner un correo para los casos de emergencia.",
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminado.</div>')                    
                    window.location = 'usuario.php'
                    return false
                }
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.php';
                    return false
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        creado_por: $('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),                        
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombre').val(),
                        telefono:$('#telefono').val().replace(' ',''),                        
                        email:$('#email').val().replace(' ',''),
                        unidad:$('#unidad').val(),
                        tipo:$('#tipo').val(),
                        estado:2,
                        tiene_ninios:$('#tiene_ninios').prop('checked'),
                        tiene_empleada:$('#tiene_empleada').prop('checked'),
                        tiene_mascota:$('#tiene_mascota').prop('checked'),
                        tiene_bicicleta:$('#tiene_bicicleta').prop('checked'),
                        tiene_vehiculo:$('#tiene_vehiculo').prop('checked'),
                        grupo:$('#grupo').val(),
                        descripcion:$('#descripcion').val(),
                        contanco_emergencia:
                        {
                            enombre:$('#enombre').val(),
                            etelefono:$('#etelefono').val().replace(' ',''),                        
                            ecorreo:$('#ecorreo').val().replace(' ','')
                        } 
                      }
                    }; 
                    var url = "usuario";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });

$(document).ready(function() {
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})    
    $("#proveedor_form_eliminar").validate(
    {
        rules: {
                opcion: {required: true}                
            },
            messages: {
                opcion: "Debe seleccionar una opcion.",                                
            },
            submitHandler: function(form){                
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminados.</div>')                    
                    window.location = 'usuario.php'
                    return false
                }
                var ParamFecha=fecha();
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.php';
                    return false
                 }
                 else
                 {                    
                    var ContactoUno={
                        nombre:$('#nombre1').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono1').val(),
                        telefonoDos:$('#telefono21').val(),
                        email:$('#mail1').val(),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                    }
                    if($('#nombre2').val()!="")
                    {                        
                        var ContactoDos={
                        nombre:$('#nombre2').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono2').val(),
                        telefonoDos:$('#telefono22').val(),
                        email:$('#mail2').val(),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }
                    if($('#nombre3').val()!="")
                    {                        
                        var ContactoTres={
                        nombre:$('#nombre3').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefono3').val(),
                        telefonoDos:$('#telefono23').val(),
                        email:$('#mail3').val(),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        }
                    }                    
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        creado_por:$('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombreProveedor').val(),
                        empresa:$('#nombreProveedor').val(),
                        telefono:$('#telefonoProveedor').val(),
                        telefonoDos:$('#telefonoDosProveedor').val(),
                        email:$('#emailProveedor').val(),
                        descripcion:$('#descripcionProveedor').val(),
                        tipo:$('#tipoProveedor').val(),
                        estado:2,
                        contactos:{uno:ContactoUno,dos:ContactoDos,tres:ContactoTres}
                      }
                    }; 
                    var url = "usuario";
                    //alert(JSON.stringify(arr))
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });