// function enviarData(datos)
// {
// 	if(datos != null || datos != undefined)
//   {
// 		if(datos.length > 0)
//       var contador=0;
// 			$.each(datos,function(x,y){      
      
//         var variable = cleanUpSpecialChars(y['nombre'])+"|"+cleanUpSpecialChars(y['apellido'])+"|"+y['email']+"|"+y['telefono'];
//         var token = creaToken(variable);
//         envioCorreo(y['email'], token, y['nombre'], y['apellido']);
//         contador++;
      
//     });
//       alert("Se han enviado " +contador+ " correos");
//   }

// }

function enviarData()
{
  // Nombre  Apellido  EMAIL Telefono
  // Luz Mireya  Gamez luzmireyagamezcastillo@gmail.com  3133972202
  // William Velandia  edificioagoraph@gmail.com 2451217
  var variable = cleanUpSpecialChars("Luz Mireya")+"|"+cleanUpSpecialChars("Gamez")+"|"+"jgil@teleinte.com"+"|"+"3014641858";
  var token = creaToken(variable);
  envioCorreo("jgil@teleinte.com", token, "Luz Mireya", "Gamez");
}

 function creaToken(datos)
{
  var token = btoa(datos);
  return token;
}
function envioCorreo(email, token, nombre, apellido)
{
  var link = "https://appdes.copropiedad.co/registrese/index.php?tknp="+token;
  var body = '<p><img src="https://appdes.copropiedad.co/api/services/images.php?user='+email+'&color=f51e7c" width=1 />Estimado(a) <strong>'+nombre+' '+apellido+'</strong>:<br/><br/>En días pasados  usted ingresó a www.copropiedad.co y se inscribió para ser uno de los primeros usuarios de Copropiedad.co. Nos complace informar que desde el 23 de julio pasado iniciamos operaciones en Colombia.<br/><p align="center"><strong>¿Qué es Copropiedad.co?</strong></p>Es un sistema de información gerencial que agrupa diferentes herramientas adaptadas para apoyar el trabajo del administrador de propiedades horizontales.<br/><br/>Características:<br/><ul> <li><strong>Manejo del tiempo</strong>, permite al administrador organizar actividades, responsabilidades y prioridades;</li><li><strong>Gestión en línea</strong>, posibilita el acceso a la información y a herramientas integradas de manejo y control de la administración  en cualquier momento y desde cualquier lugar;</li><li><strong>Comunicación</strong>, gestiona la comunicación hacia los residentes de manera fluida y transparente;</li><li><strong>Colaboración</strong>, proporciona herramientas que incrementan la interacción con los residentes.</li></ul><br/>Para obtener más detalles sobre Copropiedad.co, puede visitar nuestro <a href="www.copropiedad.co" >sitio web </a>o enviarnos un correo electrónico a info@copropiedad.co.<br/><br/><strong>Pulse el botón para continuar el proceso de registro y recibir el demo de 90 días.</strong><br/><br/><a href="'+link+'" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">Continuar registro</a>';
  var to = email;
  enviocorreoSync(to, "Copropiedad.co", body, "https://appdes.copropiedad.co/","peregristro");  
}

function cleanUpSpecialChars(str)
{
    str = str.replace(/[Á]/g,"A");
    str = str.replace(/[á]/g,"a");
    str = str.replace(/[É]/g,"E");
    str = str.replace(/[é]/g,"e");
    str = str.replace(/[Í]/g,"I");
    str = str.replace(/[í]/g,"i");
    str = str.replace(/[Ó]/g,"O");
    str = str.replace(/[ó]/g,"o");
    str = str.replace(/[Ú]/g,"U");
    str = str.replace(/[ú]/g,"u");
    str = str.replace(/[Ñ]/g,"N");
    str = str.replace(/[ñ]/g,"n");
    return str.replace(/[^a-z0-9]/gi,''); // final clean up
}