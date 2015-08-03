<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include('Pagoclase.php');?>
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->
<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<?php include("../template/js.inc");?>
<script src="js/copropiedad-pagos-confirmar.js">//envio datos</script>
<script src="js/md5-min.js"></script>
<?php include("templates/mcopropiedad.php"); ?> 
<!-- Script selector de copropiedad -->
<script src="../js/jquery-dd.js"></script>
<script>
  $(document).ready(function(e) {  
    //no use
    try {      
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          if (val=="Nueva"){window.open('../copropiedad/copropiedad-nuevodos.php','_parent');}
          else{sessionStorage.setItem("cp", val)
            javascript:location.reload()  
          }           
        }
      }}}).data("dd");
    } catch(e) {
      //console.log(e); 
    }
    $("#ver").html(msBeautify.version.msDropdown);
  });
</script>
<script>
  $(document).ready(function()
  {
    var cntid = $(this).attr('cnt');
    var des = 2;
    var per = 0.08;
    
    var items = sessionStorage.getItem('shop');
    var cart = items.substring(0, items.length - 1).split("^");
    var copropiedades=[];
    var referencias =[];
    var montos=[];
    var ncps=[];

    //console.log(cart);
    $(description).val('');
    $.each(cart,function(k,v)
    {
      $("#copropiedadescart").append('<tr><td>' + v.split("@")[3] + '</td><td>' + v.split("@")[4]+ '</td></tr>');
      $("#numcop").html(Number($("#numcop").html()) + 1);
      var actual = Number($("#totpag").attr('total')) + Number(v.split("@")[2]);
      $("#totpag").attr('total',actual);

      if(Number($("#numcop").html()) > des)
      {
        var total = actual - (actual * per);
        $("#totdes").html('$ ' + total.toLocaleString('es-CO', { style: 'currency', currency: 'COP'}));
        $('#amount').val(total);
      }
      else
      {
        $("#totdes").html("$ 0 COP");
        $('#amount').val(actual);
      }

      $("#totpag").html("$" + actual.toLocaleString('es-CO', { style: 'currency', currency: 'COP'}));

      copropiedades[k] = v.split("@")[0];
      referencias[k] = v.split("@")[1];
      montos[k] = v.split("@")[2];
      ncps[k]=v.split("@")[3];
      $(description).val($(description).val()+v.split("@")[0]+', '+v.split("@")[1]+', '+v.split("@")[2] +'; ');
    });
    sessionStorage.setItem('shop',cart.join("^") + "^");
    if(sessionStorage.getItem('shop') == "^")
        sessionStorage.removeItem('shop');

    
    $(this).val($(this).attr('vigencia'));

    $("#taxReturnBase").val(0);
    $("#tax").val(0);

    //var cpp= "170vp0cv81qjt3i8jslpjbunn6";
    var cpp= "6u39nqhq8ftd0hlvnjfs66eh8c";
    var refref = sessionStorage.getItem("token")+'~'+sessionStorage.getItem("shop")+'~'+'CC'+ Math.floor(Math.random()*100000000000000000)+'~';

    $("#referenceCode").val(hex_md5(refref));
    $("#buyerEmail").val(sessionStorage.getItem('email').split('cp-')[1]);

    var sstring=cpp+"~"+$("#merchantId").val()+"~"+$("#referenceCode").val()+"~"+$("#amount").val()+"~"+$('#currency').val();

    $("#signature").val(hex_md5(sstring));
    //$("#taxReturnBase").val(calculo[0]);

    var ParamFecha=fecha();

    //ARMA PAQUETE QUE SE ENVIA A BD

    $( "#target" ).submit(function( event ) 
    { 

      for (var i = 0; i < copropiedades.length; i++) 
      { 
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          { 
            id_crm_persona: sessionStorage.getItem('id_crm'),
            fecha_pago:ParamFecha,
            fecha_confirmacion:'',
            referencia_activa: referencias[i],
            valor:montos[i],
            id_copropiedad : copropiedades[i],
            ncp: ncps[i],
            cruzado:'0',
            email_pagador: $("#buyerEmail").val(),
            name_pagador: sessionStorage.getItem('nombreCompleto'),
            referenceCode:$('#referenceCode').val(),
            estado:'777',// Pendiente                           
            merchantId:$('#merchantId').val(),
            apikey:cpp,
            accountId:$('#accountId').val(),
            description:$('#description').val(),
            tax:$('#tax').val(),
            signature:$('#signature').val(),                        
            currency:$('#currency').val(),
            test:$('#test').val(),
            lng:$('#lng').val(),
            responseUrl:$('#responseUrl').val(),
            confirmationUrl:$('#confirmationUrl').val(),
            total_pago: $('#amount').val()
          }
        };
        var url = "pagosteleinte";
        alert(JSON.stringify(arr));
        envioFormulario(arr,url,'POST');
      };
    });
    //DA FORMATO A FECHA DE CREACION
    function fecha()
    {
      var d = new Date();
      var n = (d.getMonth() + 1) + "-" + d.getDate() + "-" + d.getFullYear()+"  "+d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds(); 
      return n;
    }  

  });
