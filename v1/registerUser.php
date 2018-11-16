<?php

//echo 'here';
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST '); //GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type: application/json");


require_once('../includes/DbOperations.php');



$response = array();

$responseDB = array();





if ($_SERVER['REQUEST_METHOD'] == 'POST') {




    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $strEmail = $request->strEmail;
    $strName = $request->strName;
    $strLastName = $request->strLastName;
    $strMonth = $request->strMonth;

    $strYear = $request->strYear;
    $strGender = $request->strGender;
    $bOffers = $request->bOffers;
    $strPassword = $request->strPassword;


    echo json_encode($strPassword);

    return;
    exit();




    if (
        ($strEmail != '' and $strName != '' and $strLastName != '' and $strMonth != ''
        and $strYear != '' and $strGender != '' and $bOffers != '' and $strPassword != '')
        and
        (!empty($strEmail) and !empty($strName) and !empty($strLastName) and !empty($strMonth)
        and !empty($strYear) and !empty($strGender) and !empty($bOffers)  and !empty($strPassword))
        and
        (!is_null($strEmail) and !is_null($strName) and !is_null($strLastName) and !is_null($strMonth)
        and !is_null($strYear) and !is_null($strGender) and !is_null($bOffers) and !is_null($strPassword))
      ) {



        $db = new DbOperations();

        //ok to go

        $responseDB = $db->createUser($strEmail, $strName, $strLastName, $strMonth,
        $strYear, $strGender, $bOffers, $strPassword);




        if ($responseDB['error'] == false) {
            $responseDB['error'] = false;
            $responseDB['message'] = $responseDB['message'];
        } else {
          $responseDB['error'] = true;
          $responseDB['message'] = $responseDB['message'];
        }
    } else {
        $responseDB['error'] = true;
        $responseDB['message'] = 'Required fields are missing';
    }
} else {

    $responseDB['error'] = true;
    $responseDB['message'] = 'Invalid Request';
}


echo json_encode($responseDB);



?>
