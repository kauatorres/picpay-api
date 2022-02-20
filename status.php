<?php
session_start();
error_reporting(0);

$produto = $_SESSION['produto'];
$horario = date('d.m.Y - H:i:s');
// recebe o código de referência por GET
if (empty($_GET) && !isset($_GET['referencia'])) {
    // aborta caso não tenha passado o código
    die('Forneça a refêrencia');
}


$picPayToken = 'SeuToken'; // Token PicPay
// monta a url
$url = 'https://appws.picpay.com/ecommerce/public/payments/'.$_GET['referencia'].'/status';
// inicializa o cURL
$ch = curl_init();
// fornece a url de destino
curl_setopt($ch, CURLOPT_URL, $url);
// passa o parâmetro para retornar a resposta
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// envia os headers obrigatórios
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Picpay-Token: ' . $picPayToken
]);
// REQUISIÇÃO
$result = curl_exec($ch);
// RESPOSTA
$resposta = json_decode($result);

//Função de adionar cash - liberar este serviço apos a compra ser aprovada
/*function add_cash($player, $total_cash){
     pg_query("UPDATE accounts SET money = money + '$total_cash' WHERE login = '$player'");
}*/

//RETORNO DE STATUS
if($resposta->status == "paid"){
    $resposta->status = "pago";
    /*add_cash($player, $qtd_cash);*/
}elseif ($resposta->status == "refunded") {
    $resposta->status = "<span style='color:red;'><i class='fa fa-times'></i> Compra cancelada.</span>";
}

curl_close($ch);

if ($resposta->authorizationId) { 
    exit($resposta->status);
}else{
    exit("<i class='fa fa-spinner fa-spin'></i> Aguardando pagamento");
}


