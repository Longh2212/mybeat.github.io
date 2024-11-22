<?php 
    $con = mysqli_connect("localhost", "root", "", "regtutorial");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>HeartBeat</title>
</head>
<body>
    <?php 
        $select_songs = $recent_songs = $mixed_songs = $trending_songs = false;
        $chill_songs = $party_songs = $workout_songs = $study_songs = false;

        if (isset($_SESSION['valid'])) {
            $id = $_SESSION['id'];
            $query = mysqli_query($con, "SELECT * FROM users WHERE ID=$id");

            if ($query && mysqli_num_rows(result: $query) > 0) {
                $result = mysqli_fetch_assoc($query);
                $res_Fullname = $result['Fullname'];
            }

            $select_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag = 'Pop'");
            $mixed_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag IN ('Pop', 'Workout', 'Chill') LIMIT 10");
            $chill_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag = 'Chill'");
            $party_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag = 'Party'");
            $workout_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag = 'Workout'");
            $study_songs = mysqli_query($con, "SELECT * FROM songs WHERE tag = 'Study'");
        }
    ?>
    <div class="main-home">
        <!-- Home1: Pop Songs -->
        <h2><i class='bx bxs-heart-circle'></i> More of what you prefer :</h2>
        <div class="home1">
            <?php if ($select_songs && mysqli_num_rows($select_songs) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($select_songs)): ?>
                    <div class="song-item" 
                        onclick="playSelectedSong('<?php echo htmlspecialchars($song['title']); ?>', 
                                                  '<?php echo htmlspecialchars($song['tag']); ?>', // can sua them
                                                  '<?php echo htmlspecialchars($song['file']); ?>', 
                                                  '<?php echo htmlspecialchars($song['image']); ?>')">
                        <img src="<?php echo htmlspecialchars($song['image']); ?>" 
                            alt="<?php echo htmlspecialchars($song['title']); ?>"
                            style="
                            width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;">
                        <h3>
                            <?php echo strlen($song['title']) > 20 ? substr(htmlspecialchars($song['title']), 0, 20) . '...' : htmlspecialchars($song['title']); ?>
                        </h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No songs found.</p>
            <?php endif; ?>
        </div>

        <!-- Home2: Recently Played -->
        <h2><i class='bx bxl-sketch'></i> Recently played :</h2>
        <div class="home2">
            
        </div>

        <!-- Home3: Mixed for User -->
        <h2><i class='bx bxs-user-rectangle'></i> Mixed for <b><?php echo isset($res_Fullname) ? htmlspecialchars($res_Fullname) : 'Guest'; ?></b> :</h2>
        <div class="home3">
        
        </div>

        <!-- Home4: Trending -->
        <h2><i class='bx bxs-happy-heart-eyes'></i> Trending on HeartBeat :</h2>
        <div class="home4">
            
        </div>

        <!-- Home5: Chill -->
        <h2><i class='bx bx-podcast'></i> Chill on HeartBeat :</h2>
        <div class="home5">
            <?php if ($chill_songs && mysqli_num_rows($chill_songs) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($chill_songs)): ?>
                    <div class="song-item">
                        <img src="<?php echo htmlspecialchars($song['image']); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>"
                        style="width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;"
                        >
                        <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No chill songs available.</p>
            <?php endif; ?>
        </div>

        <!-- Home6: Party -->
        <h2><i class='bx bxs-party'></i> Party :</h2>
        <div class="home6">
            <?php if ($party_songs && mysqli_num_rows($party_songs) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($party_songs)): ?>
                    <div class="song-item">
                        <img src="<?php echo htmlspecialchars($song['image']); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>"
                        style="width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;"
                        >
                        <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No party songs available.</p>
            <?php endif; ?>
        </div>

        <!-- Home7: Workout -->
        <h2><i class='bx bx-dumbbell'></i> Workout :</h2>
        
        <div class="home7">
            <?php if ($workout_songs && mysqli_num_rows($workout_songs) >= 0): ?>
                <?php while ($song = mysqli_fetch_assoc($workout_songs)): ?>
                    <div class="song-item">
                        <img src="<?php echo htmlspecialchars($song['image']); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>"
                        style="width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;"
                        >
                        <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No workout songs found.</p>
            <?php endif; ?>
        </div>

        <!-- Home8: Study -->
        <h2><i class='bx bxs-book-reader'></i> Study :</h2>
        <div class="home8">
            <?php if ($study_songs && mysqli_num_rows($study_songs) > 0): ?>
                <?php while ($song = mysqli_fetch_assoc($study_songs)): ?>
                    <div class="song-item">
                        <img src="<?php echo htmlspecialchars($song['image']); ?>" alt="<?php echo htmlspecialchars($song['title']); ?>"
                        style="width: 130px; 
                            height: 130px; 
                            object-fit: cover; 
                            border-radius: 8px; 
                            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.4); 
                            cursor: pointer;"
                        >
                        <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No study songs found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
