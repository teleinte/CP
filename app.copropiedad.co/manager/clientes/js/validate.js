$(document).ready(function() 
{

  $("#btn_submit").click(function()
    {
           
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var d = new Date();
      var n = d.toISOString();
      var diasdemo=45;
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
            id_crm_persona: $('#id_crm').val(),
            fecha_registro:ParamFecha,
            fecha_actualizacion:ParamFecha,
            referencia:'demo'+diasdemo,
            fecha_fin:fin,
            name_client:$('#name_client').val(),                   
            cc_client:$('#cc_client').val(),
            email_client:$("#email_client").val(),
            tel_client:$("#tel_client").val(),
            cel_client:$("#cel_client").val(),
            dir_client:$("#dir_client").val(),
            origin_client:$("#origin_client").val(),
            pais_client:$("#pais_client").val(),
            ciudad_client:$("#ciudad_client").val(),
            estado: '1'
          }
        }; 
        var url = "clientes";
        //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'POST',params);
        url = "usuarios_demo";
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
            id:params['idt'],
            id_crm_persona: $('#id_crm').val(),
            fecha_registro:$('#fecha_registro').val(),
            fecha_actualizacion:ParamFecha,
            referencia:$('#referencia').val(),
            fecha_fin:$('#fecha_fin').val(),
            name_client:$('#name_client').val(),                   
            cc_client:$('#cc_client').val(),
            email_client:$("#email_client").val(),
            tel_client:$("#tel_client").val(),
            cel_client:$("#cel_client").val(),
            dir_client:$("#dir_client").val(),
            origin_client:$("#origin_client").val(),
            pais_client:$("#pais_client").val(),
            ciudad_client:$("#ciudad_client").val(),
            estado: '1'
          }
        }; 
        var url = "clientes";
        //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'PUT',params);
        //url = "usuarios_demo";
        //envioFormulario(arr,url,'PUT',params);
        
  });
$("#btn_eliminar").click(function()
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
            id:params['idt'],
            id_crm_persona: $('#id_crm').val(),
            fecha_registro:$('#fecha_registro').val(),
            fecha_actualizacion:ParamFecha,
            referencia:$('#referencia').val(),
            fecha_fin:$('#fecha_fin').val(),
            name_client:$('#name_client').val(),                   
            cc_client:$('#cc_client').val(),
            email_client:$("#email_client").val(),
            tel_client:$("#tel_client").val(),
            cel_client:$("#cel_client").val(),
            dir_client:$("#dir_client").val(),
            origin_client:$("#origin_client").val(),
            pais_client:$("#pais_client").val(),
            ciudad_client:$("#ciudad_client").val(),
            estado: '0'
          }
        }; 
        var url = "clientes";
          //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'DELETE',params);
        //url = "usuarios_demo";
        //envioFormulario(arr,url,'DELETE',params);
        
  });

});