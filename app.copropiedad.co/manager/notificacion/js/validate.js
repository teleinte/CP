$(document).ready(function() 
{

  $("#btn_submit").click(function()
    {
           
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      var n = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+d.getFullYear();
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
            titulo:$('#titulo').val(),                   
            mensaje:$('#mensaje').val(),
            creado_por:$("#creado_por").val(),
            fecha_creacion:ParamFecha,
            fecha_despliegue:ParamFecha,
            id_crm_persona: "1",//$('#id_crm').val(),
            tipo:$("#tipe").val(),
            prioridad:$("#prioridad").val()
          }
        }; 
        var url = "notificaciones";
        //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'POST',params);
  });
  $("#btn_edit_submit").click(function()
    {
           
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var d = new Date();
      var month = d.getMonth()+1;
      var day = d.getDate();
      var n = (day<10 ? '0' : '') + day+'-'+(month<10 ? '0' : '') + month+'-'+d.getFullYear();
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
            titulo:$('#titulo').val(),                   
            mensaje:$('#mensaje').val(),
            creado_por:$("#creado_por").val(),
            fecha_creacion:$("#fecha_creacion").val(),
            fecha_despliegue:ParamFecha,
            id_crm_persona: "1",//$('#id_crm').val(),
            tipo:$("#tipe").val(),
            prioridad:$("#prioridad").val()
          }
        }; 
        var url = "notificaciones";
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
            id:params['idt']
          }
        }; 
        var url = "notificaciones";
        //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'DELETE',params);
        
  });

});