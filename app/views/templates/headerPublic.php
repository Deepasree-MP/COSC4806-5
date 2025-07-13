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

  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">COSC 4806</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic" aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarPublic">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!--<?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1): ?>
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register">Register</a>
            </li>
          <?php endif; ?>
          -->
        </ul>
      </div>
    </div>
  </nav>
