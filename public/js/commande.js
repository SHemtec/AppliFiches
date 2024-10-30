document.addEventListener('DOMContentLoaded', function () {
    const commandeModal = document.getElementById('commandeModal');
    const commandeSpan = document.getElementsByClassName('commandeModalClose')[0];
    console.log('commande.js loaded');

    document.getElementById('createCommandeButton').addEventListener('click', function () {
        const clientId = this.getAttribute('data-client-id');
        console.log('createCommandeButton clicked');
        fetch(`/commande/new/${clientId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('commandeModalBody').innerHTML = html;
                commandeModal.style.display = 'block';
            });
    });

    commandeSpan.onclick = function () {
        commandeModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == commandeModal) {
            commandeModal.style.display = 'none';
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const createCommandeModal = document.getElementById('createCommandeModal');
    const createCommandeSpan = document.getElementsByClassName('commandeModalClose')[0];
    console.log('commande.js loaded');

    document.getElementById('createCommandeButton').addEventListener('click', function () {
        const clientId = this.getAttribute('data-client-id');
        console.log('createCommandeButton clicked');
        fetch(`/commandes/new`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('createCommandeModalBody').innerHTML = html;
                createCommandeModal.style.display = 'block';
            });
    });

    createCommandeSpan.onclick = function () {
        createCommandeModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == createCommandeModal) {
            createCommandeModal.style.display = 'none';
        }
    }
});

