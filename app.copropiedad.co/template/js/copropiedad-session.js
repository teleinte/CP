var url = 'https://appdes.copropiedad.co';

if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))   
{
	if(sessionStorage.getItem('userflow') != 0)
	{
		sessionStorage.clear();
	    window.location = url;
	}    
}