<?php

/**
 * Classe d'accès aux données.
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL - CNED <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */
/**
 * Classe d'accès aux données.
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $connexion de type PDO
 * $instance qui contiendra l'unique instance de la classe
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   Release: 1.0
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

namespace Modeles;

use PDO;
use Outils\Utilitaires;

require '../config/bdd.php';

class PdoGsb {

    protected $connexion;
    private static $instance = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        $this->connexion = new PDO(DB_DSN, DB_USER, DB_PWD);
        $this->connexion->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct() {
        $this->connexion = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb(): PdoGsb {
        if (self::$instance == null) {
            self::$instance = new PdoGsb();
        }
        return self::$instance;
    }
    
    /**
     * Retourne les informations d'un visiteur
     *
     * @param String $login Login du visiteur
     * @param String $mdp   Mot de passe du visiteur
     *
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login): array|bool
    {
        $requetePrepare = $this->connexion->prepare(
                'SELECT visiteur.id AS id, visiteur.nom AS nom, '       
                . 'visiteur.prenom AS prenom, visiteur.email as email,  '
                . 'visiteur.id_role AS role '

                . 'FROM visiteur '
                . 'WHERE visiteur.login = :unLogin '
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);

        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    public function getMdpVisiteur($login) {
        $requetePrepare = $this->connexion->prepare(
                'SELECT mdp '
                . 'FROM visiteur '
                . 'WHERE visiteur.login = :unLogin'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch(PDO::FETCH_OBJ)->mdp;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * hors forfait concernées par les deux arguments.
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return tous les champs des lignes de frais hors forfait sous la forme
     * d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT * FROM lignefraishorsforfait '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = Utilitaires::dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return le nombre entier de justificatifs
     */
    public function getNbjustificatifs($idVisiteur, $mois): int {
        $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.nbjustificatifs as nb FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * au forfait concernées par les deux arguments
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return l'id, le libelle et la quantité sous la forme d'un tableau
     * associatif
     */
    public function getLesFraisForfait($idVisiteur, $mois): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT fraisforfait.id as idfrais, '
                . 'fraisforfait.libelle as libelle, '
                . 'lignefraisforfait.quantite as quantite '
                . 'FROM lignefraisforfait '
                . 'INNER JOIN fraisforfait '
                . 'ON fraisforfait.id = lignefraisforfait.idfraisforfait '
                . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraisforfait.mois = :unMois '
                . 'ORDER BY lignefraisforfait.idfraisforfait'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne tous les id de la table FraisForfait
     *
     * @return un tableau associatif
     */
    public function getLesIdFrais(): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT fraisforfait.id as idfrais '
                . 'FROM fraisforfait ORDER BY fraisforfait.id'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Met à jour la table ligneFraisForfait
     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param Array  $lesFrais   tableau associatif de clé idFrais et
     *                           de valeur la quantité pour ce frais
     *
     * @return null
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais): void {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $requetePrepare = $this->connexion->prepare(
                    'UPDATE lignefraisforfait '
                    . 'SET lignefraisforfait.quantite = :uneQte '
                    . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                    . 'AND lignefraisforfait.mois = :unMois '
                    . 'AND lignefraisforfait.idfraisforfait = :idFrais'
            );
            $requetePrepare->bindParam(':uneQte', $qte, PDO::PARAM_INT);
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(':idFrais', $unIdFrais, PDO::PARAM_STR);
            $requetePrepare->execute();
        }
    }

    /**
     * Met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné
     *
     * @param String  $idVisiteur      ID du visiteur
     * @param String  $mois            Mois sous la forme aaaamm
     * @param Integer $nbJustificatifs Nombre de justificatifs
     *
     * @return null
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE fichefrais '
                . 'SET nbjustificatifs = :unNbJustificatifs '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(
                ':unNbJustificatifs',
                $nbJustificatifs,
                PDO::PARAM_INT
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return vrai ou faux
     */
    public function estPremierFraisMois($idVisiteur, $mois): bool {
        $boolReturn = false;
        $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.mois FROM fichefrais '
                . 'WHERE fichefrais.mois = :unMois '
                . 'AND fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        if (!$requetePrepare->fetch()) {
            $boolReturn = true;
        }
        return $boolReturn;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur): string {
        $requetePrepare = $this->connexion->prepare(
                'SELECT MAX(mois) as dernierMois '
                . 'FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait
     * pour un visiteur et un mois donnés
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs
     * idEtat, crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée
     * les lignes de frais forfait de quantités nulles
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return null
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois): void {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $requetePrepare = $this->connexion->prepare(
                'INSERT INTO fichefrais (idvisiteur,mois,nbjustificatifs,'
                . 'montantvalide,datemodif,idetat) '
                . "VALUES (:unIdVisiteur,:unMois,0,0,now(),'CR')"
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $unIdFrais) {
            $requetePrepare = $this->connexion->prepare(
                    'INSERT INTO lignefraisforfait (idvisiteur,mois,'
                    . 'idfraisforfait,quantite) '
                    . 'VALUES(:unIdVisiteur, :unMois, :idFrais, 0)'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(':idFrais', $unIdFrais['idfrais'], PDO::PARAM_STR);
            $requetePrepare->execute();
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $libelle    Libellé du frais
     * @param String $date       Date du frais au format français jj//mm/aaaa
     * @param Float  $montant    Montant du frais
     *
     * @return null
     */
    public function creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant): void {
        $dateFr = Utilitaires::dateFrancaisVersAnglais($date);
        $requetePrepare = $this->connexion->prepare(
                'INSERT INTO lignefraishorsforfait '
                . 'VALUES (null, :unIdVisiteur,:unMois, :unLibelle, :uneDateFr,'
                . ':unMontant) '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateFr', $dateFr, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument
     *
     * @param String $idFrais ID du frais
     *
     * @return null
     */
    public function supprimerFraisHorsForfait($idFrais): void {
        $requetePrepare = $this->connexion->prepare(
                'DELETE FROM lignefraishorsforfait '
                . 'WHERE lignefraishorsforfait.id = :unIdFrais'
        );
        $requetePrepare->bindParam(':unIdFrais', $idFrais, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs
     *         l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.mois AS mois FROM fichefrais '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'ORDER BY fichefrais.mois desc'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un
     * mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return un tableau avec des champs de jointure entre une fiche de frais
     *         et la ligne d'état
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.idetat as idEtat, '
                . 'fichefrais.datemodif as dateModif,'
                . 'fichefrais.nbjustificatifs as nbJustificatifs, '
                . 'fichefrais.montantvalide as montantValide, '
                . 'etat.libelle as libEtat '
                . 'FROM fichefrais '
                . 'INNER JOIN etat ON fichefrais.idetat = etat.id '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne;
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais.
     * Modifie le champ idEtat et met la date de modif à aujourd'hui.
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $etat       Nouvel état de la fiche de frais
     *
     * @return null
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE ficheFrais '
                . 'SET idetat = :unEtat, datemodif = now() '
                . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
                . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unEtat', $etat, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * 
     * @param type $id
     * @param type $code
     * @return void
     */
    public function setCodeA2f($id, $code):  void {
        $requetePrepare = $this->connexion->prepare(
            'UPDATE visiteur '
          . 'SET code = :unCode '
          . 'WHERE visiteur.id = :unIdVisiteur '
        );
        $requetePrepare->bindParam(':unCode', $code, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $id, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * 
     * @param type $id
     * @return string
     */
    public function getCodeVisiteur($id): string {
        $requetePrepare =  $this->connexion->prepare(
            'SELECT visiteur.code AS code '
          . 'FROM visiteur '
          . 'WHERE visiteur.id = :unId'
        );
        $requetePrepare->bindParam(':unId', $id, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch()['code'];
    }
    /**
     * 
     * @return array
     */
    public function getFichesValidees(): array {
        $requestPrepare = $this->connexion->prepare(
            'SELECT fichefrais.idvisiteur, fichefrais.mois, fichefrais.montantvalide, '
            . 'fichefrais.datemodif, fichefrais.idetat, visiteur.nom, visiteur.prenom '
            . 'FROM fichefrais INNER JOIN visiteur on fichefrais.idvisiteur = visiteur.id '
            . 'WHERE fichefrais.idetat = "VA"'
        );
        $requestPrepare->execute();
        return $requestPrepare->fetchAll();
    }
    /**
     * 
     * @param int $idVisiteur
     * @param int $mois
     * @return float
     */
    public function getTotauxFicheFraisHorsForfait(int $idVisiteur, int $mois): float {
        $requestPrepare = $this->connexion->prepare(
                'select coalesce(sum(montant),0) as cumul from lignefraishorsforfait '
                . "where lignefraishorsforfait.idvisiteur = :unId "
                . "and lignefraishorsforfait.mois = :unMois "
                . "and lignefraishorsforfait.libelle not like 'REFUSE%' ");
        $requestPrepare->bindParam(':unId', $idVisiteur, PDO::PARAM_INT);
        $requestPrepare->bindParam(':unMois', $mois, PDO::PARAM_INT);
        $requestPrepare->execute();
        $ligne1 = $requestPrepare->fetch();
        $cumulMontantHF = $ligne1['cumul'];
        return $cumulMontantHF;
    }
    /**
     * 
     * @param int $idVisiteur
     * @return array
     */
    public function getUtilisateurFicheFrais(int $idVisiteur): array {
        $requestPrepare = $this->connexion->prepare(
                "select distinct visiteur.nom, visiteur.prenom, visiteur.id from lignefraisforfait inner join visiteur on lignefraisforfait.idvisiteur=visiteur.id where lignefraisforfait.idvisiteur = :unId "
                );
        $requestPrepare->bindParam(':unId', $idVisiteur, PDO::PARAM_INT);
        $requestPrepare->execute();
        return $requestPrepare->fetch();
    }
    /**
     * 
     * @param int $idVisiteur
     * @param int $mois
     * @return float
     */
    public function getTotauxFicheFraisForfait(int $idVisiteur, int $mois): float {
        $requestPrepare2 = $this->connexion->prepare(
                'select coalesce(sum(lignefraisforfait.quantite * fraisforfait.montant), 0) '
                . 'as cumul '
                . 'from lignefraisforfait, fraisforfait '
                . 'where lignefraisforfait.idfraisforfait = fraisforfait.id '
                . "and lignefraisforfait.idvisiteur = :unId "
                . "and lignefraisforfait.mois = :unMois ");
        $requestPrepare2->bindParam(':unId', $idVisiteur, PDO::PARAM_INT);
        $requestPrepare2->bindParam(':unMois', $mois, PDO::PARAM_INT);
        $requestPrepare2->execute();
        $ligne2 = $requestPrepare2->fetch();
        $cumulMontantForfait = $ligne2['cumul'];
        return $cumulMontantForfait;
    }

    /**
     * 
     * @param int $idVisiteurMois
     * @return void
     */
    public function setFicheFraisMiseEnPaiement(int $idVisiteurMois): void {
        $date=(date("Y-m-d"));
        $requestPrepare = $this->connexion->prepare(
            "UPDATE fichefrais set idetat = 'MP', datemodif = :uneDate WHERE CONCAT(idvisiteur,mois) = :unIdVisiteurMois"
        );
        $requestPrepare->bindParam(':unIdVisiteurMois', $idVisiteurMois, PDO::PARAM_INT);
        $requestPrepare->bindParam(':uneDate', $date);
        $requestPrepare->execute();
    }
    
    /**
     * 
     * @param int $idVisiteurMois
     * @return array
     */
    public function getFicheFraisEtat(int $idVisiteurMois):array {
         $requestPrepare = $this->connexion->prepare(
           'select idetat from fichefrais WHERE CONCAT(idvisiteur,mois) = :unIdVisiteurMois'      
           );
         $requestPrepare->bindParam(':unIdVisiteurMois', $idVisiteurMois, PDO::PARAM_INT);
         $requestPrepare->execute();
         return $requestPrepare->fetch();
    }

      /**
     * 
     * @param type $idVisiteur
     * @param type $mois
     * @return array
     */
    public function getLignesFicheFraisCL($idVisiteur, $mois): array {
        $requetePrepare = $this->connexion->prepare(
            'SELECT * FROM lignefraisforfait '
                .' inner join fichefrais ' 
                .' on lignefraisforfait.idvisiteur = fichefrais.idvisiteur '
                .' and lignefraisforfait.mois=fichefrais.mois '
                .' WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                .' AND lignefraisforfait.mois = :unMois '
                .' AND fichefrais.idetat= \'CL\' '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetchAll();
        return $laLigne;
    }
    
    /**
     * 
     * @param type $idVisiteur
     * @param type $mois
     * @return array
     */
    public function getLignesHorsForfaitCL($idVisiteur, $mois): array {
        $requetePrepare = $this->connexion->prepare(
                'SELECT * FROM lignefraishorsforfait '
                .' inner join fichefrais ' 
                .' on lignefraishorsforfait.idvisiteur = fichefrais.idvisiteur '
                .' and lignefraishorsforfait.mois=fichefrais.mois '
                . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraishorsforfait.mois = :unMois'
                .' AND fichefrais.idetat= \'CL\' '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        return $lesLignes;
    }
    /**
     * 
     * @return type
     */
    public function getAllVisiteur() {
        $requetePrepare =  $this->connexion->prepare(
            'SELECT visiteur.id,visiteur.nom,visiteur.prenom FROM visiteur WHERE id_role= 1'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll(PDO::FETCH_ASSOC);
    }

      /**
     * 
     * @param type $id
     * @param type $mois
     * @param type $etape
     * @return void
     */
    public function setLigneFraisForfaitEtape($id,$mois,$etape): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraisforfait` '
                . 'SET `quantite` = :uneetape '
                . 'WHERE `idvisiteur` = :unid '
                . ' and `mois` =:unmois '
                . ' and `idfraisforfait` = \'ETP\'; '
        );
        $requetePrepare->bindParam(':unid', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneetape', $etape, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    /**
     * 
     * @param type $id
     * @param type $mois
     * @param type $nui
     * @return void
     */
    public function setLigneFraisForfaitNui($id,$mois,$nui): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraisforfait` '
                . 'SET `quantite` = :unenui '
                . 'WHERE `lignefraisforfait`.`idvisiteur` = :unid '
                . 'AND `lignefraisforfait`.`mois` = :unmois '
                . 'AND `lignefraisforfait`.`idfraisforfait` = \'NUI\' '
        );
        $requetePrepare->bindParam(':unid', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unenui', $nui, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    /**
     * 
     * @param type $id
     * @param type $mois
     * @param type $km
     * @return void
     */
    public function setLigneFraisForfaitKm($id,$mois,$km): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraisforfait` '
                . 'SET `quantite` = :unkm '
                . 'WHERE `lignefraisforfait`.`idvisiteur` = :unid '
                . 'AND `lignefraisforfait`.`mois` = :unmois '
                . 'AND `lignefraisforfait`.`idfraisforfait` = \'KM\' '
        );
        $requetePrepare->bindParam(':unid', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unkm', $km, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    /**
     * 
     * @param type $id
     * @param type $mois
     * @param type $rep
     * @return void
     */
    public function setLigneFraisForfaitRep($id,$mois,$rep): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraisforfait` '
                . 'SET `quantite` = :unrep '
                . 'WHERE `lignefraisforfait`.`idvisiteur` = :unid '
                . 'AND `lignefraisforfait`.`mois` = :unmois '
                . 'AND `lignefraisforfait`.`idfraisforfait` = \'REP\' '
        );
        $requetePrepare->bindParam(':unid', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unrep', $rep, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

     /**
     * 
     * @param type $id
     * @param type $libelle
     * @param type $date
     * @param type $montant
     * @return void
     */
    public function setLigneHorsForfait($id,$libelle,$date,$montant): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraishorsforfait` '
                . 'SET `montant` = :unmontant,'
                . ' `libelle` = :unlibelle,'
                . ' `date` = :unedate '
                . ' WHERE `lignefraishorsforfait`.`id` = :unid'
        );
        $requetePrepare->bindParam(':unid', $id, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unedate', $date, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unlibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unmontant', $montant, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * 
     * @param type $idLignehorsforfait
     * @return void
     */
    public function refuserLigneHorsForfait($idLignehorsforfait,$idVisiteur):void{
        $this->decalerDateLigneHorsForfait($idLignehorsforfait,$idVisiteur);
        $this->addRefuserLigneHorsForfait($idLignehorsforfait);
    }

     /**
     * 
     * @param type $idLignehorsforfait
     * @return void
     */
    public function addRefuserLigneHorsForfait($idLignehorsforfait):void{
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraishorsforfait` '
                . 'SET `libelle` = CONCAT(\'REFUSER \',libelle) '
                . 'WHERE `id` = :unid '
        );
        $requetePrepare->bindParam(':unid', $idLignehorsforfait, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

  /**
   * 
   * @param type $idLigneHorsForfait
   * @param type $idVisiteur
   * @return void
   */
    public function decalerDateLigneHorsForfait($idLigneHorsForfait,$idVisiteur):void{
        $mois=$this->getMoisLigneHorsForfaitById($idLigneHorsForfait);
        $estPresent = $this->getFicheFraisMoisDapres($idVisiteur,$mois);
        if($estPresent == true){
            $this->decalerDateLigneHF($idVisiteur,$mois);
        } else {
            $this->setFicheFraisMoisDapres($idVisiteur, $mois);
            $this->decalerDateLigneHF($idVisiteur,$mois);
        }
    }
    
        /**
         * 
         * @param type $idVisiteur
         * @param type $mois
         * @return void
         */
        public function decalerDateLigneHF($idVisiteur,$mois):void {
            if(substr($mois,-2) != "12"){
            $requetePrepare = $this->connexion->prepare(
                'UPDATE `lignefraishorsforfait` '
                . 'SET `mois` = mois+1 '
                . 'WHERE `id` = :unId '
            );
                }else{
                    substr($mois,-3,1) + 1;
                    str_replace(substr($mois,-3,1),substr($mois,-3,1)+1,$mois);
                    str_replace(substr($mois,-2),'01',$mois);
                    $requetePrepare = $this->connexion->prepare(
                        'UPDATE `lignefraishorsforfait` '
                        . 'SET `mois` = :unMois '
                        . 'WHERE `id` = :unId '
                    );
                    $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        }
        $requetePrepare->bindParam(':unId', $idLigneHorsForfait, PDO::PARAM_INT);
        $requetePrepare->execute();
        }
        
    /**
     * 
     * @param type $idvisiteur
     * @param int $mois
     * @return array
     */
    public function getFicheFraisMoisDapres($idvisiteur,$mois): array{
        if(substr($mois,-2) != "12"){
            $mois += 1;
            $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.*'
                . 'FROM fichefrais '
                . 'WHERE idvisiteur = :unId and mois = :unMois '
            );
            $requetePrepare->bindParam(':unMois', $mois);
        }else{
            substr($mois,-3,1) + 1;
            str_replace(substr($mois,-3,1),substr($mois,-3,1)+1,$mois);
            str_replace(substr($mois,-2),'01',$mois);
            $requetePrepare = $this->connexion->prepare(
                'SELECT fichefrais.*'
                . 'FROM fichefrais '
                . 'WHERE idvisiteur = :unId and mois = :unMois '
            );
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        }
        $requetePrepare->bindParam(':unId', $idvisiteur, PDO::PARAM_INT);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetch();
        return $lesLignes;
        }
    
    /**
     * 
     * @param type $idvisiteur
     * @param int $mois
     * @return type
     */
    public function setFicheFraisMoisDapres($idvisiteur,$mois){
        $dateMotif = date("Y-m-d");
        $etat = "CR";
        $mois += 1;
        $requetePrepare = $this->connexion->prepare(
                'INSERT INTO  fichefrais(idvisiteur,mois,datemodif,idetat)'
                    . 'VALUES (:unId,:unMois,:uneDateModif,:unEtat)'
            );
         $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
         $requetePrepare->bindParam(':unId', $idvisiteur, PDO::PARAM_INT);
         $requetePrepare->bindParam(':uneDateModif', $dateMotif);
         $requetePrepare->bindParam(':unEtat', $etat);
         return $requetePrepare->execute();
    }

     /**
     * 
     * @param type $idLignehorsforfait
     * @return string
     */
    public function getMoisLigneHorsForfaitById($idLignehorsforfait):string{
        $requetePrepare = $this->connexion->prepare(
                'select mois from `lignefraishorsforfait` '
                . 'WHERE `id` = :unId '
        );
        $requetePrepare->bindParam(':unId', $idLignehorsforfait, PDO::PARAM_INT);
        $requetePrepare->execute();
        $mois = $requetePrepare->fetch();
        return $mois['mois'];
    }

     /**
     * 
     * @param type $idvisiteur
     * @param type $mois
     * @param type $nbjustificatifs
     * @return void
     */
    public function validerJustificatifs($idvisiteur,$mois,$nbjustificatifs): void {
        $requetePrepare = $this->connexion->prepare(
                'UPDATE `fichefrais` '
                . 'SET `nbjustificatifs` = :nbjustificatifs '
                . 'WHERE `idvisiteur` = :unid '
                . 'AND `mois` = :unmois ' 
        );
        $requetePrepare->bindParam(':unid', $idvisiteur, PDO::PARAM_INT);
        $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':nbjustificatifs', $nbjustificatifs, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    /**
     * 
     * @param type $idvisiteur
     * @param type $mois
     * @return void
     */
    public function validerFicheFrais($idvisiteur,$mois):void{
        $requetePrepare = $this->connexion->prepare(
                  'UPDATE `fichefrais` '
                  . 'SET `idetat` = \'VA\' , '
                  . 'datemodif = NOW() '
                  . 'WHERE `idvisiteur` = :unid '
                  . 'AND `mois` = :unmois '
          );
          $requetePrepare->bindParam(':unid', $idvisiteur, PDO::PARAM_INT);
          $requetePrepare->bindParam(':unmois', $mois, PDO::PARAM_STR);
          $requetePrepare->execute();
      }
}

