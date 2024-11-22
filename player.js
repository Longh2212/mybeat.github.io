const image = document.getElementById('cover'),
    title = document.getElementById('music-title'),
    artist = document.getElementById('music-artist'),
    currentTimeEl = document.getElementById('current-time'),
    durationEl = document.getElementById('duration'),
    progress = document.getElementById('progress'),
    playerProgress = document.getElementById('player-progress'),
    prevBtn = document.getElementById('prev'),
    nextBtn = document.getElementById('next'),
    playBtn = document.getElementById('play'),
    background = document.getElementById('bg-img');

const music = new Audio();

function playSelectedSong(title, artist, src, cover) {
    // Cập nhật thông tin bài hát
    music.src = src;
    title.textContent = title;
    artist.textContent = artist;
    image.src = cover;
    background.src = cover;

    // Phát nhạc
    playMusic();
    saveState();
}

let musicIndex = 0;
let isPlaying = false;

// Khi trang được tải lại, lấy thông tin về bài hát và trạng thái phát nhạc
window.addEventListener('load', () => {
    const savedIndex = localStorage.getItem('musicIndex');
    const savedIsPlaying = localStorage.getItem('isPlaying');
    
    if (savedIndex !== null) {
        musicIndex = parseInt(savedIndex);
    }

    loadMusic(songs[musicIndex]);

    if (savedIsPlaying === 'true') {
        playMusic();
    }
});

// Lưu trạng thái hiện tại của nhạc vào localStorage
function saveState() {
    localStorage.setItem('musicIndex', musicIndex);
    localStorage.setItem('isPlaying', isPlaying);
}

function togglePlay() {
    if (isPlaying) {
        pauseMusic();
    } else {
        playMusic();
    }
    saveState();
}

function playMusic() {
    isPlaying = true;
    playBtn.classList.replace('fa-play', 'fa-pause');
    playBtn.setAttribute('title', 'Pause');
    music.play();
    saveState();
}

function pauseMusic() {
    isPlaying = false;
    playBtn.classList.replace('fa-pause', 'fa-play');
    playBtn.setAttribute('title', 'Play');
    music.pause();
    saveState();
}

function loadMusic(song) {
    music.src = song.src;
    title.textContent = song.path;
    artist.textContent = song.artist;
    image.src = song.cover;
    background.src = song.cover;
}

function changeMusic(direction) {
    musicIndex = (musicIndex + direction + songs.length) % songs.length; // Chuyển chỉ số bài hát tiếp theo hoặc trước
    loadMusic(songs[musicIndex]); // Tải thông tin bài hát mới
    playMusic(); // Phát bài hát ngay sau khi tải
    saveState(); // Lưu trạng thái vào localStorage
}

function updateProgressBar() {
    const { duration, currentTime } = music;
    const progressPercent = (currentTime / duration) * 100;
    progress.style.width = `${progressPercent}%`;

    const formatTime = (time) => String(Math.floor(time)).padStart(2, '0');
    durationEl.textContent = `${formatTime(duration / 60)}:${formatTime(duration % 60)}`;
    currentTimeEl.textContent = `${formatTime(currentTime / 60)}:${formatTime(currentTime % 60)}`;
}

function setProgressBar(e) {
    const width = playerProgress.clientWidth;
    const clickX = e.offsetX;
    music.currentTime = (clickX / width) * music.duration;
}

// Thêm các sự kiện
playBtn.addEventListener('click', togglePlay);
prevBtn.addEventListener('click', () => changeMusic(-1));
nextBtn.addEventListener('click', () => changeMusic(1));
music.addEventListener('ended', () => changeMusic(1));
music.addEventListener('timeupdate', updateProgressBar);
playerProgress.addEventListener('click', setProgressBar);

// Tải bài hát đầu tiên
loadMusic(songs[musicIndex]);
