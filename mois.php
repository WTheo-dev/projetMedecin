<?php

class mois{

    private $Mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    private $mois;
    private $annee;

    /**
     * mois constructeur
     * @param int|null $mois le mois compris entre 1 et 12
     * @param int|null $annee l'année
     * @throws Exception
     */
    public function __construct(?int $mois= null, ?int $annee= null) {
        
        if ($mois === null || $mois < 1 || $mois > 12){
            $mois = intval(date('m'));
        }
        if ($annee === null){
            $annee = intval(date('Y'));
        }
        $mois = $mois % 12;

        $this->mois = $mois;
        $this->annee = $annee;
    }

    /**
     * Retourne le mois en toute lettre 
     * @return string
     */
    public function toString(): string{
        return $this->Mois[$this->mois -1].' '.$this->annee;
    }

    /**
     * @return int
     */
    public function getSemaines() : int{
        $debut = new DateTime("1-{$this->mois}-{$this->annee}");
        $fin = (clone $debut)->modify('last day of this month');
        $semaines = intval($debut->format('S')) - intval($fin->format('S')) +1;
        if ($semaines <0){
            $semaines = intval($fin->format('S'));
        }
        return $semaines;
    }
}
