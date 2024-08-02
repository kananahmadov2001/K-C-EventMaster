
// AJAX functionality to allow LOGIN 
function loginAjax(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    // add token?

    const dataBody = { username: username, password: password };
  
    fetch("login_ajax.php", {
            method: 'POST', // using the POST method
            body: JSON.stringify(dataBody), // converting the dataBody object to a JSON string
            headers: { 'Content-Type': 'application/json' } // setting the content type to JSON
        })
        .then(response => response.json()) // parsing the JSON response
        .then(data => {
            if (data.success) {
                console.log("You've been logged in!");
                sessionStorage.setItem("current_token", data.token);
                document.getElementById("welcome").textContent = `Hi ${data.username}!`;
                document.getElementsByClassName('not-logged-in')[0].style.display = 'none';
                document.getElementsByClassName('logged-in')[0].style.display = 'flex';
                document.getElementsByClassName('event-toolbar')[0].style.display = 'flex';
                closeLoginBox();
                getAllUsers();
            } else {
                alert(`You were not logged in: ${data.message}`);
            }
            checkLoginStatus();
        })
        .catch(err => console.log(err));
  }

  // AJAX functionality to allow REGISTRATION
  function registerAjax(event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    
    const dataBody = { "username": username, "password": password };
  
    fetch("register_ajax.php", {
            method: 'POST',
            body: JSON.stringify(dataBody),
            headers: { 'Content-Type': 'application/json' } 
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
              alert(data.message + " You can log in now!");
            } else { 
                console.error(data.message);
            }
            checkLoginStatus();
        })
        .catch(err => console.error(err));
  }
  
  // AJAX functionality to allow LOGOUT
  function logoutAjax(event) {
    event.preventDefault();
  
    fetch("logout_ajax.php", {
            method: 'POST', 
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("You've been logged out!");
                document.getElementsByClassName('not-logged-in')[0].style.display = 'block';
                document.getElementsByClassName('logged-in')[0].style.display = 'none';
                document.getElementsByClassName('output-events')[0].style.display = 'none';
                sessionStorage.clear();
            } else { // If logout is not successful
                console.error(`Logout failed: ${data.message}`);
            }
            checkLoginStatus();
        })
        .catch(err => console.error(err));
  }
  
  // AJAX for Event-Maagement
  
  // Add event
  function addEvent(event) {
      event.preventDefault();    
      const link = "dbadd.php"
      
      // Data from add event
      let title = document.querySelector("#addEventTitle").value;
      let tag = document.querySelector("#addEventTag").value;
      let date = document.querySelector("#addEventDate").value;
      let time = document.querySelector("#addEventTime").value;
      let token = sessionStorage.getItem("current_token");  // for token validation
      
      const dataBody = { title: title, tag: tag, date: date, time: time, token: token };
  
      fetch(link, {
          method: 'POST',
          body: JSON.stringify(dataBody),
          headers: { 'Content-Type': 'application/json' }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert(`${data.message}`);
              sessionStorage.getItem("token", data.token);  // for token validation
          } else {
              console.error(`${data.message}`);
          }
      })
      .catch(err => console.error(err));
  
      closeAddEventBox();
  }
  
  // View Events
  function viewEvent(type) {
      const link = "dbview.php"
      
      // data from view event
  
      const queryType = type;
      let token = sessionStorage.getItem("current_token");  // for token validation

      let dataBody;
      
      if (queryType == "byTag") {
        let tag = document.querySelector("#viewEventTag").value;
        dataBody = { tag: tag, type: queryType, token: token };
      }
      else if (queryType == "byDate") {
          let date = document.querySelector("#viewEventDate").value;
          dataBody = { date: date, type: queryType, token: token };
      }
      else if (queryType == "all") {
          dataBody = { type: queryType, token: token };
      }
      else {
          alert("Error has occured with viewing event.");
          return;
      }
  
      fetch(link, {
          method: 'POST',
          body: JSON.stringify(dataBody),
          headers: { 'Content-Type': 'application/json' }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              outputEventsFromDB(data.events);
          } else {
              console.error(`${data.message}`);
          }
      })
      .catch(err => console.error(err));
  
      closeViewEventBox();
      document.getElementsByClassName('event-toolbar')[0].style.display = 'none';
  
  }


// Event listeners for login, register, and logout buttons
document.getElementById("login_btn").addEventListener("click", loginAjax, false);
document.getElementById("register_btn").addEventListener("click", registerAjax, false); 
document.getElementById("logout").addEventListener("click", logoutAjax, false); 

// Event listeners for event-management
document.querySelector("#addEventToDB").addEventListener("click", addEvent, false); // Event listener to add event to database
document.querySelector("#viewEventAll").addEventListener("click", function() { viewEvent("all") }, false); // view all
document.querySelector("#viewEventsFromDBTag").addEventListener("click", function() { viewEvent("byTag") }, false); // view by date
document.querySelector("#viewEventsFromDBDate").addEventListener("click", function() { viewEvent("byDate") }, false); // view by date