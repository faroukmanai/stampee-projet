<?php

/**
 * Classe des requêtes SQL
 *
 */
class RequetesSQL extends RequetesPDO {

  /* GESTION DES UTILISATEURS 
     ======================== */

  /**
   * Récupération des utilisateurs
   * @return array tableau d'objets Utilisateur
   */ 
  public function getUtilisateurs() {
    $this->sql = "
    SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_courriel, utilisateur_renouveler_mdp, utilisateur_profil
    FROM utilisateur
    INNER JOIN role ON role.role_id = utilisateur.role_id ORDER BY utilisateur_id DESC";
     return $this->getLignes();
  }

  /**
   * Récupération d'un utilisateur
   * @param int $utilisateur_id, clé du utilisateur  
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */ 
  public function getUtilisateur($utilisateur_id) {
    $this->sql = "
    SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_courriel, utilisateur_renouveler_mdp, utilisateur_profil
    FROM utilisateur
    INNER JOIN role ON role.role_id = utilisateur.role_id
    WHERE utilisateur_id = :utilisateur_id";
    return $this->getLignes(['utilisateur_id' => $utilisateur_id], RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Contrôler si adresse courriel non déjà utilisée par un autre utilisateur que utilisateur_id
   * @param array $champs tableau utilisateur_courriel et utilisateur_id (0 si dans toute la table)
   * @return array|false utilisateur avec ce courriel, false si courriel disponible
   */ 
  public function controlerCourriel($champs) {
    $this->sql = 'SELECT utilisateur_id FROM utilisateur
                  WHERE utilisateur_courriel = :utilisateur_courriel AND utilisateur_id != :utilisateur_id';
    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Connecter un utilisateur
   * @param array $champs, tableau avec les champs utilisateur_courriel et utilisateur_mdp  
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */ 
  public function connecter($champs) {
    $this->sql = "
    SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_courriel, utilisateur_renouveler_mdp, utilisateur_profil
    FROM utilisateur
    INNER JOIN role ON role.role_id = utilisateur.role_id
    WHERE utilisateur_courriel = :utilisateur_courriel AND utilisateur_mdp = SHA2(:utilisateur_mdp, 512)";
    return $this->getLignes($champs, RequetesPDO::UNE_SEULE_LIGNE);
  }

  /**
   * Créer un compte utilisateur dans le frontend
   * @param array $champs tableau des champs de l'utilisateur 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function creerCompteClient($champs) {
    $utilisateur = $this->controlerCourriel(
      ['utilisateur_courriel' => $champs['utilisateur_courriel'], 'utilisateur_id' => 0]);
    if ($utilisateur !== false)
      return ['utilisateur_courriel' => Utilisateur::ERR_COURRIEL_EXISTANT];
    unset($champs['nouveau_mdp_bis']);  
    $this->sql = '
      INSERT INTO utilisateur SET
      utilisateur_nom            = :utilisateur_nom,
      utilisateur_prenom         = :utilisateur_prenom,
      utilisateur_courriel       = :utilisateur_courriel,
      utilisateur_mdp            = SHA2(:nouveau_mdp, 512),
      role_id        = 1';
    return $this->CUDLigne($champs);
  }

  /**
   * Ajouter un utilisateur
   * @param array $champs tableau des champs de l'utilisateur 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function ajouterUtilisateur($champs) {
    $utilisateur = $this->controlerCourriel(
      ['utilisateur_courriel' => $champs['utilisateur_courriel'], 'utilisateur_id' => 0]);
    if ($utilisateur !== false)
      return Utilisateur::ERR_COURRIEL_EXISTANT;
      $this->sql = '
      INSERT INTO utilisateurs SET
      utilisateur_nom            = :utilisateur_nom,
      utilisateur_prenom         = :utilisateur_prenom,
      utilisateur_courriel       = :utilisateur_courriel,
      utilisateur_mdp            = SHA2(:utilisateur_mdp, 512),
      role_id        = 1';
    return $this->CUDLigne($champs);
  }


  /**
   * Modifier un utilisateur
   * @param array $champs tableau des champs de l'utilisateur 
   * @return boolean|string true si modifié, message d'erreur sinon
   */ 
  public function modifierUtilisateur($champs) {
    $utilisateur = $this->controlerCourriel(
      ['utilisateur_courriel' => $champs['utilisateur_courriel'], 'utilisateur_id' => $champs['utilisateur_id']]);
    if ($utilisateur !== false)
      return Utilisateur::ERR_COURRIEL_EXISTANT;
    $this->sql = '
      UPDATE utilisateur SET
      utilisateur_nom = :utilisateur_nom,
      utilisateur_prenom = :utilisateur_prenom,
      utilisateur_courriel = :utilisateur_courriel
      WHERE utilisateur_id = :utilisateur_id';
    return $this->CUDLigne($champs);
  }

  /**
   * Supprimer un utilisateur
   * @param int $utilisateur_id clé primaire
   * @return boolean|string true si suppression effectuée, message d'erreur sinon
   */ 
  public function supprimerUtilisateur($utilisateur_id) {
    $this->sql = '
      DELETE FROM utilisateur WHERE utilisateur_id = :utilisateur_id';
    return $this->CUDLigne(['utilisateur_id' => $utilisateur_id]);
  }



    /* GESTION DES TIMBRES
     ======================== */

  /**
   * Récupération des timbres
   * @param  string $critere
   * @return array tableau des lignes produites par la select   
   */ 
  public function getTimbres() {
    $this->sql = "select * from timbre";
    // $this->sql = "select * from timbre where utilisateur_id = {$_SESSION['oUtilConn']->utilisateur_id}";
    return $this->getLignes();
  }
  
  public function getTimbresbyId() {
    // $this->sql = "select * from timbre";
    $this->sql = "select * from timbre where utilisateur_id = {$_SESSION['oUtilConn']->utilisateur_id}";
    return $this->getLignes();
  }

  /**
   * Récupération d'un timbre
   * @param int $timbre_id, clé du timbre
   * @return array|false tableau associatif de la ligne produite par la select, false si aucune ligne
   */
  public function getTimbre($timbre_id) {
    $this->sql = "
    SELECT *
    FROM timbre
    WHERE timbre_id = :timbre_id";
    return $this->getLignes(['timbre_id' => $timbre_id], RequetesPDO::UNE_SEULE_LIGNE);
  }

   /**
   * supprimer des timbres
   * @param  string $critere
   * @return array tableau des lignes produites par la select   
   */ 
  public function supprimerTimbre($timbre_id) {
    $this->sql = '
      DELETE FROM timbre WHERE timbre_id = :timbre_id';
    return $this->CUDLigne(['timbre_id' => $timbre_id]);
  }


  /**
   * Ajouter un timbre
   * @param array $champs tableau des champs du timbre 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function ajouterTimbre($champs) {
    try {
      $this->sql = '
        INSERT INTO timbre SET
        timbre_Titre         = :timbre_Titre,
        timbre_Annee         = :timbre_Annee,
        timbre_lord_favoris  = 0,
        timbre_Description   = :timbre_Description,
        timbre_Pays        = :timbre_Pays,
        timbre_Etat      = :timbre_Etat,
        utilisateur_id = :utilisateur_id';
      $timbre_id = $this->CUDLigne($champs); 
      return  $timbre_id;

    } catch(Exception $e) {
      return $e->getMessage();
    }
  }



  /**
   * Modifierer un timbre
   * @param array $champs tableau des champs du timbre 
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 
  public function modifierTimbre($champs) {
    try {
        $this->sql = "
            UPDATE timbre SET
                timbre_Titre       = :timbre_Titre,
                timbre_Annee       = :timbre_Annee,
                timbre_Description = :timbre_Description,
                timbre_Pays        = :timbre_Pays,
                timbre_Etat        = :timbre_Etat
            WHERE timbre_id       = :timbre_id
        ";
        $timbre_id = $this->CUDLigne($champs); 
        
        $retourAffiche = $this->modifierTimbreAffiche($champs['timbre_id']);
        return $timbre_id;
    } catch(Exception $e) {
        return $e->getMessage();
    }
  } 

    /**
   * Modifier l'affiche d'un timbre
   * @param int $timbre_id
   * @return boolean true si téléversement, false sinon
   */ 
  public function modifierTimbreAffiche($timbre_id) {
    if ($_FILES['timbre_Affiche']['tmp_name'] !== "") {
      $this->sql = 'UPDATE timbre SET timbre_Affiche = :timbre_Affiche WHERE timbre_id = :timbre_id';
      $champs['timbre_id']      = $timbre_id;
      $champs['timbre_Affiche'] = $_FILES['timbre_Affiche']['name'];
      $this->CUDLigne($champs);
      foreach (glob("/stampee/img/*$timbre_id*") as $fichier) {
        if (!@unlink($fichier)) 
          throw new Exception("Erreur dans la suppression de l'ancien fichier image de l'affiche.");
      } 
      if (!@move_uploaded_file($_FILES['timbre_Affiche']['tmp_name'], $champs['timbre_Affiche']))
        throw new Exception("Le stockage du fichier image de l'affiche a échoué.");
      return true; 
    }
    return false;
  }

  
    /* GESTION DES ENCHÈRES
     ======================== */
   /* Récupération des films à l'affiche ou prochainement ou pour l'interface admin
   * @param  string $critere
   * @return array tableau des lignes produites par la select   
   */ 
  public function getEncheres() {
    $this->sql = "SELECT * from enchere";
    return $this->getLignes();
  }

  public function getEncheresById() {
    $utilisateur_id = $_SESSION['oUtilConn']->utilisateur_id;
    $this->sql = "SELECT * FROM enchere WHERE utilisateur_id = :utilisateur_id";
    return $this->getLignes(['utilisateur_id' => $utilisateur_id]);
}


  /* récupère les timbres qui sont disponibles pour une enchère
   et qui n'ont pas encore été enchéris par l'utilisateur spécifié par son identifiant.
  */
  public function getTimbreEnchere($utilisateur_id){
    $this->sql = "SELECT * FROM timbre WHERE utilisateur_id = :utilisateur_id";
    return $this->getLignes(['utilisateur_id' => $utilisateur_id],false);
  }

  /**
   * Ajouter une enchère
   * @param array $champs tableau  
   * @return int|string clé primaire de la ligne ajoutée, message d'erreur sinon
   */ 

  public function ajouterEnchere($champs){
    $this->sql = "
    INSERT INTO enchere SET
    Timbre_id = :Timbre_id,
    Date_debut = :Date_debut,
    Date_fin = :Date_fin,
    Prix_plancher = :Prix_plancher,
    utilisateur_id = :utilisateur_id
    ";
    return $this->CUDLigne($champs); 
  }

  /**
   * Supprimer une enchère
   * @param int $enchere_id identifiant de l'enchère à modifier
   * @param array $champs tableau contenant les champs à modifier
  
   */ 
  public function supprimerEnchere($enchere_id){
    $this->sql = "DELETE FROM enchere WHERE enchere_id = :enchere_id";
    return $this->CUDLigne(['enchere_id' => $enchere_id]);
  }

   /* GESTION DES MISES
     ======================== */
     public function ajouterMise($champs){
      $this->sql = '
      INSERT INTO mise SET
      utilisateur_id  = :utilisateur_id,
      enchere_id = :enchere_id,
      Montant = :montant';  
      return $this->CUDLigne($champs);
  
    }
/**
 * Obtenir les informations d'une enchère par ID
 * @param int $enchere_id identifiant de l'enchère
 * @return array|false tableau contenant les informations de l'enchère ou false si l'enchère n'est pas trouvée
 */
public function getEnchereByIdUtilisateur($enchere_id) {
  $this->sql = "SELECT * FROM encheres WHERE id = :enchere_id";
  return $this->getLignes(['enchere_id' => $enchere_id], self::UNE_SEULE_LIGNE);
}
    // public function getMisesPourEnchere($enchere_id) {
    //   $this->sql = '
    //       SELECT *
    //       FROM mise
    //       WHERE enchere_id = :enchere_id
    //       ORDER BY date_mise ASC
    //   ';
    //   $this->params = ['enchere_id' => $enchere_id];
    //   return $this->fetchAll($this->sql, $this->params);
    // }
    
    // public function getDerniereMisePourEnchere($enchere_id) {
    //   $this->sql = '
    //       SELECT Montant
    //       FROM mise
    //       WHERE enchere_id = :enchere_id
    //       ORDER BY date_mise DESC
    //       LIMIT 1
    //   ';
    //   $this->params = ['enchere_id' => $enchere_id];
    //   return $this->fetch($this->sql, $this->params);
    // }
    /**
   * Récupérer le prix plancher pour une enchère
   * @param int $enchere_id, clé de l'enchère
   * @return float|false prix plancher de l'enchère, false si erreur ou enchère introuvable
   */
  public function getPrixPlancherPourEnchere($enchere_id) {
    $this->sql = "
      SELECT Prix_plancher
      FROM enchere
      WHERE enchere_id = :enchere_id";
    $result = $this->getLignes(['enchere_id' => $enchere_id], RequetesPDO::UNE_SEULE_LIGNE);
    return $result !== false ? (float)$result['Prix_plancher'] : false;
  }

    
  
    
  
}