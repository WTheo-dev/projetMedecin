const titre = document.querySelector(".titre");
const medecinSelect = document.getElementById("id_medecin");
const URL = "http://localhost/projetMedecin/API_Medecin/APIMedecin.php";

const erreurDiv = document.querySelector(".erreur");

function getMedecin() {
    return fetch(`${URL}?id_medecin=all`)
        .then(response => response.json())
        .then(medecins => medecins)
        .catch(err => {
            erreurDiv.innerText = "Impossible de récupérer la liste des médecins";
            throw err;
        });
}

function updateCalendar(id_medecin) {
    if (!id_medecin || id_medecin === "all") {
        return;
    }

    fetch(`${URL}?id_medecin=${id_medecin}`)
        .then(response => response.json())
        .then(data => {
            const modalContent = document.getElementById("modalContent");
            modalContent.innerHTML = "";

            if (data && data.length > 0) {
                const rendezvousList = document.createElement("ul");

                data.forEach(rendezvous => {
                    const rendezvousItem = document.createElement("li");
                    rendezvousItem.textContent = `${rendezvous.date_rdv} - ${rendezvous.heure_rdv} - ${rendezvous.nom} ${rendezvous.prenom}`;
                    rendezvousList.appendChild(rendezvousItem);
                });

                modalContent.appendChild(rendezvousList);
            } else {
                modalContent.textContent = "Aucun rendez-vous pour ce médecin.";
            }
        })
        .catch(error => {
            console.error("Erreur lors de la mise à jour du calendrier :", error);
            // Gérez l'erreur, par exemple, en affichant un message à l'utilisateur
        });
}

getMedecin().then(data => {
    let option;
    data.forEach(medecin => {
        option = document.createElement("option");
        option.text = `${medecin.civilite} ${medecin.nom} ${medecin.prenom}`;
        option.value = medecin.id_medecin;
        medecinSelect.add(option);
    });
});

medecinSelect.addEventListener("change", function () {
    const selectedMedecinId = this.value;
    updateCalendar(selectedMedecinId);
});





function openModal(day) {
    var modalContent = document.getElementById("modalContent");

    // Faites une requête AJAX pour récupérer les rendez-vous du jour depuis le serveur (PHP)
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "rendezvous.php?day=" + day, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var rendezvous = JSON.parse(xhr.responseText);

            // Construisez le contenu de la modal avec les rendez-vous existants
            var modalHTML = `
                <h3>Rendez-vous du ${day}</h3>
                <ul>`;
            rendezvous.forEach(function (rendezvous) {
                modalHTML += `<li>${rendezvous.heure} - ${rendezvous.nom} ${rendezvous.prenom}</li>`;
            });
            modalHTML += `</ul>
                <h3>Ajouter un rendez-vous</h3>
                <label for="heure">Heure :</label>
                <input type="text" id="heure" name="heure" placeholder="Heure du rendez-vous"><br>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Nom du patient"><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Prénom du patient"><br>
                <button onclick="ajouterModal()">Ajouter</button>
            `;

            modalContent.innerHTML = modalHTML;
            document.getElementById("myModal").style.display = "flex";
        }
    };
    xhr.send();
}


function ajouterModal() {
    var heure = document.getElementById("heure").value;
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;

    // Faites une requête AJAX pour ajouter le rendez-vous côté serveur (PHP)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "rendezvous.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            alert(response.message);

            // Actualisez la fenêtre modale pour afficher le nouveau rendez-vous
            openModal(response.day);
        }
    };
    xhr.send("action=ajouterRendezVous&heure=" + heure + "&nom=" + nom + "&prenom=" + prenom);
}


    // Fonction pour fermer la fenêtre modale
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
    // Fonction pour sauvegarder la fenêtre modale
    function saveModal(){
        document.getElementById("myModal").style.display ="none";
    }
    // Fonction pour modifier un rendez-vous déjà pris auparavant
    function modifierModal(){
        document.getElementById("myModal").style.display ="none";
    }

    function updateCalendrier(id_medecin) {
        if (!id_medecin || id_medecin === "all") {
            return;
        }
    
        // Faites une requête AJAX pour récupérer les rendez-vous du médecin depuis le serveur (PHP)
        fetch(`http://localhost/projetMedecin/API_Medecin/APIMedecin.php?id_medecin=${id_medecin}`)
            .then(response => response.json())
            .then(data => {
                // Mettez à jour le calendrier avec les nouveaux rendez-vous
                const modalContent = document.getElementById("modalContent");
                modalContent.innerHTML = ""; // Efface le contenu existant
    
                // Ajoutez le contenu du modal avec les rendez-vous du médecin
                if (data && data.length > 0) {
                    const rendezvousList = document.createElement("ul");
    
                    data.forEach(rendezvous => {
                        const rendezvousItem = document.createElement("li");
                        rendezvousItem.textContent = `${rendezvous.date_rdv} - ${rendezvous.heure_rdv} - ${rendezvous.nom} ${rendezvous.prenom}`;
                        rendezvousList.appendChild(rendezvousItem);
                    });
    
                    modalContent.appendChild(rendezvousList);
                } else {
                    modalContent.textContent = "Aucun rendez-vous pour ce médecin.";
                }
            })
            .catch(error => {
                console.error("Erreur lors de la mise à jour du calendrier :", error);
                // Gérez l'erreur, par exemple, en affichant un message à l'utilisateur
            });
    }
    
    