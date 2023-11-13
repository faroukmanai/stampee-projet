<?php

/**
 * Classe de l'entité Film
 *
 */
class Enchere extends Entite
{
  protected $timbre_id;
  protected $enchere_id;
  protected $Date_debut;
  protected $Date_fin;
  protected $Prix_plancher;
 
 

  const ANNEE_PREMIER_FILM = 1895;

  /**
   * Mutateur de la propriété enchere_id 
   * @param int $enchere_id
   * @return $this
   */    
  public function setEnchere_id($enchere_id) {
    unset($this->erreurs['enchere_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $enchere_id)) {
      $this->erreurs['enchere_id'] = 'Numéro de enchere incorrect.';
    }
    $this->enchere_id = $enchere_id;
    return $this;
  } 
    
  public function setTimbre_id($timbre_id) {
    unset($this->erreurs['Timbre_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $timbre_id)) {
      $this->erreurs['Timbre_id'] = 'Numéro de Timbre incorrect.';
    }
    $this->timbre_id = $timbre_id;
    return $this;
  }    

  /**
   * Mutateur de la propriété enchere_titre 
   * @param string $enchere_titre
   * @return $this
   */    
  public function setDate_debut($Date_debut) {
    unset($this->erreurs['Date_debut']);
    
    $this->Date_debut = $Date_debut;
    return $this;
  }
  public function setDate_fin($Date_fin) {
    unset($this->erreurs['Date_fin']);  
    $this->Date_fin = $Date_fin;
    return $this;
  }


  /**
   * Mutateur de la propriété enchere_annee
   * @param int $enchere_annee
   * @return $this
   */        
  public function setPrix_plancher($Prix_plancher) {
    unset($this->erreurs['Prix_plancher']);
    if (!preg_match('/^\d+$/', $Prix_plancher))  {
      $this->erreurs['Prix_plancher'] = "Entrez au minimum un prix plancher.";
    }
    $this->Prix_plancher = $Prix_plancher;
    return $this;
  }

  
}