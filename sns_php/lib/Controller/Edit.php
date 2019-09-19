<?php

namespace MyApp\Controller;

class Edit extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }



    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());



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
        $id = $_POST['id'];
        $icon = $_FILES['upload_file']['name'];

        $upload = '../picture/icon/'.$_FILES['upload_file']['name'];

        move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload);



        $userModel = new \MyApp\Model\User();
        $userModel->new_icon([
          'icon' => $icon,
          'id' => $id
        ]);

        $user = $userModel->reLogin([
          'id' => $_POST['id']
        ]);
        session_regenerate_id(true);
        $_SESSION['me'] = $user;

      } catch (\MyApp\Exception\WriteError $e) {
        $this->setErrors('write', $e->getMessage() . $id . $icon);
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
