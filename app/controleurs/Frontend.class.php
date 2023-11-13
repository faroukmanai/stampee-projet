<?php

/**
 * Classe Contrôleur des requêtes de l'interface frontend
 * 
 */

class Frontend extends Routeur {


  private $oUtilConn;
  
  /**
   * Constructeur qui initialise des propriétés à partir du query string
   * et la propriété oRequetesSQL déclarée dans la classe Routeur
   * 
   */
  public function __construct() {
    
    $this->oUtilConn = $_SESSION['oUtilConn'] ?? null; 
    $this->oRequetesSQL = new RequetesSQL;
    // $this->detailsEnchere($timbre_id);
  }

  /**
   * Connecter un utilisateur
   */
  public function connecter() {
    $utilisateur = $this->oRequetesSQL->connecter($_POST);
    if ($utilisateur !== false) {
      $_SESSION['oUtilConn'] = new Utilisateur($utilisateur);
    }
    echo json_encode($utilisateur);
  }

  /**
   * Créer un compte utilisateur
   */
  public function creerCompte() {
    $oUtilisateur = new Utilisateur($_POST);
    $erreurs = $oUtilisateur->erreurs;
    if (count($erreurs) > 0) {
      $retour = $erreurs;
    } else {
      $retour = $this->oRequetesSQL->creerCompteClient($_POST);
      if (!is_array($retour) && preg_match('/^[1-9]\d*$/', $retour)) {
       
      } 
    }
    echo json_encode($retour);
  }

  /**
   * Déconnecter un utilisateur
   */
  public function deconnecter() {
    unset ($_SESSION['oUtilConn']);
    echo json_encode(true);
  }

  /**
   * Afficher la page d'accueil
   * 
   */  
  public function Accueil() {
    (new Vue)->generer(
      "index",
      [
        'oUtilConn' => $this->oUtilConn,
        'titre'     => "Stampee",  
      ],
      "gabarit-frontend");
  }

  /**
   * Afficher la page Galerie
   * 
   */  
  public function galerie() {
    $timbres = $this->oRequetesSQL->getTimbres();
    $encheres = $this->oRequetesSQL->getEncheres();
    (new Vue)->generer(
      "galerie",
      [
        'oUtilConn' => $this->oUtilConn,
        'titre'     => "Galerie Stampee",  
        'timbres'   => $timbres,
        'encheres'  => $encheres,
      ],
      "gabarit-frontend");
  }
  public function profil(){
    $timbres = $this->oRequetesSQL->getTimbresbyId();
    $encheres = $this->oRequetesSQL->getEncheresById();
    // $retour = $this->oRequetesSQL->supprimerEnchere($this->enchere_id);
    (new Vue)->generer(
      "profil",
      [
        'oUtilConn' => $this->oUtilConn,
        'titre'     => "Mon profil",  
        'timbres'   => $timbres,
        'encheres'  => $encheres,
      ],
      "gabarit-frontend");
  }
  

}