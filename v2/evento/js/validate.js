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
                    window.location = '../index.php';
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
                        frecuencia:$('#frecuencia').val(),
                        frecordatorio:$('#datepicker').val(),
                        recordatorio_mail:$('#recordatorio_mail').is(':checked'),
                        recordatorio_cp:$('#recordatorio_cp').is(':checked'),
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
                    window.location = '../index.php';                    
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
                        fecha_creacion:$('#fecha_creacion').val(),
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:$('#estado').val(),
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:$('#frecuencia').val(),
                        frecordatorio:$('#datepicker').val(),
                        recordatorio_mail:$('#recordatorio_mail').is(':checked'),
                        recordatorio_cp:$('#recordatorio_cp').is(':checked'),
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
                    window.location = '../index.php';
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
                        fecha_creacion:$('#fecha_creacion').val(),
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:"Cerrada",
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:$('#frecuencia').val(),
                        frecordatorio:$('#frecordatorio').val(),
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
        $("#tarea_form_completar").validate(
        {
            rules: {
                com_opcion: {required: true}                
            },
            messages: {
                com_opcion: "Debe seleccionar una opcion.",                                
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
                        fecha_creacion:$('#fecha_creacion').val(),
                        tipo:"tarea",
                        nombre:$('#nombre').val(),
                        estado:"Completada",
                        responsable:$('#responsable').val(),
                        fecha_fin:fechaFinal,
                        prioridad:$('#prioridad').val(),
                        deadline:$('#datepicker2').val(),
                        notas:$('#notas').val(),
                        frecuencia:$('#frecuencia').val(),
                        frecordatorio:$('#frecordatorio').val(),
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
        $("#evento_form").validate(
        {
            rules: {
                nombree: {required: true},
                frecordatorioe: {required: true }
            },
            messages: {
                nombree: "Debe asignar un nombre al evento.",
                frecordatorioe : "Debe seleccionar una fecha de recordatorio del evento."
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();
                var starttime_final = $('#datepicker3').val() + "T" + $('#starttimee').val() + ":00+00:00";
                var endtime_final = $('#datepicker4').val() + "T" + $('#endtimee').val() + ":00+00:00";

                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                    var cal_copr = "NO";
                    if($('#ver_copropiedade').val()){cal_copr = "SI"}

                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        tipo:"evento",
                        nombre:$('#nombree').val(),
                        estado:"Por Iniciar",
                        fecha_inicio:starttime_final,
                        fecha_fin:endtime_final,
                        compartir_mail:$('#compartir_maile').val(),                    
                        frecuencia:"",
                        cal_copropiedad:cal_copr,
                        frecordatorio:$('#datepicker5').val(),
                        recordatorio_mail:$('#recordatorio_maile').val(),
                        recordatorio_cp:$('#recordatorio_cpe').val(),
                        notas:$('#notase').val()
                      }
                    }; 
                    var url = "eventos/evento/";
                    envioFormulario(arr,url,params,'POST')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#evento_form_eliminar").validate(
        {
            rules: {
                eev_nombre: {required: true},
                eev_frecordatorio: {required: true }
            },
            messages: {
                eev_nombre: "Debe asignar un nombre al evento.",
                eev_frecordatorio : "Debe seleccionar una fecha de recordatorio del evento."
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();
                var starttime_final = $('#datepicker3').val() + "T" + $('#starttimee').val() + ":00+00:00";
                var endtime_final = $('#datepicker4').val() + "T" + $('#endtimee').val() + ":00+00:00";

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
                        fecha_creacion:$('#fecha_creacion').val(),
                        tipo:"evento",
                        nombre:$('#nombre').val(),
                        estado:"Cancelado",
                        fecha_inicio:$('#finicio').val(),
                        fecha_fin:$('#ffin').val(),
                        compartir_mail:$('#compartir_mail').val(),                    
                        frecuencia:$('#frecuencia').val(),
                        cal_copropiedad:"NO",
                        frecordatorio:$('#frecordatorio').val(),
                        recordatorio_mail:$('#recordatorio_mail').val(),
                        recordatorio_cp:$('#recordatorio_cp').val(),
                        notas:$('#notas').val()               
                      }
                    }; 
                    var url = "eventos/evento/";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#evento_form_editar").validate(
        {
            rules: {
                nombree: {required: true},
                frecordatorio: {required: true }
            },
            messages: {
                nombree: "Debe asignar un nombre al evento.",
                frecordatorio : "Debe seleccionar una fecha de recordatorio del evento."
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();
                var starttime_final = $('#datepicker3').val() + "T" + $('#starttimee').val() + ":00+00:00";
                var endtime_final = $('#datepicker4').val() + "T" + $('#endtimee').val() + ":00+00:00";

                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                    var ver_cp_chk = false;
                    if($('#ver_copropiedade').is(":checked")){ver_cp_chk=true;}else{ver_cp_chk=false;}
                    var rec_cp_chk = false;
                    if($('#recordatorio_cpe').is(":checked")){rec_cp_chk=true;}else{rec_cp_chk=false;}
                    var rec_mail_chk = false;
                    if($('#recordatorio_maile').is(":checked")){rec_mail_chk=true;}else{rec_mail_chk=false;}
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:$('#fecha_creacione').val(),
                        tipo:"evento",
                        nombre:$('#nombree').val(),
                        estado:"Por Iniciar",
                        fecha_inicio:starttime_final,
                        fecha_fin:endtime_final,
                        compartir_mail:$('#compartir_maile').val(),                    
                        frecuencia:$('#frecuenciae').val(),
                        cal_copropiedad:ver_cp_chk,
                        frecordatorio:$('#datepicker5').val(),
                        recordatorio_mail:rec_mail_chk,
                        recordatorio_cp:rec_cp_chk,
                        notas:$('#notase').val()                       
                      }
                    }; 
                    var url = "eventos/evento/";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });