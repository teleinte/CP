$(document).ready(function() {
    $(document).renderme('pe');
    if(sessionStorage.getItem('cp') != null || sessionStorage.getItem('cp') != undefined)
        var payu = (sessionStorage.getItem('cp')).toString(16).toUpperCase();
    traerDatosPagos(traerReferencias());

    $("#referalcode").html(obtenerTerminoLenguage('pe','32') + sessionStorage.getItem('id_crm'));

    $("#pagar").click(function(){
        window.location="pagos.php";
    });

    $("#pagar").click(function(){
        window.location="pagos.php";
    });
    $("#numcop").html(obtenerTerminoLenguage('pe','43'))
    $(".shop").click(function(){
        var cntid = $(this).attr('cnt');
        var des = 2;
        var per = 0.08;
        if($(this).attr('act') == "rem")
        {
            if($(this).attr('vencido') == "true")
            {
                $("#prod" + cntid).removeClass();
                $("#prod" + cntid).addClass("alert-error");
            }
            else
            {   
                $("#prod" + cntid).removeClass();
            }

            $(".shop" + cntid).show();
            $(this).attr('act','add');
            $("#numcop").html(Number($("#numcop").html()) - 1);
            $("#totpag").attr('total', Number($("#totpag").attr('total')) - Number($(this).attr('valor')));
            $("#totdes").attr('total', Number($("#totdes").attr('total')) - Number($(this).attr('dto')));
            var descu = Number($("#totdes").attr('total'));
            var actual = Number($("#totpag").attr('total'));
            var finalval = actual - descu;

            $("#val" + cntid).html(obtenerTerminoLenguage('pe','48'));
            $("#des" + cntid).html(obtenerTerminoLenguage('pe','48'));

            $("#totpag").html(accounting.formatMoney(finalval,"$",0));
            $("#totdes").html(accounting.formatMoney(descu,"$",0));
            
            var items = sessionStorage.getItem('shop');
            var cart = items.substring(0, items.length - 1).split("^");
            var remove = $(this).attr("idcp") + "@" + $(this).attr('ref') + "@" + $(this).attr('valor') + "@" + $(this).attr('nombre') + "@" + $(this).attr('vigencia');

            cart = jQuery.grep(cart, function(value) {
              return value != remove;
            });
            
            sessionStorage.setItem('shop',cart.join("^") + "^");
            if(sessionStorage.getItem('shop') == "^")
                sessionStorage.removeItem('shop');

            //console.log(sessionStorage.getItem('shop'));
            $(this).val($(this).attr('vigencia'));
        }
        else
        {
            $("#prod" + cntid).removeClass();
            $("#prod" + cntid).addClass("alert-success");
            $(".shop" + cntid).hide();
            $(this).show();
            $(this).attr('act','rem');
            $("#numcop").html(Number($("#numcop").html()) + 1);
            $("#totpag").attr('total', Number($("#totpag").attr('total')) + Number($(this).attr('valor')));
            $("#totdes").attr('total', Number($("#totdes").attr('total')) + Number($(this).attr('dto')));
            
            var descu = Number($("#totdes").attr('total'));
            var actual = Number($("#totpag").attr('total'));
            var finalval = actual - descu;

            $("#totpag").html(accounting.formatMoney(finalval,"$",0));
            $("#totdes").html(accounting.formatMoney(descu,"$",0));

            //var vactual = Number($(this).attr('valor'));
            $("#val" + cntid).html(accounting.formatMoney($(this).attr('valor'),"$",0));
            $("#des" + cntid).html(accounting.formatMoney($(this).attr('dto'),'$',0));

            if(sessionStorage.getItem("shop") === null || sessionStorage.getItem("shop") === undefined)
            {   
                var item = $(this).attr("idcp") + "@" + $(this).attr('ref') + "@" + $(this).attr('valor') + "@" + $(this).attr('nombre') + "@" + $(this).attr('vigencia') + "^";
                sessionStorage.setItem('shop',item);
            }
            else
            {
                var items = sessionStorage.getItem('shop');
                var item = $(this).attr("idcp") + "@" + $(this).attr('ref') + "@" + $(this).attr('valor') + "@" + $(this).attr('nombre') + "@" + $(this).attr('vigencia') + "^";
                sessionStorage.setItem('shop',items + item);
            }
            $(this).val("(" + $(this).attr('vigencia') + ") " + obtenerTerminoLenguage('pe','49'));

        }
    });

    $("#pagar").click(function(){
        window.location = "confirmar-pago.php";
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