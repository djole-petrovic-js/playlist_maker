( function() {

  'use strict';

  const select = (selector) => {
    return document.querySelector(selector);
  };

  const ajax = async (url,params,returnValue = 'json') =>   {
    try {
      const result = await fetch(url,params);
      const response = await result[returnValue]();

      return response;
    } catch(e) {
      throw e;
    }
  }

  const registerForm = select('#registerForm');
  const errorsDiv = select('#errorsDiv');
  const checkIfUsernameExists = select('#checkIfUsernameExists');
  const checkIfEmailExists = select('#checkIfEmailExists');
  const emailLabel = select('#checkIfEmailExistsLabel');
  const usernameLabel = select('#checkIfUsernameExistsLabel');
  const username = select('#registerForm input[name=username]');
  const email = select('#registerForm input[name=email]');

  checkIfEmailExists.addEventListener('click',async(e) => {
    e.preventDefault();

    if ( email.value.length === 0 ) {
      return emailLabel.innerHTML = 'Enter email...';
    }

    const form = new Form({
      email:'bail|required|regex:^[a-zA-Z0-9\.\?\!]+@[a-z]+(\.[a-z]{2,4})?\.[a-z]{2,4}$'
    });

    form.bindValues({ email:email.value }).validate();

    if ( !form.isValid() ) {
      return emailLabel.innerHTML = 'Please enter email in proper format...';
    }

    emailLabel.innerHTML = 'Loading...';

    try {
      const response = await ajax('/api/checkIfEmailExists.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({ email:email.value })
      });

      emailLabel.innerHTML = response.exists
        ? 'Email you entered already exists'
        : 'This email is free to use';

    } catch(e) {
      emailLabel.innerHTML = 'Error occured , please try again...';
    }
  });

  checkIfUsernameExists.addEventListener('click',async(e) => {
    e.preventDefault();

    if ( username.value.length === 0 ) {
      return usernameLabel.innerHTML = 'Enter username...';
    }

    const form = new Form({
      username:'bail|required|minlength:5|maxlength:15|regex:^[a-zA-Z0-9.\?\!]{5,15}$'
    });

    form.bindValues({ username:username.value }).validate();

    if ( !form.isValid() ) {
      return usernameLabel.innerHTML = 'Please enter username in proper format...';
    }

    usernameLabel.innerHTML = 'Loading...';

    try {
      const response = await ajax('/api/checkIfUsernameExists.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({ username:username.value })
      });

      usernameLabel.innerHTML = response.exists
        ? 'Username you entered already exists'
        : 'This username is free to use';

    } catch(e) {
      usernameLabel.innerHTML = 'Error occured , please try again...';
    }
  });

  registerForm.addEventListener('submit',(e) => {
    const form = new Form({
      username:'bail|required|minlength:5|maxlength:15|regex:^[a-zA-Z0-9.\?\!]{5,15}$',
      password:'bail|required|minlength:5',
      email:'bail|required|regex:^[a-zA-Z0-9\.\?\!]+@[a-z]+(\.[a-z]{2,4})?\.[a-z]{2,4}$',
      country:'bail|required|minlength:5|regex:^[a-zA-Z0-9\.\/]{5,}$'
    });

    form.bindValues('#registerForm');
    form.validate();

    if ( !form.isValid() ) {
      e.preventDefault();

      errorsDiv.innerHTML = form.getErrorsAsUL('list-group','list-group-item');
    }
  });
 
}());