$(document).ready(function() {
    $("#form-envio-encuesta").validate(
        {
            rules: {
                asunto: {required: true},
                mensaje: {required: true},                
            },
            messages: {
                asunto: "Debe colocar un asunto, con el que se enviara el correo electronico",
                mensaje: "Debe colocar un mensaje para el correo que sera enviado con la encuesta",                
            },
            submitHandler: function(form){
            var arr = 
            {
                body:
                {
                    id_encuesta:$('#id_encuesta').val(),
                    fechaFin:$('#fechaFin').val()
                }
            };            
            var url = "encuestas/tokenEncuesta";
            SolicitoToken(arr,url,'POST');
            var retornado;
            retornado=sessionStorage.getItem("nuevoToken");
            localStorage.removeItem('nuevoToken');            
            var arr = 
            {
                token:sessionStorage.getItem('token'),
                body:
                {
                    id_copropiedad:sessionStorage.getItem('cp'),
                    id_encuesta:$('#id_encuesta').val(),
                    invitados:$('#invitados').val(),
                    invitados_externos:$('#odestinatario').val(),
                    tokenencuesta:retornado,
                    asunto:$('#asunto').val(),
                    mensaje:$('#mensaje').val(),                            
                    urlencuesta:"http://aws02.sinfo.co/v2/render-encuesta/"
                }
            };
            //alert(JSON.stringify(arr));
            var retornado;
            if($('#metodo').val()==="PUT")
            {
                var url = "encuestas/encuesta/borrarEnvio";                
                borraEnvio(arr,url,"DELETE");
            }
            
                var url = "encuestas/encuestaEnvio";
                GrabaParaEnvio(arr,url,"POST");
                var url = "mailer/mail/encuestas/enviar";
                var arr = 
                {
                    token:sessionStorage.getItem('token'),
                    body:
                    {
                        id_encuesta:$('#id_encuesta').val()                        
                    }
                };
                //alert(JSON.stringify(arr));
                enviarCorreoEncuesta(arr,url,"POST");
            
            }
        }
        );   
    
        $("#form-encuesta").validate(
        {
            rules: {
                nombre: {required: true},
                datepicker: {required: true},                
                descripcion: {required: true},
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la Encuesta.",
                datepicker: "Debe seleccionar una fecha de terminación de la encuesta.",                
                descripcion: "Debe poner una descipción para la en cuesta.",
                enunciado_pregunta0: "La pregunta debe tener un enunciado.",
                tipo_pregunta0: "debe seleccionar un tipo de pregunta",
            },
            submitHandler: function(form){
                var ParamFecha=fecha();                
                var arr = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id_copropiedad:sessionStorage.getItem('cp'),
                            id_crm_persona:sessionStorage.getItem('id_crm'),
                            fecha_creacion:ParamFecha,
                            tipo:"encuesta",
                            fecha_fin:$('#datepicker').val(),
                            nombre:$('#nombre').val(),
                            descripcion:$('#descripcion').val(),
                            estado:"1",
                            invitados:"",
                            invitados_externos:""
                        }
                    };
                var url = "encuestas/encuesta";
                envioFormulario(arr,url,'POST');
                var retornado;
                retornado=sessionStorage.getItem("insertado")
                var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];                
                for (j=0;j<20;j++)
                {                    
                    if (!$('#enunciado-pregunta'+j).val())
                    {
                        //alert("No hay nada mijo");
                        break;
                    }
                    var partido = [];
                    var arrPregunta={};
                    partido = $('#opciones-pregunta'+j).val().split("\n");
                    var resultado = "";
                    if($('#tipo-pregunta'+j).val()!="Abierta")
                    {
                        for (i in partido) 
                        {
                            resultado+=letras[i]+"|"+partido[i]+","                    
                        } 
                    }
                    var obligatorio;
                    if($('#obligatoria'+j).is(':checked')){
                        obligatorio="SI";
                    } else {                        
                        obligatorio="NO";
                    }
                    arrPregunta = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id_encuesta:retornado,
                            pregunta:$('#enunciado-pregunta'+j).val(),
                            tipo:$('#tipo-pregunta'+j).val(),
                            opciones:resultado,
                            obligatorio:obligatorio
                            //opciones:[{"A":"si"},{"B":"no"}]
                        }
                    }
                    var url = "encuestas/encuesta/pregunta";
                    //alert(JSON.stringify(arrPregunta))
                    envioPregunta(arrPregunta,url,'POST');
                }
                notificador();
            }
        }
        );
    });

