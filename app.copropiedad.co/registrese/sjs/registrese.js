$(function() {
    var thisURL = 'https://appdes.copropiedad.co';

    sessionStorage.setItem('captcha',btoa(generarCaptcha()));

    CreaTokenAuth("d302d491-38e6-4e2b-b8f7-c2bfb84a5613" + generateUUID(),"bcb2c4d3-2f8e-4c08-9b8a-9211fb4d5f66" + generateUUID());

    $("#ingreseaqui").attr('href',thisURL);

    $('#registro_form').submit(function(event){
      event.preventDefault();
      if(verify())
      {
        $('input[type=submit]').attr('disabled',true);
        CrearUsuario(thisURL);
      }
      else
      {
        $('input[type=submit]').attr('disabled',false);
        sessionStorage.setItem('captcha',btoa(generarCaptcha()));
        $('#captchatext').html(atob(sessionStorage.getItem('captcha')));
        $("#captcha").val('');
      }
    });
    
    $('#activation_form').submit(function(event){
      event.preventDefault();
      envioFormularioPassword(thisURL);
    });

    $('#link_form').submit(function(event){
      event.preventDefault();
      envioFormularioLink(thisURL);
    });

    $('#cambio_form').submit(function(event){
      event.preventDefault();
      envioFormularioCambio(thisURL);
    });

    $('#newpassword_form').submit(function(event){
      event.preventDefault();
      envioFormularioPasswordCambio(thisURL);
    });

    $('#captchatext').html(atob(sessionStorage.getItem('captcha')));
    $('input[type=text]').attr('pattern','[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]+.{2,}$');
    $('input[type=text]').attr('title','Este campo no debe tener menos de 2 caracteres');
    $('input[type=text]').addClass('tooltip');
    $('input[type=email]').attr('pattern','[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,3}$');
    $('input[type=email]').attr('title','Este campo debe tener el formato usuario@dominio.com');
    $('input[type=email]').addClass('tooltip');
    $('input[type=tel]').attr('pattern','(\\+?\\d[- .]*){7,13}$');
    $('input[type=tel]').attr('title','Este campo debe contener solo numeros, con longitud de 7 a 13 caracteres');
    $('input[type=tel]').addClass('tooltip');
    $('input[type=checkbox]').attr('title','Debe seleccionar este campo para continuar');
    $('input[type=checkbox]').addClass('tooltip');
    $('input[type=password]').attr('pattern','(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$');
    $('input[type=password]').attr('pattern','(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$');
    $("#captcha").attr('pattern',"[a-zA-Z0-9]+.{4,}");

    var urlpaginaactual = window.location.href;
    var urlescritorio = thisURL + '/registrese';
    if(urlpaginaactual.replace(/\/$/, "") == urlescritorio.replace(/\/$/, ""))
    {
      $("#condmodal").dialog({
        modal:true,
        autoOpen: false,
        width:600,
        title:"Términos y condiciones",
        closeText: "Cerrar"
      });
         
      $("#condiciones").click(function(event){
        $("#condmodal").dialog("open");
      });
    }
  });

function verify(){
  if(String($("#captcha").val().toUpperCase()) == String(atob(sessionStorage.getItem('captcha'))))
  {
    return true;
  }
  else
  {
    return false;
  }
}

function generarCaptcha(){
  var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

      for( var i=0; i < 5; i++ )
          text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text.toUpperCase();
    }