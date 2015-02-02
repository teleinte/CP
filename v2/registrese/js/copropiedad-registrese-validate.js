$(document).ready(function() {
$("#registro_form").validate(
	{
	    rules: {
	        nombre: {required: true},
	        apellido: {required: true},
	        email: {required: true},
	        telefono: {required:true},
	        direccion: { required: true},
	        tipo: {required: true },
	        pais: {required: true },
	        ciudad: {required: true },
	        verif: {required: true, minlength: 2}
	    },
	    messages: {
	        nombre: "Escribe tu nombre por favor",
	        apellido: "Escribe tu apellido por favor",
	        email: "Escribe tu correo por favor",
	        telefono : "Escribe tu telefono por favor",
	        direccion: "escribe la direccion de hubicacion de la copropiedad",
	        tipo : "Selecciona el tipo de usuario por favor",
	        pais : "Selecciona el tipo de copropiedad por favor",
	        ciudad : "por favor seleccione la ciudad de hubicacion de la copropiedad",
	        verif : "Escribe el codigo correcto"
	    },
	    submitHandler: function(form){
		    envioFormulario();
	    }
	});
$("#activation_form").validate(
	{
	    rules: {
	        password: {required: true},
	        passwordconf: {required: true}
	    },
	    messages: {
	        password: "Escribe tu contraseña por favor",
	        passwordconf: "Confirma tu contraseña por favor"             
	    },
	    submitHandler: function(form){
		    envioFormularioPassword();
	    }
	});
$("#link_form").validate(
	{
	    rules: {
	        email: {required: true}
	    },
	    messages: {
	        email: "Escribe tu correo por favor"             
	    },
	    submitHandler: function(form){
		    envioFormularioLink();
	    }
	});
$("#cambio_form").validate(
	{
	    rules: {
	        email: {required: true},
	        nombre: {required: true}
	    },
	    messages: {
	        email: "Escribe tu correo por favor",
	        nombre: "Escribe tu nombre por favor",	                    
	    },
	    submitHandler: function(form){
		    envioFormularioCambio();
	    }
	});
$("#newpassword_form").validate(
	{
	    rules: {
	        password: {required: true},
	        passwordconf: {required: true}
	    },
	    messages: {
	        password: "Escribe tu contraseña por favor",
	        passwordconf: "Confirma tu contraseña por favor"             
	    },
	    submitHandler: function(form){
		    envioFormularioPasswordCambio();
	    }
	});
});