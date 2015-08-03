                    <SCRIPT TYPE="text/javascript">
                    $(document).ready(function(e) {

                        if (sessionStorage.getItem('cp')!=null)
                        {
                            var arr = {token:sessionStorage.getItem('token'),body:{_id:sessionStorage.getItem('cp'),}};    
                            TraerModulosCopropiedad(arr,"copropiedad/getlistFilter", sessionStorage.getItem('cp'));
                        }
                        else
                        {
                            var arr = {token:sessionStorage.getItem('token'),body:{id_crm_persona:sessionStorage.getItem('id_crm'),}};    
                            TraerModulosCopropiedad(arr,"copropiedad/usuarioCopropiedad", parseInt(sessionStorage.getItem('id_crm')));                
                        }
                        var datos = JSON.stringify(sessionStorage.getItem("modulos"));
                        var endata =  JSON.parse(datos);
                        for (i in endata)
                        {                       
                            if(endata[i]==1)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/admin/admin.html" id="administracion"><img src="../../v2/images/configuracion.png" /><h6>Configuración de la copropiedad</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/tareas/tareas.html" id="tarea"><img src="../../v2/images/tareas.png" /><h6>Tareas del admninistrador</h6></a></div></div></div>')
                            }
                            else if (endata[i]==3)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/cartelera/cartelera.html" id="cartelera"><img src="../../v2/images/cartelera.png" /><h6>Cartelera</h6></a></div></div></div>')
                                
                            }
                            else if (endata[i]==4)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/calendario/" id="calendario"><img src="../../v2/images/calendario.png" /><h6>Calendario</h6></a></div></div></div>')                                     
                                
                            }
                            else if (endata[i]==5)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/encuestas/encuestas.html" id="tarea"><img src="../../v2/images/encuestas.png" /><h6>Encuestas</h6></a></div></div></div>')
                            }
                        }
                    });
                    </SCRIPT>                    