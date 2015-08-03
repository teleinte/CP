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
                        var endata =  sessionStorage.getItem("modulos").split(",");
                        
                        for (i in endata)
                        {
                            if(endata[i]==1)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/admin/" id="administracion"><img src="../../v2/images/configuracion.png" /><h6>Configuración de la copropiedad</h6></a></div></div></div><div class="app"><div id="square"><div class="absoluto"><a href="../../v2/dashboard/dashboard.php" id="inicio"><img src="../../v2/images/micrositio.png" /><h6>Inicio</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/calendario/" id="calendario"><img src="../../v2/images/calendario.png" /><h6>Calendario</h6></a></div></div></div>')                                
                            }
                            else if (endata[i]==3)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/tarea/" id="tarea"><img src="../../v2/images/tareas.png" /><h6>Tareas del admninistrador</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/tarea/">Nueva Tarea</p>')
                            }
                            else if (endata[i]==4)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/evento/" id="eventos"><img src="../../v2/images/consejo.png" /><h6>Eventos</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/evento/">Nuevo Evento</p>')
                                
                            }
                            else if (endata[i]==5)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/encuesta/" id="encuestas"><img src="../../v2/images/encuestas.png" /><h6>Encuestas</h6></a></div></div></div>')                                     
                                $('#new-panel').append('<p><a href="../../v2/encuesta/">Nueva Encuesta</p>')
                            }
                            else if (endata[i]==6)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/cartelera/" id="cartelera"><img src="../../v2/images/cartelera.png" /><h6>Cartelera</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/cartelera/">Nueva Cartelera</p>')                               
                            }
                            /*else if (endata[i]==7)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../parqueadero/" id="parqueadero"><img src="../images/parqueaderos.png" /><h6>Parqueaderos</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../parqueadero/">Parqueadero</p>')                               
                            }*/
                            else if (endata[i]==8)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/reservas/" id="tarea"><img src="../../v2/images/reservas.png" /><h6>Reservas</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/reservas/">Nueva Reserva</p>')                               
                            }
                            else if (endata[i]==9)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/votacion/" id="tarea"><img src="../../v2/images/encuestas.png" /><h6>Votaciones</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/votacion/">Nueva Votación</p>')                               
                            }
                            else if (endata[i]==10)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/solicitudes/" id="tarea"><img src="../../v2/images/solicitudes.png" /><h6>Solicitudes</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/solicitudes/">Nueva solicitud</p>')                               
                            }
                            else if (endata[i]==12)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/gestion-documental/" id="tarea"><img src="../../v2/images/documentos.png" /><h6>Gestion Documental</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/gestion-documental/">Nuevo Documento</p>')                               
                            }
                            else if (endata[i]==13)
                            {
                                $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../v2/contabilidad/" id="contabilidad"><img src="../../v2/images/contabilidad.png" /><h6>Contabilidad</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../../v2/contabilidad/">Contabilidad</p>')                               
                            }
                            // else if (endata[i]==8)
                            // {
                            //     $('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../../encuestas/" id="tarea"><img src="../images/encuestas.png" /><h6>Encuestas</h6></a></div></div></div>')
                            //     $('#new-panel').append('<p><a href="../encuesta/nueva_encuesta.php">Parqueaderos</p>')                               
                            // }
                        }
                    });
                    </SCRIPT>
                    <div class="trescolumnas primera">
                        <div class="panel" id="new-panel">
                            
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="nuevos" href="#" title="nuevos">Nuevo...</a>

                        <div class="panel" id="app-panel">
                            <div class="aplicaciones" id="contenerdor">                                                            
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="aplicaciones" href="#" title="aplicaciones"><img src="../../v2/images/aplicaciones.png" alt="aplicaciones"/></a>
                    </div>