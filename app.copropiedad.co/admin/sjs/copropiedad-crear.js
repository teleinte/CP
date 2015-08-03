$(document).ready(function(){

  $(document).renderme('ccp');

  $("#copropiedad_form").submit(function(event){
    event.preventDefault();
    $('input[type=submit]').attr('disabled',true);

    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_crm_persona: sessionStorage.getItem('id_crm'),       
        email : sessionStorage.getItem('email').replace('cp-','')        
      }
    };
    var url = "admin/copropiedad/diasvigencia";
    var agrearDias = envioFormularioMessageBodySync(url,arr,'POST');    

    var arr = 
    {
      token:sessionStorage.getItem('token'),
      body:
      {
        id_crm_persona: sessionStorage.getItem('id_crm'),
        fecha_creacion:fecha(),                        
        nombre:$('#nombre').val(),
        direccion:$('#direccion').val().replace(' ',''),
        telefono:$('#telefono').val().replace(' ',''),
        nit:$('#nit').val().replace(' ',''),
        ciudad: $('#ciudad').val(),
        estado:1,
        referencia : "Demo "+agrearDias,
        vigencia : agregarDias(agrearDias),
        pagosonline : false
      }
    };
    //console.warn(arr);
    var url = "admin/copropiedad/copropiedad";
    var response1 = envioFormularioMessageBodySync(url,arr,'POST');
    //console.warn(response1);
    if(response1)
    {
      arr = 
      {
          token:sessionStorage.getItem('token'),
          body:
          {
              id_crm_persona: sessionStorage.getItem('id_crm'),
              correo: sessionStorage.getItem('email').replace('cp-',''),
              id_copropiedad: response1['$id'],
              nombre:$('#nombre').val(),
              rol:"administrador",
          }
      };
      //console.warn(arr);
      var url = "admin/copropiedad/rol";
      var personalrol = envioFormularioSync(url,arr,'POST');    

      if(response1 && personalrol)
      {
        var estadoCP = verificarEstadoCP(sessionStorage.getItem('email').replace('cp-',''),sessionStorage.getItem('token'));
        sessionStorage.setItem('estadoCP',parseInt(estadoCP));
        var cps = checkPerfiles(traerDireccion());
        setupIngreso(estadoCP,cps);
        setupInicialCP(estadoCP,cps);
        checkRemoteUserFlow(traerDireccion());
        refreshWindow(traerDireccion());
      }
    }
  });

  $(document).renderme('ccp');
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


