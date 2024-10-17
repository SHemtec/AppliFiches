document.addEventListener('DOMContentLoaded', function () {
    const interventionModal = document.getElementById('interventionModal');
    const interventionSpan = document.getElementsByClassName('interventionModalClose')[0];
    console.log('intervention.js loaded');

    document.getElementById('createInterventionButton').addEventListener('click', function () {
        const clientId = this.getAttribute('data-client-id');
        console.log('createInterventionButton clicked');
        fetch(`/intervention/new/${clientId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('interventionModalBody').innerHTML = html;
                interventionModal.style.display = 'block';
            });
    });

    interventionSpan.onclick = function () {
        interventionModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == interventionModal) {
            interventionModal.style.display = 'none';
        }
    }
});