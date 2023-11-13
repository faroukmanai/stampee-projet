<?php

/**
 * Classe GestionCourriel
 *
 */
class GestionCourriel {

  /**
   * Envoyer un courriel à l'utilisateur pour lui communiquer
   * son identifiant de connexion et son mot de passe
   * @param object $oUtilisateur utilisateur destinataire
   * @return boolean|string, chaîne = chemin du fichier message html en environnement de développement
   *
   */
  public function envoyerMdp(Utilisateur $oUtilisateur) {
    $destinataire  = $oUtilisateur->utilisateur_courriel; 
    $message       = (new Vue)->generer('cMdp',
                                         array(
                                           'titre'        => 'Information',
                                           'http_host'    => $_SERVER['HTTP_HOST'],
                                           'oUtilisateur' => $oUtilisateur
                                         ),
                                         'gabarit-courriel', true);
  }
}