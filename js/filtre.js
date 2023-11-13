document.addEventListener('DOMContentLoaded', function () {
    const parfaitRadio = document.getElementById('parfait');
    const moyenRadio = document.getElementById('moyen');
    const endommageRadio = document.getElementById('endommage');
    const prixMinInput = document.querySelector('input[name="prix-min"]');
    const prixMaxInput = document.querySelector('input[name="prix-max"]');
    const cartes = document.getElementsByClassName('carte');

    function filterTimbres() {
        const prixMin = parseFloat(prixMinInput.value) || 0;
        const prixMax = parseFloat(prixMaxInput.value) || Infinity;

        for (let carte of cartes) {
            const etat = carte.querySelector('p:nth-of-type(2)').textContent;
            const prix = parseFloat(carte.querySelector('.prix').dataset.prix);

            const estDansLaPlageDePrix = prix >= prixMin && prix <= prixMax;

            if (estDansLaPlageDePrix) {
                if (parfaitRadio.checked && etat.includes('Parfait')) {
                    carte.style.display = 'flex';
                } else if (moyenRadio.checked && etat.includes('Moyen')) {
                    carte.style.display = 'flex';
                } else if (endommageRadio.checked && etat.includes('Endommagé')) {
                    carte.style.display = 'flex';
                } else {
                    carte.style.display = 'none';
                }
            } else {
                carte.style.display = 'none';
            }
        }
    }

    parfaitRadio.addEventListener('change', filterTimbres);
    moyenRadio.addEventListener('change', filterTimbres);
    endommageRadio.addEventListener('change', filterTimbres);
    prixMinInput.addEventListener('input', filterTimbres);
    prixMaxInput.addEventListener('input', filterTimbres);
});
