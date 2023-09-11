<style>
    .navbar-nav .dropdown-menu {
        right: 0;
        left: auto;
    }

    .nav-link {
        color: #fff;
    }
    
</style>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1C2331;">
    <div class="d-flex align-items-center ms-1">
        <a class="navbar-brand ms-2" href="home.php">
            <img src="img/logo.png" alt="logo" width="50" height="40" class="ms-3">
            <span style="vertical-align: middle; color: #fff;"><strong>DFS</strong></span>

        </a>
    </div>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end m-0 pe-3" id="navbarNav">
        <ul class="navbar-nav ps-3">
            <li class="nav-item p-1">
                <a class="nav-link" href="home.php"><strong>Home</strong></a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link" href="aboutus.php"><strong>About Us</strong></a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link" href="profile.php"><strong>Profile</strong></a>
            </li>
            <li class="nav-item p-1 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><strong>Menu</strong></a>
                <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                    <li><a class="dropdown-item" href="upload_document.php">Upload</a></li>
                    <li><a class="dropdown-item" href="view_download_document.php">View & Download</a></li>
                    <li><a class="dropdown-item" href="share_document.php">Share</a></li>
                    <li><a class="dropdown-item" href="void_document.php">Void</a></li>
                    <li><a class="dropdown-item" href="?logout=true">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
