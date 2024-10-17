document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('searchBar');
    const interventions = document.querySelectorAll('.intervention');

    searchBar.addEventListener('keyup', function (e) {
        const searchTerm = e.target.value.toLowerCase();

        interventions.forEach(function (intervention) {
            const interventionText = intervention.textContent.toLowerCase();
            if (interventionText.includes(searchTerm)) {
                intervention.style.display = '';
            } else {
                intervention.style.display = 'none';
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('searchBar');
    const clients = document.querySelectorAll('.client');

    searchBar.addEventListener('keyup', function (e) {
        const searchTerm = e.target.value.toLowerCase();

        clients.forEach(function (client) {
            const clientText = client.textContent.toLowerCase();
            if (clientText.includes(searchTerm)) {
                client.style.display = '';
            } else {
                client.style.display = 'none';
            }
        });
    });
});