function findVenues() {
  const date = document.getElementById("date").value;
  const from = document.getElementById("from").value;
  const to = document.getElementById("to").value;

  // Check if all required fields are filled
  if (!date || !from || !to) {
    alert("Please fill out all fields before searching for venues.");
    return;
  }

  // Prevent booking for past dates (client-side)
  const today = new Date();
  today.setHours(0, 0, 0, 0); // Set to midnight for accurate comparison
  const selectedDate = new Date(date);
  selectedDate.setHours(0, 0, 0, 0);
  if (selectedDate < today) {
    const resultsDiv = document.getElementById("results");
    resultsDiv.innerHTML = '<div style="color:red; font-weight:bold;">You cannot search or book for a past date.</div>';
    return;
  }

  fetch(`get_venues.php?date=${encodeURIComponent(date)}&from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`)
    .then(response => {
      if (!response.ok) throw new Error("Network response was not ok");
      return response.json();
    })
    .then(data => {
      // Fetch locked venues and display lock reason if any
      fetch('get_locked_venues.php')
        .then(r => r.json())
        .then(locked => {
          const resultsDiv = document.getElementById("results");
          resultsDiv.innerHTML = "";
          const userRole = sessionStorage.getItem("userRole") || "guest";
          data.forEach(venue => {
            const div = document.createElement("div");
            let lockMsg = '';
            if (locked[venue.id]) {
              lockMsg = `<div style='color:red;font-weight:bold;'>Locked: ${locked[venue.id]}</div>`;
            }
            div.innerHTML = `<h3>${venue.name}</h3>
                             <p>Capacity: ${venue.capacity}</p>
                             <p>Features: ${venue.features}</p>
                             ${lockMsg}`;
            if (locked[venue.id]) {
              // If locked, do not show book button
              div.innerHTML += `<p style='color:gray;'><em>Booking disabled for this venue.</em></p>`;
            } else if (userRole === "crs" || userRole === "teacher") {
              div.innerHTML += `<button onclick="bookVenue(${venue.id})">Book</button>`;
            } else {
              div.innerHTML += `<p style="color: gray;"><em>Login as CRS/Teacher to book</em></p>`;
            }
            resultsDiv.appendChild(div);
          });

          // Notification button for CRS/Teacher
          if (userRole === "crs" || userRole === "teacher") {
            const resultsDiv = document.getElementById("results");
            const notifBtn = document.createElement("button");
            notifBtn.textContent = "View Notifications";
            notifBtn.style.margin = "12px 0 18px 0";
            notifBtn.onclick = function () {
              window.open('notifications.html', '_blank');
            };
            resultsDiv.appendChild(notifBtn);
            // Complaint button
            const complaintBtn = document.createElement("button");
            complaintBtn.textContent = "Submit a Complaint";
            complaintBtn.style.margin = "0 0 18px 12px";
            complaintBtn.onclick = function () {
              window.open('complaint.html', '_blank');
            };
            resultsDiv.appendChild(complaintBtn);
          }
        });
    })
    .catch(error => {
      console.error("Fetch error:", error);
    });
}

function bookVenue(venueId) {
  const date = document.getElementById("date").value;
  const from = document.getElementById("from").value;
  const to = document.getElementById("to").value;

  // Prevent booking for past dates (client-side)
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const selectedDate = new Date(date);
  selectedDate.setHours(0, 0, 0, 0);
  if (selectedDate < today) {
    alert("You cannot book a venue for a past date.");
    return;
  }

  // Pass userRole from sessionStorage to PHP for authorization
  const userRole = sessionStorage.getItem("userRole") || "guest";

  fetch("book_venue.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `venue_id=${venueId}&date=${encodeURIComponent(date)}&from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&userRole=${encodeURIComponent(userRole)}`
  })
    .then(response => response.text())
    .then(msg => {
      alert(msg);
      findVenues();
    })
    .catch(error => {
      console.error("Booking error:", error);
    });
}

window.onload = function () {
  // If not logged in, redirect to login page
  const userRole = sessionStorage.getItem("userRole");
  const fullname = sessionStorage.getItem("fullname");
  if (!userRole) {
    window.location.href = "login.html";
    return;
  }
  // Optionally, show user info or logout button
  const container = document.querySelector('.container');
  if (container) {
    const infoDiv = document.createElement('div');
    infoDiv.style.textAlign = 'right';
    infoDiv.innerHTML = `<span style="color:#007bff;font-weight:bold;">Logged in as: ${fullname} (${userRole.toUpperCase()})</span> <button id="logoutBtn" style="margin-left:10px;">Logout</button>`;
    container.insertBefore(infoDiv, container.firstChild);
    document.getElementById('logoutBtn').onclick = function () {
      fetch('logout.php').then(() => {
        sessionStorage.removeItem('userRole');
        sessionStorage.removeItem('fullname');
        window.location.href = 'login.html';
      });
    };
  }
  // Set minimum date for date input to today to prevent selecting past dates
  const dateInput = document.getElementById('date');
  if (dateInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const minDate = `${yyyy}-${mm}-${dd}`;
    dateInput.setAttribute('min', minDate);
  }
  // Notification for key given/returned
  if (userRole === 'crs' || userRole === 'teacher') {
    Promise.all([
      fetch('get_notifications.php').then(r => r.json()),
      fetch('bookings.json').then(r => r.json()),
      fetch('get_venues.php').then(r => r.json())
    ]).then(([notifs, bookings, venues]) => {
      let msg = '';
      notifs.forEach(n => {
        const b = bookings[n.idx];
        if (b && b.booked_by === fullname) {
          const venue = venues.find(v => String(v.id) === String(b.venue_id));
          const venueName = venue ? venue.name : b.venue_id;
          if (n.type === 'given') msg += `<div style='color:green;font-weight:bold;'>Guard has given you the key for venue <b>${venueName}</b> on ${b.date}.</div>`;
          if (n.type === 'returned') msg += `<div style='color:blue;font-weight:bold;'>Guard has marked the key as returned for venue <b>${venueName}</b> on ${b.date}.</div>`;
        }
      });
      if (msg) {
        const resultsDiv = document.getElementById('results');
        if (resultsDiv) resultsDiv.innerHTML = msg + resultsDiv.innerHTML;
      }
    });
  }
};
