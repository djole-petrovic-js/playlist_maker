( function(){

  'use strict';

  const select = (selector) => {
    return document.querySelector(selector);
  };

  const selectAll = (selector) => {
    return Array.from(document.querySelectorAll(selector));
  }

  const ajax = async (url,params,returnValue = 'json') =>   {
    try {
      const result = await fetch(url,params);
      const response = await result[returnValue]();

      return response;
    } catch(e) {
      throw e;
    }
  }

  const allSongButtons = selectAll('.btnSongs');

  const getSongs = async (e) => {
    const playlistID = e.target.dataset.id;

    try {
      const allSongs = await ajax('/api/songs.php',{
        method:'POST',
        body:JSON.stringify({ playlistID })
      });

      if ( allSongs.length === 0 ) {
        return select('#list' + playlistID).innerHTML = `<li class="list-group-item">No songs for this playlist...</li>`;
      }

      const all = allSongs.map(({ song_title }) => `<li class="list-group-item">${ song_title }</li>`);

      select('#list' + playlistID).innerHTML = all.join('');
    } catch(e) {
      alert('Error ocured , please try again...');
    }
  }

  allSongButtons.forEach(x => x.addEventListener('click',getSongs));

}());