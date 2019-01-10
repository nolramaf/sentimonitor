<?php
// Para mais detalhes, ver documentação do Sentimonitor em: https://www.sentimonitor.com/docs/pt-br/dev/

$sKey    = "<sua-api-key>"; // Fornecida pelo suporte do Sentimonitor
$sEmail  = "<seu-e-mail>"; // E-mail do seu login
$sAuth   = base64_encode($sEmail . ":" . $sKey); // Ver detalhes sobre a autenticação na documentação
$aHeader = array("Authorization: Basic " . $sAuth);

$oComm   = curl_init("https://app.sentimonitor.com/api/4.0/monitorings");

curl_setopt($oComm, CURLOPT_HTTPHEADER, $aHeader);
curl_setopt($oComm, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($oComm, CURLOPT_TIMEOUT, 30);
curl_setopt($oComm, CURLOPT_SSL_VERIFYPEER, TRUE);
curl_setopt($oComm, CURLOPT_HTTPGET, 1);

$sRetorno = curl_exec($oComm);
$oRetorno = json_decode($sRetorno);

if (empty($oRetorno) || isset($oRetorno->errors))
	die("<b>Erro:</b>" . $oRetorno->errors[0]->message);
?>
<html>
    <head>
        <title>Exemplo de Integração com Sentimonitor - Monitorings</title>
    </head>
    <body>
        <b>Resultados retornados:</b><br><br>
        <?php
        foreach ($oRetorno->monitorings as $iIndex => $oData) {
            echo $oData->id . " - " . $oData->title . " <i>(Status: " . $oData->status . ")</i>";
            echo "<br>";
        }
        ?>
  </body>
</html>
