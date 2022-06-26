const musicContainer = document.getElementById('music-container');
const playBtn = document.getElementById('play');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
const cataloguePlayBtns = document.getElementsByClassName('catalogue-play');

const user = document.getElementById('user');

const audio = document.getElementById('audio');
const progress = document.getElementById('progress');
const progressContainer = document.getElementById('progress-container');
const title = document.getElementById('title');
const artist = document.getElementById('artist');
const album = document.getElementById('album');
const cover = document.getElementById('cover');
const currTime = document.querySelector('#currTime');
const durTime = document.querySelector('#durTime');

var form = document.getElementById("load-more");

var songs = getSongs();

function getSongs()
{
    var songs = [];
    var entries = document.getElementsByClassName("catalogue-entry");

    for (var i = 0; i < entries.length; i++)
    {
        songs.push(JSON.parse(entries.item(i).dataset.json));
    }

    return songs;
}

// Keep track of song
let songIndex = 0;

// Initially load song details into DOM
loadSong(songs[songIndex]);

// Update song details
function loadSong(song)
{
    title.innerText = song["name"];
    artist.innerText = song["artist"];
    album.innerText = song["album"];
    audio.src = `../${song["path"]}`;
    cover.src = `../${song["image"]}`;
}

// Play song
function playSong(song_id)
{
    musicContainer.classList.add('play');
    playBtn.querySelector('i.fas').classList.remove('fa-play');
    playBtn.querySelector('i.fas').classList.add('fa-pause');

    cataloguePlayBtns[songIndex].classList.remove('fa-pause');
    cataloguePlayBtns[songIndex].classList.add('fa-play');

    if (song_id !== undefined)
    {
        for (var i = 0; i < songs.length; i++)
        {
            if (songs[i].id == song_id)
            {
                songIndex = i;
                loadSong(songs[songIndex]);
            }
        }
    }

    cataloguePlayBtns[songIndex].classList.remove('fa-play');
    cataloguePlayBtns[songIndex].classList.add('fa-pause');

    console.log(songs[songIndex])
    addSong(songs[songIndex]);

    audio.play();
}

// Pause song
function pauseSong(song_id)
{
    musicContainer.classList.remove('play');
    playBtn.querySelector('i.fas').classList.add('fa-play');
    playBtn.querySelector('i.fas').classList.remove('fa-pause');

    updateCatalogueBtn();

    audio.pause();
}

// Previous song
function prevSong()
{
    updateCatalogueBtn();

    songIndex--;

    if (songIndex < 0)
    {
        songIndex = songs.length - 1;
    }

    loadSong(songs[songIndex]);

    playSong();
}

// Next song
function nextSong()
{
    updateCatalogueBtn();

    songIndex++;

    if (songIndex > songs.length - 1)
    {
        songIndex = 0;
    }

    console.log('write');
    loadSong(songs[songIndex]);

    playSong();
}

function updateCatalogueBtn()
{
    for (var i = 0; i < cataloguePlayBtns.length; i++)
    {
        if (cataloguePlayBtns[i].id == songs[songIndex].id)
        {
            cataloguePlayBtns[i].classList.add('fa-play');
            cataloguePlayBtns[i].classList.remove('fa-pause');
        }
    }
}

// Update progress bar
function updateProgress(e)
{
    const { duration, currentTime } = e.srcElement;
    const progressPercent = (currentTime / duration) * 100;
    progress.style.width = `${progressPercent}%`;
}

// Set progress bar
function setProgress(e)
{
    const width = this.clientWidth;
    const clickX = e.offsetX;
    const duration = audio.duration;

    audio.currentTime = (clickX / width) * duration;
}

//get duration & currentTime for Time of song
function DurTime(e)
{
    const { duration, currentTime } = e.srcElement;
    var sec;
    var sec_d;

    // define minutes currentTime
    let min = (currentTime == null) ? 0 :
        Math.floor(currentTime / 60);
    min = min < 10 ? '0' + min : min;

    // define seconds currentTime
    function get_sec(x)
    {
        if (Math.floor(x) >= 60)
        {

            for (var i = 1; i <= 60; i++)
            {
                if (Math.floor(x) >= (60 * i) && Math.floor(x) < (60 * (i + 1)))
                {
                    sec = Math.floor(x) - (60 * i);
                    sec = sec < 10 ? '0' + sec : sec;
                }
            }
        } else
        {
            sec = Math.floor(x);
            sec = sec < 10 ? '0' + sec : sec;
        }
    }

    get_sec(currentTime, sec);

    // change currentTime DOM
    currTime.innerHTML = min + ':' + sec;

    // define minutes duration
    let min_d = (isNaN(duration) === true) ? '0' :
        Math.floor(duration / 60);
    min_d = min_d < 10 ? '0' + min_d : min_d;


    function get_sec_d(x)
    {
        if (Math.floor(x) >= 60)
        {

            for (var i = 1; i <= 60; i++)
            {
                if (Math.floor(x) >= (60 * i) && Math.floor(x) < (60 * (i + 1)))
                {
                    sec_d = Math.floor(x) - (60 * i);
                    sec_d = sec_d < 10 ? '0' + sec_d : sec_d;
                }
            }
        } else
        {
            sec_d = (isNaN(duration) === true) ? '0' :
                Math.floor(x);
            sec_d = sec_d < 10 ? '0' + sec_d : sec_d;
        }
    }

    // define seconds duration

    get_sec_d(duration);

    // change duration DOM
    durTime.innerHTML = min_d + ':' + sec_d;

};

// Event listeners
playBtn.addEventListener('click', () =>
{
    const isPlaying = musicContainer.classList.contains('play');

    if (isPlaying)
    {
        pauseSong();
    } else
    {
        playSong();
    }
});

for (var i = 0; i < cataloguePlayBtns.length; i++)
{
    cataloguePlayBtns[i].addEventListener('click', (e) =>
    {
        const isPlaying = musicContainer.classList.contains('play');
        song_id = e.target.id;

        if (isPlaying)
        {
            pauseSong();
            if (song_id != songs[songIndex].id)
            {
                playSong(song_id);
            }

        } else
        {
            playSong(song_id);
        }
    });
}

// Change song
prevBtn.addEventListener('click', prevSong);
nextBtn.addEventListener('click', nextSong);

// Time/song update
audio.addEventListener('timeupdate', updateProgress);

// Click on progress bar
progressContainer.addEventListener('click', setProgress);

// Song ends
audio.addEventListener('ended', nextSong);

// Time of song
audio.addEventListener('timeupdate', DurTime);

const addSong = async (song) =>
{
    const { hostname: location } = window.location;
    var request = $.ajax({
        method: "POST",
        url: `http://${location}:80/src/listensTracker.php`,
        data: { "User_Name": user.innerText, "Song_Id": song.id },
        success: function (responseText)
        {
            console.log('success to reach backend');
        },
        error: function (jqXHR, status, error)
        {
            if (jqXHR.status === 0)
            {
                console.log('Not connected.\nPlease verify your network connection.');
            } else if (jqXHR.status == 404)
            {
                console.log('The requested page not found. [404]');
            } else if (jqXHR.status == 500)
            {
                console.log('Internal Server Error [500].');
            } else if (exception === 'parsererror')
            {
                console.log('Requested JSON parse failed.');
            } else if (exception === 'timeout')
            {
                console.log('Time out error.');
            } else if (exception === 'abort')
            {
                console.log('Ajax request aborted.');
            } else
            {
                console.log('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });

};