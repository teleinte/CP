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
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/activar-usuario/" id="administracion"><img src="../../images/configuracion.png" /><h6>Activar Usuarios</h6></a></div></div></div>');
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/clientes/" id="contacto"><img src="../../images/cartelera.png" /><h6>Lista de clientes de Copropiedad</h6></a></div></div></div>');
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/copropiedad/" id="calendario"><img src="../../images/tareas.png" /><h6>Lista de Copropiedades</h6></a></div></div></div>')                                
                            }
                            else if (endata[i]==3)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/notificacion/" id="tarea"><img src="../images/reservas.png" /><h6>Notificaciones de la copropiedad</h6></a></div></div></div>')                                
                            }
                            else if (endata[i]==4)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/pagos/" id="eventos"><img src="../../images/contabilidad.png" /><h6>Listado de pagos a Copropiedad</h6></a></div></div></div>')
                            }
                            else if (endata[i]==5)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/referencias/" id="encuestas"><img src="../images/configuracion.png"/><h6>Referencias de pago para copropiedad</h6></a></div></div></div>')                                     
                            }
                            else if (endata[i]==6)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/usuarios_demo/" id="cartelera"><img src="../../images/consejo.png" /><h6>Usuarios en demo</h6></a></div></div></div>')
                            }
                            /*else if (endata[i]==7)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../parqueadero/" id="parqueadero"><img src="../images/parqueaderos.png" /><h6>Parqueaderos</h6></a></div></div></div>')
                            }*/
                            else if (endata[i]==8)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="/manager/usuarioscp/" id="reserva"><img src="../images/reservas.png" /><h6>Lista de usuarios de Copropiedad</h6></a></div></div></div>')                                
                            }
                        }
                    });
                    </SCRIPT>                    