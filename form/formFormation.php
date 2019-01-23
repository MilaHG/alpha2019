<?php
require '../inc/admin/adminHeader.inc.php';
require '../inc/init.inc.php';
require '../controller/traitement.php';
session_start();
?>
<div class="container">

    <div class="row">
        <h5> Ajouter une formation : </h5>
        <div class="col-lg-4 offset-2 mt-5">
            <form method="POST">
                <?php
                    echo $msg;
                ?>
	            <input type="hidden" name="idschooling" value="0"> <!-- champ caché utile pour la modification d'un élément existant car on a besoin de le connaître pour la requête SQL REPLACE INTO qui se comporte comme un UPDATE en présence d'un ID existant. La value à 0 permet de spécifier que l'ID n'existe pas, donc que REPLACE INTO doit se comporter comme un INSERT pour créer la ligne en BDD -->
                <div class="form-group">
                    <select name="sgdate" class="form-control custom-select">
	                    <option value="">Année</option>
                        <?php
                        	echo $select_date;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="text" name="sgtitle" placeholder="Diplome" value="<?php echo $school_update['sgtitle'] ??
	                    $_POST['sgtitle'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="text" name="sgsubtitle" placeholder="spécialité" value="<?php echo
                    $school_update['sgsubtitle'] ?? $_POST['sgsubtitle'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <textarea name="sgdescription" id="" rows="5" placeholder="Description" class="form-control"><?php echo
                            $school_update['sgsubtitle'] ?? $_POST['sgsubtitle'] ?? '' ?></textarea>
                </div>
                <input type="submit" class="btn btn-outline-dark mt-4 text-success btn-block" value="Enregistrer">
            </form>
        </div>
    </div>
	<div class="row">
		<div class="col-lg-2 offset-3">
			<a href="../admin/gestionIndex.php?gestion=formation"><i class="fas fa-chevron-circle-left fa-3x"></i></a>
		</div>
	</div>

</div>