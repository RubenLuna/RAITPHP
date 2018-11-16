<?php

//echo 'here';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST '); //GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json");

//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Max-Age: 86400');    // cache for 1 day


require_once('../includes/DbOperations.php');



$response = array();

$responseDB = array();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $email = $request->email;
    $password = $request->password;
    //$data = $_POST;
    //echo json_encode($data);
    //$email = $request->jsonRaitData;
    //echo json_encode($email);
    //echo json_encode(var_dump($_POST));



    if (($email != '' and $password != '')
      and
      (!empty($email) and !empty($password))
      and
      (!is_null($email) and !is_null($password))

    ) {

        //ok to go

        $db = new DbOperations();

        $responseDB = $db->fxLogin(
          $email,
          $password
        );

        if ($responseDB['error'] == false) {

          //$response['error'] = false;
            //$response['message'] = 'User has been login successfully';

            $responseDB['error'] = false;
            $responseDB['message'] = $responseDB['message'];
        } else {

          //$response['error'] = true;
            //$response['message'] = 'Some error occurred please try again';
            $responseDB['error'] = true;
            $responseDB['message'] = $responseDB['message'];
        }
    } else {
        $responseDB['error'] = true;
        $responseDB['message'] = 'Required fields are missing';

        //$response['error'] = true;
    //$response['message'] = 'Required fields are missing';
    }
} else {

  //$response['error'] = true;
    //$response['message'] = 'Invalid Request';

    $responseDB['error'] = true;
    $responseDB['message'] = 'Invalid Request';
}


//echo json_encode($response);
echo json_encode($responseDB);
?>
