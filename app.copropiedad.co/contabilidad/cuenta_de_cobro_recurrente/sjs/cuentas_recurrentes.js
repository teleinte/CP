$(document).ready(function() 
{
  $(document).renderme('co');
  $('.selector-copropiedad').html("<span class=titulo-cop><strong>"+ sessionStorage.getItem('ncp') +"</strong></span>");
  //$("#selcopropiedades").prop('disabled', true);
  $(".ttip").addClass("tooltip-boton");

  $("#alertas").append('<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong teid="ale:html:1"></strong><h4>Pasos para generar cuentas de cobro recurrentes </h4><br/><p><strong>1. Asignacion de cargos: </strong>Cree los cargos a facturar y asocie las cuentas contables respectivas.</p><p><strong>2. Asignacion de valores a los cargos: </strong>Asigne los valores de los cargos a los inmuebles correspondientes.</p><p><strong>3 Generar cuentas de cobro recurrentes: </strong>Con los cargos y los valores diligenciados, proceda a generar las cuentas de cobro para toda la copropiedad.</p></div>');

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