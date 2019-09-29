<?php

namespace MyApp\Model;

class Thread extends \MyApp\Model {

  public function create($values) {
    $stmt1 = $this->db->prepare("insert into thread_list (createdby, title, created, modified) values (:createdby, :title, now(), now())");
    $res1 = $stmt1->execute([
      ':createdby' => $values['createdby'],
      ':title' => $values['title']
    ]);

    $stmt2 = $this->db->prepare("SELECT MAX(id) FROM thread_list ");
    $stmt2->execute();
    $result = $stmt2->fetch(\PDO::FETCH_ASSOC);
    $values['thread_id'] = $result['MAX(id)'];


    $stmt3 = $this->db->prepare("INSERT INTO comments (writer, content, created,thread_id, comment_id) VALUES (:writer, :content, now(), :thread_id, :comment_id)");
    $res3 = $stmt3->execute([
      ':writer' => $values['createdby'],
      ':content' => $values['content'],
      'thread_id' => $values['thread_id'],
      ':comment_id' => '1'
    ]);


    if ($res1 === false) {
      throw new \MyApp\Exception\WriteError();
    }
    // if ($res2 === false) {
    //   throw new \MyApp\Exception\WriteError();
    // }
    if ($res3 === false) {
      throw new \MyApp\Exception\WriteError();
    }
  }


  public function write($values) {
    $stmt = $this->db->prepare("INSERT INTO comments (writer, content, thread_id, comment_id, created) VALUES (:writer, :content, :thread_id, :comment_id, now())");
    $res = $stmt->execute([
      ':writer' => $values['writer'],
      ':content' => $values['content'],
      ':thread_id' => $values['thread_id'],
      ':comment_id' => $values['comment_id']
    ]);
    if ($res === false) {
      throw new \MyApp\Exception\WriteError();
    }
    $stmt2 = $this->db->prepare("UPDATE thread_list SET modified = now() WHERE id={$values['thread_id']}");
    $res2 = $stmt2->execute();
    if ($res2 === false) {
      throw new \MyApp\Exception\WriteError();
    }

  }


  public function getThread_page() {
    $stmt = $this->db->prepare("SELECT count(*) FROM thread_list");
    $stmt->execute();
    $count = $stmt->fetch(\PDO::FETCH_ASSOC);
    $temp = $count["count(*)"];
    return ceil($temp/10);
  }

  public function count_thread() {
    $stmt = $this->db->prepare("SELECT count(*) FROM thread_list");
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result;
  }

  // public function getThread_list_page($page) {
  //   $page = ($page - 1)*10;
  //   $stmt = $this->db->prepare("SELECT * FROM thread_list ORDER BY id limit {$page} , 10");
  //   $stmt->execute();
  //   $result = $stmt->fetchALL(\PDO::FETCH_ASSOC);
  //   return $result;
  // }

  public function getThread_list_page($page) {
    $page = ($page - 1)*10;
    $stmt = $this->db->prepare("SELECT t.id, t.title, t.modified, u.icon, u.username, c.content from thread_list as t
    inner join comments as c
    on t.id = c.thread_id
    and c.comment_id = 1
    inner join users as u
    on c.writer =u.id
    order by t.modified DESC
    limit {$page} , 10");
    $stmt->execute();
    $result = $stmt->fetchALL(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function getTHREAD_list() {
    $stmt = $this->db->prepare("SELECT * FROM thread_list ORDER BY id");
    $stmt->execute();
    $result = $stmt->fetchALL(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function getTHREAD_title($thread_id) {
    $stmt = $this->db->prepare("SELECT title FROM thread_list WHERE id = {$thread_id} ");
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result['title'];
  }

  public function getRes($thread_id) {
    $stmt = $this->db->prepare("SELECT * FROM comments WHERE thread_id = {$thread_id} ORDER BY id");
    $stmt->execute();
    $result = $stmt->fetchALL(\PDO::FETCH_ASSOC);
    return $result;
  }

  public function getResnum($thread_id) {
    $stmt = $this->db->prepare("SELECT MAX(comment_id) FROM comments WHERE thread_id = {$thread_id} ");
    $stmt->execute();
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result['MAX(comment_id)'];
  }

  public function get_res($thread_id) {
    $stmt = $this->db->prepare("SELECT comment_id,writer,content,username,icon FROM comments LEFT JOIN users ON comments.writer = users.id WHERE thread_id = {$thread_id} ORDER BY comment_id");
    $stmt->execute();
    $result = $stmt->fetchALL(\PDO::FETCH_ASSOC);
    return $result;
  }

//for getting thread info
  public function findAll() {
    $stmt = $this->db->query("select * from thread_list order by id");
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    return $stmt->fetchAll();
  }
}
