<?php

/**
 * Classe de l'entité Mise
 *
 */
class Mise extends Entite
{
  protected $mise_id;
  protected $utilisateur_id;
  protected $enchere_id;
  protected $montant;

  /**
   * Mutateur de la propriété mise_id 
   * @param int $mise_id
   * @return $this
   */    
  public function setMise_id($mise_id) {
    unset($this->erreurs['mise_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $mise_id)) {
      $this->erreurs['mise_id'] = 'Numéro de mise incorrect.';
    }
    $this->mise_id = $mise_id;
    return $this;
  } 

  /**
   * Mutateur de la propriété utilisateur_id 
   * @param int $utilisateur_id
   * @return $this
   */    
  public function setUtilisateur_id($utilisateur_id) {
    unset($this->erreurs['utilisateur_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $utilisateur_id)) {
      $this->erreurs['utilisateur_id'] = 'Numéro d\'utilisateur incorrect.';
    }
    $this->utilisateur_id = $utilisateur_id;
    return $this;
  } 

  /**
   * Mutateur de la propriété enchere_id 
   * @param int $enchere_id
   * @return $this
   */    
  public function setEnchere_id($enchere_id) {
    unset($this->erreurs['enchere_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $enchere_id)) {
      $this->erreurs['enchere_id'] = 'Numéro d\'enchère incorrect.';
    }
    $this->enchere_id = $enchere_id;
    return $this;
  } 
    
  /**
   * Mutateur de la propriété montant 
   * @param float $montant
   * @return $this
   */    
  public function setMontant($montant) {
    unset($this->erreurs['montant']);
    if (!preg_match('/^\d+(?:\.\d{1,2})?$/', $montant)) {
      $this->erreurs['montant'] = 'Le montant doit être un nombre entier ou décimal avec deux chiffres après la virgule.';
    }
    $this->montant = $montant;
    return $this;
  }    

}
