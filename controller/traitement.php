<?php
//require_once '../inc/function.php';

/*************************************************************************************************
                                        FRONT
 *************************************************************************************************/
//Variable pour message d'avertissement :
$msg = "";
//Variable d'affichage :
$competence = "";

/*----- Affichage des competences -----*/

if(isset($_GET['choix']) && $_GET['choix'] == 'competence'){

    $req= $pdo->query("SELECT * FROM competences");
    
    
    while($comps = $req->fetch(PDO::FETCH_ASSOC)){
        //debugV($comps);
        
        $competence .= '<div class="col-md-3 mt-5">';
            $competence .= '<div class="card mt-5 shadow-sm">';
                $competence .= '<i class="'.$comps['cptechnology'].'"></i>';
                $competence .= '<div class ="card-body">';
                    if($comps['cplevel'] == 1){
                        $competence .= '<p>Débutant</p>';
                    }elseif($comps['cplevel'] == 2){
                        $competence .= '<p>Intermédiaire</p>';
                    }elseif($comps['cplevel']== 3){
                        $competence .= '<p>Avancé</p>';
                    }elseif($comps['cplevel']== 4){
                        $competence .= '<p>Maitrise</p>';
                    }
        
                $competence .= '<div class ="d-flex justify-content-between align-items-center">';
                $competence .= '</div>';
                $competence .= '</div>';
            $competence .= '</div>';
        $competence .= '</div>';
    }
}

/*----- Affichage des réalisations -----*/

//Variable d'affichage :
$projet ="";


if(isset($_GET['choix']) && $_GET['choix'] == 'competence'){

    $req = $pdo->query("SELECT * FROM projects");
    
    if($req->rowCount() == 0){
        $msg .= '<h2> Projets à venir ...</h2>';
    }
        while($projets = $req->fetch(PDO::FETCH_ASSOC)){
            debugV($project);

            $projet .='<div class="col-lg-4">';
            $projet .='<img class="rounded-circle" src="" alt="Generic placeholder image" width= "140" height= "140">';
            $projet .='<h2>'.$projets['pjtitle'].'</h2>';
            $projet .='<p><a class="btn btn-secondary" href="'.$projets['pjlink'].'" role="button"> Visiter & raquo;</a></p>';
            $projet .='</div>';
        }
}

/*----- Affichage expériences -----*/

//Variable d'affichage :
$xp ="";

if(isset($_GET['choix']) && $_GET['choix'] =='xp'){

    $req = $pdo->query("SELECT * FROM xp ");

   while($xps = $req->fetch(PDO::FETCH_ASSOC)){
       $xp .= '<tr>';
        $xp .= '<th scope="row">'.$xps['xpyear1'] .'-'.$xps['xpyear2'] .' </th> ';
        $xp .= '<td>'.$xps['xpfunction'] .'</td>';
        $xp .= '<td>'.$xps['xpemployer'].'</td>';
        $xp .= '<td>'.$xps['xpresume'] .'</td>';
       $xp .= '</tr>';
   }

}

/*----- Affichage Formations et langues -----*/

//Variable d'affichage formation:
$diplome = "";
if(isset($_GET['choix']) && $_GET['choix'] == 'formation'){

    $req = $pdo->query("SELECT * FROM schooling");

    while($school = $req->fetch(PDO::FETCH_ASSOC)){

        $diplome .= '<tr>';
            $diplome .= '<th scope="row">'.$school['sgdate'] .'</th>';
            $diplome .= '<td>'.$school['sgtitle'] .'</td>';
            $diplome .= '<td>'.$school['sgsubtitle'] .'</td>';
            $diplome .= '<td>'.$school['sgdescription'] .'</td>';
        $diplome .= '</tr>';
    }
}

//Variable d'affichage langue:
$langue = "";

if(isset($_GET['choix']) && $_GET['choix'] == 'formation'){

    $req = $pdo->query("SELECT * FROM languages");

    while($lang = $req->fetch(PDO::FETCH_ASSOC)){

        $langue .= '<tr>';
            $langue .= '<th scope="row"> '.$lang['lglanguage'].' </th>';
            $langue .= '<td>';
                if($lang['lglevel'] == 1){
                    $langue .= '<p class="text-warning">Débutant</p>';
                }elseif($lang['lglevel'] == 2){
                    $langue .= '<p class="text-info">Intermédiaire</p>';
                }elseif($lang['lglevel']== 3){
                    $langue .= '<p class="text-primary">Avancé</p>';
                }elseif($lang['lglevel']== 4){
                    $langue .= '<p class="text-success">Maitrise</p>';
                }
            $langue .= '</td>';
    }
}

/*************************************************************************************************
                                        BACK-OFFICE
 *************************************************************************************************/

