$(document).ready(function() {        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#unidad_form").validate({
            rules: {
                tipo: {required: true},                
                identificador: {required:true},
                detalle: {required:true},
                coeficiente: {required:true},
                canon: {required:true},
                nombre0: {required:true},
                apellido0: {required:true},
                telefono0: {required:true},
                celular0: {required:true},
                email0: {required:true, email: true},
                empresa0: {required:true},
                descripcion0: {required:true}
            },
            messages: {
                tipo: "Debe llenar este campo.", 
                identificador: "Debe llenar este campo.", 
                detalle: "Debe llenar este campo.", 
                coeficiente: "Debe llenar este campo.", 
                canon: "Debe llenar este campo.", 
                nombre0: "Debe llenar este campo.", 
                apellido0: "Debe llenar este campo.", 
                telefono0: "Debe llenar este campo.", 
                celular0: "Debe llenar este campo.", 
                email0: "Debe llenar este campo.", 
                empresa0: "Debe llenar este campo.", 
                descripcion0: "Debe llenar este campo." 
            },
            submitHandler: function(form){
                
                var ParamFecha=fecha();
                
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id_copropiedad: sessionStorage.getItem('cp'),
                        nombre_copropiedad:sessionStorage.getItem('ncp'),
                        id_crm_persona:sessionStorage.getItem('id_crm'),
                        tipo_unidad:$('#tipo').val(),                        
                        identificador:$('#identificador').val(),
                        reservable:false,
                        detalle:$('#detalle').val(),
                        estado:1,                        
                        fecha_creacion:ParamFecha,
                        proveedor:$('#proveedor').prop('checked')
                      }
                    }; 
                    var url = "unidad";
                    envioFormulario(arr,url,params,'POST');
                    var retornado;
                    retornado=sessionStorage.getItem("insertado");
                    //alert("dato retornado"+retornado);
                    
                    
                    //creamos el usuario en copropiedad
                    var id_crm=Math.floor((Math.random() * 1000) + 1);
                    sessionStorage.setItem('id_crmPro',id_crm)
                    
                    
                    var url = "usuario";
                    var tipo="";
                    if($('#proveedor').prop('checked')){tipo = "proveedor";}else{tipo = "residente";}
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        creado_por: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        id_copropiedad:sessionStorage.getItem('cp'),
                        id_crm_persona:id_crm,
                        nombre:$('#nombre0').val()+" "+$('#apellido0').val(),
                        telefono:$('#telefono0').val().replace(' ',''),
                        celular:$('#celular0').val().replace(' ',''),
                        email:$('#email0').val().replace(' ',''),
                        empresa:$('#empresa0').val(),
                        unidad:retornado,
                        tipo:tipo,
                        estado:1,
                        grupo:$('#grupo0').val()
                      }
                    };
                    envioFormularioUsuario(arr,url,params,'POST', 0);
                    var retornadoUsuario;
                    retornadoUsuario=sessionStorage.getItem("insertadoUsuario");

                    //registramos el rol de la persona creada:
                    var arr = 
                    {
                        token:sessionStorage.getItem('token'),
                        body:
                        {
                            id_crm_persona: id_crm,
                            id_copropiedad:sessionStorage.getItem('cp'),
                            correo:$('#email0').val().replace(' ',''),
                            nombre:sessionStorage.getItem('ncp'),
                            rol:tipo,
                            imagen:""
                        }
                    };

                    var url = "rol";
                    alert(JSON.stringify(arr))                    
                    envioFormularioDos(arr,url,'POST')
                    //alert("retornado usuario"+retornado);
                    
                    
                    /////// creando el encargado de la coporpiedad para facturarle
                    var url = "unidadEncargado";
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id_copropiedad:sessionStorage.getItem('cp'),
                        id_crm_persona:id_crm,
                        unidad:retornado,
                        encargado:$('#nombre0').val()+" "+$('#apellido0').val(),
                        id_usuario:retornadoUsuario,                        
                        email:$('#email0').val().replace(' ',''),
                        coeficiente:$('#coeficiente').val(),
                        canon:$('#canon').val(),
                        proveedor:$('#proveedor').prop('checked')
                      }
                    };
                    envioFormularioUsuarioEncargado(arr,url,params,'POST',0);
                    var retornadoUsuarioEncargado;
                    retornadoUsuarioEncargado=sessionStorage.getItem("retornadoUsuarioEncargado");
                    //alert("envio entregado"+retornadoUsuarioEncargado);
                    
                    for (j=1;j<20;j++)
                    {
                        if(!$('#nombre'+j).val())
                        {
                            break;
                        }

                        var id_crm=Math.floor((Math.random() * 1000) + 1);
                        sessionStorage.setItem('id_crmPro',id_crm)

                        //registramos el rol de la persona creada:
                        var arr = 
                        {
                            token:sessionStorage.getItem('token'),
                            body:
                            {
                                id_crm_persona: id_crm,
                                id_copropiedad:sessionStorage.getItem('cp'),
                                correo:$('#email'+j).val(),
                                nombre:sessionStorage.getItem('ncp'),
                                rol:tipo,
                                imagen:""
                            }
                        };

                        var url = "rol";
                        alert(JSON.stringify(arr))                    
                        envioFormularioDos(arr,url,'POST')




                                                
                        var url = "usuario";
                        var tipo="";
                        if($('#proveedor').prop('checked')){tipo = "proveedor";}else{tipo = "residente";}
                        var arr = 
                        {
                          token:sessionStorage.getItem('token'),
                          body:
                          {
                            creado_por: sessionStorage.getItem('id_crm'),
                            fecha_creacion:ParamFecha,
                            id_copropiedad:sessionStorage.getItem('cp'),
                            id_crm_persona:id_crm,
                            nombre:$('#nombre'+j).val()+" "+$('#apellido'+j).val(),
                            telefono:$('#telefono'+j).val(),
                            celular:$('#celular'+j).val(),
                            email:$('#email'+j).val(),
                            empresa:$('#empresa'+j).val(),
                            unidad:retornado,
                            tipo:tipo,
                            estado:1,
                            grupo:$('#grupo'+j).val()
                          }
                        };
                        envioFormularioUsuario(arr,url,params,'POST',j);
                        envioFormularioUsuarioEncargado(arr,url,params,'POST',j);
                        
                    }
                    //alert("termino el envio de la información");
                    location.href="usuario.php";
                 }
            }
        });
    });
    
    
