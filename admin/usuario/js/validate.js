$(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#usuario_form").validate(
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
                        nombre:$('#nombre').val(),
                        telefono:$('#telefono').val().replace(' ',''),                        
                        email:$('#email').val().replace(' ',''),
                        unidad:$('#unidad').val(),
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
        $("#usuario_form_editar").validate(
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
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
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
                        email:$('#email').val().replace(' ',''),
                        unidad:$('#unidad').val(),
                        estado:$('#estado').val().toString(),
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
                    window.location = 'usuario.html'
                    return false
                }
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
                        id:params['idt'],
                        creado_por: $('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),                        
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombre').val(),
                        telefono:$('#telefono').val().replace(' ',''),                        
                        email:$('#email').val().replace(' ',''),
                        unidad:$('#unidad').val(),
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