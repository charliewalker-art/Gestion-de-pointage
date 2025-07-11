<?php

require ('Table.php');

class Conge extends Table {

public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'CONGE', ['numConge', 'numEmp', 'motif', 'nbrjr', 'dateDemande', 'dateRetour'], 'numConge');
    }

   //fonction d'insertion 
    public function create($data) {
        // Vérifier si le numEmp existe dans la table Employe
        $sql = "SELECT COUNT(*) FROM EMPLOYE WHERE numEmp = :numEmp";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numEmp' => $data['numEmp']]);
        if ($stmt->fetchColumn() == 0) {
            return "Le numéro d'employé n'existe pas.";
        }

        // Vérifier si le numEmp existe dans la table Conge
        $sql = "SELECT SUM(nbrjr) as totalJours FROM CONGE WHERE numEmp = :numEmp";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numEmp' => $data['numEmp']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nbjExistent = $result['totalJours'] ?? 0;

        if ($nbjExistent >= 30) {
            return "Demande refusée car l'employé a plus de congés.";
        }

        $nbDemande = $data['nbrjr'];
        $nbjRestent = $nbjExistent + $nbDemande;

        if ($nbjRestent > 30) {
            $nbjRestent = 30 - $nbjExistent;
            return "Demande refusée. Il reste $nbjRestent jours de congé disponibles pour l'employé.";
        }

        // Insérer la demande de congé
        $sql = "INSERT INTO {$this->name_table} (numConge, numEmp, motif, nbrjr, dateDemande, dateRetour) VALUES (:numConge, :numEmp, :motif, :nbrjr, :dateDemande, :dateRetour)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return "Demande de conge acceptée.";
    }

        //fonction affichage
    public function afficheconge() {
        $sql = "SELECT * FROM {$this->name_table} ORDER BY numConge ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        //fonction de generation de ID unique
    public function generateId() {
        $sql = "SELECT numConge FROM {$this->name_table} ORDER BY numConge DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $lastId = $stmt->fetchColumn();
        
        if ($lastId) {
            $num = (int)substr($lastId, 1) + 1;
            return 'C' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            return 'C001';
        }
    }

    // Méthode pour obtenir les jours de congé restants pour chaque employé
    public function joursRestants() {
        $sql = "
            SELECT 
                e.numEmp,
                e.Nom,
                e.Prenom,
                (30 - COALESCE(SUM(c.nbrjr), 0)) AS jours_restants
            FROM EMPLOYE e
            LEFT JOIN CONGE c ON e.numEmp = c.numEmp
            GROUP BY e.numEmp, e.Nom, e.Prenom
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
//listes de tous les employés en congés
    public function getAllConges() {
        $sql = "
            SELECT 
                e.numEmp,
                e.Nom,
                e.Prenom,
                c.dateDemande,
                c.dateRetour
            FROM EMPLOYE e
            JOIN CONGE c ON e.numEmp = c.numEmp
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Méthode pour obtenir la liste des employés en congé entre deux dates
    public function handleRequest($dateDebut, $dateFin) {
        $sql = "
            SELECT 
                e.numEmp,
                e.Nom,
                e.Prenom,
                c.dateDemande,
                c.dateRetour
            FROM EMPLOYE e
            JOIN CONGE c ON e.numEmp = c.numEmp
            WHERE c.dateDemande >= :dateDebut AND c.dateRetour <= :dateFin
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour modifier un congé
    public function modifie($numConge, $data) {
        $sql = "UPDATE {$this->name_table} SET numEmp = :numEmp, motif = :motif, nbrjr = :nbrjr WHERE numConge = :numConge";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'numEmp' => $data['numEmp'],
            'motif' => $data['motif'],
            'nbrjr' => $data['nbrjr'],
            'numConge' => $numConge
        ]);
        return "Le congé avec l'ID $numConge a été modifié avec succès.";
    }


    
    // Méthode pour supprimer un congé
    public function supprimer($numConge) {
        $sql = "DELETE FROM {$this->name_table} WHERE numConge = :numConge";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numConge' => $numConge]);
        return "Le congé avec l'ID $numConge a été supprimé avec succès.";
    }

   // Méthode pour obtenir la liste des employés en congé entre deux dates
    public function employesEnCongeEntreDates($dateDebut, $dateFin) {
        $sql = "
            SELECT 
                e.numEmp,
                e.Nom,
                e.Prenom,
                c.dateDemande,
                c.dateRetour
            FROM EMPLOYE e
            JOIN CONGE c ON e.numEmp = c.numEmp
            WHERE c.dateDemande >= :dateDebut AND c.dateRetour <= :dateFin
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}


?>
