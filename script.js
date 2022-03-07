var audio = {};

function startAudio(url) {
  if("pause" in audio) audio.pause();

  audio = new Audio(url);
  audio.play();
}

