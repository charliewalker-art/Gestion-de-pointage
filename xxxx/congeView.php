<!-- affichage entre 2 dates -->


</head>
<body class="body-conge">


<?php
require_once 'models/Conge.php'; 

$conge = new Conge($pdo);
$listeEmployes = $conge->getAllConges(); // Récupère TOUS les employés en congé
?>

<!-- pour l'affichage des employés en congé entre deux dates -->
<h2>Rechercher les employés en congé par dates</h2>

<form id="formconge" method="POST" action="">
    <label for="date_debut">Date de début :</label>
    <input type="date" name="date_debut" id="date_debut" required>

    <label for="date_fin">Date de fin :</label>
    <input type="date" name="date_fin" id="date_fin" required>

    <button type="button" onclick="filtrerConges()" style="background-color: lightblue; border-radius: 8px; padding: 5px 5px; margin: 10px; border: none; font-size: 16px; cursor: pointer;">Rechercher</button>

</form>


<!-- Boîte modale -->
<div id="resultBox" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeResultBox()">✖</span>
        <h2>Liste des employés en congé</h2>
        <div id="resultBody">
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de demande</th>
                        <th>Date de retour</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php foreach ($listeEmployes as $employe) : ?>
                        <tr data-date-demande="<?= $employe['dateDemande'] ?>" data-date-retour="<?= $employe['dateRetour'] ?>">
                            <td><?= htmlspecialchars($employe['numEmp']) ?></td>
                            <td><?= htmlspecialchars($employe['Nom']) ?></td>
                            <td><?= htmlspecialchars($employe['Prenom']) ?></td>
                            <td><?= htmlspecialchars($employe['dateDemande']) ?></td>
                            <td><?= htmlspecialchars($employe['dateRetour']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Style de la boîte modale */
.modal {
    display: none; /* Cachée par défaut */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Contenu de la boîte modale */
.modal-content {
    background-color: white;
    padding: 20px;()
    border-radius: 10px;
    width: 60%;
    max-height: 80vh;
    overflow-y: auto;
    text-align: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    position: relative;
}

/* Bouton de fermeture */
.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}

/* Tableau */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #f4f4f4;
}
  </style>




  <!-- Modal : Ajout -->
  <div id="modal-ajouter" class="modal-conge">
    <div class="modal-inner-conge">
      <div class="modal-content-conge form-conge">
        <h2>Ajouter un Congé</h2>
        <form action="" method="POST">
          <div>
            <label for="ajout-numEmp">Numéro d'Employé :</label>
            <input type="text" id="ajout-numEmp" name="numEmp" required>
          </div>
          <div>
            <label for="ajout-motif">Motif :</label>
            <input type="text" id="ajout-motif" name="motif" required>
          </div>
          <div>
            <label for="ajout-nbrjr">Nombre de Jours :</label>
            <input type="number" id="ajout-nbrjr" name="nbrjr" required>
          </div>
          <div>
            <label for="ajout-dateDemande">Date de début de congé :</label>
            <input type="date" id="ajout-dateDemande" name="dateDemande" required>
          </div>
          <div>
            <label for="ajout-dateRetour">Date de Retour :</label>
            <input type="date" id="ajout-dateRetour" name="dateRetour" required>
          </div>
          <div class="flex-conge justify-between-conge">
            <button type="button" id="close-modal-ajouter" class="btn-conge btn-secondary-conge">Annuler</button>
            <button type="submit"  value="ajouter" class="btn-conge btn-primary-conge">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal : Modification (pour soumission classique, non utilisé pour l'édition inline) -->
  <div id="modal-modifier" class="modal-conge">
    <div class="modal-inner-conge">
      <div class="modal-content-conge form-conge">
        <h2>Modifier le Congé</h2>
        <form action="" method="POST">
          <input type="hidden" id="modal-numConge" name="numConge">
          <div style="display:none;">
            <label for="modal-numEmp">Numéro d'Employé :</label>
            <input type="text" id="modal-numEmp" name="numEmp" required>
          </div>
          <div>
            <label for="modal-motif">Motif :</label>
            <input type="text" id="modal-motif" name="motif" required>
          </div>
          <div>
            <label for="modal-nbrjr">Nombre de Jours :</label>
            <input type="number" id="modal-nbrjr" name="nbrjr" required>
          </div>
          <div>
            <label for="modal-dateDemande">Date de début de congé :</label>
            <input type="date" id="modal-dateDemande" name="dateDemande" required>
          </div>
          <div>
            <label for="modal-dateRetour">Date de Retour :</label>
            <input type="date" id="modal-dateRetour" name="dateRetour" required>
          </div>
          <div class="flex-conge justify-between-conge">
            <button type="submit" name="action" value="modifier" class="btn-conge btn-primary-conge">Modifier</button>
            <button type="button" id="close-modal" class="btn-conge btn-secondary-conge">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal : Suppression -->
  <div id="modal-supprimer" class="modal-conge">
    <div class="modal-inner-conge">
      <div class="modal-content-conge">
        <h2>Confirmation de Suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer ce congé ?</p>
        <form action="" method="POST">
          <input type="hidden" name="numConge">
          <input type="hidden" name="action" value="supprimer">
          <div class="flex-conge justify-between-conge">
            <button type="button" id="close-modal-supprimer" class="btn-conge btn-secondary-conge">Annuler</button>
            <button type="button" id="confirm-supprimer" class="btn-conge btn-danger-conge">Supprimer</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Contenu principal -->
  <div class="container-conge">
    <!-- Affichage des messages -->
    <?php if (!empty($errorMessage)): ?>
      <div style="background-color: #fed7d7; border: 1px solid #f56565; color: #c53030; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($errorMessage); ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($successMessage)): ?>
      <div style="background-color: #c6f6d5; border: 1px solid #48bb78; color: #2f855a; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($successMessage); ?>
      </div>
    <?php endif; ?>

    <button id="open-modal-ajouter" class="btn-conge btn-primary-conge" style="margin-bottom: 1rem;">Ajouter un Congé</button>

    <h2 style="font-size: 1.5rem; font-weight: bold; margin: 2rem 0 1rem;">Liste des Congés</h2>
    <table class="table-conge">
      <thead>
        <tr>
          <th>Numéro de Congé</th>
          <th>Numéro Employé</th>
          <th>Motif</th>
          <th>Nombre de Jours</th>
          <th>Date de Demande</th>
          <th>Date de Retour</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($conges as $c): ?>
        <tr data-numconge="<?php echo htmlspecialchars($c['numConge']); ?>">
          <td><?php echo htmlspecialchars($c['numConge']); ?></td>
          <td data-field="numEmp"><?php echo htmlspecialchars($c['numEmp']); ?></td>
          <td data-field="motif"><?php echo htmlspecialchars($c['motif']); ?></td>
          <td data-field="nbrjr"><?php echo htmlspecialchars($c['nbrjr']); ?></td>
          <td data-field="dateDemande"><?php echo htmlspecialchars($c['dateDemande']); ?></td>
          <td data-field="dateRetour"><?php echo htmlspecialchars($c['dateRetour']); ?></td>
          <td class="relative-conge">
            <div class="dropdown-conge">
              <button type="button" class="toggleDropdown btn-conge" style="background-color: #e2e8f0; color: #374151;">&#x22EE;</button>
              <div class="dropdown-menu-conge hidden">
                <button type="button" class="dropdown-item-conge modifier-item">Modifier</button>
                <button type="button" class="dropdown-item-conge supprimer-item">Supprimer</button>
              </div>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      /* Calcul de la date de retour pour l'ajout */
      const ajoutNbrjrInput = document.getElementById('ajout-nbrjr');
      const ajoutDateDemandeInput = document.getElementById('ajout-dateDemande');
      const ajoutDateRetourInput = document.getElementById('ajout-dateRetour');
      function calculateAjoutDateRetour() {
        const nbrjr = parseInt(ajoutNbrjrInput.value);
        const dateDemande = new Date(ajoutDateDemandeInput.value);
        if (!isNaN(nbrjr) && dateDemande instanceof Date && !isNaN(dateDemande)) {
          dateDemande.setDate(dateDemande.getDate() + nbrjr);
          ajoutDateRetourInput.value = dateDemande.toISOString().split('T')[0];
        }
      }
      ajoutNbrjrInput.addEventListener('input', calculateAjoutDateRetour);
      ajoutDateDemandeInput.addEventListener('input', calculateAjoutDateRetour);

      /* Gestion des modales */
      document.getElementById('open-modal-ajouter').addEventListener('click', function () {
        document.getElementById('modal-ajouter').style.display = 'block';
      });
      document.getElementById('close-modal-ajouter').addEventListener('click', function () {
        document.getElementById('modal-ajouter').style.display = 'none';
      });
      document.querySelectorAll('.supprimer-btn, .dropdown-menu-conge .supprimer-item').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          const row = this.closest('tr');
          const numConge = row.querySelector('td:first-child').innerText;
          const modal = document.getElementById('modal-supprimer');
          modal.querySelector('input[name="numConge"]').value = numConge;
          modal.style.display = 'block';
        });
      });
      document.getElementById('close-modal-supprimer').addEventListener('click', function () {
        document.getElementById('modal-supprimer').style.display = 'none';
      });
      document.getElementById('confirm-supprimer').addEventListener('click', function () {
        const form = document.getElementById('modal-supprimer').querySelector('form');
        form.submit();
      });
      document.getElementById('close-modal')?.addEventListener('click', function () {
        document.getElementById('modal-modifier').style.display = 'none';
      });

      /* Gestion du toggle dropdown */
      document.querySelectorAll('.toggleDropdown').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          document.querySelectorAll('.dropdown-menu-conge').forEach(menu => {
            if (menu !== this.nextElementSibling) menu.classList.add('hidden');
          });
          this.nextElementSibling.classList.toggle('hidden');
        });
      });
      document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-menu-conge').forEach(menu => menu.classList.add('hidden'));
      });

      /* Edition inline (sans AJAX) */
      document.querySelectorAll('.dropdown-menu-conge .modifier-item').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          const row = this.closest('tr');
          // Remplacement des cellules éditables par des inputs
          ['numEmp', 'motif', 'nbrjr', 'dateDemande', 'dateRetour'].forEach(field => {
            const cell = row.querySelector(`td[data-field="${field}"]`);
            const currentValue = cell.innerText.trim();
            let input = document.createElement('input');
            if (field === 'nbrjr') {
              input.type = 'number';
            } else if (field === 'dateDemande' || field === 'dateRetour') {
              input.type = 'date';
            } else {
              input.type = 'text';
            }
            input.value = currentValue;
            input.className = "form-conge-input"; // Vous pouvez définir un style supplémentaire ici
            cell.innerHTML = '';
            cell.appendChild(input);
          });
          // Mise à jour automatique de la date de retour dans l'édition inline
          const nbrInput = row.querySelector('td[data-field="nbrjr"] input');
          const dateDemandeInput = row.querySelector('td[data-field="dateDemande"] input');
          const dateRetourInput = row.querySelector('td[data-field="dateRetour"] input');
          function calculateInlineDateRetour() {
            const nbr = parseInt(nbrInput.value);
            const startDate = new Date(dateDemandeInput.value);
            if (!isNaN(nbr) && startDate instanceof Date && !isNaN(startDate)) {
              startDate.setDate(startDate.getDate() + nbr);
              dateRetourInput.value = startDate.toISOString().split('T')[0];
            }
          }
          nbrInput.addEventListener('input', calculateInlineDateRetour);
          dateDemandeInput.addEventListener('input', calculateInlineDateRetour);
          // Remplacement de la cellule Action par des boutons Enregistrer et Annuler
          const actionCell = row.querySelector('td.relative-conge');
          actionCell.innerHTML = `
            <button type="button" class="save-btn btn-conge btn-primary-conge">Enregistrer</button>
            <button type="button" class="cancel-btn btn-conge btn-secondary-conge">Annuler</button>
          `;
          actionCell.querySelector('.save-btn').addEventListener('click', function () {
            const form = document.createElement('form');
            form.method = "POST";
            form.action = "";
            const numConge = row.getAttribute('data-numconge');
            const fields = ['numEmp', 'motif', 'nbrjr', 'dateDemande', 'dateRetour'];
            form.innerHTML = `<input type="hidden" name="numConge" value="${numConge}">
                                <input type="hidden" name="action" value="modifier">`;
            fields.forEach(field => {
              const cell = row.querySelector(`td[data-field="${field}"]`);
              const inputVal = cell.querySelector('input').value;
              const hiddenInput = document.createElement('input');
              hiddenInput.type = "hidden";
              hiddenInput.name = field;
              hiddenInput.value = inputVal;
              form.appendChild(hiddenInput);
            });
            document.body.appendChild(form);
            form.submit();
          });
          actionCell.querySelector('.cancel-btn').addEventListener('click', function () {
            location.reload();
          });
        });
      });
    });

