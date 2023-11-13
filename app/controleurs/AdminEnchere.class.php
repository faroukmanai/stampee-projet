<?php


/**
 * Classe Contrôleur des requêtes sur l'entité Film de l'application admin
 */

class AdminEnchere extends Admin {

  protected $methodes = [
    'l' => ['nom' => 'listerEnchere',   'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR, Utilisateur::PROFIL_CORRECTEUR]],
    'a' => ['nom' => 'ajouteEnchere',   'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR]],
    'm' => ['nom' => 'modifieEnchere',  'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR, Utilisateur::PROFIL_CORRECTEUR]],
    's' => ['nom' => 'supprimeEnchere', 'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR]],
    'o' => ['nom' => 'ajouteMise', 'droits' => [Utilisateur::PROFIL_ADMINISTRATEUR, Utilisateur::PROFIL_EDITEUR]]
  ];

  /**
   * Constructeur qui initialise des propriétés à partir du query string
   * et la propriété oRequetesSQL déclarée dans la classe Routeur
   * 
   */
  public function __construct() {
    $this->enchere_id = $_GET['enchere_id'] ?? null;
    $this->oRequetesSQL = new RequetesSQL;
  }

  /**
   * Lister les enchères
   */
  public function listerEnchere() {
    $encheres = $this->oRequetesSQL->getEncheresById();
    // var_dump($encheres);
    (new Vue)->generer(
      'vAdminEncheres',
      [
        'oUtilConn'           => self::$oUtilConn,
        'titre'               => 'Gestion des encheres',
        'encheres'            => $encheres,
        'classRetour'         => $this->classRetour,  
        'messageRetourAction' => $this->messageRetourAction        
      ],
      'gabarit-admin'
    );
  }
  

  
  /**
   * Ajouter une enchere
   */
  
  public function ajouteEnchere() {
    if (count($_POST) !== 0) {
      $enchere = $_POST;
      $oEnchere = new Enchere($enchere);
      $Timbre_id = $enchere['Timbre_id'];
      $erreurs = $oEnchere->erreurs;
      if (count($erreurs) === 0) {
        $retour = $this->oRequetesSQL->ajouterEnchere([
          'Timbre_id'      => $Timbre_id,
          'Date_debut'     => $oEnchere->Date_debut,
          'Date_fin'       => $oEnchere->Date_fin,
          'Prix_plancher'  => $oEnchere->Prix_plancher,
          'utilisateur_id' => self::$oUtilConn->utilisateur_id
        ]);
        
        if (preg_match('/^[1-9]\d*$/', $retour)) {         
          $this->messageRetourAction = "Ajout du enchere numéro $retour effectué.";
        } else {
          $this->classRetour = "erreur";
          $this->messageRetourAction = "Ajout du enchere non effectué. ".$retour;
        }
        $this->listerEnchere();
        exit;
      }
    } else {
      $enchere   = [];
      $erreurs = [];
    }
    
    $id=self::$oUtilConn->utilisateur_id;
    $timbres = $this->oRequetesSQL->getTimbreEnchere($id);
    // var_dump($timbres);
    
    (new Vue)->generer(
      'vAdminEnchereAjouter',
      [
        'oUtilConn' => self::$oUtilConn,
        'titre'     => 'Ajouter un enchere',
        'enchere'      => $enchere,
        'timbres'      =>  $timbres,
        'timbre_id'    => $timbres[0]['timbre_id'],
        'erreurs'   => $erreurs
      ],
      'gabarit-admin');
  }

 /**
   * supprimer une enchere
   */

  public function supprimeEnchere() {
    if (!preg_match('/^\d+$/', $this->enchere_id))
      throw new Exception("Numéro de Enchere incorrect pour une suppression.");
  
    $retour = $this->oRequetesSQL->supprimerEnchere($this->enchere_id);
    if ($retour === true) {
      $this->messageRetourAction = "Suppression de l'enchère numéro $this->enchere_id effectuée.";
    } else {
      $this->classRetour = "erreur";
      $this->messageRetourAction = "Suppression de l'enchère numéro $this->enchere_id non effectuée. ".$retour;
    }
    $this->listerEnchere();
    
  }


  /**
   * Ajouter une mise
   */

public function ajouteMise(){ 

  if (isset($_POST['enchere_id']) && isset($_POST['Montant'])) {
      $utilisateur_id = self::$oUtilConn->utilisateur_id;
      $enchere_id = $_POST['enchere_id'];
      $montant = $_POST['Montant'];
      // // Vérifier si l'utilisateur est le créateur de l'enchère
      // $enchere = $this->oRequetesSQL->getEnchereByIdUtilisateur($enchere_id);
      // if ($enchere['utilisateur_id'] == $utilisateur_id) {
      //     $reponse = [
      //         "success" => false,
      //         "message" => "Vous ne pouvez pas miser sur une enchère que vous avez créée."
      //     ];
      //     header("Content-Type: application/json");
      //     echo json_encode($reponse);
      //     return;
      // }
      
      $resultat = $this->oRequetesSQL->ajouterMise([
          "montant" => $montant,
          "utilisateur_id" => $utilisateur_id,
          "enchere_id" => $enchere_id
      ]);
      if ($resultat !== false) {
          $reponse = [
              "success" => true,
              "message" => "La mise a été ajoutée avec succès. Vous avez misé ". $montant . "$",
              "mise_id" => $resultat
          ];
      } else {
          $reponse = [
              "success" => false,
              "message" => "Une erreur s'est produite lors de l'ajout de la mise"
          ];
      }
  } else {
      $reponse = [
          "success" => false,
          "message" => "Données manquantes pour ajouter la mise"
      ];
  }
  header("Content-Type: application/json");
  echo json_encode($reponse);
}



}
  

  
  
