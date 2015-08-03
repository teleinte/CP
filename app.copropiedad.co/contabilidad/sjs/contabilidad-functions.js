function buscarPuc(datos)
{
  if(datos==null)
  {
      var rutaAplicatico = traerDireccion()+"api/";  
      var arr={token:sessionStorage.getItem('token'),body:{id_copropiedad : sessionStorage.getItem('cp'),tipo_documento : "puc",puc : [{cuenta:"1",nombre:"Activo",editar:false,agregar:false},{cuenta:"11",nombre:"Disponible",editar:false,agregar:false},{cuenta:"1105",nombre:"Caja",editar:false,agregar:true},{cuenta:"110505",nombre:"Caja general",editar:true,agregar:true},{cuenta:"110510",nombre:"Cajas menores",editar:true,agregar:true},{cuenta:"1110",nombre:"Bancos",editar:false,agregar:true},{cuenta:"1120",nombre:"Cuentas de ahorro",editar:false,agregar:true},{cuenta:"112005",nombre:"Bancos",editar:true,agregar:true},{cuenta:"112010",nombre:"Corporaciones de ahorro y vivienda",editar:true,agregar:true},{cuenta:"12",nombre:"Inversiones",editar:false,agregar:false},{cuenta:"1205",nombre:"Acciones",editar:false,agregar:true},{cuenta:"1215",nombre:"Bonos",editar:false,agregar:true},{cuenta:"1220",nombre:"Cedulas",editar:false,agregar:true},{cuenta:"1225",nombre:"Certificados",editar:false,agregar:true},{cuenta:"1230",nombre:"Papeles comerciales",editar:false,agregar:true},{cuenta:"1235",nombre:"Titulos",editar:false,agregar:true},{cuenta:"1240",nombre:"Aceptaciones bancarias o financieras",editar:false,agregar:true},{cuenta:"1245",nombre:"Derechos fiduciarios",editar:false,agregar:true},{cuenta:"1250",nombre:"Derechos de recompra de inversiones negociadas (repos)",editar:false,agregar:true},{cuenta:"1255",nombre:"Obligatorias",editar:false,agregar:true},{cuenta:"1260",nombre:"Cuentas en participacion",editar:false,agregar:true},{cuenta:"1295",nombre:"Otras inversiones",editar:false,agregar:true},{cuenta:"1299",nombre:"Provisiones",editar:false,agregar:true},{cuenta:"13",nombre:"Deudores",editar:false,agregar:false},{cuenta:"1305",nombre:"Clientes",editar:false,agregar:true},{cuenta:"130505",nombre:"Nacionales",editar:true,agregar:true},{cuenta:"1310",nombre:"Cuentas corrientes comerciales",editar:false,agregar:true},{cuenta:"1345",nombre:"Ingresos por cobrar",editar:false,agregar:true},{cuenta:"14",nombre:"Inventarios",editar:false,agregar:false},{cuenta:"1415",nombre:"Obras de construccion en curso",editar:false,agregar:true},{cuenta:"1450",nombre:"Terrenos",editar:false,agregar:true},{cuenta:"15",nombre:"Propiedades planta y equipo",editar:false,agregar:false},{cuenta:"1504",nombre:"Terrenos",editar:false,agregar:true},{cuenta:"1508",nombre:"Construcciones en curso",editar:false,agregar:true},{cuenta:"1516",nombre:"Construcciones y edificaciones",editar:false,agregar:true},{cuenta:"1520",nombre:"Maquinaria y equipo",editar:false,agregar:true},{cuenta:"1524",nombre:"Equipo de oficina",editar:false,agregar:true},{cuenta:"1528",nombre:"Equipo de computacion y comunicacion",editar:false,agregar:true},{cuenta:"1592",nombre:"Depreciacion acumulada",editar:false,agregar:true},{cuenta:"17",nombre:"Diferidos",editar:false,agregar:false},{cuenta:"1705",nombre:"Gastos pagados por anticipado",editar:false,agregar:true},{cuenta:"1710",nombre:"Cargos diferidos",editar:false,agregar:true},{cuenta:"2",nombre:"Pasivo",editar:false,agregar:false},{cuenta:"21",nombre:"Obligaciones financieras",editar:false,agregar:false},{cuenta:"2105",nombre:"Bancos nacionales",editar:false,agregar:true},{cuenta:"2125",nombre:"Corporaciones de ahorro y vivienda",editar:false,agregar:true},{cuenta:"22",nombre:"Proveedores",editar:false,agregar:false},{cuenta:"2205",nombre:"Nacionales",editar:false,agregar:true},{cuenta:"23",nombre:"Cuentas por pagar",editar:false,agregar:false},{cuenta:"2335",nombre:"Costos y gastos por  pagar",editar:false,agregar:true},{cuenta:"2365",nombre:"Retencion en la fuente",editar:false,agregar:true},{cuenta:"236505",nombre:"Salarios y pagos laborales",editar:true,agregar:true},{cuenta:"236525",nombre:"Servicios",editar:true,agregar:true},{cuenta:"2367",nombre:"Impuesto a las ventas retenido",editar:false,agregar:true},{cuenta:"2368",nombre:"Impuesto de industria y comercio retenido",editar:false,agregar:true},{cuenta:"2370",nombre:"Retenciones y aportes de nomina",editar:false,agregar:true},{cuenta:"237005",nombre:"Aportes al i.s.s.",editar:true,agregar:true},{cuenta:"237006",nombre:"Aportes a administradoras de riesgos profesionales - ARP",editar:true,agregar:true},{cuenta:"237010",nombre:"Aportes al i.c.b.f., sena y cajas de compensacion",editar:true,agregar:true},{cuenta:"237015",nombre:"Aportes al f.i.c.",editar:true,agregar:true},{cuenta:"2380",nombre:"Acreedores varios",editar:false,agregar:true},{cuenta:"24",nombre:"Impuestos, gravamenes y tasas",editar:false,agregar:false},{cuenta:"2408",nombre:"Impuesto sobre las ventas por pagar",editar:false,agregar:true},{cuenta:"2412",nombre:"De industria y comercio",editar:false,agregar:true},{cuenta:"25",nombre:"Obligaciones laborales",editar:false,agregar:false},{cuenta:"2505",nombre:"Salarios por pagar",editar:false,agregar:true},{cuenta:"26",nombre:"Pasivos estimados y provisiones",editar:false,agregar:false},{cuenta:"2610",nombre:"Para obligaciones laborales",editar:false,agregar:true},{cuenta:"261005",nombre:"Cesantias",editar:true,agregar:true},{cuenta:"261010",nombre:"Intereses sobre cesantias",editar:true,agregar:true},{cuenta:"261015",nombre:"Vacaciones",editar:true,agregar:true},{cuenta:"261020",nombre:"Prima de servicios",editar:true,agregar:true},{cuenta:"2695",nombre:"Provisiones diversas",editar:false,agregar:true},{cuenta:"27",nombre:"Diferidos",editar:false,agregar:false},{cuenta:"2705",nombre:"Ingresos recibidos por anticipado",editar:false,agregar:true},{cuenta:"270505",nombre:"Intereses",editar:true,agregar:true},{cuenta:"3",nombre:"Patrimonio",editar:false,agregar:false},{cuenta:"31",nombre:"Capital social",editar:false,agregar:false},{cuenta:"3105",nombre:"Capital suscrito y pagado",editar:false,agregar:true},{cuenta:"3115",nombre:"Aportes sociales",editar:false,agregar:true},{cuenta:"33",nombre:"Reservas",editar:false,agregar:false},{cuenta:"3305",nombre:"Reservas obligatorias",editar:false,agregar:true},{cuenta:"330505",nombre:"Reserva legal",editar:true,agregar:true},{cuenta:"4",nombre:"Ingresos",editar:false,agregar:false},{cuenta:"41",nombre:"Operacionales",editar:false,agregar:false},{cuenta:"4170",nombre:"Otras actividades de servicios comunitarios, sociales y personales",editar:false,agregar:true},{cuenta:"417010",nombre:"Actividades de asociacion",editar:true,agregar:true},{cuenta:"417011",nombre:"Fondo de imprevistos",editar:true,agregar:true},{cuenta:"42",nombre:"No operacionales",editar:false,agregar:false},{cuenta:"4210",nombre:"Financieros",editar:false,agregar:true},{cuenta:"421005",nombre:"Intereses",editar:true,agregar:true},{cuenta:"42100501",nombre:"Intereses deudores",editar:true,agregar:true},{cuenta:"42100502",nombre:"Intereses inversiones",editar:true,agregar:true},{cuenta:"4295",nombre:"Diversos",editar:false,agregar:true},{cuenta:"5",nombre:"Gastos",editar:false,agregar:false},{cuenta:"51",nombre:"Operacionales de administracion",editar:false,agregar:false},{cuenta:"5105",nombre:"Gastos de personal",editar:false,agregar:true},{cuenta:"510506",nombre:"Sueldos",editar:false,agregar:true},{cuenta:"510527",nombre:"Auxilio de transporte",editar:true,agregar:true},{cuenta:"510530",nombre:"Cesantias",editar:true,agregar:true},{cuenta:"510533",nombre:"Intereses sobre cesantias",editar:true,agregar:true},{cuenta:"510536",nombre:"Prima de servicios",editar:true,agregar:true},{cuenta:"510539",nombre:"Vacaciones",editar:true,agregar:true},{cuenta:"510569",nombre:"Aportes al i.s.s",editar:true,agregar:true},{cuenta:"510570",nombre:"Aportes afondos de pensiones y/o cesantias",editar:true,agregar:true},{cuenta:"5130",nombre:"Seguros",editar:false,agregar:true},{cuenta:"5135",nombre:"Servicios",editar:false,agregar:true},{cuenta:"513505",nombre:"Aseo y vigilancia",editar:true,agregar:true},{cuenta:"513510",nombre:"Temporales",editar:true,agregar:true},{cuenta:"513515",nombre:"Asistencia tecnica",editar:true,agregar:true},{cuenta:"513525",nombre:"Acueducto y alcantarillado",editar:true,agregar:true},{cuenta:"513530",nombre:"Energia electrica",editar:true,agregar:true},{cuenta:"513535",nombre:"Telefono",editar:true,agregar:true},{cuenta:"513555",nombre:"Gas",editar:true,agregar:true},{cuenta:"5145",nombre:"Mantenimiento y reparaciones",editar:false,agregar:true},{cuenta:"514505",nombre:"Terrenos",editar:true,agregar:true},{cuenta:"514515",nombre:"Maquinaria y equipo",editar:true,agregar:true},{cuenta:"514520",nombre:"Equipo de oficina",editar:true,agregar:true},{cuenta:"514525",nombre:"Equipo de computacion y comunicacion",editar:true,agregar:true},{cuenta:"514550",nombre:"Flota y equipo aereo",editar:true,agregar:true},{cuenta:"5150",nombre:"Adecuacion e instalacion",editar:false,agregar:true},{cuenta:"515005",nombre:"Instalaciones electricas",editar:true,agregar:true},{cuenta:"515010",nombre:"Arreglos ornamentales",editar:true,agregar:true},{cuenta:"515015",nombre:"Reparaciones locativas",editar:true,agregar:true},{cuenta:"515095",nombre:"Otros",editar:true,agregar:true},{cuenta:"5160",nombre:"Depreciaciones",editar:false,agregar:true},{cuenta:"516010",nombre:"Maquinaria y equipo",editar:true,agregar:true},{cuenta:"5195",nombre:"Diversos",editar:false,agregar:true},{cuenta:"519520",nombre:"Gastos de representacion y relaciones publicas",editar:true,agregar:true},{cuenta:"519520",nombre:"Gastos de representacion y relaciones publicas",editar:true,agregar:true},{cuenta:"519525",nombre:"Elementos de aseo y cafeteria",editar:true,agregar:true},{cuenta:"519530",nombre:"Utiles, papeleria y fotocopias",editar:true,agregar:true},{cuenta:"519595",nombre:"Otros",editar:true,agregar:true},{cuenta:"5199",nombre:"Provisiones",editar:false,agregar:true},{cuenta:"519905",nombre:"Inversiones",editar:true,agregar:true},{cuenta:"53",nombre:"No operacionales",editar:false,agregar:false},{cuenta:"5305",nombre:"Financieros",editar:false,agregar:true},{cuenta:"530505",nombre:"Gastos bancarios",editar:true,agregar:true},{cuenta:"6",nombre:"Costos de ventas",editar:false,agregar:false},{cuenta:"61",nombre:"Costo de ventas y de prestacion de servicios",editar:false,agregar:false},{cuenta:"6155",nombre:"Actividades inmobiliarias, empresariales y de alquiler",editar:false,agregar:true},{cuenta:"62",nombre:"Compras",editar:false,agregar:false},{cuenta:"6205",nombre:"De mercancias",editar:false,agregar:true}]}}      
      var generadorPuc = traerDatosSync("contabilidad/puc", arr);
      var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo_documento:"puc"}}; 
      var datos = traerDatosSync("contabilidad/obtener/puc/", arr);
      $.each(datos, function(x , y) 
      {
        $.each(y, function(a , b)
          {
              //alert(a+" ESTA ES DOS "+ b);
              if(a=="puc")
              {
                  sessionStorage.setItem('puc', JSON.stringify(b))
              }
          });
      });

  }
  else
  {
      $.each(datos, function(x , y) 
      {
        $.each(y, function(a , b)
          {
              //alert(a+" ESTA ES DOS "+ b);
              if(a=="puc")
              {
                  sessionStorage.setItem('puc', JSON.stringify(b))
              }
          });
      });
  }
}
function buscarCifras(datos)
{
  if(datos==null)
  {
      var arr ={token:sessionStorage.getItem('token'),body:{id_copropiedad : sessionStorage.getItem('cp'),tipo_documento:"consecutivos",cc:1,rc:1,fv:1,ce:1,nc:1,fc:1}};
      var generador = traerDatosSync("contabilidad/configuracion", arr);
  }  
}

function buscarCargos(datos)
{
  if(datos==null)
  {
      var arr = 
      {
        token:sessionStorage.getItem('token'),
        body:
        {
          id_copropiedad : sessionStorage.getItem('cp'),
          tipo_documento: "cargos_"+sessionStorage.getItem('cp'),
          estado: 1,
          cargo: "Administracion",
          Activo_Pasivo: "editar esta cuenta",
          cuenta_ingreso: "editar esta cuenta",
          identificador:"1"
        }
      }; 
      var url = "contabilidad/crearcargos/";
      envioFormularioSync(url,arr,'POST');

      var arr = 
      {
        token:sessionStorage.getItem('token'),
        body:
        {          
          id_copropiedad : sessionStorage.getItem('cp'),
          tipo_documento: "cargos_"+sessionStorage.getItem('cp'),
          estado: 1,
          cargo: "Cuota Extraordinaria",
          Activo_Pasivo: "editar esta cuenta",
          cuenta_ingreso: "editar esta cuenta",
          identificador:"2"
        }
      }; 
      var url = "contabilidad/crearcargos/";
      envioFormularioSync(url,arr,'POST');




  }  
}