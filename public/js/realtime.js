// public/js/realtime.js
function updateRealTime() {
    // Fetch the server time
    fetch('/get-server-time.php') // Update the URL to point to your PHP script
        .then(response => response.json())
        .then(data => {
            // Get the server time
            const serverTime = new Date(data.time);

            // Define an array to map month numbers to month names
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            // Format the date, month, and year
            const day = serverTime.getDate().toString().padStart(2, '0');
            const month = monthNames[serverTime.getMonth()]; // Get month name from the array
            const year = serverTime.getFullYear();

            // Format the time
            const hours = serverTime.getHours().toString().padStart(2, '0');
            const minutes = serverTime.getMinutes().toString().padStart(2, '0');
            const seconds = serverTime.getSeconds().toString().padStart(2, '0');

            // Update the HTML element with the new time and date
            document.getElementById('real-time-clock').innerText = `${day} - ${month} - ${year} `;
        })
        .catch(error => {
            console.error('Error fetching server time:', error);
        });
}

// Update the time every second
setInterval(updateRealTime, 1000);

// Initial call to set the time immediately
updateRealTime();