$(document).ready(function() {
        $("#form-encuesta-editar").validate(
        {
            rules: {
                nombre: {required: true},
                datepicker: {required: true},                
                descripcion: {required: true},
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la Encuesta.",
                datepicker: "Debe seleccionar una fecha de terminación de la encuesta.",                
                descripcion: "Debe poner una descipción para la en cuesta.",
                enunciado_pregunta0: "La pregunta debe tener un enunciado.",
                tipo_pregunta0: "debe seleccionar un tipo de pregunta",
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                var ParamFecha=fecha();                
                var arr = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id:params['idt'],
                            id_copropiedad:$('#id_copropiedad').val(),
                            id_crm_persona:$('#id_crm_persona').val(),
                            fecha_creacion:$('#fecha_creacion').val(),
                            tipo:"encuesta",
                            fecha_fin:$('#datepicker').val(),
                            nombre:$('#nombre').val(),
                            descripcion:$('#descripcion').val(),
                            estado:$('#estado').val(),
                            invitados:$('#invitados').val(),
                            invitados_externos:$('#odestinatario').val()
                        }
                    }
                //alert(JSON.stringify(arr));
                var url = "encuestas/encuesta";
                envioFormulario(arr,url,'PUT',params)
            }
        }
        );
    });



$(document).ready(function() {
        $("#form-edita-pregunta").validate(
        {
            rules: {
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true},                
            },
            messages: {
                enunciado_pregunta0: "Debe tener un enunciado de la pregunta.",
                tipo_pregunta0: "Debe seleccionar un tipo de pregunta.",
            },

            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {                                        
                    window.location = '../index.php';                    
                 }
                 else
                 {
                    var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
                    var resultado = "";
                    var partido = [];
                    var arrPregunta={};
                    partido = $('#opciones_pregunta0').val().split("\n");
                    if($('#tipo_pregunta0').val()!="Abierta")
                    {
                        for (i in partido) 
                        {
                            resultado+=letras[i]+"|"+partido[i]+","                    
                        } 
                    } 
                    
                    var obligatorio;
                    if($('#obligatoria0').is(':checked')){
                        obligatorio="SI";
                    } else {                        
                        obligatorio="NO";
                    }
                    
                    var arrPregunta = 
                    {                        
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id:params['idt'],
                            id_encuesta:$('#id_encuesta').val(),
                            pregunta:$('#enunciado_pregunta0').val(),
                            tipo:$('#tipo_pregunta0').val(),
                            opciones:resultado,
                            obligatorio:obligatorio
                        }
                    };
                    var url = "encuestas/encuesta/pregunta";
                    //alert(JSON.stringify(arrPregunta))
                    envioPreguntaModificada(arrPregunta,url,'PUT',$('#id_encuesta').val())
                 }
            }
        }
        );
    });
    

$(document).ready(function() {
        $("#form-elmina-pregunta").validate(
        {
            rules: {
                nombre: {required: true},
                datepicker: {required: true},
                invitados: {required: true},
                descripcion: {required: true},
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la Encuesta.",
                datepicker: "Debe seleccionar una fecha de terminación de la encuesta.",
                invitados: "Debe seleccionar un grupo de invitados.",
                descripcion: "Debe poner una descipción para la en cuesta.",
                enunciado_pregunta0: "La pregunta debe tener un enunciado.",
                tipo_pregunta0: "debe seleccionar un tipo de pregunta",
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminados.</div>')                    ;
                    window.location = 'encuesta-editar.php?idt='+$('#id_encuesta').val();
                    return false;
                }
                var arr = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id_pregunta:params['idt']                            
                        }
                    };
                alert(JSON.stringify(arr));
                var url = "encuestas/encuesta/pregunta";
                envioPreguntaEliminar(arr,url,'DELETE',$('#id_encuesta').val());
            }
        }
        );
    });
    
    


