<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="#">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"
    />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Music Player</title>
  </head>
  <body>
    <h1>Music Player</h1>

    <div class="music-container" id="music-container">
      <div class="music-info">
        <h4 id="title"></h4>
        <div class="progress-container" id="progress-container">
          <div class="progress" id="progress"></div>
        </div>
        <div class="time">
            <span id = "currTime"></span>
            <span id = "durTime"></span>
        </div>
      </div>

      <audio src="../music/A Lifetime Of Adventure.mp3" id="audio"></audio>

      <div class="img-container">
        <img src="../images/A Lifetime Of Adventure.jpg" alt="music-cover" id="cover" />
      </div>
      <div class="navigation">
        <button id="prev" class="action-btn">
          <i class="fas fa-backward"></i>
        </button>
        <button id="play" class="action-btn action-btn-big">
          <i class="fas fa-play"></i>
        </button>
        <button id="next" class="action-btn">
          <i class="fas fa-forward"></i>
        </button>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>