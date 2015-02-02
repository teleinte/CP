$(document).ready(function() {
    $("#reserva_form").validate({
        rules: {
            crea_id_copropiedad: {required: true},
            crea_id_inmueble: {required: true},
            crea_grupo: {required:true},
            crea_fecha_inicio: {required: true },
            crea_fecha_fin: { required: true},
            crea_usuario: { required: true},
            crea_estado: { required: true}
        },
        messages: {
            crea_id_copropiedad: "No hay id_copropiedad",
            crea_id_inmueble: "No hay id_inmueble",
            crea_grupo : "No hay grupo",
            crea_fecha_inicio : "No hay fecha inicio",
            crea_fecha_fin : "No hay fecha fin",
            crea_usuario : "No hay usuario",
            crea_estado : "No hay estado"        
        },
        submitHandler: function(form){
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
                    fecha_creacion:fecha(),
                    id_copropiedad : $("#crea_id_copropiedad").val(),
                    id_inmueble: $("#crea_id_inmueble").val(),
                    grupo:$("#crea_grupo").val(),
                    fecha_inicio:$("#crea_fecha_inicio").val(),
                    fecha_fin:$("#crea_fecha_fin").val(),
                    usuario:$("#crea_usuario").val(),
                    estado:$("#crea_estado").val(),
                    comentario:$('#crea_comentario').val()                      
                  }
                }; 
                var url = "reservas/reserva/";
                envioFormulario(arr,url,'POST')
             }
        }
    });
    $("#reservaEditar").validate({
        rules: {
            mongoid: {required: true},
            creacion: {required: true},
            user: {required: true},
            comentario: {required: true},
            idcopropiedad: {required: true},
            idinmueble: {required: true},
            grupo: {required: true},
            estado: {required: true},
            startfecha: {required: true},
            starthora: {required: true},
            endfecha: {required: true},
            endhora: {required: true}
        },
        messages: {
            mongoid: "No hay mongoid",
            creacion: "No hay creacion",
            user: "No hay user",
            comentario: "No hay comentario",
            idcopropiedad: "No hay idcopropiedad",
            idinmueble: "No hay idinmueble",
            grupo: "No hay grupo",
            estado: "No hay estado",
            startfecha: "No hay startfecha",
            starthora: "No hay starthora",
            endfecha: "No hay endfecha",
            endhora: "No hay endhora"
        },
        submitHandler: function(form){
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
                    id:$("#mongoid").val(),
                    fecha_creacion:$("#creacion").val(),
                    usuario:$("#user").val(),
                    comentario:$("#comentario").val(),
                    id_copropiedad:$("#idcopropiedad").val(),
                    id_inmueble:$("#idinmueble").val(),
                    grupo:$("#grupo").val(),
                    estado:$("#estado").val(),
                    fecha_inicio:$("#startfecha").val() + "COT" + $("#starthora").val() + ":00+00:00",
                    fecha_fin:$("#endfecha").val()  + "COT" + $("#endhora").val() + ":00+00:00"
                  }
                }; 
                var url = "reservas/reserva/";
                envioFormulario(arr,url,'PUT')
             }
        }
    });
    $("#reservaBorrar").validate({
        rules: {
            mongoid: {required: true}
        },
        messages: {
            mongoid: "No hay mongoid"
        },
        submitHandler: function(form){
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
                    id:$("#mongoid").val()
                  }
                }; 
                var url = "reservas/reserva/";
                envioFormulario(arr,url,'DELETE')
             }
        }
    });
    $("#crearInmuebleForm").validate({
        rules: {
            inmueble: {required: true},
            nombre_despliegue: {required: true},
            treintas: {required: true},
            tiempo_reserva: {required: true},
            hora_inicio_reserva: {required: true},
            hora_fin_reserva: {required: true},
            hora_inicio_restriccion: {required: true},
            hora_fin_restriccion: {required: true},
            grupo: {required: true},
            costo: {required: true},
            dias_reserva: {required: true}
        },
        messages: {
            inmueble: "Llena este campo por favor",
            nombre_despliegue: "Llena este campo por favor",
            treintas: "Llena este campo por favor",
            tiempo_reserva: "Llena este campo por favor",
            hora_inicio_reserva: "Llena este campo por favor",
            hora_fin_reserva: "Llena este campo por favor",
            hora_inicio_restriccion: "Llena este campo por favor",
            hora_fin_restriccion: "Llena este campo por favor",
            grupo: "Llena este campo por favor",
            costo: "Llena este campo por favor",
            dias_reserva: "Llena este campo por favor",
        },
        submitHandler: function(form){
            if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
             {  
                window.location = '../index.html';
                return false
             }
             else
             {
                var dias = new Array();
                if($("#lunes").is(":checked"))
                    dias.push(parseInt($("#lunes").val()));
                if($("#martes").is(":checked"))
                    dias.push(parseInt($("#martes").val()));
                if($("#miercoles").is(":checked"))
                    dias.push(parseInt($("#miercoles").val()));
                if($("#jueves").is(":checked"))
                    dias.push(parseInt($("#jueves").val()));
                if($("#viernes").is(":checked"))
                    dias.push(parseInt($("#viernes").val()));
                if($("#sabado").is(":checked"))
                    dias.push(parseInt($("#sabado").val()));
                if($("#domingo").is(":checked"))
                    dias.push(parseInt($("#domingo").val()));

                var offset = ":(";
                if($("#treintas3").is(":checked"))
                    offset = "30";
                if($("#treintas0").is(":checked"))
                    offset = "00";

                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id_copropiedad: sessionStorage.getItem("cp"),
                    id_inmueble: $("#inmueble").val(),
                    nombre_despliegue: $("#nombre_despliegue").val(),
                    tiempo_reserva: $("#tiempo_reserva").val(),
                    hora_inicio_reserva: $("#hora_inicio_reserva").val(),
                    hora_fin_reserva: $("#hora_fin_reserva").val(),
                    hora_inicio_restriccion: $("#hora_inicio_restriccion").val(),
                    hora_fin_restriccion: $("#hora_fin_restriccion").val(),
                    grupo: $("#grupo").val(),
                    offset_inicio: offset,
                    valor_reserva:$("#costo").val(),
                    dias_reserva: dias.toString()
                 }
                }
                var url = "reservas/reserva/inmueble/";
                envioFormularioInmueble(arr,url,'POST');
                //console.log(arr);
                }
        }
    });
    $("#editarInmuebleForm").validate({
        rules: {
            edit_inmueble: {required: true},
            edit_mongoid: {required: true},
            edit_nombre_despliegue: {required: true},
            edit_treintas: {required: true},
            edit_tiempo_reserva: {required: true},
            edit_hora_inicio_reserva: {required: true},
            edit_hora_fin_reserva: {required: true},
            edit_hora_inicio_restriccion: {required: true},
            edit_hora_fin_restriccion: {required: true},
            edit_grupo: {required: true},
            edit_costo: {required: true},
            edit_dias_reserva: {required: true}
        },
        messages: {
            edit_inmueble: "Llena este campo por favor",
            edit_mongoid: "Llena este campo por favor",
            edit_nombre_despliegue: "Llena este campo por favor",
            edit_treintas: "Llena este campo por favor",
            edit_tiempo_reserva: "Llena este campo por favor",
            edit_hora_inicio_reserva: "Llena este campo por favor",
            edit_hora_fin_reserva: "Llena este campo por favor",
            edit_hora_inicio_restriccion: "Llena este campo por favor",
            edit_hora_fin_restriccion: "Llena este campo por favor",
            edit_grupo: "Llena este campo por favor",
            edit_costo: "Llena este campo por favor",
            edit_dias_reserva: "Llena este campo por favor"
        },
        submitHandler: function(form){
            if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
             {  
                window.location = '../index.html';
                return false
             }
             else
             {
                var dias = new Array();
                if($("#edit_lunes").is(":checked"))
                    dias.push(parseInt($("#edit_lunes").val()));
                if($("#edit_martes").is(":checked"))
                    dias.push(parseInt($("#edit_martes").val()));
                if($("#edit_miercoles").is(":checked"))
                    dias.push(parseInt($("#edit_miercoles").val()));
                if($("#edit_jueves").is(":checked"))
                    dias.push(parseInt($("#edit_jueves").val()));
                if($("#edit_viernes").is(":checked"))
                    dias.push(parseInt($("#edit_viernes").val()));
                if($("#edit_sabado").is(":checked"))
                    dias.push(parseInt($("#edit_sabado").val()));
                if($("#edit_domingo").is(":checked"))
                    dias.push(parseInt($("#edit_domingo").val()));

                console.log(dias);

                var offset = ":(";
                if($("#edit_treintas3").is(":checked"))
                    offset = "30";
                if($("#edit_treintas0").is(":checked"))
                    offset = "00";

                var arr = 
                {
                  token:sessionStorage.getItem('token'),
                  body:
                  {
                    id:$("#edit_mongoid").val(),
                    id_copropiedad: sessionStorage.getItem("cp"),
                    id_inmueble: $("#edit_inmueble").val(),
                    nombre_despliegue: $("#edit_nombre_despliegue").val(),
                    tiempo_reserva: $("#edit_tiempo_reserva").val(),
                    hora_inicio_reserva: $("#edit_hora_inicio_reserva").val(),
                    hora_fin_reserva: $("#edit_hora_fin_reserva").val(),
                    hora_inicio_restriccion: $("#edit_hora_inicio_restriccion").val(),
                    hora_fin_restriccion: $("#edit_hora_fin_restriccion").val(),
                    grupo: $("#edit_grupo").val(),
                    valor_reserva: $("#edit_costo").val(),
                    offset_inicio: offset,
                    dias_reserva: dias.toString()
                 }
                }
                var url = "reservas/reserva/inmueble/";
                envioFormularioInmueble(arr,url,'PUT');
                //console.log(arr);
                }
        }
    });
    $("#borrarInmuebleForm").validate({
        rules: {
            del_mongoid: {required: true}
        },
        messages: {
            del_mongoid: "Llena este campo por favor"
        },
        submitHandler: function(form){
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
                        id: $("#del_mongoid").val()
                    }
                }
                var url = "reservas/reserva/inmueble/";
                console.log(arr);
                envioFormularioInmueble(arr,url,'DELETE');
             }
        }
    });
});