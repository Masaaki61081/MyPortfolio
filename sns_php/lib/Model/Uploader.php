<?php

namespace MyApp\Model;

class Upload extends \MyApp\Model {

  public function create($values) {
    $stmt = $this->db->prepare("insert into users (username, email, password, created, modified) values (:username, :email, :password, now(), now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\DuplicateEmail();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("select * from users where email = :email");
    $res = $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();

    if (empty($user)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    if (!password_verify($values['password'], $user->password)) {
      throw new \MyApp\Exception\UnmatchEmailOrPassword();
    }

    return $user;
  }

  public function findAll() {
    $stmt = $this->db->query("select * from users order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
