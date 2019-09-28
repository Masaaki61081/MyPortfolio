<?php

namespace MyApp\Controller;

class Edit extends \MyApp\Controller {

  private $_imageType;

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
      $this->_validateImageType();
    } catch (\MyApp\Exception\InvalidIcon $e) {
      $this->setErrors('icon', $e->getMessage());
      return;
    }

    // try {
    // }catch (\MyApp\Exception\InvalidIcon $e) {
    //   $this->setErrors('icon', $e->getMessage());
    //   return;
    // }

    if($this->hasError()) {
      return;
    }else{
      // create user
      try {
        $id = $_POST['id'];
        $icon = $_FILES['upload_file']['name'];

        $savePath = '../picture/icon/'.$_FILES['upload_file']['name'];

        move_uploaded_file($_FILES['upload_file']['tmp_name'], $savePath);

        $this->_createThumbnail($savePath);



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

    private function _validateImageType() {
      $this->_imageType = exif_imagetype($_FILES['upload_file']['tmp_name']);
      switch($this->_imageType) {
        case IMAGETYPE_GIF:
          throw new \MyApp\Exception\InvalidIcon();
        case IMAGETYPE_JPEG:
          // return 'jpg';
          continue;
        case IMAGETYPE_PNG:
          // return 'png';
          continue;
        default:
          throw new \MyApp\Exception\InvalidIcon();
      }

    }

    private function _createThumbnail($savePath) {
      $imageSize = getimagesize($savePath);
      $width = $imageSize[0];
      $height = $imageSize[1];
      if ($width > 500) {
        $this->_createThumbnailMain($savePath, $width, $height);
      }
    }



    private function _createThumbnailMain($savePath, $width, $height) {
      switch($this->_imageType) {
        // case IMAGETYPE_GIF:
        //   $srcImage = imagecreatefromgif($savePath);
        //   break;
        case IMAGETYPE_JPEG:
          $srcImage = imagecreatefromjpeg($savePath);
          break;
        case IMAGETYPE_PNG:
          $srcImage = imagecreatefrompng($savePath);
          break;
      }
      $thumbHeight = 500;
      $thumbWidth = 500;
      $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
      imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

      switch($this->_imageType) {
        // case IMAGETYPE_GIF:
        //   imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        //   break;
        case IMAGETYPE_JPEG:
          imagejpeg($thumbImage, '../picture/icon_thumbnail/'.$_FILES['upload_file']['name']);
          break;
        case IMAGETYPE_PNG:
          imagepng($thumbImage, '../picture/icon_thumbnail/'.$_FILES['upload_file']['name']);
          break;
      }
    }





}
