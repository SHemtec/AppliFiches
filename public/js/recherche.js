document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('searchBar');
    const interventions = document.querySelectorAll('.intervention');
    const dateIndicators = document.querySelectorAll('.dateIndicator');

    searchBar.addEventListener('keyup', function (e) {
        const searchTerm = e.target.value.toLowerCase();

        // Parcourir les interventions et afficher/masquer selon la recherche
        interventions.forEach(function (intervention) {
            const interventionText = intervention.textContent.toLowerCase();
            if (interventionText.includes(searchTerm)) {
                intervention.style.display = '';
            } else {
                intervention.style.display = 'none';
            }
        });

        // Gérer les indicateurs de date
        dateIndicators.forEach(function (dateIndicator) {
            // Récupérer les interventions suivantes associées à cet indicateur
            const relatedInterventions = [];
            let nextElement = dateIndicator.nextElementSibling;

            while (nextElement && nextElement.classList.contains('intervention')) {
                relatedInterventions.push(nextElement);
                nextElement = nextElement.nextElementSibling;
            }

            // Vérifier si au moins une intervention est visible
            const hasVisibleInterventions = relatedInterventions.some(
                (intervention) => intervention.style.display !== 'none'
            );

            // Afficher ou masquer l'indicateur en conséquence
            if (hasVisibleInterventions) {
                dateIndicator.style.display = '';
            } else {
                dateIndicator.style.display = 'none';
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