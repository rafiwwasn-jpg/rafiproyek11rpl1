<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pizza Planet System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&display=swap" rel="stylesheet">
  </head>
  <body>
    
<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="Usersss.php">
      <img src="pz.png" alt="me" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="Usersss.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tambah User </a>
          < class="dropdown-menu custom-dropdown">
            <li><hr class="dropdown-divider bg-secondary"></li>
            <li><a class="dropdown-item fw-bold text-success" href="formmapel.php">Isi Form Tambah Mapel</a></li>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2 bg-dark text-white border-success" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success fw-bold" type="submit">Search</button>
      </form>
      <!-- Tombol Log Out -->
      <a href="logout.php" class="btn btn-danger fw-bold ms-lg-3 mt-3 mt-lg-0">Log Out</a>
    </div>
  </div>
</nav>
