                    <SCRIPT TYPE="text/javascript">
                    $(document).ready(function(e) {
                        if (sessionStorage.getItem('cp')!=null)
                        {
                            var arr = {token:sessionStorage.getItem('token'),body:{_id:sessionStorage.getItem('cp'),}};    
                            TraerModulosCopropiedad(arr,"copropiedad/getlistFilter", sessionStorage.getItem('cp'));
                        }
                        else
                        {
                            var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};    
                            TraerModulosCopropiedad(arr,"copropiedad/usuarioCopropiedad/rol/modulos/", parseInt(sessionStorage.getItem('id_crm')));                
                        }
                        var datos = JSON.stringify(sessionStorage.getItem("modulos"));
                        var endata =  JSON.parse(datos);
                        for (i in endata)
                        {                       
                            /*if(endata[i]==1)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../admin/admin.html" id="administracion"><img src="../images/configuracion.png" /><h6>Configuraciòn de la copropiedad</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/copropiedad/copropiedad.html" id="tarea"><img src="images/tareas.png" /><h6>Copropiedades</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/inmueble/inmueble.html" id="inmueble"><img src="images/tareas.png" /><h6>Inmuebles</h6></a></div></div></div>')
                                // $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="admin/usuario/usuario.html" id="usuarios"><img src="images/tareas.png" /><h6>Usuarios</h6></a></div></div></div>')
                            }
                            else if (endata[i]==2)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../tareas/tareas.html" id="tarea"><img src="../images/tareas.png" /><h6>Tareas del admninistrador</h6></a></div></div></div>')
                            }
                            else */
                            if (endata[i]==1)//3)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../cartelera/cartelera.html" id="cartelera"><img src="../images/cartelera.png" /><h6>Cartelera</h6></a></div></div></div>')
                                
                            }
                            else if (endata[i]==2)//4)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../calendario-copropiedad/" id="calendario"><img src="../images/calendario.png" /><h6>Calendario</h6></a></div></div></div>')                                     
                                
                            }
                            /*else if (endata[i]==5)
                            {
                                $('#aplicaciones').append('<div class="app"><div id="square"><div class="absoluto"><a href="../encuestas/encuestas.html" id="tarea"><img src="../images/encuestas.png" /><h6>Encuestas</h6></a></div></div></div>')
                            }*/
                        }
                    });
                    </SCRIPT>                    