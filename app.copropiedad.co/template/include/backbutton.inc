<?php
$actual_link_s = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$div = "";
if(($actual_link_s == "https://appdes.copropiedad.co/inicio/") || ($actual_link_s == "https://appdes.copropiedad.co/inicio"))
{
	$div = '';
}
else
{
	$div = '<div style="margin-top:10px;" ><a href="https://appdes.copropiedad.co/inicio/" id="BackButtonMain" class="btn" teid="ms:html:1"></a></div>';
	//$div = '<div style="margin-top:10px;" ><a href="https://app.copropiedad.co/inicio/" id="BackButtonMain" class="btn" teid="ms:html:1"><img src="/template/images/icon-apps-escritorio.png" style="width:20px; height:auto;"/> &nbsp;</a></div>';
}
echo $div;
?>