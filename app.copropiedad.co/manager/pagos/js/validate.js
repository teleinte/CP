$(document).ready(function() 
{

  $("#btn_submit").click(function()
    {
           
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var d = new Date();
      var n = d.toISOString();
      var diasdemo=1;
      var findemo=sumaFecha(diasdemo,d);
      var fin= findemo.toISOString();
      var ParamFecha=n;
      //alert('aqui llega');

      /*if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
       {  
          window.location = '../index.php';
          //alert('no valida');
          return false;
       }
       else
       {*/
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_crm_persona: $('#id_crm_persona').val(),
            fecha_pago:ParamFecha,
            fecha_confirmacion:fin,
            referencia_activa:$('#referencia_activa').val(),
            valor: $('#valor').val(),
            id_copropiedad:$('#id_copropiedad').val(),                   
            ncp:$('#ncp').val(),
            cruzado:'0',
            email_pagador:$("#email_pagador").val(),
            name_pagador:$("#name_pagador").val(),
            referenceCode:$("#referenceCode").val(),
            estado:$("#estado").val()
          }
        }; 
        var url = "pagosteleinte";
        alert(JSON.stringify(arr));
        envioFormulario(arr,url,'POST',params);
  });
  $("#btn_edit_submit").click(function()
    {
           
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var d = new Date();
      var n = d.toISOString();
      var ParamFecha=n;
      //alert('aqui llega');

      /*if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
       {  
          window.location = '../index.php';
          //alert('no valida');
          return false;
       }
       else
       {*/
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_crm_persona: $('#id_crm_persona').val(),
            fecha_pago:ParamFecha,
            fecha_confirmacion:fin,
            referencia_activa:$('#referencia_activa').val(),
            valor: $('#valor').val(),
            id_copropiedad:$('#id_copropiedad').val(),                   
            ncp:$('#ncp').val(),
            cruzado:$('#cruzado').val(),
            email_pagador:$("#email_pagador").val(),
            name_pagador:$("#name_pagador").val(),
            referenceCode:$("#referenceCode").val(),
            estado:$("#estado").val()
          }
        }; 
        var url = "pagosteleinte";
        //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'PUT',params);
        //url = "usuarios_demo";
        //envioFormulario(arr,url,'PUT',params);
        
  });

    $(document).ready(function() 
    {
      $("#usuario_form_eliminar").validate(
      {
        rules: 
        {
          opcion: {required: true}                
        },
        messages: 
        {
          opcion: "Debe seleccionar una opcion.",                                
        },
        submitHandler: function(form)
        {
          var params={};
          window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value)
          {
            params[key] = value;
          })
          if ($('#opcion').val()=="NO")
          {
              $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> No dió vigencia a la coporpiedad.</div>')                    
              window.location = 'index.php';
              return false
          }
          var ParamFecha=fecha();
          var fechaFinal=ParamFecha;
          /*if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
           { 
              window.location = '../index.php';
              return false
           }
           else
           {*/
              var arr = 
              {
                token:sessionStorage.getItem('token'),
                body:
                {
                  id_crm_persona: $('#id_crm_persona').val(),
                  fecha_pago: $('#fecha_pago').val(),
                  fecha_confirmacion: $('#fecha_confirmacion').val(),
                  referencia_activa: $('#referencia_activa').val(),
                  valor: $('#valor').val(),
                  id_copropiedad: $('#id_copropiedad').val(),
                  ncp: $('#ncp').val(),
                  cruzado: $('#cruzado').val(),
                  email_pagador: $('#email_pagador').val(),
                  name_pagador: $('#name_pagador').val(),
                  referenceCode: $('#referenceCode').val(),
                  estado: $('#estado').val() //aprovado o no                       
                }
              };
              
              var url = "dar_vigencia";
              //alert(JSON.stringify(arr));
              envioFormulario(arr,url,'POST',params);
              //var pagina="contacto-editar.php?idt="+params['rg'];
              //location.href='index.php';//pagina;

           //}
        }
      });
    });

});
function fecha()
{
    var d = new Date();
    var n = d.toISOString(); 
    return n;
}  