/*>>>>> GESTION COMPETENCE & PROJET >>>>>*/

//Affichage des compétences :

// Variable d'affichage :

$bo_comps ="";

if(isset($_GET['gestion']) && $_GET['gestion'] =='competence'){

    $req = $pdo->query("SELECT * FROM competences ");

    while($competence = $req->fetch(PDO::FETCH_ASSOC)){
        $bo_comps .= '<tr>';
        $bo_comps .= '<th scope="row"><i class="'.$competence['cptechnology'].'"></i></th> ';
        if($competence['cplevel'] == 1){
            $bo_comps .= '<td class="text-warning">Débutant</td>';
        }elseif($competence['cplevel'] == 2){
            $bo_comps .= '<td class="text-info">Intermédiaire</td>';
        }elseif($competence['cplevel']== 3){
            $bo_comps .= '<td class="text-primary">Avancé</td>';
        }elseif($competence['cplevel']== 4){
            $bo_comps .= '<td class="text-success">Maitrise</td>';
        }
        $bo_comps .='<td><a href="../form/formModifComp.php?action=update&id='.$competence['idcompetence'].'"><i class="far fa-edit text-warning"></i></a></td>';
        $bo_comps .='<td><a href="?gestion=competence&action=supp&id='.$competence['idcompetence'].'"><i class="far fa-trash-alt text-danger"></i></a></td>';
        $bo_comps .= '</tr>';
    }

}

/* Ajout de competence */
//Variable d'affichage :
$gestion_comp ="";
if($_POST && isset($_POST['cptechnology'])){

    // Vérification des champs du formulaire :
    if(!isset($_POST['cptechnology']) || strlen($_POST['cptechnology']) < 3 || strlen($_POST['cptechnology']) > 255){
        $msg.= '<div class="alert alert-warning text-danger"> ** Indiquez une technologie</div>';
    }
    if(!isset($_POST['cplevel']) || !is_numeric($_POST['cplevel'])){
        $msg.= '<div class="alert alert-warning text-danger"> ** Sélectionnez un niveau.</div>';
    }

    if(empty($msg)){

        //Protection contre les injections  JS & CSS :
        foreach ($_POST as $indices => $valeurs) {
            $_POST['indice'] = htmlspecialchars($valeurs, ENT_QUOTES);
        }


        $req = $pdo->prepare("INSERT INTO competences (cptechnology, cplevel) VALUES (:cptechnology, :cplevel)");
        $req->bindParam(':cptechnology',$_POST['cptechnology'], PDO::PARAM_STR);
        $req->bindParam(':cplevel',$_POST['cplevel'], PDO::PARAM_INT);
        $req->execute();

//Je me redirige vers mon tableau :
        header('location:../admin/gestionIndex.php?gestion=competence');
    }
}//FIN If(POST)

/* Suppression de competence */
if(isset($_GET['action']) && $_GET['action'] == 'supp' && isset($_GET['id'])){
   $req =   executeRequete("DELETE FROM competences WHERE idcompetence = :idcompetence", array(
       ':idcompetence' => $_GET['id']
   ));

    if($req->rowCount()== 1){
        //die('l200');
        $msg .= '<div class="alert alert-success>La competence n°' . $_GET['id'] . ' a bien été supprimée </div>';
    }else{
        //die('l203');
        $msg .='<div class="alert alert-danger>La  suppression n\'a pu être faite</div>';
    }
}

/* Modif des competences */
//
//If(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
//    $sql="SELECT * FROM competences WHERE idcompetence = ".intval($_GET['id']);
//   // echo $sql;
//    $req = $pdo->query($sql);
//    $result= $req->fetch(PDO::FETCH_ASSOC);
//    //print_r($result);
//
//    //if(isset($_POST['cptechnology']) && strlen($_POST['cptechnology'])> 3 && strlen($_POST['cptechnology']) < 255 && isset($_POST['cplevel']) && is_numeric($_POST['cplevel'])){
//
//        $update ="UPDATE competences SET cptechnology=".$_POST['cptechnology']."cplevel=". $_POST['cplevel']."WHERE idcompetence = ".intval($_GET['id']);
//        $req = $pdo->query($update);
//    echo($req);
//
//}


    /*>>>>> GESTION FORMATION & LANGUES >>>>>*/

/**
 * 1- AFFICHAGE FORMATION
 */

// 1.1- Variable d'affichage formation:
    $bo_diplome = "";

