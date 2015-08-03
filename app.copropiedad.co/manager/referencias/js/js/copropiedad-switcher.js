$(document).ready(function(e) {		
		//no use
    try {
      var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona:sessionStorage.getItem('id_crm'),}};
      TraerCopropiedadDrop(arr,"copropiedad/usuarioCopropiedad", parseInt(sessionStorage.getItem('id_crm')));

      
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          sessionStorage.setItem("cp", val)          
          location.reload()
          //window.open("#"+val,'_parent');

        }
          sessionStorage.setItem("cp", val)          
          location.reload()
          // window.open("#"+val,'_parent');
        }}}).data("dd");
  
    } catch(e) {
      //console.log(e); 
    }
    
    $("#ver").html(msBeautify.version.msDropdown);
      
    //convert
    //$("select").msDropdown({roundedBorder:false});
    //createByJson();
    
  });