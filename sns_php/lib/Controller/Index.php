<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // login
      header('Location: ' . SITE_URL . '/public_html/login.php');
      exit;
    }


    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());

    //get threds info
    // $threadModel = new \MyApp\Model\Thread();
    // $threads = $threadModel->getTHREAD_list();

  }

}
