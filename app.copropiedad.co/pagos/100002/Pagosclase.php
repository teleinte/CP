<?php
class Pago
{
	//DECLARACION DE PROPIEDADES

	//Credenciales Prueba
	//private $merchantId="500238";
	//public $apikey="6u39nqhq8ftd0hlvnjfs66eh8c";
	//public $accountId="500538";
	//public $test="1";

	//Credenciales Produccion

	private $merchantId="512157";
	public $apikey="170vp0cv81qjt3i8jslpjbunn6";
	public $referenceCode; 
	public $description='Pago administracion del mes de mayo';
	public $taxReturnBase="";
	public $amount="52000";
	public $accountId="513411"; 
	public $tax="";
	public $partnerId="512157";
	public $signature_envio="";
	public $signature_response="";
	public $signature_confirmacion="";
	public $currency="COP";
	public $test="0";
	public $lng="es";
	public $responseUrl="https://app.copropiedad.co/pagos/100002/respuesta.php";
	public $confirmationUrl="https://app.copropiedad.co/pagos/100002/confirmacion.php";

	//DECLARACION DE METODOS
	public function construirFormOculto()
	{

		echo '<input type="hidden" id="merchantId" name="merchantId" value="'.$this->merchantId.'" >';
		echo '<input type="hidden" id="amount" name="amount" value="'.$this->amount.'" >';
		//echo '<input type="hidden" id="apikey" name="apikey" value="'.$this->apikey.'" >';
		echo '<input type="hidden" id="referenceCode" name="referenceCode" value="'.$this->referenceCode.'" >';
		echo '<input type="hidden" id="description" name="description" value="'.$this->description.'" >';
		echo '<input type="hidden" id="taxReturnBase" name="taxReturnBase" value="'.$this->taxReturnBase.'" >';
		echo '<input type="hidden" id="accountId" name="accountId" value="'.$this->accountId.'" >';
		echo '<input type="hidden" id="tax" name="tax" value="'.$this->tax.'" >';
		echo '<input type="hidden" id="partnerId" name="partnerId" value="'.$this->partnerId.'" >';
		echo '<input type="hidden" id="signature" name="signature" value="'.$this->signature_envio.'" >';
		echo '<input type="hidden" id="currency" name="currency" value="'.$this->currency.'" >';
		echo '<input type="hidden" id="test" name="test" value="'.$this->test.'" >';
		echo '<input type="hidden" id="lng" name="lng" value="'.$this->lng.'" >';
		echo '<input type="hidden" id="responseUrl" name="responseUrl" value="'.$this->responseUrl.'" >';
		echo '<input type="hidden" id="confirmationUrl" name="confirmationUrl" value="'.$this->confirmationUrl.'" >';
	
	}
	
	
}

	
?>