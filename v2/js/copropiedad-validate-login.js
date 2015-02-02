$(document).ready(function() {
        $("#index_form").validate(
        {
            rules: {
                usr: {required: true, email: true},
                pas: {required: true},                
            },
            messages: {
                usr: "El campo usuario es obligatorio y debe ser un correo valido.",
                pas: "El campo contraseña es obligatorio.",
            },

            submitHandler: function(form){                          
                var arr = '{"token":"no-token","body":{"email":"cp-'+$("#usr").val()+'","password":"'+$("#pas").val()+'"}}'                
                var url = "http://aws01.sinfo.co/auth/login";
                envioFormulario(arr,url,'POST')                
                return false
            }
        }
        );
    });
