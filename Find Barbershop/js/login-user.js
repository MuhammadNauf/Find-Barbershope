
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const latitude = document.querySelector('input[name="latitude"]').value;
        const longitude = document.querySelector('input[name="longitude"]').value;

        // Here you can add your logic to handle the form data
        alert(`Name: ${name}\nEmail: ${email}\nLatitude: ${latitude}\nLongitude: ${longitude}`);
    });