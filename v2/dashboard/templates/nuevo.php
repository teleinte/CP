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
                            if (endata[i]==3)
                            {
                                //$('#contenerdor').append('<div class="app"><div id="square"><div class="absoluto"><a href="../tarea/" id="tarea"><img src="../images/tareas.png" /><h6>Tareas</h6></a></div></div></div>')
                                $('#new-panel').append('<p><a href="../tarea/">Nueva Tarea</p>')
                            }
                            else if (endata[i]==4)
                            {
                                
                                $('#new-panel').append('<p><a href="../evento/">Nuevo Evento</p>')
                                
                            }
                            else if (endata[i]==5)
                            {
                                
                                $('#new-panel').append('<p><a href="../encuesta/">Nueva Encuesta</p>')
                            }
                            else if (endata[i]==6)
                            {
                                $('#new-panel').append('<p><a href="../cartelera/">Nueva Cartelera</p>')                               
                            }
                            else if (endata[i]==7)
                            {
                                $('#new-panel').append('<p><a href="../parqueadero/">Parqueadero</p>')                               
                            }
                            else if (endata[i]==8)
                            {
                                $('#new-panel').append('<p><a href="../reservas/">Nueva Reserva</p>')                               
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
                    </div>