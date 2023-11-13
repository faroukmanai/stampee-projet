document.addEventListener('DOMContentLoaded', function () {
    const rechercheInput = document.querySelector('input[placeholder="recherche de timbres, collections, etc ..."]');
    const cartes = document.getElementsByClassName('carte');

    function searchTimbres() {
        const searchTerm = rechercheInput.value.toLowerCase();

        for (let carte of cartes) {
            const titre = carte.querySelector('h3').textContent.toLowerCase();

            if (titre.includes(searchTerm)) {
                carte.style.display = 'flex';
            } else {
                carte.style.display = 'none';
            }
        }
    }

    rechercheInput.addEventListener('input', searchTimbres);
});
