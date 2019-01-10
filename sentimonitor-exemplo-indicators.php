<?php
// Para mais detalhes, ver documentação do Sentimonitor em: https://www.sentimonitor.com/docs/pt-br/dev/

/*
Lista de filtros possíveis

Ver descrição completa na do Sentimonitor
$aFiltros = array (
    "monitorings" => "", // obrigatório
    "start" => "", // obrigatório
    "end" => "", // obrigatório
    "sources" => "",
    "viewSource" => "",
    "query" => "",
    "authorName" => "",
    "authorAbout" => "",
    "sentiments" => "",
    "languages" => "",
    "tags" => "",
    "ignoreTags" => "",
    "tagExpression" => "",
    "authors" => "",
    "authorTags" => "",
    "onlyVerifiedAuthors" => "",
    "onlyWithPersonalUrl" => "",
    "contributors" => ""
);
*/

$aFiltros = array (
    "monitorings" => "2576,4954", // *obrigatório* - ver o método "monitorings" na documentação - exemplo de implementação em "sentimonitor-exemplo-monitorings.php"
    "start" => "2018-12-30 00:00", // *obrigatório* - data inicial da pesquisa
    "end" => "2018-12-30 13:15" // *obrigatório* - data final da pesquisa
);

$sKey    = "<sua-api-key>"; // Fornecida pelo suporte do Sentimonitor
$sEmail  = "<seu-e-mail>"; // E-mail do seu login
$sAuth   = base64_encode($sEmail . ":" . $sKey); // Ver detalhes sobre a autenticação na documentação
$aHeader = array("Authorization: Basic " . $sAuth);

$oComm   = curl_init("https://app.sentimonitor.com/api/4.0/indicators?" . http_build_query($aFiltros));

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
        <title>Exemplo de Integração com Sentimonitor - Indicators</title>
    </head>
    <body>
        <b>Resultados retornados:</b>
        <br><br>
        <table>
            <tr>
                <th>Indicator</th>
                <th>Dados do indicator</th>
            </tr>
            <?php
            foreach ($oRetorno->indicators as $iIndex => $oData) {
                ?>
                <tr>
                    <td>
                        <?php
                        echo $iIndex + 1;
                        ?>
                    </td>
                    <td>
                        <?php
                        print_r($oData);
                        ?>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
