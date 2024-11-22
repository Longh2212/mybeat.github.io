<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 
$con = mysqli_connect("localhost", "root", "", "regtutorial");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["playlistavt"])) {
    $playlistname = filter_var($_POST["playlistname"], FILTER_SANITIZE_STRING);
    $cap = filter_var($_POST["cap"], FILTER_SANITIZE_STRING);

    $album = $_FILES['playlistavt']['name'];
    $album_size = $_FILES['playlistavt']['size'];
    $album_tmp_name = $_FILES['playlistavt']['tmp_name'];
    $album_folder = 'list/' . $album;

    if ($album_size > 2000000) {
        echo "Image size is too large!";
    } else {
        if (move_uploaded_file($album_tmp_name, $album_folder)) {
            $avatar = $album_folder;
        } else {
            echo "Failed to upload image!";
        }
    }

    $st = $con->prepare("INSERT INTO list (name, avatar, tag) VALUES (?, ?, ?)");
    $st->bind_param("sss", $playlistname, $avatar, $cap);
    $st->execute();

    $st->close();

}

// Truy vấn danh sách playlist
if (isset($_SESSION['valid'])) {
    $id = $_SESSION['id'];
    $select_list = mysqli_query($con, "SELECT * FROM list"); 
}
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="library.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>
    <div class="cre-playlist">
        <div class="create">
            <h2><i class='bx bxs-plus-circle'></i> Create your playlist</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="filename">Playlist Name</label>
                <input type="text" id="playlistname" name="playlistname" placeholder="..." class="input">
                
                <label for="title">Caption:</label>
                <input type="text" id="title" name="cap" placeholder="Add a caption..." class="input">

                <label for="album">Select Avatar</label>
                <input type="file" id="playlistavt" name="playlistavt" accept="image/*" onchange="previewImage(event)" class="input">
                <img id="albumPreview" src="" alt="Image Preview" style="display: none; width: 100px; margin-top: 10px;">

                <button type="submit">Save</button>
                <button type="button" onclick="window.location.href='../MyBeatEX/manguonmo/index.php';">Cancel</button>
            </form>
        </div>
    </div>
    <h2>My play list</h2>
    <div class="myplaylist">
            
        <?php if ($select_list && mysqli_num_rows($select_list) > 0):?>    
            <?php while ($list = mysqli_fetch_assoc($select_list)): ?>
                    <div class="list">
                        <img src="<?php echo htmlspecialchars($list['avatar']); ?>" alt="<?php echo htmlspecialchars($list['name']); ?>"
                        style="
                            margin: 10px;
                            width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;">
                        <h3><?php echo strlen($list['name']) > 20 ? substr($list['name'], 0, 20) . '...' : htmlspecialchars($list['name']); ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No songs found.</p>
            <?php endif; ?>
    </div>
</body>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById("albumPreview");

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
</script>
</html>
