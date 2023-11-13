<?php

/**
 * Classe de l'entité Film
 *
 */
class Timbre extends Entite
{
  protected $timbre_id;
  protected $timbre_Titre;
  protected $timbre_Affiche;
  protected $timbre_Description;
  protected $timbre_Annee;
  protected $timbre_Pays;
  protected $timbre_Etat;
  protected $timbre_lord_favoris;
 

  const ANNEE_PREMIER_TIMBRE = 1895;

   // Getters explicites nécessaires au moteur de templates TWIG
   public function getTimbre_id()           { return $this->timbre_id; }
   public function getTimbre_Titre()        { return $this->timbre_Titre; }
   public function getTimbre_Affiche()      { return $this->timbre_Affiche; }
   public function getTimbre_Description()  { return $this->timbre_Description; }
   public function getTimbre_Annee()        { return $this->timbre_Annee; }
   public function getTimbre_Pays()         { return $this->timbre_Pays; }
   public function getTimbre_Etat()         { return $this->timbre_Etat; }
   public function getTimbre_lord_favoris() { return $this->timbre_lord_favoris; }
   public function getErreurs()             { return $this->erreurs; }

  /**
   * Mutateur de la propriété timbre_id 
   * @param int $timbre_id
   * @return $this
   */    
  public function setTimbre_id($timbre_id) {
    unset($this->erreurs['timbre_id']);
    $regExp = '/^[1-9]\d*$/';
    if (!preg_match($regExp, $timbre_id)) {
      $this->erreurs['timbre_id'] = 'Numéro de timbre incorrect.';
    }
    $this->timbre_id = $timbre_id;
    return $this;
  }    

  /**
   * Mutateur de la propriété timbre_titre 
   * @param string $timbre_titre
   * @return $this
   */    
  public function setTimbre_Titre($timbre_Titre) {
    unset($this->erreurs['timbre_titre']);
    $timbre_Titre = trim($timbre_Titre);
    $regExp = '/^.+$/';
    if (!preg_match($regExp, $timbre_Titre)) {
      $this->erreurs['timbre_titre'] = 'Au moins un caractère.';
    }
    $this->timbre_Titre = mb_strtoupper($timbre_Titre);
    return $this;
  }
  
  public function setTimbre_Affiche($timbre_Affiche) {
    unset($this->erreurs['timbre_Affiche']);
    $timbre_Affiche = trim($timbre_Affiche);
    $regExp = '/^.*\.(jpg|jpeg|webp|png)$/i';
    if (!preg_match($regExp, $timbre_Affiche)) {
      $this->erreurs['timbre_Affiche'] = "Vous devez téléverser un fichier de type jpg | jpeg | webp | png";
    }
    $this->timbre_Affiche = $timbre_Affiche;
    return $this;
  }

  /**
   * Mutateur de la propriété timbre Description 
   * @param int $timbre Description , en minutes
   * @return $this
   */        
  public function setTimbre_Description($timbre_Description) {
    unset($this->erreurs['timbre_Description']);
    
    $timbre_Description = trim($timbre_Description);
    $regExp = '/^\S+(\s+\S+){4,}$/';
    if (!preg_match($regExp, $timbre_Description)) {
      $this->erreurs['timbre_Description'] = 'Au moins 5 mots.';
    }
    
    $this->timbre_Description = $timbre_Description;
    return $this;
  }

  /**
   * Mutateur de la propriété timbre_annee
   * @param int $timbre_annee
   * @return $this
   */        
  public function setTimbre_Annee($timbre_Annee) {
    unset($this->erreurs['timbre_Annee']);
    if (!preg_match('/^\d+$/', $timbre_Annee) ||
        $timbre_Annee < self::ANNEE_PREMIER_TIMBRE  || 
        $timbre_Annee > date("Y")) {
      $this->erreurs['timbre_Annee'] = "Entre ".self::ANNEE_PREMIER_TIMBRE." et l'année en cours.";
    }
    $this->timbre_Annee = $timbre_Annee;
    return $this;
  }

  /**
   * Mutateur de la propriété timbre_Pays
   * @param string $timbre_Pays
   * @return $this
   */    
  public function setTimbre_Pays($timbre_Pays) {
    unset($this->erreurs['timbre_Pays']);
   
    $this->timbre_Pays = $timbre_Pays;
    return $this;
  }

  /**
   * Mutateur de la propriété timbre_etat
   * @param string $timbre_etat
   * @return $this
   */    
  public function setTimbre_Etat($timbre_Etat) {
    unset($this->erreurs['timbre_Etat']);
    $this->timbre_Etat = $timbre_Etat;
    return $this;
  }

  /**
   * Mutateur de la propriété timbre_lord_favoris
   * @param string $timbre_lord_favoris
   * @return $this
   */    
  public function setTimbre_lord_favoris($timbre_lord_favoris) {
    unset($this->erreurs['timbre_lord_favoris']);
  
    $this->timbre_lord_favoris = '0';
    return $this;
  }

}