document.addEventListener("DOMContentLoaded", function() {
let boutonsMiser = document.querySelectorAll(".bouton.miser");

boutonsMiser.forEach(function (bouton) {
    // Récupérer l'élément parent de la carte du timbre
let parentElement = bouton.closest(".carte");

// Récupérer la date de fin de l'enchère
let dateFinElement = parentElement.querySelector(".date-fin");
let dateFin = new Date(dateFinElement.getAttribute("data-date-fin"));

// Comparer la date de fin avec la date actuelle
let maintenant = new Date();
if (maintenant > dateFin) {
  // Mettre à jour l'état de l'enchère
  let etatEnchereElement = parentElement.querySelector(".etat-enchere");
  etatEnchereElement.textContent = "État de l'enchère: Inactif";
  parentElement.style.opacity = "0.4";
  let boutonMiserElement = parentElement.querySelector(".bouton.miser");
  boutonMiserElement.disabled = true;
} else {
  // Mettre à jour l'état de l'enchère
  let etatEnchereElement = parentElement.querySelector(".etat-enchere");
  etatEnchereElement.textContent = "État de l'enchère: Actif";
  
}
  bouton.addEventListener("click", function (event) {
    event.preventDefault();

    // Récupérer le montant de la mise
    let montant = parseInt(this.parentElement.querySelector(".montant").value);
    console.log(montant)
    // Récupérer le prix de départ
    let prixDeDepartElement = this.parentElement.querySelector(".prix");
    let prixDeDepart = parseInt(prixDeDepartElement.getAttribute("data-prix"));
    console.log(prixDeDepart);
    // Vérifier si le montant est supérieur au prix de départ
    if (montant < prixDeDepart) {
        alert("Le montant de la mise doit être supérieur au prix de départ.");
    return;
    }

    // Vider le champ de saisie
    this.parentElement.querySelector(".montant").value = "";

    // Créer un objet FormData et ajouter les données
    let formData = new FormData();
    formData.append("timbre_id", this.dataset.timbreId);
    formData.append("enchere_id", this.dataset.enchereId);
    formData.append("Montant", montant); 

    let oOptions = {
      method: "POST",
      body: formData, // Utiliser formData ici
    };

    fetch("http://localhost:8888/sprint2/stampee/admin?entite=enchere&action=o", oOptions)
      .then(function (reponse) {
        if (reponse.ok) return reponse.json();  //retourner du JSON
      })
      .then(function (data) {
        console.log(data);
        let dialog = document.getElementById("dialog");
        if (data.success) {
          // Afficher un message de succès
          dialog.innerHTML = data.message;
          dialog.style.display = "block";

          // Mettre à jour le prix de départ
          let prixDeDepartElement = bouton.parentElement.querySelector(".prix");
          let nouveauPrixDeDepart = montant;
          prixDeDepartElement.setAttribute("data-prix", nouveauPrixDeDepart);
          prixDeDepartElement.textContent = "Dernière mise: " + nouveauPrixDeDepart + "$";
        } else {
          // Afficher un message d'erreur
          dialog.innerHTML = data.message;
          dialog.style.display = "block";
        }
      })
      .catch(function (err) {
        console.log(err.message);
        //  alert("Vous devez être connecté pour pouvoir miser.");
        //  return;
      });

    // Ajouter un événement pour fermer la boîte de dialogue lorsque l'utilisateur clique dessus
    document.addEventListener("click", function (event) {
      let dialog = document.getElementById("dialog");
      if (event.target == dialog) {
        dialog.style.display = "none";
      }
    });

    function afficherMessage(message) {
      let dialog = document.getElementById("dialog");
      dialog.innerHTML = message;
      dialog.style.display = "block";
    }
  });
});
});


  