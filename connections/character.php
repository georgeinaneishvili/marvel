<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
 if (isset($_GET['character-id'])) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $character_id = $_GET['character-id'];

  $ts = time();
  $public_key = '96bb9d58458eb5d8230c8775ae4b9ba3';
  $private_key = '1e553d0e643924341fa5c8eef1e44dff3f0a99e2';
  $hash = md5($ts . $private_key . $public_key);

  $query = array(
   'format' => 'comic',
   'formatType' => 'comic',
   'apikey' => $public_key,
   'ts' => $ts,
   'hash' => $hash,
  );

  curl_setopt($curl, CURLOPT_URL,
   "https://gateway.marvel.com:443/v1/public/characters/" . $character_id . "/comics" . "?" . http_build_query($query)
  );

  $result = json_decode(curl_exec($curl), true);

  curl_close($curl);

  echo json_encode($result);

 } else {
  echo "Character Id not defined";
 }
} else {
 echo "Error: wrong server.";
}