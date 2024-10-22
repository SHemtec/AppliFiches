document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('clientModal');
    const span = document.getElementsByClassName('clientModalClose')[0];

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

document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editClientModal');
    const editSpan = document.getElementsByClassName('clientModalClose')[0];

    document.getElementById('editClientButton').addEventListener('click', function () {
        const clientId = this.getAttribute('data-client-id');
        fetch(`/client/${clientId}/edit`) // Adjust the URL to your route
            .then(response => response.text())
            .then(html => {
                document.getElementById('editClientModalBody').innerHTML = html;
                editModal.style.display = 'block';
            });
    });

    editSpan.onclick = function () {
        editModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    }
});