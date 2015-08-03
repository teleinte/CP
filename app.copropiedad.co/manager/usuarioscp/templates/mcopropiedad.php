                           <!-- Selector para cambiar las hojas de estilo -->
                      
                      <script type="text/javascript">

                      $(document).ready(function(e) {

                        var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona:sessionStorage.getItem('id_crm'),}};
                        const rutaAplicatico = "https://aws02.sinfo.co/api/admin/copropiedad/";    
                        $.ajax(
                            {
                                url: rutaAplicatico+"copropiedad/usuarioCopropiedad",
                                type: 'POST',
                                data: JSON.stringify(arr),
                                contentType: 'application/json; charset=utf-8',
                                dataType: 'json',
                                async: false,
                                success: function(msg) 
                                {
                                    var msgDividido = JSON.stringify(msg);
                                    var mensaje =  JSON.parse(msgDividido);
                                    var msgDivididoDos = JSON.stringify(mensaje.message);
                                    var datos = JSON.parse(msgDivididoDos);                
                                    if (datos=="Token invalido")
                                    {
                                        $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')                  
                                        window.location = '../index.html';
                                    }
                                    else
                                    {
                                      var cadena = "";
                                        $.each(datos, function(x , y) 
                                        {                                            
                                            var idmongo= JSON.stringify(y['_id']);
                                            var idMongoFinal = JSON.parse(idmongo);
                                            if (idMongoFinal.$id==sessionStorage.getItem('cp'))
                                            {
                                              cadena+='<option value="'+idMongoFinal.$id+'" data-image="../../images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" selected>'+y['nombre']+'</option>'
                                              sessionStorage.setItem('ncp',y['nombre']);
                                                //$('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="../../images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" selected>'+y['nombre']+'</option>')
                                            }
                                            else
                                            {
                                              cadena+='<option value="'+idMongoFinal.$id+'" data-image="../../images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" >'+y['nombre']+'</option>'
                                                //$('#copropiedad').append('<option value="'+idMongoFinal.$id+'" data-image="../../images/msdropdown/color'+y['color']+'.png" data-description="'+y['direccion']+'" >'+y['nombre']+'</option>')    
                                            }
                                            
                                        })
                                        cadena+='<option value="Nueva" data-image="" data-description="Crear nueva Copropiedad" >Nueva copropiead</option>'
                                        $('#copropiedad').append(cadena);               
                                    }
                                }
                            });

                      });
                     </script>
                      