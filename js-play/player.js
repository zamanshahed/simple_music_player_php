var songs = [
    "Don Moen - I Want To Be Where You Are.mp3",
    "don moen - I Want To Know More.mp3",
    "don moen - I want to know you more.mp3",
    "don moen - I Will Bless The Lord.mp3",
    "don moen - I Will Celebrate.mp3",
    "don moen - I Worship You Almighty God.mp3",
    "don moen - I Worship You, Almighty God.mp3",
    "don moen - I'm The God That Healed.mp3",
    "don moen - If You Could See Me Now.mp3",
    "don moen - it is well with my soul.mp3"
];

var songTitle = document.getElementById('songTitle');
var songSlider = document.getElementById('songSlider');
var currentTime = document.getElementById('currentTime');
var duration = document.getElementById('duration');
var volumeSlider = document.getElementById('volumeSlider');
var nextSongTitle = document.getElementById('nextSongTitle');

var song = new Audio();
var currentSong = 0;

window.onload = loadSong;

function loadSong() {
    song.src = "songs/" + songs[currentSong];
    songTitle.textContent = (currentSong + 1) + ". " + songs[currentSong];
    nextSongTitle.innerHTML = "<b>Next Song: </b>" + songs[currentSong + 1 % songs.length];
    song.playbackRate = 1;
    song.volume = volumeSlider.value;
    song.play();
    setTimeout(showDuration, 1000);
}

setInterval(updateSongSlider, 1000);

function updateSongSlider() {
    var c = Math.round(song.currentTime);
    songSlider.value = c;
    currentTime.textContent = convertTime(c);
    if (song.ended) {
        next();
    }
}

function convertTime(secs) {
    var min = Math.floor(secs / 60);
    var sec = secs % 60;
    min = (min < 10) ? "0" + min : min;
    sec = (sec < 10) ? "0" + sec : sec;
    return (min + ":" + sec);
}

function showDuration() {
    var d = Math.floor(song.duration);
    songSlider.setAttribute("max", d);
    duration.textContent = convertTime(d);
}

function playOrPauseSong(img) {
    song.playbackRate = 1;
    if (song.paused) {
        song.play();
        img.src = "images/pause.png";
    } else {
        song.pause();
        img.src = "images/play.png";
    }
}

function next() {
    currentSong = currentSong + 1 % songs.length;
    loadSong();
}

function previous() {
    currentSong--;
    currentSong = (currentSong < 0) ? songs.length - 1 : currentSong;
    loadSong();
}

function seekSong() {
    song.currentTime = songSlider.value;
    currentTime.textContent = convertTime(song.currentTime);
}

function adjustVolume() {
    song.volume = volumeSlider.value;
}

function increasePlaybackRate() {
    songs.playbackRate += 0.5;
}

function decreasePlaybackRate() {
    songs.playbackRate -= 0.5;
}