<?php
// create connection to db
require 'functions/form.php';
$form = new Form();

switch($_GET['method']){
    case 'file_upload':
        $save_img = $form->save_img();
        echo $save_img;
    break;
    case 'insert':
        $insert = $form->insert();
        echo json_encode($insert);
    break;
    case 'view':
        $view = $form->view();
        echo json_encode($view);
    break;
    case "login":
        $login = $form->login();
        echo json_encode($login);
    break;
    case "logout":
        $logout = $form->logout();
        echo json_encode($logout);
    break;
    default:
        die('404 Not Found');
    break;
    
}
