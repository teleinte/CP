$(document).ready(function() {
        $("#tarea_form").validate(
        {
            rules: {
                nombre: {required: true},
                responsable: {required: true},
                deadline: {required:true},
                frecordatorio: {required: true },
                compartir_mail: { required: true},
                estado: { required: true},
                prioridad: { required: true},
                notas: { required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la tarea.",
                responsable: "Debe seleccionar un responsable.",
                deadline : "Debe seleccionar una fecha de terminación de la tarea.",
                frecordatorio : "Debe seleccionar una fecha de recordatorio de la tarea.",
                compartir_mail : "Debe compartir la tarea con alguien.",
                estado : "Debe seleccionar un estado.",
                prioridad : "Debe darle una prioridad a la tarea.",
                notas : "debe poner una nota a la tarea.",                
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();
                if ($('#estado').val()=="Cerrada"){var fechaFinal=ParamFecha;}
                else {var fechaFinal='';}

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
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:$('#estado').val(),
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:"",
                        frecordatorio:$('#datepicker').val(),
                        recordatorio_mail:$('#recordatorio_mail').val(),
                        recordatorio_cp:$('#recordatorio_cp').val(),
                        compartir_mail:$('#compartir_mail').val()                        
                      }
                    }; 
                    var url = "tareas/list";
                    envioFormulario(arr,url,params,'POST')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#tarea_form_editar").validate(
        {
            rules: {
                nombre: {required: true},
                responsable: {required: true},
                deadline: {required:true},
                frecordatorio: {required: true },
                compartir_mail: { required: true},
                estado: { required: true},
                prioridad: { required: true},
                notas: { required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la tarea.",
                responsable: "Debe seleccionar un responsable.",
                deadline : "Debe seleccionar una fecha de terminación de la tarea.",
                frecordatorio : "Debe seleccionar una fecha de recordatorio de la tarea.",
                compartir_mail : "Debe compartir la tarea con alguien.",
                estado : "Debe seleccionar un estado.",
                prioridad : "Debe darle una prioridad a la tarea.",
                notas : "debe poner una nota a la tarea.",                
            },

            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();
                if ($('#estado').val()=="Cerrada"){var fechaFinal=ParamFecha;}
                else {var fechaFinal='';}

                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {                                        
                    window.location = '../index.html';                    
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:$('#estado').val(),
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:"",
                        frecordatorio:$('#datepicker').val(),
                        recordatorio_mail:$('#recordatorio_mail').val(),
                        recordatorio_cp:$('#recordatorio_cp').val(),
                        compartir_mail:$('#compartir_mail').val()                        
                      }
                    }; 
                    var url = "tareas/list";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#tarea_form_eliminar").validate(
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
                    window.location = 'index.php'
                    return false
                }
                var ParamFecha=fecha();
                var fechaFinal=ParamFecha;
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
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:"Completada",
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:"",
                        frecordatorio:$('#datepicker').val(),
                        recordatorio_mail:$('#recordatorio_mail').val(),
                        recordatorio_cp:$('#recordatorio_cp').val(),
                        compartir_mail:$('#compartir_mail').val()
                      }
                    }; 
                    var url = "tareas/list";
                    envioFormulario(arr,url,params,'PUT')

                 }
            }
        }
        );
    });