$(document).ready(function() {        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#form-cliente-editar").validate(
        {
            rules: {
                tipo: {required: true},                
                identificador: {required:true},
                detalle: {required:true},
                coeficiente: {required:true},
                canon: {required:true},                
            },
            messages: {
                tipo: "Debe seleccionar el tipo de unidad.",                
                identificador: "Debe seleccionar un estado para la unidad.",
                detalle: "Debe incluir un detalle (eje. Apto 205).",
                coeficiente: "Debe poner un coeficiente",
                canon: "Debe poner el valor del canon de administracion",                
            },
            submitHandler: function(form){
                
                var ParamFecha=fecha();
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                     //actualizar primero la tabla unidades con los datos nuevos cargados                     
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:$('#id_unidad').val(),
                        id_copropiedad: $('#id_copropiedad').val(),
                        nombre_copropiedad:$('#nombre_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        tipo_unidad:$('#tipo').val(),
                        identificador:$('#identificador').val(),
                        reservable:false,
                        detalle:$('#detalle').val(),
                        estado:$('#estado').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        proveedor:$('#proveedor').prop('checked')
                      }
                    };
                    
                    var url = "unidad/unidad";
                    envioFormularioModificado(arr,url,params,'PUT');
                    
                    var url = "unidad/unidadEncargado";
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        
                        id:$('#id_extra').val(),
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        unidad:$('#id_unidad').val(),
                        encargado:$('#encargado').val(),
                        id_usuario:$('#id_usuario').val(),                        
                        email:$('#email').val().replace(' ',''),                        
                        coeficiente:$('#coeficiente').val(),
                        canon:$('#canon').val()
                      }
                    };
                    
                    
                    //alert(JSON.stringify(arr));
                    envioFormularioModificado(arr,url,params,'PUT');
                    
                 }
            }
        }
        );
    });



