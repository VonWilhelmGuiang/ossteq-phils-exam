<?php
require 'db.php';

class Form{
    private $db;
    function __construct(){
        $this->db = new Database();
        session_start();
    }
    public function insert(){
        $textbox = $_POST['textbox']??'';
        $radio = $_POST['radio']??null;
        $form_id = null;
        $file = $_POST["file"]??null;

        $check_box = !empty($_POST['check-world']) ? $_POST['check-world'] : '';
        $check_box = !empty($_POST['check-web']) ? $check_box.','.$_POST['check-web']  : '';
        $check_box = trim($check_box,',');
        $valid_check_box = $check_box == "" ? false:true;
        
        $check_fields = !$textbox && !$radio && !$valid_check_box && !$file?  false : true ;

        if($check_fields){
            $insert_form= "INSERT INTO `dbuser0_form`(`dbuser0_text`, `dbuser0_radio`, `dbuser0_checkbox`, `dbuser0_filename`) VALUES ('{$textbox}','{$radio}','{$check_box}','{$file}')";
            try{
                if($this->db->getConnection()->query($insert_form)){
                    $form_id = $this->db->getConnection()->insert_id;
                    return($form_id);
                }else{
                    return(false);
                }
            }catch(Exception $e){
                die("An Error has occured inserting data");
            }
        }else{
            die('All fields are empty');
        }
    }

    public function view(){
        $id = $_POST['id'];
        $sql = "SELECT * FROM `dbuser0_form` WHERE `dbuser0_id` = {$id}";
        $data = $this->db->getConnection()->query($sql);
        $format_data = mysqli_fetch_assoc($data);
        return($format_data);
    }

    public function save_img(){
        // $targetDir = '/var/www/user0/html/public_html/assets/form-files';
        $targetDir = 'assets/form-files';

        // create file unique name
        $raw_fileName = $_REQUEST["name"];
        $name	= explode(".",$raw_fileName);
        if(!empty($_SESSION['verify_file_name']) && $_SESSION['verify_file_name'] == $name[0]){
            $file_name = $_SESSION['file_name'];
        }else{
            $file_name = $name[0].time();
            $_SESSION['verify_file_name'] = $name[0];
            $_SESSION['file_name'] = $file_name;
        }
        $ext = $name[1];
        $file_name = $file_name.'.'.$ext;

        // Create target directory if not present
        if (!file_exists($targetDir)) { 
            if (!mkdir($targetDir, 0777, true)) {
                exit("Failed to create file");
            }
        }
    

        // Create file
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $file_name;

        //  DEAL WITH CHUNKS
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
         
        // append chunks to file
        $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        if ($out) {
                $in = @fopen($_FILES['file']['tmp_name'], "rb");
                if ($in) {
                    while ($buff = fread($in, 4096)) { fwrite($out, $buff); }
                } else {
                    exit("Failed to open input stream");
                }
                @fclose($in);
                @fclose($out);
                @unlink($_FILES['file']['tmp_name']);
        } else {
                exit("Failed to open output stream");
        }

        // CHECK IF FILE HAS BEEN UPLOADED
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
            // unset session variables for next file upload
            unset($_SESSION['file_name']);
            unset($_SESSION['verify_file_name']);
            // if finished uploaded return the file name
            return($file_name);
        }
    }
    
    public function login(){
        //static creds 
        $email = 'guiang.vw@gmail.com';
        $password = 'password';

        //user inputs
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];

        // verification
        $password_hashed = password_hash($user_password,PASSWORD_DEFAULT);
        $password_verified = password_verify($password,$password_hashed);
        if($password_verified && ($email==$user_email)){
            //set session variables
            $_SESSION['logged_in'] = true;
            return "Log in Successful";
        }else{
            $_SESSION['logged_in'] = false;
            return "Incorrect Credentials";
        }

    }

    public function logout(){
        session_destroy();
        return "User logged out";
    }
}