// 1.2- requête d'affichage de la formation

    if(isset($_GET['gestion']) && $_GET['gestion'] == 'formation'){

        $req = $pdo->query("SELECT * FROM schooling");

        while($school = $req->fetch(PDO::FETCH_ASSOC)){

            $bo_diplome .= '<tr>';
            $bo_diplome .= '<th scope="row">'.$school['sgdate'] .'</th>';
            $bo_diplome .= '<td>'.$school['sgtitle'] .'</td>';
            $bo_diplome .= '<td>'.$school['sgsubtitle'] .'</td>';
            $bo_diplome .= '<td>'.$school['sgdescription'] .'</td>';
            $bo_diplome .='<td><a href="../form/formFormation.php?action=update&id='.$school['idschooling'].'"><i class="far fa-edit text-warning"></i></a></td>';
            $bo_diplome .='<td><a href="?gestion=formation&action=supp&id='.$school['idschooling'].'"><i class="far fa-trash-alt text-danger"></i></a></td>';
            $bo_diplome .= '</tr>';
        }
    }

/**
 * 2- AJOUT & MODIFICATION FORMATION
 */

// ----------------
// 2.1- Boucle SELECT pour l'année
// ----------------
$select_date = '';
$year = date('Y');
$century = $year - 100;

if($_POST){

    debugV($_POST);
}

// 2.2- récupération des infos pour la modification
if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
//    debugV($_GET);
    $req = $pdo->prepare("SELECT * FROM schooling WHERE idschooling = :idschooling");
    $req->bindParam(':idschooling', $_GET['id']);
    $req->execute();

    if($req->rowCount() > 0){
        // récupération des infos en BDD pour affichage dans le formulaire de modification
        $school_update = $req->fetch(PDO::FETCH_ASSOC);
//        extract($school_update);
        //$year = $school_update['sgdate'];
    }
//    debugV($year);
}

while($year >= $century){
    if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id']) && $_GET['id'] == $school_update['idschooling'] && $school_update['sgdate'] == $year){
        $select_date .= '<option selected>' . $year . '</option>';
    }
    elseif ($_POST && isset($_POST['sgdate']) && $_POST['sgdate'] == $year) {
        $select_date .= '<option selected>' . $year . '</option>';
    } else {
        $select_date .= '<option>' . $year . '</option>';
    }
    $year--;
}


// 2.2- traitement du formulaire => enregistrement en BDD
if($_POST && isset($_POST['sgdate']) && isset($_POST['sgtitle']) && isset($_POST['sgsubtitle']) && isset($_POST['sgdescription']) ){

    // 2.2.1- contrôles du formulaire
    if (!isset($_POST['sgdate']) || !is_numeric($_POST['sgdate']) || $_POST['sgdate'] > date('Y') || ($_POST['sgdate']) < $century) $msg .= '<div class="alert alert-danger">L\'année est incorrecte.</div>';
//    if (!isset($_POST['sgdate']) || !is_numeric($_POST['sgdate']) || $_POST['sgdate'] > $year || ($_POST['sgdate']) < $century || $_POST['sgdate'] == 'annee') $msg .= '<div class="alert alert-danger">L\'année est incorrecte.</div>';
    if (!isset($_POST['sgtitle']) || strlen($_POST['sgtitle']) < 2 || strlen($_POST['sgtitle']) > 100) $msg .= '<div class="alert alert-danger">Le titre de la formation doit contenir entre 2 et 100 caractères.</div>';
    if (!isset($_POST['sgsubtitle']) || strlen($_POST['sgsubtitle']) < 2 || strlen($_POST['sgsubtitle']) > 150) $msg .= '<div class="alert alert-danger">La spécialité de la formation doit contenir entre 2 et 150 caractères.</div>';
    if (!isset($_POST['sgdescription']) || strlen($_POST['sgdescription']) < 2 || strlen($_POST['sgdescription']) > 200) $msg .= '<div class="alert alert-danger">Le descriptif de la formation peut contenir entre 2 et 200 caractères.</div>';

    // 2.2.2- Insertion en BDD si les contrôles de saisie sont bons
    if(empty($msg)) {
        //-- 1- assainissement des saisies de l'internaute
        foreach ($_POST as $indice => $valeur) {
            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
        }

        //-- 2- enregistrement en BDD
        executeRequete("REPLACE INTO schooling VALUES (:idschooling, :sgtitle, :sgsubtitle, :sgdate, :sgdescription)",
                array(
                    ':idschooling' => $_POST['idschooling'],
                    ':sgtitle' => $_POST['sgtitle'],
                    ':sgsubtitle' => $_POST['sgsubtitle'],
                    ':sgdate' => $_POST['sgdate'],
                    ':sgdescription' => $_POST['sgdescription'],
                )
            );

        $msg .= '<div class="alert alert-success">L\'enregistrement a bien été réalisé en BDD.</div>';


    } // fin  if(empty($msg))

} // fin if($_POST)