$(document).ready(function() {        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
        $("#modificar-usuario").validate(
        {
            rules: {
                nombre: {required:true},
                telefono: {required:true},
                celular: {required:true},
                email: {required:true, email: true},
                empresa: {required:true}
            },
            messages: {
                nombre: "Debe poner nombre de usuario",
                telefono: "Debe poner un telefono de contacto",
                celular: "Debe poner un numero celular de contacto",
                email: "Debe poner un corre electronico valido",
                empresa: "Debe debe poner la empresa a la que pertenece",                
            },
            submitHandler: function(form){                
                var ParamFecha=fecha();
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                     //actualizar primero la tabla unidades con los datos nuevos cargados                     
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:$('#id_usuario').val(),
                        creado_por:$('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombre').val(),                                                    
                        telefono:$('#telefono').val(),
                        celular:$('#celular').val(),
                        email:$('#email').val(),
                        empresa:$('#empresa').val(),
                        unidad:$('#unidad').val(),
                        tipo:$('#tipo').val(),
                        estado:parseInt($('#estado').val()),
                        grupo:$('#grupo').val()
                        
                      }
                    };
                    
                    var url = "admin/copropiedad/usuario/";
                    //alert(JSON.stringify(arr));
                    envioFormularioModificado(arr,url,params,'PUT');                    
                    var pagina="contacto-editar.php?idt="+params['rg'];
                    location.href=pagina;
                 }
            }
        }
        );
    });
    
    $(document).ready(function() {        
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});        
        $("#crear-usuario").validate(
        {
            rules: {
                nombre1: {required:true},
                apellido1: {required:true},
                telefono1: {required:true},
                email1: {required:true, email: true},
                empresa1: {required:true}
            },
            messages: {
                nombre1: "Debe poner nombre de usuario",
                apellido1: "Debe poner apellido de usuario",
                telefono1: "Debe poner un telefono de contacto",
                email1: "Debe poner un corre electronico valido",
                empresa1: "Debe debe poner la empresa a la que pertenece",                
            },
            submitHandler: function(form){                
                var ParamFecha=fecha();
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../index.html';
                    return false
                 }
                 else
                 {
                 
                    var id_crm=Math.floor((Math.random() * 1000) + 1);
                    var url = "usuario";                    
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        creado_por: sessionStorage.getItem('id_crm'),
                        fecha_creacion:ParamFecha,
                        id_copropiedad:sessionStorage.getItem('cp'),
                        id_crm_persona:id_crm,
                        nombre:$('#nombre1').val()+" "+$('#apellido1').val(),
                        telefono:$('#telefono1').val().replace(' ',''),
                        email:$('#email1').val().replace(' ',''),
                        empresa:$('#empresa1').val(),
                        unidad:params['idt'],
                        tipo:'residente',
                        estado:1,
                        grupo:$('#grupo1').val()
                      }
                    };
                    
                    envioFormularioUsuario(arr,url,params,'POST',1);
                    envioFormularioUsuarioEncargado(arr,url,params,'POST',1);
                    var pagina="contacto-editar.php?idt="+params['idt'];
                    location.href=pagina;
                    
                    
                 }
            }
        }
        );
    });
    
    
    $(document).ready(function() {
        $("#usuario_form_eliminar").validate(
        {
            rules: {
                opcion: {required: true}                
            },
            messages: {
                opcion: "Debe seleccionar una opcion.",                                
            },
            submitHandler: function(form){
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminados.</div>')                    
                    window.location = 'contacto-editar.php?idt='+params['rg'];
                    return false
                }
                var ParamFecha=fecha();
                var fechaFinal=ParamFecha;
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 { 
                    window.location = '../index.php';
                    return false
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                      id:$('#id_usuario').val(),
                        creado_por:$('#creado_por').val(),
                        fecha_creacion:$('#fecha_creacion').val(),
                        id_copropiedad:$('#id_copropiedad').val(),
                        id_crm_persona:$('#id_crm_persona').val(),
                        nombre:$('#nombre').val(),                                                    
                        telefono:$('#telefono').val(),
                        celular:$('#celular').val(),
                        email:$('#email').val(),
                        empresa:$('#empresa').val(),
                        unidad:$('#unidad').val(),
                        tipo:$('#tipo').val(),
                        estado:parseInt(2),
                        grupo:$('#grupo').val()
                        
                      }
                    };
                    
                    var url = "admin/copropiedad/usuario/";
                    //alert(JSON.stringify(arr));
                    envioFormularioModificado(arr,url,params,'PUT');
                    var pagina="contacto-editar.php?idt="+params['rg'];
                    location.href=pagina;

                 }
            }
        }
        );
    });
    
    
    
$(document).ready(function() {
        $("#usuario_form_cambio").validate(
        {
            rules: {
                opcion: {required: true}                
            },
            messages: {
                opcion: "Debe seleccionar una opcion.",                                
            },
            submitHandler: function(form){
                
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminados.</div>')                    
                    window.location = 'contacto-editar.php?idt='+params['rg'];
                    return false
                }
                var ParamFecha=fecha();
                var fechaFinal=ParamFecha;
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 { 
                    window.location = '../index.php';
                    return false
                 }
                 else
                 {
                    //debo eliminar el dato existente para sustituirlo por el nuevo para eso uso el id unidad que debe ser unico en esta coleccion
                    var url = "unidad/unidad/borrarencargado/";
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                          unidad:params['rg']
                      }
                    };
                    envioFormularioModificado(arr,url,params,'DELETE');
                    var url = "unidadEncargado"; 
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                            id_copropiedad:sessionStorage.getItem('cp'),
                            id_crm_persona:sessionStorage.getItem('id_crm'),
                            unidad:params['rg'],
                            encargado:$('#nombre').val(),
                            id_usuario:$('#id_usuario').val(),
                            email:$('#email').val(),
                            coeficiente:$('#coeficiente').val(),
                            canon:$('#canon').val(),
                            proveedor:$('#proveedor').val()
                      }
                    };
                    //alert(JSON.stringify(arr))
                    envioUsuarioEncargado(arr,url,params,'POST')
                    var pagina="contacto-editar.php?idt="+params['rg'];
                    location.href=pagina;
                 }
            }
        }
        );
    });    