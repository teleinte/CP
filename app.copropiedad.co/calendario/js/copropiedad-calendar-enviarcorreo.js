function enviocorreo(){		
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/tareas/compartir/";
        var metodo = "POST";
        var mail_arr = $('#compartir_mail').val().split(",");
        //console.log(mail_arr);
        for (key in mail_arr) {
        var arr = {
                      token:sessionStorage.getItem('token'),
                      body:
                      {  
                            id_crm_persona:sessionStorage.getItem('id_crm'),
                            fecha_solicitud:fecha(),
                            nombre_remitente:sessionStorage.getItem('nombre'),
                            nombre_tarea:$('#nombre').val(),
                            destinatarios:[  
                               {  
                                  nombre:"usuario",
                                  email:mail_arr[key]
                               }
                            ],
                      }
                    }; 
                    //console.log(arr);
        $.ajax(
        {
            url: rutaAplicativo,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                //console.log(msg);
            }
        });
    }       
}

function enviocorreoEvento(eventin){
        var rutaAplicativo = "https://app.copropiedad.co/api/mailer/mail/eventos/compartir/";
        var metodo = "POST";        
        var arr = 
        {
            token:sessionStorage.getItem('token'),
            body:
            {
                id_copropiedad : sessionStorage.getItem('cp'),
                id_evento:eventin,
                id_crm_persona:sessionStorage.getItem('id_crm'),
                fecha_solicitud:fecha(),
                nombre_remitente:sessionStorage.getItem('nombre'),                        
            }
        };
        //alert(JSON.stringify(arr));
        $.ajax(
        {
            url: rutaAplicativo,
            type: metodo,
            data: JSON.stringify(arr),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            async: true,
            success: function(msg) 
            {
                var msgDividido = JSON.stringify(msg);
                var mensaje =  JSON.parse(msgDividido);
                //console.log(msg);
            }
        });      
}