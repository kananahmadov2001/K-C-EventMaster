<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="stylesheets/home.css">
</head>

<body>
    <div class="container">

        <!-- User bar for handling login, registration, and logout -->
        <div class="user-bar-container">
            <div class="not-logged-in">
                <img src="pics/rounded.webp" alt="avatar" class="avatar">
                <button id="login">Sign In</button>
            </div>
            <div class="logged-in">
                <p id="welcome"></p>
                <button id="logout">Logout</button>
            </div>
        </div>

        <div class="login-box" style="display:none;">
            <span class="close" id="close-login-box">&times;</span>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" id="login_btn">Log In</button>
            <button type="submit" id="register_btn">Register</button>
        </div>

        <div class="content-container">
            <!-- Container for main content -->
            <div class="left-side">
                <div id="welcome-message" class="welcome-message">
                    <!-- Welcome message container -->
                    <h2><strong>WELCOME<br><br>TO<br><br>K&C EventMaster<br><br>! ! !</strong></h2><br><br>
                    <img src="pics/pen-pic.png" alt="Pen Picture" class="welcome-image">
                </div>
                <div class="event-container">
                    <!-- Event container, initially hidden -->
                    <div class="event-toolbar">
                        <button id="open-add-event">Add Event</button>
                        <button id="open-view-event">View Event</button>
                        <button id="open-share-calendar">Share Calendar</button>
                    </div>

                    <!-- Add Calendar Modal -->
                    <div id="add-event-box" style="display:none;">
                        <div id="add-event-header">
                            <h2>Add Event</h2>
                        </div>
                        <div id="add-event-input-group">
                            <label for="addEventTitle">Title</label>
                            <input type="text" id="addEventTitle" name="addEventTitle" placeholder="Event Title" required>
                            <label for="addEventTag">Event Tag</label>
                            <select id="addEventTag" name="addEventTag">
                                <option value="personal">Personal</option>
                                <option value="business">Business</option>
                                <option value="school">School</option>
                                <option value="etc">Etc</option>
                            </select>
                            <label for="addEventDate">Date</label>
                            <input type="date" id="addEventDate" name="addEventDate" required>
                            <label for="addEventTime">Time</label>
                            <input type="time" id="addEventTime" name="addEventTime" required>
                        </div>
                        <button type="submit" id="addEventToDB">Add To Calendar</button>
                        <span class="close" id="close-add-event-box">&times;</span>
                    </div>

                    <!-- Edit Event Modal -->
                    <div id="edit-event-box" style="display:none;">
                        <div id="edit-event-header">
                            <h2>Edit Event</h2>
                        </div>
                        <div id="edit-event-input-group">
                            <label for="editEventTitle">Title</label>
                            <input type="text" id="editEventTitle" name="editEventTitle" placeholder="Event Title" required>
                            <label for="editEventTag">Event Tag</label>
                            <select id="editEventTag" name="editEventTag">
                                <option value="personal">Personal</option>
                                <option value="business">Business</option>
                                <option value="school">School</option>
                                <option value="etc">Etc</option>
                            </select>
                            <label for="editEventDate">Date</label>
                            <input type="date" id="editEventDate" name="editEventDate" required>
                            <label for="editEventTime">Time</label>
                            <input type="time" id="editEventTime" name="editEventTime" required>
                            <input type="hidden" id="editEventDBID">
                        </div>
                        <button type="submit" id="editEventInDB">Edit Calendar Event</button>
                        <span class="close" id="close-edit-event-box">&times;</span>
                    </div>

                    <!-- View Event Modal -->
                    <div id="view-event-box">
                        <div id="view-event-header">
                            <h2>View Event</h2>
                        </div>
                        <div id="view-event-input-group">
                            <br>
                            <label for="viewEventTag">View Event by Tag</label>
                            <select id="viewEventTag" name="viewEventTag">
                                <option value="personal">Personal</option>
                                <option value="business">Business</option>
                                <option value="school">School</option>
                                <option value="etc">Etc</option>
                            </select>
                            <button type="submit" id="viewEventsFromDBTag">Submit</button>
                            <label for="viewEventDate">View Event On Day</label>
                            <input type="date" id="viewEventDate" name="viewEventDate">
                            <button type="submit" id="viewEventsFromDBDate">Submit</button>
                        </div>
                        <button type="submit" id="viewEventAll">View All Your Events</button>
                        <span class="close" id="close-view-event-box">&times;</span>
                    </div>

                    <!-- Share Calendar Modal -->
                    <div id="share-calendar-box" style="display:none;">
                        <div id="share-calendar-header">
                            <h2>Share Calendar</h2>
                        </div>
                        <div id="share-calendar-input-group">
                            <label for="shareWithUser">Share With User</label>
                            <select id="shareWithUser" name="shareWithUser">
                                <!-- Dynamically populate with user IDs and names -->
                            </select>
                        </div>
                        <button type="submit" id="shareCalendar">Share</button>
                        <span class="close" id="close-share-calendar-box">&times;</span>
                    </div>
                </div>
                <div class="output-events"></div>
            </div>

            <div class="right-side">
                <div class="calendar_container">
                    <div class="nav_buttons">
                        <!-- Navigation buttons for the calendar -->
                        <div class="prev_month_btn">
                            <button>&lt;</button>
                            <!-- Button to navigate to the previous month -->
                        </div>
                        <div class="current_month">
                            <h2>July 2024</h2>
                            <!-- Current month display -->
                        </div>
                        <div class="next_month_btn">
                            <button>&gt;</button>
                            <!-- Button to navigate to the next month -->
                        </div>
                    </div>

                    <div id="display-container">
                        <!-- Container for the calendar display -->
                        <table class="calendar">
                            <tr class="weekdays">
                                <th>Sunday</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="ajax.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", updateCalendar, false);
        document.addEventListener("DOMContentLoaded", checkLoginStatus, false);
        document.addEventListener("DOMContentLoaded", getAllUsers, false);

        document.querySelector("#login").addEventListener("click", openLoginBox, false); // Event listener to open login box
        document.querySelector("#close-login-box").addEventListener("click", closeLoginBox, false); // Event listener to close login box

        // Event-management events
            //Add
        document.querySelector("#open-add-event").addEventListener("click", showAddEventBox, false); // Event listener to show add event box
        document.querySelector("#close-add-event-box").addEventListener("click", closeAddEventBox, false); // Event listener to close add event box
        
            //View
        document.querySelector("#open-view-event").addEventListener("click", showViewEventBox, false);
        document.querySelector("#close-view-event-box").addEventListener("click",closeViewEventBox, false);
        
            //Edit
        document.querySelector("#close-edit-event-box").addEventListener("click",closeEditEventBox, false);
        document.querySelector("#editEventInDB").addEventListener("click",editEvent, false);            

            //Share
        document.querySelector("#open-share-calendar").addEventListener("click", showShareCalendarBox, false);
        document.querySelector("#close-share-calendar-box").addEventListener("click", closeShareCalendarBox, false);

        document.querySelector("#shareCalendar").addEventListener("click", shareCalendar, false);

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ VVV CALENDAR CODE VVV ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        // Extend Date prototype with deltaDays and getSunday methods
        (function () {
            Date.prototype.deltaDays = function (c) { return new Date(this.getFullYear(), this.getMonth(), this.getDate() + c) }; // Method to get date c days from current date
            Date.prototype.getSunday = function () { return this.deltaDays(-1 * this.getDay()) } // Method to get the Sunday of the current week
        })();
        
        function Week(c) {
            this.sunday = c.getSunday();
            this.nextWeek = function () { return new Week(this.sunday.deltaDays(7)) }; // Get the next week
            this.prevWeek = function () { return new Week(this.sunday.deltaDays(-7)) }; // Get the previous week
            this.contains = function (b) { return this.sunday.valueOf() === b.getSunday().valueOf() }; // Check if the week contains the given date
            this.getDates = function () { for (var b = [], a = 0; 7 > a; a++) b.push(this.sunday.deltaDays(a)); return b } // Get all dates in the week
        }
        
        function Month(c, b) {
            this.year = c;
            this.month = b;
            this.nextMonth = function () { return new Month(c + Math.floor((b + 1) / 12), (b + 1) % 12) }; // Get the next month
            this.prevMonth = function () { return new Month(c + Math.floor((b - 1) / 12), (b + 11) % 12) }; // Get the previous month
            this.getDateObject = function (a) { return new Date(this.year, this.month, a) }; // Get the date object for the given day
            this.getWeeks = function () {
                var a = this.getDateObject(1), b = this.nextMonth().getDateObject(0), c = [], a = new Week(a);
                for (c.push(a); !a.contains(b);) a = a.nextWeek(), c.push(a); // Get all weeks in the month
                return c
            }
        };

        const currentMonthHeading = document.querySelector(".current_month h2");
        const date = new Date();
        const monthNames = {
            0: "January",
            1: "February",
            2: "March",
            3: "April",
            4: "May",
            5: "June",
            6: "July",
            7: "August",
            8: "September",
            9: "October",
            10: "November",
            11: "December"
        };

        let currentMonth = new Month(date.getFullYear(), date.getMonth(), date.getDay());

        // Event listener to change to the previous month
        document.getElementsByClassName("prev_month_btn")[0].addEventListener("click", function (event) {
            currentMonth = currentMonth.prevMonth();
            updateCalendar();
            currentMonthHeading.textContent = monthNames[currentMonth.month] + " " + currentMonth.year;
        }, false);

        // Event listener to change to the next month
        document.getElementsByClassName("next_month_btn")[0].addEventListener("click", function (event) {
            currentMonth = currentMonth.nextMonth();
            updateCalendar();
            currentMonthHeading.textContent = monthNames[currentMonth.month] + " " + currentMonth.year;
        }, false);

        // Function to update the calendar display
        function updateCalendar() {
            let weeks = currentMonth.getWeeks();
            let calendar = document.querySelector(".calendar");
            
            while (calendar.rows.length > 1) {
                calendar.deleteRow(-1);
            }

            for (let w in weeks) {
                let days = weeks[w].getDates();
                let calendarRow = calendar.insertRow();

                for (let d in days) {
                    let cell = calendarRow.insertCell(-1); 
                    cell.innerHTML = days[d].getDate();
                    cell.setAttribute("id", "calendar_day");

                    if (days[d].toDateString() == date.toDateString()) {
                        cell.setAttribute("class", "current_day");
                        cell.innerHTML += "<span class=\"tooltip\">Today</span>";
                    }
                }
            }
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ^^^ CALENDAR CODE ^^^ ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ VVV LOGIN CODE VVV ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function openLoginBox() {
            document.getElementsByClassName('login-box')[0].style.display = 'block';
        }

        function closeLoginBox() {
            document.getElementsByClassName('login-box')[0].style.display = 'none';
        }

        // Function to check the login status
        function checkLoginStatus() {
            fetch("is_logged_in.php")
                .then(response => response.json())
                .then(data => {
                    if (data.loggedin) {
                        document.getElementsByClassName('not-logged-in')[0].style.display = 'none';
                        document.getElementsByClassName('logged-in')[0].style.display = 'flex';
                       
                        document.getElementsByClassName('event-container')[0].style.display = 'block'; // Show the event container
                        document.getElementById('welcome-message').style.display = 'none'; // Hide the welcome message
                        document.getElementById("welcome").textContent = `Hi ${data.username}!`;
                        document.getElementsByClassName('user-bar-container')[0].style.transition = 'background-color 2s ease-in';
                        document.getElementsByClassName('user-bar-container')[0].style.backgroundColor = '#C4C4C4';
                    } else {
                        document.getElementsByClassName('logged-in')[0].style.display = 'none';
                        document.getElementsByClassName('not-logged-in')[0].style.display = 'flex';
                        document.getElementById('welcome-message').style.display = 'block'; // show the welcome message
                        
                        document.getElementsByClassName('event-toolbar')[0].style.display = 'none';
                        document.getElementsByClassName('user-bar-container')[0].style.transition = 'background-color 2s ease-out';
                        document.getElementsByClassName('user-bar-container')[0].style.backgroundColor = '#4A4A4A';
                    }
                    document.getElementById('add-event-box').style.display = 'none';
                    document.getElementById('view-event-box').style.display = 'none';
                });
        }
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ^^^ LOGIN CODE ^^^ ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        // Section for handling events     
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function showAddEventBox(){
            document.getElementsByClassName('event-toolbar')[0].style.display = 'none';
            document.getElementById('add-event-box').style.display = 'flex';
        }

        // Function to close the add event box
        function closeAddEventBox() {
            document.getElementsByClassName('event-toolbar')[0].style.display = 'flex';
            document.getElementById('add-event-box').style.display = 'none';
        }

        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ View ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function showViewEventBox(){
            document.getElementsByClassName('event-toolbar')[0].style.display = 'none';
            document.getElementById('view-event-box').style.display = 'flex';
        }
        function closeViewEventBox(){
            document.getElementsByClassName('event-toolbar')[0].style.display = 'flex';
            document.getElementById('view-event-box').style.display = 'none';
        }
        
        function outputEventsFromDB(events) {
            document.querySelector("#view-event-box").style.display = "none";
            const eventContainer = document.querySelector(".output-events");
            eventContainer.style.display = "block";
            eventContainer.style.position = "absolute";
            eventContainer.style.top = "40%";
            eventContainer.style.left = "7%";
            

            // Help from MDN: https://developer.mozilla.org/en-US/docs/Web/API/Node/removeChild 
            while(eventContainer.firstChild){
                eventContainer.removeChild(eventContainer.firstChild);
            }

            events.forEach(event => {
                const eventElement = document.createElement("div");
                eventElement.classList.add("event");

                const titleElement = document.createElement("span");
                titleElement.textContent = event.title;

                const dateElement = document.createElement("span");
                dateElement.textContent = `Date: ${event.date}`;

                const timeElement = document.createElement("span");
                timeElement.textContent = `Time: ${event.time}`;

                const tagElement = document.createElement("span");
                tagElement.textContent = `Tag: ${event.tag}`;

                const editElement = document.createElement("button");
                editElement.className = "edit-event";
                editElement.setAttribute("id",`edit-${event.id}`);
                editElement.innerHTML = "Edit";
                editElement.value = event.id;

                const deleteElement = document.createElement("button");
                deleteElement.className = "delete-event";
                deleteElement.setAttribute("id",`delete-${event.id}`);
                deleteElement.innerHTML = "Delete";
                deleteElement.value = event.id;

                // Append elements to eventElement
                eventElement.appendChild(titleElement);
                eventElement.appendChild(document.createTextNode(" "));
                eventElement.appendChild(dateElement);
                eventElement.appendChild(document.createTextNode(" "));
                eventElement.appendChild(timeElement);
                eventElement.appendChild(document.createTextNode(" "));
                
                console.log(tagElement.textContent.length);

                if (tagElement.textContent.length > 5) { // check if there is a tag
                    eventElement.appendChild(tagElement);
                    
                }
                
                eventElement.appendChild(document.createElement('br'));
                eventElement.appendChild(editElement);
                eventElement.appendChild(document.createTextNode(" "));
                eventElement.appendChild(deleteElement);

                eventContainer.appendChild(eventElement);
            });

            // add delete button
            eventContainer.innerHTML += "<span class=\"close\" id=\"close-output-event-box\">&times;</span>";

            events.forEach(event => {
                document.querySelector(`#edit-${event.id}`).addEventListener("click", function() {
                    
                    eventContainer.style.display = "none";
                    document.querySelector(".event-toolbar").style.display = "none";
                    document.querySelector("#edit-event-box").style.display = "flex";
                    document.querySelector("#editEventDBID").setAttribute("value", `${event.id}`) ;
                });
                
                
                document.querySelector(`#delete-${event.id}`).addEventListener("click", function() {
                    deleteEvent(event.id);
                });
            });            

            document.querySelector(`#close-output-event-box`).addEventListener("click", function() {
                    
                    eventContainer.style.display = "none";
                    document.querySelector(".event-toolbar").style.display = "flex";
                });
        }
        
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Edit ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function closeEditEventBox() {
            document.getElementById("edit-event-box").style.display = "none";
            document.getElementsByClassName("event-toolbar")[0].style.display = "flex";
        }

        function editEvent(event) {
                event.preventDefault();    
                const link = "dbedit.php"
                
                // data from add event
                let title = document.querySelector("#editEventTitle").value;
                let tag = document.querySelector("#editEventTag").value;
                let date = document.querySelector("#editEventDate").value;
                let time = document.querySelector("#editEventTime").value;
                let eventID = document.querySelector("#editEventDBID").value;
                let token = sessionStorage.getItem("current_token");  // for token validation

                const dataBody = { title: title, tag: tag, date: date, time: time, eventID: eventID, token: token };

                fetch(link, {
                    method: 'POST',
                    body: JSON.stringify(dataBody),
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`If you are the event creator, event will be edited. Those who have the event shared with them cannot edit.`);
                    } else {
                        console.error(`${data.message}`);
                    }
                })
                .catch(err => console.error(err));

                closeAddEventBox();
                document.getElementById("edit-event-box").style.display = "none";
                document.getElementById("view-event-box").style.display = "none";
            }
        
        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~            
        function deleteEvent(eventID) {
            const link = "dbdelete.php";

            let token = sessionStorage.getItem("current_token");  // for token validation
            
            const dataBody = { eventID: eventID, token: token };

            fetch(link, {
                method: 'POST',
                body: JSON.stringify(dataBody),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`If you are the event creator, event will be deleted. Those who have the event shared with them cannot delete.`);
                    document.querySelector(".output-events").style.display = "none";
                    document.querySelector(".event-toolbar").style.display = "flex";
                } else {
                    console.error(`${data.message}`);
                }
            })
            .catch(err => console.error(err));

        }

        //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Share ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        function showShareCalendarBox() {
            document.querySelector(".event-toolbar").style.display = "none";
            document.querySelector("#share-calendar-box").style.display = "block";
        }

        function closeShareCalendarBox() {
            document.querySelector(".event-toolbar").style.display = "flex";
            document.querySelector("#share-calendar-box").style.display = "none";
        }

        // AJAX functionality to allow indexing users for later usage
        // Placed here as a reqirement for sharing
        function getAllUsers(users) {

            let token = sessionStorage.getItem("current_token");  // for token validation

            const dataBody = { token: token };

            fetch("dbgetusers.php", {
                method: 'POST', // using the POST method
                body: JSON.stringify(dataBody),
                headers: { 'Content-Type': 'application/json' } // setting the content type to JSON
            })
            .then(response => response.json()) // parsing the JSON response
            .then(data => {
                if (data.success) {
                    console.log("Users retrieved!");
                    addUserstoShare(data.users, data.loggedin_userID);
                } else {
                    console.log(`You could not retrieve users.`);
                }
            })
            .catch(err => console.log(err));            
        }

        // adds users to share dropdown
        function addUserstoShare(users, loggedin_userID) {
            // connection to getAllUsers;
            userContainer = document.querySelector("#shareWithUser");
            
            users.forEach(user => {
                if (user.id != loggedin_userID) { //checks to see if logged user is currently beign read from array
                    userOption = document.createElement("option");
                    userOption.value = user.id;
                    userOption.textContent = user.username;
                    userContainer.appendChild(userOption);
                }
            });
        }
        
        function shareCalendar() {
            const link = "share_calendar.php";

            const shared_with_user_id = document.getElementById("shareWithUser").value;
            let token = sessionStorage.getItem("current_token");  // for token validation

            const dataBody = { shared_with_user_id: shared_with_user_id, token: token };

            fetch(link, {
                method: 'POST',
                body: JSON.stringify(dataBody),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`SUCCESS: ${data.message}`);
                    closeShareCalendarBox();
                } else {
                    console.error(`ERROR: ${data.message}`);
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>