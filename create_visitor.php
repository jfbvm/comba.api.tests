<?php
function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Authorization:Token 4bf9a93635dce81720103a22fdf03170b70a3b08c215a6188bf6c444ebc26b29',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

$data_array =  array(
    "name"=> "Jack",
    "target"=> "Visitante",
    "purpose"=> "Conhecer a empresa",
    "company"=> "Visualbox",
    "phone"=> "133333333",
    "email"=> "user@test.com",
    "remark"=> "Novo visitante que vai ter acesso a empresa",
    "devices"=> array("1"),
    "photo"=> 41507,
    "periods"=> array(
        array(
            "day"=> "2019-06-12",
            "start"=> "16:40",
            "end"=> "18:40"
        )
    ),
    "own_by"=> 1
);
$make_call = callAPI('POST', 'https://scanvis-test.comba-telecom.com/api/v1/visitor/visitors/', json_encode($data_array));
$response = json_decode($make_call, true);
$errors   = $response['response']['errors'];
$data     = $response['response']['data'][0];


echo '<pre>'; print_r($response); echo '</pre>';
?>
