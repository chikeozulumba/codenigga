<?php
  $db = mysqli_connect('127.0.0.1','root','root','africacodes', 3307);
  $pdo = new PDO('mysql:host=localhost;port=3307;dbname=africacodes', 'root', 'root');
  $db->query("CREATE TABLE IF NOT EXISTS customers (
            id INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(id),
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            state VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NOT NULL,
            date VARCHAR(255) NOT NULL,
            pin VARCHAR(255) NOT NULL,
            UNIQUE(email)
        )");
  $db->query("CREATE TABLE IF NOT EXISTS transactions (
            id INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(id),
            customer_id VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            date TIMESTAMP NOT NULL,
        )");
  if (mysqli_connect_errno()) {
    echo "database connection failed with following errors: ".msqli_connect_error();
    die();
  }
  ?>