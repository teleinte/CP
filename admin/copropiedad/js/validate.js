
$(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#copropiedad_form").validate(
        {
            rules: {
                nombre: {required: true},
                direccion: {required: true},
                telefono: {required:true},
                nit: {required: true },
                email: {required: true, email: true},
                tipocopropiedad:{required: true, email: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la copropiedad.",
                direccion: "debe poner una direccion a la copropiedad.",
                telefono : "debe poner un telefono.",
                nit : "Debe seleccionar una fecha de recordatorio de la tarea.",
                email : "Debe compartir la tarea con alguien.",
                tipocopropiedad:"Debe seleccionar un tipo de copropiedad",
            },
            submitHandler: function(form){
                
                var ParamFecha=fecha();
                
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.html';
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
                        id_crm_persona: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,                        
                        nombre:$('#nombre').val(),
                        direccion:$('#direccion').val().replace(' ',''),
                        telefono:$('#telefono').val().replace(' ',''),
                        nit:$('#nit').val().replace(' ',''),
                        email:$('#email').val().replace(' ',''),
                        tipocopropiedad:$('#tipocopropiedad').val(),
                        tiene_acensor:$('#ascensor').prop('checked'),
                        tiene_porteria:$('#porteria').prop('checked'),
                        tiene_zona_bbq:$('#bbq').prop('checked'),
                        tiene_piscina:$('#piscina').prop('checked'),
                        tiene_gimnasio:$('#gimnasio').prop('checked'),
                        tiene_sauna:$('#sauna').prop('checked'),
                        tiene_turco:$('#turco').prop('checked'),
                        tiene_jardin:$('#jardin').prop('checked'),
                        estado:1,
                        modulos_activos:checked,
                        color:$('#colores').val()
                      }
                    }; 
                    var url = "copropiedad";
                    envioFormulario(arr,url,params,'POST',$('#direccion').val().replace(' ',''),$('#nombre').val().replace(' ',''))
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#copropiedad_form_editar").validate(
        {
            rules: {
                nombre: {required: true},
                direccion: {required: true},
                telefono: {required:true},
                nit: {required: true },
                email: {required: true, email: true},                
            },
            messages: {
                nombre: "Debe poner un nombre a la copropiedad.",
                direccion: "debe poner una direccion a la copropiedad.",
                telefono : "debe poner un telefono.",
                nit : "Debe seleccionar una fecha de recordatorio de la tarea.",
                email : "Debe compartir la tarea con alguien.",                
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.html';
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
                        id_crm_persona: $('#id_crm_persona').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        nombre:$('#nombre').val(),
                        direccion:$('#direccion').val(),
                        telefono:$('#telefono').val(),
                        nit:$('#nit').val().replace(' ',''),
                        email:$('#email').val().replace(' ',''),
                        tipocopropiedad:$('#tipocopropiedad').val(),
                        tiene_acensor:$('#ascensor').prop('checked'),
                        tiene_porteria:$('#porteria').prop('checked'),
                        tiene_zona_bbq:$('#bbq').prop('checked'),
                        tiene_piscina:$('#piscina').prop('checked'),
                        tiene_gimnasio:$('#gimnasio').prop('checked'),
                        tiene_sauna:$('#sauna').prop('checked'),
                        tiene_turco:$('#turco').prop('checked'),
                        tiene_jardin:$('#jardin').prop('checked'),
                        estado:1,
                        modulos_activos:checked,
                        color:$('#colores').val()
                      }
                    }; 
                    var url = "copropiedad";
                    envioFormularioDos(arr,url,'PUT')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#copropiedad_form_eliminar").validate(
        {
            rules: {
                nombre: {required: true},
                direccion: {required: true},
                telefono: {required:true},
                nit: {required: true },
                email: {required: true, email: true},                
            },
            messages: {
                nombre: "Debe poner un nombre a la copropiedad.",
                direccion: "debe poner una direccion a la copropiedad.",
                telefono : "debe poner un telefono.",
                nit : "Debe seleccionar una fecha de recordatorio de la tarea.",
                email : "Debe compartir la tarea con alguien.",                
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminado.</div>')                    
                    window.location = 'copropiedad.html'
                    return false
                }
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.html';
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
                        id_crm_persona: $('#id_crm_persona').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        nombre:$('#nombre').val(),
                        direccion:$('#direccion').val(),
                        telefono:$('#telefono').val(),
                        nit:$('#nit').val(),
                        email:$('#email').val(),
                        tipocopropiedad:$('#tipocopropiedad').val(),
                        tiene_acensor:$('#ascensor').val(),
                        tiene_porteria:$('#porteria').val(),
                        tiene_zona_bbq:$('#bbq').val(),
                        tiene_piscina:$('#piscina').val(),
                        tiene_gimnasio:$('#gimnasio').val(),
                        tiene_sauna:$('#sauna').val(),
                        tiene_turco:$('#turco').val(),
                        tiene_jardin:$('#jardin').val(),
                        estado:2,
                        modulos_activos:$('#modulos').val(),
                        color:$('#colores').val()
                      }
                    }; 
                    var url = "copropiedad";
                    envioFormularioDos(arr,url,'PUT')
                 }
            }
        }
        );
    });