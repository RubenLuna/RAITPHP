<?php



class DbOperations
{
    private $con;

    public function __construct()
    {
        require_once dirname(__FILE__).'/DbConnect.php';

        $db = new DbConnect();
        $this->con = $db->connect();
    }

    public function fxRequest()
    {
    }

    public function fxLogin($email, $pass)
    {
        $bResult = array();
        try {
            $password = md5($pass);

            $stmt = $this->con->prepare("SELECT strEmail, strPassword FROM tblUsers WHERE strEmail = ? and strPassword = ? and bitActive = 1 ");
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                //$bResult = false;
                $bResult['error'] = true;
                $bResult['message'] = 'Email or Password does not exist';
            } else {
                //$bResult = true;
                $bResult['error'] = false;
                $bResult['message'] = 'User has been logged in successfully';
            }

            return $bResult;
        } catch (Exception $ex) {
            $bResult['error'] = true;
            $bResult['message'] = $ex.message;

            //return false;
            return $bResult;
        }
    }


    public function createUser(
        $strEmail,
        $strName,
        $strLastName,
        $strMonth,
        $strYear,
        $strGender,
        $bOffers,
        $strPassword
    ) {
        $bResult = array();



        try {


            $bResult = $this->fxUserExists($strEmail);


            if ($bResult['error'] == false) {
                $password = md5($strPassword);

                $stmt = $this->con->prepare("INSERT INTO `tblUsers` (`ID`, `strEmail`, `strPassword`, `strName`,
              `strLastName`, `strMonth`, `intYear`,
              `strGender`, `bitbOffers`, `bitActive`)
          VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 1); ");
                $stmt->bind_param(
                "sssssisi",
                $strEmail,
                $password,
                $strName,
                $strLastName,
                $strMonth,
                $strYear,
                $strGender,
                $bOffers
            );

                if ($stmt->execute()) {
                    //return true;
                    $bResult['error'] = false;
                    $bResult['message'] = 'User has been successfully registered';
                } else {
                    //return false;
                    $bResult['error'] = true;
                    $bResult['message'] = $bResult['message'];
                }
            } else {
                $bResult['error'] = true;
                $bResult['message'] = $bResult['message'];
            }

            return $bResult;
        } catch (Exception $ex) {
            $bResult['error'] = true;
            $bResult['message'] = $ex.message;
            return $bResult;
        }
    }


    private function fxUserExists($email)
    {
        $bResult = array();

        //return false;
        try {
            //$bResult = false;

            $stmt = $this->con->prepare("SELECT strEmail FROM tblUsers WHERE strEmail = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $bResult['error'] = false;
                $bResult['message'] = 'Can Register';
            } else {
                //$bResult = true;
                $bResult['error'] = true;
                $bResult['message'] = 'User already exists';
            }

            return $bResult;
        } catch (Exception $ex) {
            //return false;
            $bResult['error'] = true;
            $bResult['message'] = $ex.message;
            return $bResult;
        }
    }
}




/*

$arr = [];
$stmt = $mysqli->prepare("SELECT id, name, age FROM myTable WHERE name = ?");
$stmt->bind_param("s", $_POST['name']);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
  $arr[] = $row;
}
if(!$arr) exit('No rows');
var_export($arr);
$stmt->close();


while($row = $result->fetch_assoc()) {
  $ids[] = $row['id'];
  $names[] = $row['name'];
  $ages[] = $row['age'];

*/
