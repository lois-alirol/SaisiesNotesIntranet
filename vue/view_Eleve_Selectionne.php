<?php
function afficherEtudiantAvecLiens($infoTutor, $infoSecondary, $infoEnglish, $idUser, $isTutor, $isSecondary, $isEnglishEvaluator) {
	echo "{$isTutor} {$isSecondary} {$isEnglishEvaluator}";
	/*if (empty($etudiant)) {
		echo "<p>Aucune information disponible pour cet étudiant.</p>";
		return;
	}*/
	echo "<h2>Informations sur l'étudiant</h2>";
			if($isSecondary) {
				echo "Nom : {$infoSecondary[0]['nom']}";
				echo "Prénom : {$infoSecondary[0]['prenom']}";
				echo "Eval Stage:<br>";
				echo "<table border='1'>";
				echo "<tr><th>Entreprise</th><td>{$infoSecondary[0]['entreprise']}</td></tr>";
				echo "<tr><th>Sujet</th><td>{$infoSecondary[0]['sujet']}</td></tr>";
				echo "<tr><th>Date soutenance</th><td>{$infoSecondary[0]['date_h']}</td></tr>";
				echo "<tr><th>Salle</th><td>{$infoSecondary[0]['salle']}</td></tr>";
				echo "</table>";
			}
			if($isTutor) {
				echo "Eval Stage:<br>";
				echo "<table border='1'>";
				echo "<tr><th>Entreprise</th><td>{$infoTutor[0]['entreprise']}</td></tr>";
				echo "<tr><th>Sujet</th><td>{$infoTutor[0]['sujet']}</td></tr>";
				echo "<tr><th>Date soutenance</th><td>{$infoTutor[0]['date_h']}</td></tr>";
				echo "<tr><th>Salle</th><td>{$infoTutor[0]['salle']}</td></tr>";
				echo "</table>";
				echo "<br>Eval Rapport:<br>";
				echo "<br><table border = 1>";
				echo "<tr><th>Note</th><td>{$infoTutor[0]['ernote']}</td></tr>";
				echo "<tr><th>Commentaire</th><td>{$infoTutor[0]['ercomm']}</td></tr>";
				echo "<tr><th>Annee</th><td>{$infoTutor[0]['eryr']}</td></tr>";
				echo "<tr><th>Statue</th><td>{$infoTutor[0]['erstat']}</td></tr>";
				echo "</table>";
				echo "<br>Eval Portfolio:<br>";
				echo "<br><table border = 1>";
				echo "<tr><th>Note</th><td>{$infoTutor[0]['epnote']}</td></tr>";
				echo "<tr><th>Commentaire</th><td>{$infoTutor[0]['epcomm']}</td></tr>";
				echo "<tr><th>Annee</th><td>{$infoTutor[0]['epyr']}</td></tr>";
				echo "<tr><th>Statue</th><td>{$infoTutor[0]['epstat']}</td></tr>";
				echo "</table>";
			}
			if($isEnglishEvaluator) {
				echo "<br>Eval Anglais:<br>";
				echo "<table border='1'>";
				echo "<tr><th>Note</th><td>{$infoEnglish[0]['eanote']}</td></tr>";
				echo "<tr><th>Note</th><td>{$infoEnglish[0]['eacomm']}</td></tr>";
				echo "<tr><th>Note</th><td>{$infoEnglish[0]['easalle']}</td></tr>";
				echo "<tr><th>Date soutenance</th><td>{$infoEnglish[0]['eadate']}</td></tr>";
				echo "<tr><th>Note</th><td>{$infoEnglish[0]['eastat']}</td></tr>";
				echo "</table>";
			}

    //echo "<h3>Actions disponibles pour $role</h3>";
    //echo "<ul>";
    //echo "<li><a href='pageSuivante.php?action=portfolio&idUser=$idUser&idEtudiant={$etudiant[0]['IdEtudiant']}'>Saisir/Consulter les grilles</a></li>";
    //echo "</ul>";
}