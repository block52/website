<?php
namespace phpformbuilder\database;

class Pagination extends Mysql
{
    public $pagine;
    private $active_class       = 'active';
    private $disabled_class     = 'disabled';
    private $pagination_class   = 'pagination pagination-flat';
    private $first_markup       = '<i class="fas fa-angle-double-left"></i>';
    private $previous_markup    = '<i class="fas fa-angle-left"></i>';
    private $next_markup        = '<i class="fas fa-angle-right"></i>';
    private $last_markup        = '<i class="fas fa-angle-double-right"></i>';
    private $rewrite_transition;
    private $rewrite_extension;

    /**
     * Build pagination
     * @param string  $sql         Elément commun de requête : "FROM..." auquel sera ajouté le "LIMIT..."
     * @param string  $mpp         Nombre max de lignes par page
     * @param string  $querystring Elément de querystring indiquant le n° de page
     * @param string  $url         URL de la page
     * @param integer $long        Nombre max de pages avant et après la page courante
     */
    public function pagine($sql, $mpp, $querystring, $url, $long = 5, $rewrite_links = true, $rewrite_transition = '-', $rewrite_extension = '.html', $debug = false)
    {
    // Pour construire les liens, regarde si $url contient déjà un ?
        $t   = $this->rewrite_transition = $rewrite_transition;
        $ext = $this->rewrite_extension = $rewrite_extension;
        $url = $this->removePreviousQuerystring($url, $querystring, $rewrite_links);
        if ($rewrite_links !== true) {
            if (strpos($url, "?")) {
                $t = '&amp;';
            } else {
                $t = '?';
            }
        }
        $rs_pagination = parent::query($sql);
        if ($debug === true) {
            echo parent::getLastSQL();
        }
        $nbre = parent::rowCount($rs_pagination);  // Nombre total d'enregistrements retournés
        if (!empty($nbre)) {
            $_SESSION['result_rs'] = $nbre;    // Calcul du nombre de pages
            $nbpage = ceil($nbre/$mpp);    // La page courante est
            $p = @$_GET[$querystring];
            if (!$p) {
                $p = 1;
            }
            if ($p>$nbpage) {
                $p = $nbpage;    // Longueur de la liste de pages
            }
            $deb = max(1, $p-$long);
            $fin = min($nbpage, $p+$long);    // Construction de la liste de pages
            $this->pagine = "";
            if ($nbpage > 1) {
                for ($i = $deb; $i <= $fin; $i++) { // Page courante ?
                    if ($i == $p) {
                        $this->pagine .= '<li class="page-item ' . $this->active_class . '"><a class="page-link" href="#">' . $i . '</a></li>' . "\n";    // Page 1 > lien sans query
                    } elseif ($i == 1) {
                        if ($rewrite_links === true) {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $ext . '">' . $i . '</a></li>' . "\n";   // Autre page -> lien avec query
                        } else {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . '">' . $i . '</a></li>' . "\n";   // Autre page -> lien avec query
                        }
                    } else {
                        if ($rewrite_links === true) {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . $i . $ext . '">' . $i . '</a></li>' . "\n";
                        } else {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . '=' . $i . '">' . $i . '</a></li>' . "\n";
                        }
                    }
                }
                if ($this->pagine) {
                    $this->pagine = '<li class="page-item ' . $this->disabled_class . '"><a class="page-link" href="#">Page</a></li>' . $this->pagine . "\n";
                }
                if ($this->pagine && ($p > 1)) { //PREVIOUS
                    if ($p == 2) {
                        if ($rewrite_links === true) {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . $ext . '">' . $this->previous_markup . '</a></li>' . $this->pagine . "\n";
                        } else {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . '">' . $this->previous_markup . '</a></td>' . $this->pagine . "\n";
                        }
                    } else { //PREVIOUS
                        if ($rewrite_links === true) {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . ($p-1) . $ext . '">' . $this->previous_markup . '</a></li>' . $this->pagine . "\n";
                        } else {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . '=' . ($p-1)  . '">' . $this->previous_markup . '</a></li>' . $this->pagine . "\n";
                        }
                    }
                    if ($p>1) { // FIRST
                        if ($rewrite_links === true) {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . $ext . '">' . $this->first_markup . '</a></li>' . $this->pagine . "\n";
                        } else {
                            $this->pagine = '<li class="page-item"><a class="page-link" href="' . $url . '">' . $this->first_markup . '</a></li>' . $this->pagine . "\n";
                        }
                    }
                }
                if ($this->pagine && ($p<$nbpage)) { // NEXT, LAST
                    if ($rewrite_links === true) {
                        $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . ($p+1) . $ext . '">' . $this->next_markup . '</a></li>' . "\n"; //SUIVANT
                    } else {
                        $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . '=' . ($p+1)  . '">' . $this->next_markup . '</a></li>' . "\n";
                    }
                    if ($p<$nbpage) { // LAST
                        if ($rewrite_links === true) {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . ($nbpage) . $ext . '">' . $this->last_markup . '</a></li>' . "\n";
                        } else {
                            $this->pagine .= '<li class="page-item"><a class="page-link" href="' . $url . $t . $querystring . '=' . ($nbpage)  . '">' . $this->last_markup . '</a></li>' . "\n";
                        }
                    }
                }    // Modification de la requête
                $suppr = 'LIMIT';
                $cherche = strstr($sql, $suppr);
                $sql = str_replace($cherche, "", $sql);    // si vide on supprime la clause "LIMIT"
                $sql .= ' LIMIT ' . (($p-1) *$mpp)  . ',' . $mpp;
                $rs_pagination = parent::query($sql);    // nouveau jeu d'enregistrements avec la clause LIMIT
                $nbrePageActu = parent::rowCount($rs_pagination);    // affichage 'résultats n à m sur x    // départ = $depart    //fin = $fin    // total = $nbre
                $depart = $mpp*($p-1) +1;    // nbre par page x page actuelle.
                $fin = $depart+$nbrePageActu-1;
            } else {    //s'il n'y a qu'une seule page
                $this->pagine = '' . "\n";
                $depart = 1;    // nbre par page x page actuelle.
                $fin = $nbre;
            }

            // CRUD admin i18n
            if (defined('PAGINATION_RESULTS')) {
                $this->resultats = '<p class="text-right text-semibold">' . PAGINATION_RESULTS . ' ' . $depart . ' ' . PAGINATION_TO . ' ' . $fin . ' ' . PAGINATION_OF . ' ' . $nbre . '</p>' . "\n";
            } else {
                $this->resultats = '<p class="text-right text-semibold">résultats ' . $depart . ' à ' . $fin . ' sur ' . $nbre . '</p>' . "\n";
            }
            $htmlPagination = '';
            if (!empty($this->resultats)) {
                $htmlPagination .= '<ul class="' . $this->pagination_class . '">' . "\n";
                $htmlPagination .= $this->pagine . "\n";
                $htmlPagination .= '</ul>' . "\n";
            }
            $htmlPagination .= '<div class="heading-elements pt-2 pr-3">' . "\n";
            $htmlPagination .= $this->resultats;
            $htmlPagination .= '</div>' . "\n";

            return $htmlPagination;
        }
    }

    /**
     * Sets form layout options to match your framework
     *
     * @param array $user_options (Optional) An associative array containing the
     *                            options names as keys and values as data.
     * @return $this
     */
    public function setOptions($user_options = array())
    {
        $options = array('active_class', 'disabled_class', 'first_markup', 'pagination_class', 'previous_markup', 'next_markup', 'last_markup', 'rewrite_transition', 'rewrite_extension');
        foreach ($user_options as $key => $value) {
            if (in_array($key, $options)) {
                $this->$key = $value;
            }
        }
    }

    private function removePreviousQuerystring($url, $querystring, $rewrite_links)
    {
        if ($rewrite_links === true) {
            $find = array('`' . $this->rewrite_transition . $querystring . '[0-9]+`', '`' . $this->rewrite_extension . '`');
            $replace = array('', '');
        } else {
            $find = array('`\?' . $querystring . '=([0-9]+)&(amp;)?`', '`\?' . $querystring . '=([0-9]+)`', '`&(amp;)?' . $querystring . '=([0-9]+)`');
            $replace = array('?', '', '');
        }
        $url = preg_replace($find, $replace, $url);

        return $url;
    }
}
