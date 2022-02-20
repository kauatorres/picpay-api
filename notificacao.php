<?php
date_default_timezone_set('America/Sao_Paulo');

// pega o corpo da requisição
$payload = json_decode(file_get_contents('php://input'), true);
// token
$picPayToken = 'SeuToken';
// monta a url
$url = 'https://appws.picpay.com/ecommerce/public/payments/'.$payload['referenceId'].'/status';
// inicializa o cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Picpay-Token: ' . $picPayToken
]);
$result = curl_exec($ch);
$linha = date('d/m/Y H:i:s') . ' - ' . $result . "\n";
//criamos o arquivo
$arquivo = fopen('Log.txt','w');
//verificamos se foi criado
if ($arquivo == false) die('Não foi possível criar o arquivo.');
fwrite($arquivo, $linha);
fclose($arquivo);

if (curl_errno($ch)) {
    die('Error: ' . curl_error($ch));
}
curl_close($ch);