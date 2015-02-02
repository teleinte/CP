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
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../admin/" id="administracion"><img src="../images/configuracion.png" /><h6>Administración</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../calendario/" id="calendario"><img src="../images/calendario.png" /><h6>Calendario</h6></a></div></div></div>')                                
                            }
                            else if (endata[i]==3)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../tarea/" id="tarea"><img src="../images/tareas.png" /><h6>Tareas</h6></a></div></div></div>')                                
                            }
                            else if (endata[i]==4)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../evento/" id="eventos"><img src="../images/consejo.png" /><h6>Eventos</h6></a></div></div></div>')
                            }
                            else if (endata[i]==5)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../encuesta/" id="encuestas"><img src="../images/encuestas.png" /><h6>Encuestas</h6></a></div></div></div>')                                     
                            }
                            else if (endata[i]==6)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../cartelera/" id="cartelera"><img src="../images/cartelera.png" /><h6>Cartelera</h6></a></div></div></div>')
                            }
                            else if (endata[i]==7)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../parqueadero/" id="parqueadero"><img src="../images/parqueaderos.png" /><h6>Parqueaderos</h6></a></div></div></div>')
                            }
                            else if (endata[i]==8)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../reservas/" id="reserva"><img src="../images/cartelera.png" /><h6>Reservas</h6></a></div></div></div>')                                
                            }
                        }
                    });
                    </SCRIPT>                    