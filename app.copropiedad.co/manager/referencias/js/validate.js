$(document).ready(function() 
{

  $("#btn_submit").click(function()
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
            //id_crm_persona: sessionStorage.getItem('id_crm'),
            fecha_last_change:ParamFecha,
            id_ref:$('#id_ref').val(),                   
            name_ref:$('#name_ref').val(),
            campana_ref:$("#campana_ref").val(),
            time_ref:$("#time_ref").val(),
            valor_ref:$("#valor_ref").val(),
            estado: '1'
          }
        }; 
        if($('#tipo').val()==0)
        {
          var url = "referencias";
          //alert(JSON.stringify(arr));
          envioFormulario(arr,url,'POST',params);
        }
        else 
        {
          var url = "referencias";
          //alert(JSON.stringify(arr));
          //envioFormulario(arr,url,'PUT');
        }
       /*}
      }*/
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
            //id_crm_persona: sessionStorage.getItem('id_crm'),
            id:params['idt'],
            fecha_last_change:ParamFecha,
            id_ref:$('#id_ref').val(),                   
            name_ref:$('#name_ref').val(),
            campana_ref:$("#campana_ref").val(),
            time_ref:$("#time_ref").val(),
            valor_ref:$("#valor_ref").val(),
            estado: '1'
          }
        }; 
        if($('#tipo').val()==0)
        {
          var url = "referencias";
          //alert(JSON.stringify(arr));
          envioFormulario(arr,url,'PUT',params);
        }
        else 
        {
          var url = "referencias";
          //alert(JSON.stringify(arr));
          //envioFormulario(arr,url,'PUT');
        }
       /*}
      }*/
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
            //id_crm_persona: sessionStorage.getItem('id_crm'),
            id:params['idt'],
            fecha_last_change:ParamFecha,
            id_ref:$('#id_ref').val(),                   
            name_ref:$('#name_ref').val(),
            campana_ref:$("#campana_ref").val(),
            time_ref:$("#time_ref").val(),
            valor_ref:$("#valor_ref").val(),
            estado: '0'
          }
        }; 
        var url = "referencias";
          //alert(JSON.stringify(arr));
        envioFormulario(arr,url,'DELETE',params);
        
  });

});