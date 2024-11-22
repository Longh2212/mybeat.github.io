<?php 
   session_start();

   $con = mysqli_connect("localhost","root","","regtutorial");
   if(!isset($_SESSION['valid'])){
    header("Location: Login.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="index.css?v=1.1">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <title>HeartBeat</title>
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="asset/mlogo.png" alt="Logo" onclick="window.location.href='index.php'" style="cursor: pointer;" />
            </div>
            <nav>
                <ul>
                    <li><a href="index.php?page_layout=home">Home</a></li>
                    <li><a href="index.php?page_layout=library">Library</a></li>
                    <li><a href="index.php?page_layout=artist">Artist</a></li>
                    <li><a href="index.php?page_layout=trytonext">Try to next</a></li>
                </ul>
            </nav>
            <div class="search-container">
                <input type="text" placeholder="Search..." />
                <button type="submit"><i class='bx bx-search'></i></button>
            </div>
            <div class="actions">
                <div class="user">
                    <img src="asset/1817.png" alt="Menu Icon" class="menu-icon" id="menuToggle">
                    <ul class="dropdown-menu" id="dropdownMenu">
                        <li><a href="index.php?page_layout=profile">Profile</a></li>
                        <li><a href="index.php?page_layout=your_song">Your Song</a></li>
                        <li><a href="index.php?page_layout=settings">Settings</a></li>
                    </ul> 
                    <script src="Dropdown.js"></script>
                </div>
                
                <div class="notifications">
                    <button><i class='bx bxs-bell'></i></button>
                </div>
                <div class="messages">
                    <button><i class='bx bxs-envelope'></i></i></button>
                </div>
                <div class="logout">
                    <nav>
                        <ul>
                            <li><a href="#" onclick="confirmLogout(event)"><i class='bx bxs-door-open'></i></a></li>
                        </ul>
                    </nav>
                    <script>
                        function confirmLogout(event) {
                            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
                            const confirmAction = confirm("Bạn có chắc chắn muốn đăng xuất?");
                            if (confirmAction) {
                                window.location.href = "/data/logout.php"; // Điều hướng đến trang logout nếu người dùng đồng ý
                            }
                        }
                    </script>
                </div>
                
            </div>
        </header>
        <div class="main">
            <div class="wrapper">
                <form action="">
                    <?php 
                        $page_layout = isset($_GET['page_layout']) ? $_GET['page_layout'] : 'home';
                        switch($page_layout){
                            case 'home':
                                include "Home.php";
                                break;
                            case 'library':
                                include "Library.php";
                                break;
                            case 'artist':
                                include "Artist.php";
                                break;
                            case 'trytonext':
                                include "Trytonext.php";
                                break;
                        }
                    ?>
                </form>
            </div>
            <div class="idexcontent"> -
                
                <div class="play-container">
                    <div class="player-img">
                        <img src="" class="active" id="cover">
                    </div>
                    <h2 id="music-title"></h2>
                    <h3 id="music-artist"></h3>
                    <div class="player-progress" id="player-progress"> 
                        <div class="progress" id="progress"></div>
                        <div class="music-duration">
                            <span id="current-time">0:00</span>
                            <span id="duration">0:00</span>
                        </div>
                    </div>
                    <div class="player-controls">
                        <i class="fa-solid fa-backward" title="Previous" id="prev"></i>
                        <i class="fa-solid fa-play play-button" title="Play" id="play"></i>
                        <i class="fa-solid fa-forward" title="Next" id="next"></i>
                    </div>
                    <script src="player.js"></script>
                </div>
            </div>
        </div>
       
        

    </body>
    <footer></footer>
</html>