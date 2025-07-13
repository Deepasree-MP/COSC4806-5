<?php
if (isset($_SESSION['auth']) == 1) {
    header('Location: /home');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap CDN (Active) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous">

  <!-- Skeleton CDN -->
  <!--
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
  -->

  <!-- Pearl CSS CDN -->
  <!--
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pearlcss@1.0.2/dist/pearl.min.css">
  -->

  <!-- Viewport & Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <link rel="icon" href="/favicon.png">
  <title>COSC 4806</title>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">

  <style>
    .navbar-custom {
      background-color: #b71c1c;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
      color: #fff;
    }
    .navbar-custom .nav-link:hover {
      color: #fdd835; 
    }
  </style>
</head>
<body>