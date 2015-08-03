$(document).ready(function(){
  $(document).renderme('sl');

  $("#preregistro_form").submit(function(event){
    event.preventDefault();
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
    // var arr = { token:sessionStorage.getItem('token')};
    // var datos = traerDatosSync("estados/preregistro/listar", arr, sessionStorage.getItem('cp'));    
    //enviarData(datos)
    enviarData();
  });
});