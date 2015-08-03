<!-- JAVASCRIPT -->
    <!-- LIBRERIAS -->
        <!-- VERIFICACION DE SESION -->
        <script type="text/javascript" src="../../template/js/copropiedad-session.js"></script>

        <!-- JQUERY -->
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
        <script type="text/javascript" src="../../template/js/jquery.min.js"></script>

        <!-- JQUERY UI -->
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>-->
        <script type="text/javascript" src="../../template/js/jquery-ui.js"></script>

        <!-- ACCOUNTING.JS -->
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>-->
        <script type="text/javascript" src="../../template/js/jquery.accounting.min.js"></script>

        <!-- CHOSEN -->
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>-->
        <script type="text/javascript" src="../../template/js/jquery.chosen.min.js"></script>
        
        <!-- RenderMe -->
        <script type="text/javascript" src="../../template/js/jquery.renderme.js"></script>

        <!-- Qtip -->
        <script type="text/javascript" src="../../template/js/jquery.qtip.min.js"></script>
        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.1/basic/jquery.qtip.min.css"></script>-->

        <!-- Script selector de copropiedad -->
        <!--<script type="text/javascript" src="../template/js/jquery-dd.min.js"></script>-->
        
        <!-- Selector para cambiar las hojas de estilo -->
        <!--<script type="text/javascript" src="../template/js/stylesheet-switcher-1.min.js"></script>-->
        
        <!-- jquery alertas acción de cerrar y con html -->
        <script type="text/javascript" src="../../template/js/alertas.min.js"></script>
        <script type="text/javascript" src="../../template/js/jquery.bsAlerts.min.js"></script>

        <!-- COPROPIEDAD START -->
        <script type="text/javascript" src="../../template/js/copropiedad-start.js"></script>

        <!-- COPROPIEDAD FUNCTIONS -->
        <script type="text/javascript" src="../../template/js/copropiedad-functions.js"></script>

        <!-- COPROPIEDAD VALIDATION -->
        <script type="text/javascript" src="../../template/js/copropiedad-validation.js"></script>

        <!-- MODERNIZR -->
        <script type="text/javascript" src="../../template/js/modernizr.min.js"></script>
    <!-- FIN LIBRERIAS -->
    <!-- CODIGO -->
      <script type="text/javascript">
        $(document).ready(function(){
          /* ------- INICIO PANELES BARRA COPROPIEDAD -------- */
            /*$("#nuevos").click(function(){
              $("#new-panel").toggle("fast");
              $(this).toggleClass("active");
              return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#new-panel').length) {
              if($('#new-panel').is(":visible")) {
                $('#new-panel').hide();
                $('#nuevos').toggleClass("active");
                }
              }        
            });
            $("#aplicaciones").click(function(){
              $("#app-panel").toggle("fast");
              $(this).toggleClass("active");
              return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#app-panel').length) {
              if($('#app-panel').is(":visible")) {
                $('#app-panel').hide();
                $('#aplicaciones').toggleClass("active");
                }
              }        
            });*/
            $("#pendientes").click(function(){
              $("#pending-panel").toggle("fast");
              $(this).toggleClass("active");
              return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#pending-panel').length) {
              if($('#pending-panel').is(":visible")) {
                $('#pending-panel').hide();
                $('#pendientes').toggleClass("active");
                }
              }        
            });
          /* ------- FIN PANELES BARRA COPROPIEDAD --------*/

          /* ------- INICIO QTIP -------*/
            $( ".tooltip[title!='']" ).qtip({
              position: {
                my: 'left center',
                    at: 'right center',
                viewport: $(window), //para correr el tooltip si no cabe en la pantalla
                adjust: {
                  method: 'flip invert' //método de ajuste si no cabe en la pantalla
                }
                  },
              style: {
                    tip: {
                        corner: true
                    }
                }
            });
            $( ".tooltip-boton[title!='']" ).qtip({
              position: {
                my: 'top center',
                    at: 'bottom center',
                    viewport: $(window), //para correr el tooltip si no cabe en la pantalla
                adjust: {
                  method: 'flip invert' //método de ajuste si no cabe en la pantalla
                }
                  },
              style: {
                    tip: {
                        corner: false
                    }
                }
            });
          /* ------- FIN QTIP --------/

          /* ------- INICIO CHOSEN COPROPIEDADES -------*/
            /*$("#copropiedad").msDropdown({on:{change:function(data, ui) {
              var val = data.value;
              if(val!="")
                window.open(val,'_parent');
              }}}).data("dd");
            $("#ver").html(msBeautify.version.msDropdown);

            cambioEstilos();
            
            $(".selector-copropiedad li").click(function() {
              cambioEstilos();
            });*/
          /* ------- FIN CHOSEN COPROPIEDAD --------*/

          /* ----- INICIO AYUDA -----*/
          //$(".breadcrumb").append('<div class="floatright"><a href="#" class="btn" teid="ge:html:4"><i class="fa fa-question-circle fa-fw fa-lg"></i>&nbsp;</a></div>');
          /* ----- FIN AYUDA -----*/
        });
      </script>
    <!-- FIN CODIGO -->
    <!-- TRACKING -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-64401921-1', 'auto');
      ga('send', 'pageview');

    </script>
    <!-- FIN TRACKING -->
  <!-- FIN JAVASCRIPT -->