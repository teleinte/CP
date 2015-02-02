$(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        $("#unidad_form").validate(
        {
            rules: {
                tipo: {required: true},                
                identificador: {required:true},
                detalle: {required:true}
            },
            messages: {
                tipo: "Debe seleccionar el tipo de unidad.",                
                identificador: "Debe seleccionar un estado para la unidad.",
                detalle: "Debe incluir un detalle (eje. Apto 205).",
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
                        nombre_copropiedad:$('#nombre').val(),
                        tipo_unidad:$('#tipo').val(),                        
                        identificador:$('#identificador').val(),
                        reservable:$('#reservable').prop('checked'),
                        detalle:$('#detalle').val(),
                        estado:1,
                        fecha_creacion:ParamFecha
                      }
                    }; 
                    var url = "unidad";
                    envioFormulario(arr,url,params,'POST')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#inmueble_form_editar").validate(
        {
            rules: {
                tipo: {required: true},                
                identificador: {required:true},
                detalle: {required:true}
            },
            messages: {
                tipo: "Debe seleccionar el tipo de unidad.",                
                identificador: "Debe seleccionar un estado para la unidad.",
                detalle: "Debe incluir un detalle (eje. Apto 205).",
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.html';
                    return false
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        id_copropiedad: $('#id_copropiedad').val(),
                        nombre_copropiedad:$('#nombre').val(),
                        tipo_unidad:$('#tipo').val(),
                        identificador:$('#identificador').val(),
                        reservable:$('#reservable').prop('checked'),
                        detalle:$('#detalle').val(),
                        estado:$('#estado').val(),
                        fecha_creacion:$('#fecha_creacion').val()
                      }
                    }; 
                    var url = "unidad";                    
                    alert(JSON.stringify(arr));
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });

$(document).ready(function() {
        $("#inmueble_form_eliminar").validate(
        {
            rules: {
                tipo: {required: true},
                usuario: {required: true},
                estado: {required:true},
                detalle: {required:true}
            },
            messages: {
                tipo: "Debe seleccionar el tipo de unidad.",
                usuario: "Debe seleccionar un usuario o dejarlo en ninguno.",
                estado: "Debe seleccionar un estado para la unidad.",
                detalle: "Debe incluir un detalle (eje. Apto 205).",
            },

            submitHandler: function(form){
                var ParamFecha=fecha();
                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                if ($('#opcion').val()=="NO")
                {
                    $('#alertas').html('<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong> Dato NO eliminado.</div>')                    
                    window.location = 'inmueble.php'
                    return false
                }
                if (!sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm') || !sessionStorage.getItem('token'))
                 {  
                    window.location = '../../index.html';
                    return false
                 }
                 else
                 {
                    var arr = 
                    {
                      token:sessionStorage.getItem('token'),
                      body:
                      {
                        id:params['idt'],
                        id_copropiedad: $('#id_copropiedad').val(),
                        nombre_copropiedad:$('#nombre').val(),
                        tipo_unidad:$('#tipo').val(),
                        identificador:$('#identificador').val(),
                        reservable:$('#reservable').prop('checked'),
                        detalle:$('#detalle').val(),
                        estado:4,
                        fecha_creacion:$('#fecha_creacion').val()
                      }
                    }; 
                    var url = "unidad";
                    envioFormulario(arr,url,params,'PUT')
                 }
            }
        }
        );
    });