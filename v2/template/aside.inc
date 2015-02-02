                   
                    <script type="text/javascript">
                      $(document).ready(function(){
                        var datos = JSON.stringify(sessionStorage.getItem("modulos"));
                        var endata =  JSON.parse(datos);                        
                        for (i in endata)
                        {
                            //alert("Paso por este lado")
                            if(endata[i]==1)
                            {
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {                                
                                $('#new-panel').append('<p><a href="tarea/nueva_tarea.html">Tarea</p>')
                            }
                            else if (endata[i]==3)
                            {
                                $('#new-panel').append('<p><a href="cartelera/nueva_cartelera.html">Cartelera</p>')
                                
                            }
                            else if (endata[i]==4)
                            {
                              //es calendarion no tiene nada  
                                
                            }
                            
                            else if (endata[i]==5)
                            {                                
                                $('#new-panel').append('<p><a href="encuesta/nueva_encuesta.html">Encuestas</p>')                                
                            }
                        }
                        
                      });
                  </script>


                    <aside>
                                              
                    <div class="trescolumnas primera">


                        <div class="panel" id="new-panel"></div>                        
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="nuevos" href="#" title="nuevos">Nuevo...</a>

                        <div class="panel" id="app-panel">
                            <div class="aplicaciones" id="pasandodatos">                                
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="aplicacionesDos" href="#" title="aplicacionesDos"><img src="../images/aplicaciones.png" alt="aplicaciones"/></a>
                    </div>
                    <div class="trescolumnas centro">
                        <div class="panel" id="pending-panel">
                            <ul>
                                <li>
                                    <div class="floatleft">Revisar Tejado</div>
                                    <div class="floatright">Vence Hoy</div>
                                </li>
                                <li>
                                    <div class="title">Vencidas</div>
                                    <div class="floatleft">Llamar a Bancolombia</div>
                                    <div class="floatright">20/11/2014</div>
                                </li>
                                <li>
                                    <div class="title">Solicitudes</div>
                                    <div class="floatleft">Mantenimiento del ascensor</div>
                                    <div class="floatright">01/12/2014</div>
                                </li>
                            </ul>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn white" id="pendientes" href="#" title="pendientes"><span class="noti-pendientes">2</span>Para hacer hoy...</a>
                    </div>
                    <div class="trescolumnas ultima">
                        <span class="titulo-cop">Mis Copropiedades:</span>
                        <div class="selector-copropiedad">
                            <select style="width:100%"  name="copropiedad" id="copropiedad" >                              
                           </select>
                        </div>
                    </div>
                </aside>