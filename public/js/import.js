document.addEventListener('DOMContentLoaded', function () {
    const importModal = document.getElementById('importModal');
    const importSpan = document.getElementsByClassName('importModalClose')[0];

    document.getElementById('importButton').addEventListener('click', function () {
        fetch('/import')
            .then(response => response.text())
            .then(html => {
                document.getElementById('importModalBody').innerHTML = html;
                importModal.style.display = 'block';
            });
    });

    importSpan.onclick = function () {
        importModal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == importModal) {
            importModal.style.display = 'none';
        }
    }
});