$(document).ready(function() {
        $("#form-pregunta-nueva").validate(
        {
            rules: {
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true},                
            },
            messages: {
                enunciado_pregunta0: "Debe tener un enunciado de la pregunta.",
                tipo_pregunta0: "Debe seleccionar un tipo de pregunta.",
            },

            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {                                        
                    window.location = '../index.php';                    
                 }
                 else
                 {
                    var letras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
                    var resultado = "";
                    var partido = [];
                    var arrPregunta={};
                    partido = $('#opciones_pregunta0').val().split("\n");
                    if($('#tipo_pregunta0').val()!="Abierta")
                    {
                        for (i in partido) 
                        {
                            resultado+=letras[i]+"|"+partido[i]+","                    
                        } 
                    } 
                    if($('#obligatoria0').is(':checked')){
                        obligatorio="SI";
                    } else {                        
                        obligatorio="NO";
                    }
                    var arrPregunta = 
                    {                        
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            //id:params['idt'],
                            id_encuesta:$('#id_encuesta').val(),
                            pregunta:$('#enunciado_pregunta0').val(),
                            tipo:$('#tipo_pregunta0').val(),
                            opciones:resultado,
                            obligatorio:obligatorio
                        }
                    }
                    var url = "encuestas/encuesta/pregunta";
                    //alert(JSON.stringify(arrPregunta))
                    envioPreguntaModificada(arrPregunta,url,'POST',$('#id_encuesta').val());
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#encuesta_form_eliminar").validate(
        {
            rules: {
                nombre: {required: true},
                datepicker: {required: true},
                invitados: {required: true},
                descripcion: {required: true},
                enunciado_pregunta0: {required: true},
                tipo_pregunta0: {required: true}
            },
            messages: {
                nombre: "Debe poner un nombre a la Encuesta.",
                datepicker: "Debe seleccionar una fecha de terminación de la encuesta.",
                invitados: "Debe seleccionar un grupo de invitados.",
                descripcion: "Debe poner una descipción para la en cuesta.",
                enunciado_pregunta0: "La pregunta debe tener un enunciado.",
                tipo_pregunta0: "debe seleccionar un tipo de pregunta",
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminados.</div>')                    ;
                    window.location = 'index.php';
                    return false;
                }
                var arr = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id:params['idt'],
                            id_copropiedad:$('#id_copropiedad').val(),
                            id_crm_persona:$('#id_crm_persona').val(),
                            fecha_creacion:$('#fecha_creacion').val(),
                            tipo:"encuesta",
                            fecha_fin:$('#datepicker').val(),
                            nombre:$('#nombre').val(),
                            descripcion:$('#descripcion').val(),
                            estado:(2).toString(),
                            invitados:$('#invitados').val(),
                            invitados_externos:$('#odestinatario').val()
                        }
                    };
                alert(JSON.stringify(arr));
                var url = "encuestas/encuesta";
                envioFormularioEliminar(arr,url,'PUT',params);
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
                console.log(starttime_final);
                console.log(endtime_final);

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
                console.log(starttime_final);
                console.log(endtime_final);

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
                        id:$('#eev_id').val(),
                        id_copropiedad : sessionStorage.getItem('cp'),
                        creador: sessionStorage.getItem('id_crm'),
                        fecha_creacion:$('#eev_fecha_creacion').val(),
                        tipo:"evento",
                        nombre:$('#eev_nombre').val(),
                        estado:"Cancelado",
                        fecha_inicio:$('#eev_fecha_inicio').val(),
                        fecha_fin:$('#eev_fecha_fin').val(),
                        compartir_mail:$('#eev_compartir_mail').val(),                    
                        frecuencia:$('#eev_frecuencia').val(),
                        cal_copropiedad:$('#eev_cal_copropiedad').val(),
                        frecordatorio:$('#eev_frecordatorio').val(),
                        recordatorio_mail:$('#eev_recordatorio_mail').val(),
                        recordatorio_cp:$('#eev_recordatorio_cp').val(),
                        notas:$('#eev_notas').val()                       
                      }
                    }; 
                    var url = "eventos/evento/";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });