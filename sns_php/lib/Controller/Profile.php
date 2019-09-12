<?php

namespace MyApp\Controller;

class Profile extends \MyApp\Controller {

  public function run($user_id) {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }



    $userModel = new \MyApp\Model\User();
    $this->setValues('user', $userModel->getUser($user_id));



  }

  protected function postProcess() {
    // validate
    try {
      $this->_validate();
    } catch (\MyApp\Exception\InvalidIcon $e) {
      $this->setErrors('icon', $e->getMessage());
      return;
    }

    if($this->hasError()) {
      return;
    }else{
      // create user
      try {
        $username = $_POST['username'];
        $icon = $_FILES['upload_file']['name'];

        $upload = '../picture/icon/'.$_FILES['upload_file']['name'];

        move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload);



        $threadModel = new \MyApp\Model\User();
        $threadModel->new_icon([
          'icon' => $icon,
          'username' => $username
        ]);
      } catch (\MyApp\Exception\WriteError $e) {
        $this->setErrors('write', $e->getMessage() . $username . $icon);
        return;
      }
      // redirect to login
      header('Location:' . SITE_URL . '/public_html/index.php');
      exit;
    }


  }


    private function _validate() {
    // var_dump($_FILES);
    // exit;

    if (!isset($_FILES['upload_file']) || !isset($_FILES['upload_file']['error'])) {
      throw new \MyApp\Exception\InvalidIcon();
    }

    // switch($_FILES['image']['error']) {
    //   case UPLOAD_ERR_OK:
    //     return true;
    //   case UPLOAD_ERR_INI_SIZE:
    //   case UPLOAD_ERR_FORM_SIZE:
    //     throw new \Exception('File too large!');
    //   default:
    //     throw new \Exception('Err: ' . $_FILES['image']['error']);
    // }

  }

}
