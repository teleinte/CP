  $(document).ready(function()
  {
    $(document).renderme('pe');

    var cntid = $(this).attr('cnt');
    
    var items = sessionStorage.getItem('shop');
    var cart = items.substring(0, items.length - 1).split("^");
    var copropiedades=[];
    var referencias =[];
    var montos=[];
    var ncps=[];
    var numco = 0;

    //console.log(cart);

    $("#description").val("Pago servicio suscripción a Copropiedad.co");
    if(cart != undefined || cart != null)
    $.each(cart,function(k,v)
    {
      if(v.split("@")[2] == "720000")
      {
        $("#copropiedadescart").append('<tr><td></td><td>' + v.split("@")[3] + '</td><td>' + v.split("@")[4]+ '</td><td>$ 120.000</td></tr>');
        //$("#totpag").attr('total',Number($("#totpag").attr('total')) + Number(v.split("@")[2]));
        $("#totpag").attr('total',Number($("#totpag").attr('total')) + Number(v.split("@")[2]) - Number($('#totdes').attr('total')));
        $("#totdes").attr('total',Number($("#totdes").attr('total')) + 120000);
      }
      else
      {
        $("#copropiedadescart").append('<tr><td></td><td>' + v.split("@")[3] + '</td><td>' + v.split("@")[4]+ '</td><td>$ 0</td></tr>');
        $("#totpag").attr('total',Number($("#totpag").attr('total')) + Number(v.split("@")[2]));
      }

      $("#totdes").html(accounting.formatMoney($('#totdes').attr('total'),"$",0));
      $("#totpag").html(accounting.formatMoney($('#totpag').attr('total') - $('#totdes').attr('total'),"$",0));

      copropiedades[k] = v.split("@")[0];
      referencias[k] = v.split("@")[1];
      montos[k] = v.split("@")[2];
      ncps[k]=v.split("@")[3];
      //alert(v.split("@")[0]);
      //alert(copropiedades);
      //$("#description").val($("#description").val()+v.split("@")[3].substr(0,15)+', '+v.split("@")[2] +'; ');
      numco ++;
    });

    $("#copropiedadescart").DataTable({
    columnDefs: [{
            className: 'control',
            orderable: false,
            targets:   0
        }],
    responsive: {
      details: {
                type: 'column'
      }
    },
    order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": obtenerTerminoLenguage('ta','20'),
      exclude: [ 0, 1 ],
      exclude: [ 0, 4 ]
    },
    "language": {
      "sProcessing":     obtenerTerminoLenguage('ta','2'),
      "sLengthMenu":     obtenerTerminoLenguage('ta','3'),
      "sZeroRecords":    obtenerTerminoLenguage('ta','4'),
      "sEmptyTable":     obtenerTerminoLenguage('ta','5'),
      "sInfo":           obtenerTerminoLenguage('ta','6'),
      "sInfoEmpty":      obtenerTerminoLenguage('ta','7'),
      "sInfoFiltered":   obtenerTerminoLenguage('ta','8'),
      "sInfoPostFix":    obtenerTerminoLenguage('ta','9'),
      "sSearch":         obtenerTerminoLenguage('ta','10'),
      "sUrl":            obtenerTerminoLenguage('ta','11'),
      "sInfoThousands":  obtenerTerminoLenguage('ta','12'),
      "sLoadingRecords": obtenerTerminoLenguage('ta','13'),
      "oPaginate": {
        "sFirst":    obtenerTerminoLenguage('ta','14'),
        "sLast":     obtenerTerminoLenguage('ta','15'),
        "sNext":     obtenerTerminoLenguage('ta','16'),
        "sPrevious": obtenerTerminoLenguage('ta','17')
      },
      "oAria": {
        "sSortAscending":  obtenerTerminoLenguage('ta','18'),
        "sSortDescending": obtenerTerminoLenguage('ta','19')
      }
        }
  });

    $("#numcop").html(numco);

    sessionStorage.setItem('shop',cart.join("^") + "^");
    if(sessionStorage.getItem('shop') == "^")
        sessionStorage.removeItem('shop');

    
    $(this).val($(this).attr('vigencia'));
    //alert($("#description").val());

    $("#taxReturnBase").val(0);
    $("#tax").val(0);

    var cpp= "170vp0cv81qjt3i8jslpjbunn6";
    //var cpp= "6u39nqhq8ftd0hlvnjfs66eh8c";
    var thispagototal = Number($('#totpag').attr('total')) - Number($('#totdes').attr('total'));
    $('#amount').val(thispagototal);
    //console.warn($('#totpag').attr('total'));
    var refref = sessionStorage.getItem("token")+'~'+sessionStorage.getItem("shop")+'~'+'CC'+ Math.floor(Math.random()*100000000000000000)+'~';

    $("#referenceCode").val(hex_md5(refref));
    $("#buyerEmail").val(sessionStorage.getItem('email').split('cp-')[1]);

    var sstring=cpp+"~"+$("#merchantId").val()+"~"+$("#referenceCode").val()+"~"+thispagototal+"~"+$('#currency').val();
    //alert(sstring);

    $("#signature").val(hex_md5(sstring));
    //$("#taxReturnBase").val(calculo[0]);

    //ARMA PAQUETE QUE SE ENVIA A BD

    $( "#target" ).submit(function( event ) 
    { 

      for (var i = 0; i < montos.length; i++) 
      { 
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          { 
            id_crm_persona: sessionStorage.getItem('id_crm'),
            fecha_pago:fecha(),
            fecha_confirmacion:'',
            referencia_activa: referencias[i],
            valor:montos[i],
            id_copropiedad : copropiedades[i],
            ncp: ncps[i],
            cruzado:obtenerTerminoLenguage('pe','43'),
            email_pagador: $("#buyerEmail").val(),
            name_pagador: sessionStorage.getItem('nombreCompleto'),
            referenceCode:$('#referenceCode').val(),
            estado: 'Pending',                          
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
            total_pago: $('#totpag').val()
          }
        };
        var url = "payu/pagar/teleinte";
        envioFormularioSync(url,arr,'POST');
      };
    });

    $("#regresar").click(function(){
      window.location = "mis-pagos.php";
    });

    $(document).renderme('pe');
    $(".ttip").addClass("tooltip-boton");

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
  });