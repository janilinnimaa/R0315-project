<?php
    class Account {
        
        private $con;
        private $errorArray;
        
        public function __construct($con) {
            $this->con = $con;
            $this->errorArray = array();
        }
        
        /*
        Login function which queries the given username and compares the given hashed password
        to the hashed password in the users database
        */
        public function login($un, $pw) {

            $query = "SELECT * FROM users WHERE username='$un'";
            $result = $this->con->query($query);

            if ($result->num_rows === 1) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (password_verify($pw, $row['password'])) {
                    return true;
                } else {
                    array_push($this->errorArray, Constants::$loginFailed);
                    return false;
                }
            }
            
        }
        
        /*
        After validating the user inputs, calls the insertUserDetails, if successful,
        to register the user into the database
        */
        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
            
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);
            
            if (empty($this->errorArray)) {
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            }
            else {
                return false;
            }
        }
        
        public function getError($error) {
            if (!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }
        
        // Hashes the password, sets the date and performs the insertion of data into the users database
        private function insertUserDetails($un, $fn, $ln, $em, $pw) {
            
            $encryptedPW = password_hash($pw, PASSWORD_DEFAULT);
            $date = date("Y-m-d");

            $result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, signUpDate) VALUES ('$un', '$fn', '$ln', '$em', '$encryptedPW', '$date')");
            return $result;
        }
        
        // Functions that validate the user input in preparation of creating a new user in the users database 
        private function validateUsername($un) {
            if (strlen($un) > 25 || strlen($un) < 5) {
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }
            
            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
            if (mysqli_num_rows($checkUsernameQuery) != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        }
    
        private function validateFirstName($fn) {
            if (strlen($fn) > 25 || strlen($fn) < 2) {
                array_push($this->errorArray, Constants::$firstNameCharacters);
                return;
            }
    
        }
    
        private function validateLastName($ln) {
            if (strlen($ln) > 25 || strlen($ln) < 2) {
                array_push($this->errorArray, Constants::$lastNameCharacters);
                return;
            }
    
        }
    
        private function validateEmails($em, $em2) {
            if ($em != $em2) {
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return;
            } 
            if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }
            
            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
            if (mysqli_num_rows($checkEmailQuery) != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }
    
        private function validatePasswords($pw, $pw2) {
            if ($pw != $pw2) {
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }
            if (preg_match('/[^A-Za-z0-9]/', $pw)) {
                array_push($this->errorArray, Constants::$passwordNotAlphaNumeric);
                return;
            }
            if (strlen($pw) > 30 || strlen($pw) < 8) {
                array_push($this->errorArray, Constants::$passwordCharacters);
                return;
            }
        }
        
    }
?>