( function(){

  'use strict';

  $('#btnVote').on('click',async function(){
    const id = $('#pollUL input:checked').attr('value');

    if ( !id ) {
      return alert('Morate da izaberete jednu od ponudjenih opcija');
    }

    $('#btnVote').hide();
    $('#btnShowVotes').hide();

    try {
      const result = await fetch('/api/vote.php',{
        method:'POST',
        body:JSON.stringify({ id }),
        credentials: "same-origin",
        headers:{ 'Content-Type':'application/json' }
      })

      const response = await result.json();

      if ( response.userDoesntExist === true ) {
        alert('You have to be logged in to vote...');
      }

      if ( response.alreadyVoted === true ) {
        alert('You have already voted...');
      }

      displayPollResults();
    } catch(e) {
      alert('Error occured, please try again...');
    }

  });

  $('#btnShowVotes').on('click',function(){
    $('#btnVote').hide();
    $('#btnShowVotes').hide();

    displayPollResults();
  });

  async function displayPollResults() {
    try {
      const result = await fetch('/api/get_poll.php');
      const response = await result.json();

      const html = response.map(x => {
        const percent = Math.round(x.votes / x.number_of_votes * 100);

        return `
          <li class="list-group-item">
            ${ x.option_name } : ${ x.votes } ${ percent } %
          </li>
        `;
      });

      $('#pollUL').html(html.join(''));
    } catch(e) {
      alert('Error occured, please try again...');
    }
  }

}());