//employe en conge entre deux dates
    function filtrerConges() {
    let dateDebut = document.getElementById("date_debut").value;
    let dateFin = document.getElementById("date_fin").value;

    if (!dateDebut || !dateFin) {
        alert("Veuillez entrer les deux dates !");
        return;
    }

    let tableRows = document.querySelectorAll("#tableBody tr");
    let hasResults = false;

    tableRows.forEach(row => {
        let dateDemande = row.getAttribute("data-date-demande");
        let dateRetour = row.getAttribute("data-date-retour");

        if (dateDemande >= dateDebut && dateRetour <= dateFin) {
            row.style.display = "";  
            hasResults = true;
        } else {
            row.style.display = "none";  
        }
    });

    if (hasResults) {
        document.getElementById("resultBox").style.display = "flex"; 
    } else {
        alert("Aucun employé en congé pour cette période.");
    }
}

function closeResultBox() {
    document.getElementById("resultBox").style.display = "none";
}

// Empêcher l'affichage automatique au chargement
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("resultBox").style.display = "none";
});

function closeResultBox() {
    document.getElementById("resultBox").style.display = "none";

    // Réinitialiser les champs de date
    document.getElementById("date_debut").value = "";
    document.getElementById("date_fin").value = "";
}



  </script>

  
</body>
</html>
