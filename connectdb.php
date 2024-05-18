<?php

try {
  $pdo = new PDO('mysql:host=localhost;dbname=darren_uts', 'root', '');
} catch (PDOException $f) {
  echo $f->getmessage();
}
