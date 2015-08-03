$(document).ready(function(){
  
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  $(document).renderme('ccp');

  $("#confignum_form").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);
    
    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_copropiedad : sessionStorage.getItem('cp'),
        tipo_documento:"consecutivos",
        id:$("#id").val(),
        cc:Number($('#cc').val()),
        rc:Number($('#rc').val()),
        fv:Number($('#fv').val()),
        ce:Number($('#ce').val()),
        nc:Number($('#nc').val()),
        fc:Number($('#fc').val())
      }
    };
   var url = "contabilidad/configuracion";
   var response1 = envioFormularioSync(url,arr,'PUT');
   if(response1)
    {
      refreshWindow(traerDireccion() + 'contabilidad/'); 
    }

    $(document).renderme('ccp');

  });
});


