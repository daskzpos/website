<?php

require ('conn database.php');
// $sql1 = "CREATE DATABASE FullStack" ;
// if($conn->query($sql1) === true){
//     echo "Database created succesfully";
// } else {
//     echo "Error creating database" .$conn->error ;
// }

// $sql = "CREATE TABLE  Bands (
//     id INT(6) unsigned auto_increment primary key,
//     bandname varchar(30) not null
//     )";
// $sql = "CREATE TABLE accounts (
// id INT(6) unsigned auto_increment primary key,
// username varchar(30) not null,
// password varchar(30) not null,
// email varchar(30) not null
// )";



// $sql = "CREATE TABLE Events (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     name VARCHAR(255) NOT NULL,
//     description TEXT,
//     date DATE,
//     start_time TIME,
//     end_time TIME
// );

// // $conn->close();

// $sql = "CREATE TABLE Events_Bands (
//     event_id INT(6),
//     band_id INT(6),
//     PRIMARY KEY (event_id, band_id),
//     FOREIGN KEY (event_id) REFERENCES Events(event_id),
//     FOREIGN KEY (band_id) REFERENCES Bands(band_id)
// )";

//  if($conn->query($sql) === true) {
//     echo "Table created successfully";
// }else{
//     echo 'Error creating database: ' . $conn->error;
// }   
?>