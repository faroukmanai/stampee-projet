<?php

/**
 * Classe Contrôleur des requêtes sur l'entité Film de l'application admin
 */

class AdminTimbre extends Admin {

  protected $methodes = [
    'l' => ['nom' => 'listerTimbre',   'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR, Utilisateur::PROFIL_CORRECTEUR]],
    'a' => ['nom' => 'ajouteTimbre',   'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR]],
    'm' => ['nom' => 'modifieTimbre',  'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR, Utilisateur::PROFIL_CORRECTEUR]],
    's' => ['nom' => 'supprimeTimbre', 'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR]]
  ];

  /**
   * Constructeur qui initialise des propriétés à partir du query string
   * et la propriété oRequetesSQL déclarée dans la classe Routeur
   * 
   */
  public function __construct() {
    $this->timbre_id = $_GET['timbre_id'] ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }

  /**
   * Lister les timbres
   */
  public function listerTimbre() {
    $timbres = $this->oRequetesSQL->getTimbresbyId();
    (new Vue)->generer(
      'vAdminTimbres',
      [
        'oUtilConn'           => self::$oUtilConn,
        'titre'               => 'Gestion des timbres',
        'timbres'               => $timbres,
        'classRetour'         => $this->classRetour,  
        'messageRetourAction' => $this->messageRetourAction        
      ],
      'gabarit-admin');
  }

  /**
   * Ajouter un timbre
   */
  public function ajouteTimbre() {
    if (count($_POST) !== 0) {
      $timbre = $_POST;
      $oTimbre = new Timbre($timbre);
      // $timbre->setTimbre_Annee($_POST['timbre_Annee']);
      $oTimbre->setTimbre_Affiche($_FILES['timbre_Affiche']['name']); // pour contrôler le suffixe
      $erreurs = $oTimbre->erreurs; var_dump($erreurs);
     
      if (count($erreurs) === 0) {
        $retour = $this->oRequetesSQL->ajouterTimbre([
          'timbre_Titre'        => $oTimbre->timbre_Titre,
          'timbre_Description'  => $oTimbre->timbre_Description,
          'timbre_Annee'        => $oTimbre->timbre_Annee,
          'timbre_Pays'         => $oTimbre->timbre_Pays,
          'timbre_Etat'         => $oTimbre->timbre_Etat,
          'utilisateur_id' => self::$oUtilConn->utilisateur_id
        ]); echo$retour;
        if (preg_match('/^[1-9]\d*$/', $retour)) {         
          $this->messageRetourAction = "Ajout du timbre numéro $retour effectué.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "Ajout du timbre non effectué. ".$retour;
        }
        $this->listerTimbre();
        exit;
      }
    } else {
      $timbre   = [];
      $erreurs = [];
    }
    
    (new Vue)->generer(
      'vAdminTimbreAjouter',
      [
        'oUtilConn' => self::$oUtilConn,
        'titre'     => 'Ajouter un timbre',
        'timbre'    => $timbre,
        'erreurs'   => $erreurs
      ],
      'gabarit-admin');
  }

 
  /**
   * Supprimer un timbre
   */
  public function supprimeTimbre() {
    if (!preg_match('/^\d+$/', $this->timbre_id))
      throw new Exception("Numéro de Timbre incorrect pour une suppression.");

    $retour = $this->oRequetesSQL->supprimerTimbre($this->timbre_id);
    if ($retour === true) {
      $this->messageRetourAction = "Suppression du Timbre numéro $this->timbre_id effectuée.";
    } else {
      $this->classRetour = "erreur";
      $this->messageRetourAction = "Suppression du Timbre numéro $this->timbre_id non effectuée. ".$retour;
    }
    $this->listerTimbre();
  }


  /**
  * Modifier un timbre
  */
  public function modifieTimbre() {
    $timbre_id = $_GET['timbre_id'] ?? null;
    
    if ($timbre_id && count($_POST) !== 0) {
      $timbre = $_POST;
      $oTimbre = new Timbre($timbre);
      
      if ($_FILES['timbre_Affiche']['tmp_name'] !== "") $oTimbre->setTimbre_Affiche($_FILES['timbre_Affiche']['name']);
      // var_dump($_FILES['timbre_Affiche']['tmp_name']);
      $erreurs = $oTimbre->erreurs;
      
      if (count($erreurs) === 0) {
        $oTimbre->setTimbre_Id($timbre_id); // Définir l'identifiant du timbre
        
        $retour = $this->oRequetesSQL->modifierTimbre([
          'timbre_id'           => $oTimbre->timbre_id,
          'timbre_Titre'        => $oTimbre->timbre_Titre,
          'timbre_Description'  => $oTimbre->timbre_Description,
          'timbre_Annee'        => $oTimbre->timbre_Annee,
          'timbre_Pays'         => $oTimbre->timbre_Pays,
          'timbre_Etat'         => $oTimbre->timbre_Etat,       
      ]);

        
        if (preg_match('/^[1-9]\d*$/', $retour)) {         
          $this->messageRetourAction = "Modification du timbre numéro $timbre_id effectuée.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "Modification du timbre non effectuée. ".$retour;
        }
        $this->listerTimbre();
        exit;
      }
    } else {
      $timbre   = $this->oRequetesSQL->getTimbre($this->timbre_id);
      var_dump($timbre); 
      $erreurs = [];
    }
    
    (new Vue)->generer(
      'vAdminTimbreModifier',
      [
        'oUtilConn' => self::$oUtilConn,
        'titre'     => 'Modifier un timbre',
        'timbre'      => $timbre,
        'erreurs'   => $erreurs
      ],
      'gabarit-admin'
    );
  }

}