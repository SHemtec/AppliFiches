document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('clientModal');
    const span = document.getElementsByClassName('clientModalClose')[0];
    console.log('client.js loaded');

    document.getElementById('createClientButton').addEventListener('click', function () {
        console.log('createClientButton clicked');
        fetch('/client/new') // Adjust the URL to your route
            .then(response => response.text())
            .then(html => {
                document.getElementById('clientModalBody').innerHTML = html;
                modal.style.display = 'block';
            });
    });

    span.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});