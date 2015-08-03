$(document).ready(function() {
    $(document).renderme('pe');
    traerDatosPerfil();

    $("#cambioPassword").click(function(){
        if($("#cambiopwd").val() == "0")
        {
            $("#passwordbody").fadeIn("slow");
            $("#pwd").attr('disabled',false);
            $("#cpwd").attr('disabled',false);
            $("#pwd").attr('required',true);
            $("#cpwd").attr('required',true);
            $("#pwd").attr('placeholder','');
            $("#cpwd").attr('placeholder','');
            $('input[type=password]').attr('pattern','(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$');
            $("#cambiopwd").val("1");
            $(this).val(obtenerTerminoLenguage('pe','11'));
        }
        else
        {
            $("#passwordbody").fadeOut("slow");
            $("#pwd").attr('disabled',true);
            $("#cpwd").attr('disabled',true);
            $("#pwd").attr('required',false);
            $("#cpwd").attr('required',false);
            $("#pwd").attr('placeholder',obtenerTerminoLenguage('pe','4'));
            $("#cpwd").attr('placeholder',obtenerTerminoLenguage('pe','4'));
            $("#cambiopwd").val("0");
            $(this).val(obtenerTerminoLenguage('pe','9'));
        }
    });

    $("#perfil_datos").submit(function(event){
        event.preventDefault();
        $('input[type=submit]').attr('disabled',true);
        $('input[type=button').attr('disabled',true);
        if($("#cambiopwd").val() == "1")
        {
            if($("#pwd").val() != $("#cpwd").val())
            {
                $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:22"><strong teid="ale:html:1"></strong><br/></div>');
                $('input[type=submit]').attr('disabled',false);
                $('input[type=button').attr('disabled',false);
            }
            else
            {
                var login = updateLogin();
                var pwdchange = updatePwd();

                if(login && pwdchange)
                {
                    sessionStorage.setItem('nombre',$("#nombre").val());
                    sessionStorage.setItem('apellido',$("#apellido").val());
                    var completo = $("#nombre").val() + " " + $("#apellido").val();
                    sessionStorage.setItem('nombreCompleto',completo);
                    location.reload();
                }
                else
                {
                    $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:21"></div>');
                    $('input[type=submit]').attr('disabled',false);
                    $('input[type=button').attr('disabled',false);
                }
            }
        }
        else
        {
            var login = updateLogin();

            if(login)
            {
                sessionStorage.setItem('nombre',$("#nombre").val());
                sessionStorage.setItem('apellido',$("#apellido").val());
                var completo = $("#nombre").val() + " " + $("#apellido").val();
                sessionStorage.setItem('nombreCompleto',completo);
                refreshWindow(traerDireccion() + 'inicio/');
            }
            else
            {
                $("#alertas").append('<div class="alert alert-dismissable alert-error" teid="ale:html:21"></div>');
                $('input[type=submit]').attr('disabled',false);
                $('input[type=button').attr('disabled',false);
            }
        }
    });

    $(document).renderme('pe');
    $(document).renderme('ale');
    $(".ttip").addClass("tooltip-boton");

    $( ".tooltip-boton[title!='']" ).qtip({
      position: {
        my: 'top center',
            at: 'bottom center',
            viewport: $(window), //para correr el tooltip si no cabe en la pantalla
        adjust: {
          method: 'flip invert' //método de ajuste si no cabe en la pantalla
        }
          },
      style: {
            tip: {
                corner: false
            }
        }
    });
});