<?php
function afficherEtudiantAvecLiens($infoTutor, $infoSecondary, $infoEnglish, $idUser, $isTutor, $isSecondary, $isEnglishEvaluator) {
	echo "<h2>Informations sur l'étudiant</h2>";
	if($isSecondary) {
		foreach ($infoSecondary as $infos) {
			AffEvalStage($infos);
		}
	}
	if($isTutor) {
		foreach ($infoTutor as $infot) {
			AffEvalStage($infot);
			AffEvalTut($infot);
		}
	}
	if($isEnglishEvaluator) {
		foreach ($infoEnglish as $infoe) {
			AffEvalEng($infoe);
		}
	}
}

function AffEvalStage($infoEtu) {
	if (!empty($infoEtu[0])) {
		echo "<p>Nom : {$infoEtu[0]['nom']}</p>";
		echo "<p>Prénom : {$infoEtu[0]['prenom']}</p>";
	}
	echo "Nom : {$infoEtu['nom']}";
	echo "Prénom : {$infoEtu['prenom']}";
	echo "Eval Stage:<br>";
	echo "<table border='1'>";
	echo "<tr><th>Entreprise</th><td>{$infoEtu['entreprise']}</td></tr>";
	echo "<tr><th>Nom Maitre de Stage</th><td>{$infoEtu['nomMaitreStage']}</td></tr>";
	echo "<tr><th>Note Stage</th><td>{$infoEtu['noteStage']}</td></tr>";
	echo "<tr><th>Note Tuteur</th><td>{$infoEtu['noteTut']}</td></tr>";
	echo "<tr><th>Note Soutenance</th><td>{$infoEtu['noteSout']}</td></tr>";
	echo "<tr><th>Note Rapport</th><td>{$infoEtu['noteRap']}</td></tr>";
	echo "<tr><th>Note Soutenance Enseignant 1</th><td>{$infoEtu['noteEns1']}</td></tr>";
	echo "<tr><th>Note Soutenance Enseignant 2</th><td>{$infoEtu['noteEns2']}</td></tr>";
	echo "<tr><th>Commentaire Jury</th><td>{$infoEtu['commjury']}</td></tr>";
	echo "<tr><th>Presence Maitre Stage</th><td>{$infoEtu['MSpres']}</td></tr>";
	echo "<tr><th>Confidentiel</th><td>{$infoEtu['confidentiel']}</td></tr>";
	echo "<tr><th>Sujet</th><td>{$infoEtu['sujet']}</td></tr>";
	echo "<tr><th>Date soutenance</th><td>{$infoEtu['date_h']}</td></tr>";
	echo "<tr><th>Salle</th><td>{$infoEtu['salleNom']}</td></tr>";
	echo "</table>";
}

function AffEvalTut($infoEtu) {
	echo "<br>Eval Rapport:";
	echo "<br><table border = 1>";
	echo "<tr><th>Note</th><td>{$infoEtu['ernote']}</td></tr>";
	echo "<tr><th>Commentaire</th><td>{$infoEtu['ercomm']}</td></tr>";
	echo "<tr><th>Annee</th><td>{$infoEtu['eryr']}</td></tr>";
	echo "<tr><th>Statue</th><td>{$infoEtu['erstat']}</td></tr>";
	echo "</table>";
	echo "<br>Eval Portfolio:";
	echo "<br><table border = 1>";
	echo "<tr><th>Note</th><td>{$infoEtu['epnote']}</td></tr>";
	echo "<tr><th>Commentaire</th><td>{$infoEtu['epcomm']}</td></tr>";
	echo "<tr><th>Annee</th><td>{$infoEtu['epyr']}</td></tr>";
	echo "<tr><th>Statue</th><td>{$infoEtu['epstat']}</td></tr>";
	echo "</table>";
}

function AffEvalEng($infoEtu) {
	echo "<br>Eval Anglais:";
	echo "<br><table border = 1>";
	echo "<tr><th>Note</th><td>{$infoEtu['eanote']}</td></tr>";
	echo "<tr><th>Commentaire</th><td>{$infoEtu['eacomm']}</td></tr>";
	echo "<tr><th>Date soutenance</th><td>{$infoEtu['eadate']}</td></tr>";
	echo "<tr><th>Salle</th><td>{$infoEtu['easalle']}</td></tr>";
	echo "<tr><th>Statue</th><td>{$infoEtu['eastat']}</td></tr>";
	echo "</table>";
}