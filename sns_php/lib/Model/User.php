<?php

namespace MyApp\Model;

class User extends \MyApp\Model {

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
  public function new_icon($values) {
    $stmt = $this->db->prepare("UPDATE users SET icon= :icon, modified=now() WHERE username=:username");
    $res = $stmt->execute([
      ':icon' => $values['icon'],
      ':username' => $values['username']
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\WriteError();
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

  public function getUser_icon($user_id) {
    $stmt = $this->db->prepare("SELECT icon FROM users where id = {$user_id} ");
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function getUser($user_id) {
    $stmt = $this->db->prepare("SELECT id,username,icon,email,created FROM users where id = {$user_id} ");
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function findAll() {
    $stmt = $this->db->query("select * from users order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