</script>
<!-- Selector para cambiar las hojas de estilo -->
<script src="../js/stylesheet-switcher.js"></script>
<!-- jquery alertas acción de cerrar y con html -->
<script src="../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../js/jquery.bsAlerts.js"></script>
<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="css/jquery.cleditor.css">
<script src="js/copropiedad-perfil-functions.js"></script>
<script src="js/jquery.minicart.js"></script>
<style>
  .tcheckout 
  {
    display: table;
    margin:5px 0 15px 0;
    color: #333;
    font-family: Frutiger, 'Frutiger Linotype', Univers, Calibri, 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', Myriad, 'DejaVu Sans Condensed', 'Liberation Sans', 'Nimbus Sans L', Tahoma, Geneva, 'Helvetica Neue', Helvetica, Arial, sans-serif;
  }

  .tchcheckout 
  {
    display: table-cell;
    width: 20%;
    font-weight: bolder;
    font-size: 15px;
    text-align:center;
    vertical-align:middle;
  }

  .totcheckout 
  {
    display: table-cell;
    width: 20%;
    font-weight: bolder;
    font-size: 15px;
    text-align:right;
    vertical-align:middle;
  }

  .tccheckout 
  {
    display: table-cell;
    width: 20%;
    font-size: 14px;
  }

  div.ui-tooltip {
      max-width: 200px;
      font-size: small;
      text-align: center;
  }
</style>
</head>
<body>
  <?php
  include("../template/header.inc");
  ?>
    <div id="contenido-principal">
        <section id="central">
          <aside>
          <?php
          include("templates/aside.php");
          ?>           
          </aside>
          <div class="contenedor" id="gestion">
          <div class="titulo-principal"><h1 class="title">Confirmar Pago</h1></div>
          <div class="divcentrado">
            <div class="centrado">
            <h3> Va a realizar el siguiente pago, esta seguro? </h3>
              <table id="copropiedadescart" class="tcheckout">
                <tr>
                  <th class="tchcheckout">Copropiedad</th>
                  <th class="tchcheckout">Periodo de renovacion (meses)</th>
                </tr>
              </table>
              <div class="clearfix"></div>
              <div class="floatleft" style="text-align: left; width:48%;">
                  <div style="float:right"></div>
              </div>
              <div class="floatright" style="width:48%; text-align:right;">
                <div style="float:right">
                  <h3>Copropiedades a renovar: <span id="numcop" style="font-weight:bold;">0</span></h3>
                  <h3>Total a pagar: <span id="totpag" total="0" style="font-weight:bold;">0</span></h3>
                  <h3>Total con descuento: <span id="totdes" total="0" style="font-weight:bold; cursor: help;">0</span></h3>
                  <form id="target" method="post" action="https://stg.gateway.payulatam.com/ppp-web-gateway">
                    <?php
                      $ocultos= new objetoto;
                      $ocultos->construirFormOculto();
                    ?>
                    <input type="submit" id="pagar" value=" Iniciar proceso de pago " class="btn"/>
                  </form>
                </div>
              </div>
            </div>
          </div>
          </div>
          <div data-alerts="alerts" id ="alertas"></div>
        </section>
    </div>
</body>
<!--scripts selector con búsqueda como en http://harvesthq.github.io/chosen/-->
  <script src="../js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'No se encuentra'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
      </script>
</html>
