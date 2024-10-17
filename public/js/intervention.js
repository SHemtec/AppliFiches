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

document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editInterventionModal');
    const editBtn = document.getElementById('editInterventionBtn');
    const closeBtn = document.getElementsByClassName('interventionModalClose')[0];

    editBtn.onclick = function() {
        console.log('editInterventionBtn clicked');
        const interventionId = editBtn.getAttribute('data-intervention-id');
        fetch(`/intervention/${interventionId}/edit`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('editInterventionModalBody').innerHTML = html;
                editModal.style.display = 'block';
            });
    }

    closeBtn.onclick = function() {
        editModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    }
});
