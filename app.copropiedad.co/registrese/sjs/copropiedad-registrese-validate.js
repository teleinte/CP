$(document).ready(function() {
$("#registro_form").validate(
	{
	    rules: {
	        nombre: {required: true},
	        apellido: {required: true},
	        email: {required: true},
	        telefono: {required:true},
	        verificar: {required:true}
	    },
	    messages: {
	        nombre: "Escriba su nombre por favor",
	        apellido: "Escriba su apellido por favor",
	        email: "Escriba su correo por favor",
	        telefono : "Escriba su telefono por favor",
	        verificar: "Debe aceptar los terminos y condiciones"
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
	        password: "Escriba su contraseña por favor",
	        passwordconf: "Confirme su contraseña por favor"             
	    },
	    submitHandler: function(form){
		    envioFormularioPassword();
		    activarUsuarioIdle();
	    }
	});
$("#link_form").validate(
	{
	    rules: {
	        email: {required: true}
	    },
	    messages: {
	        email: "Escriba su correo por favor"             
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
	        email: "Escriba su correo por favor",
	        nombre: "Escriba su nombre por favor",	                    
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
	        password: "Escriba su contraseña por favor",
	        passwordconf: "Confirme su contraseña por favor"             
	    },
	    submitHandler: function(form){
		    envioFormularioPasswordCambio();
	    }
	});
});