$(document).ready(function(){

  $(document).renderme('ctp');

// en via el formulario para crear un nuevo contacto
$("#nuevo-usuario").submit(function(event){
  var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
  event.preventDefault();
  var ParamFecha=fecha();        
  var id_crm=Math.floor((Math.random() * 100000000000) + 1);    
  
  var arr01 = 
  {
    token:sessionStorage.getItem('token'),          
    body:
    {
      id_crm_persona: id_crm,
      id_copropiedad:sessionStorage.getItem('cp'),
      correo:$('#email').val().toLowerCase(),
      nombre:sessionStorage.getItem('ncp'),
      rol:"proveedor",      
      imagen:""
    }
  };

  var url = "admin/copropiedad/rol";
  envioFormularioSync(url,arr01,'POST');

  
  var arr = 
  {
    token:sessionStorage.getItem('token'),
    body:
    {
      creado_por: sessionStorage.getItem('id_crm'),
      fecha_creacion:ParamFecha,
      id_copropiedad:sessionStorage.getItem('cp'),
      id_crm_persona:id_crm,
      nombre:$('#nombre').val()+" "+$('#apellido').val(),
      telefono:$('#telefono').val().replace(' ',''),       
      email:$('#email').val().replace(' ','').toLowerCase(),
      unidad:params['idt'],
      perfil:"proveedor",
      tipo:"proveedor",
      estado:1,
      grupo:"proveedor",
    }
  };
  var url = "admin/copropiedad/usuario";
  var responseUsuario = envioFormularioSync(url,arr,'POST');  
  if(responseUsuario)
  {
      var pagina="proveedores-editar.php?idt="+params['idt'];
      setTimeout(refreshWindow(pagina),1000);
  }
  });

  $(document).renderme('ctp');
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