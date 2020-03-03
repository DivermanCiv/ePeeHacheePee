<?php
session_start();
if ($_SESSION ["Mort"] == TRUE ){
  echo "Désolé, mais tu es mort et ne peux donc plus continuer. Mais tu peux toujours retenter ta chance avec un autre personnage !";
  goto end;
}
if (!isset($_SESSION['characterfinal'])){
  echo "Et bien, tu n'as même pas réussi à faire correctement ton personnage ! Recommence !";
}
if ($_SESSION['Start']=='Init'){
  $inventory=array("Des vêtements convenables, mais plutôt sales");
  $stage=1;
  $time=0;
  $character=$_SESSION['characterfinal'];
  $seau=1;
  $porte = "fermée";
  $modPV =0;
  $modPM=0;
  $modCombat=0;
  $PO = 0;
  $garde = array ('Nom'=>'Garde de prison', 'PV'=>20 , 'Combat'=>10 , 'FOR' => 5, 'INT'=> 4 , 'ADR'=>6, 'PER' =>6, 'CHA'=>4, 'COU'=>5);
}
else{
  $PO = $_SESSION['PO'];
  $time=$_SESSION['Time'];
  $stage=$_SESSION['Stage'];
  $inventory=$_SESSION['Inventory'];
  $character=$_SESSION['character'];
  $seau=$_SESSION['seau'];
  $porte=$_SESSION['porte'];
  $modPV=$_SESSION['modPV'];
  $modPM=$_SESSION['modPM'];
  $modCombat=$_SESSION['modCombat'];
  $garde = $_SESSION["garde"];
}
$_SESSION['Start']="Started";
$heroname=$character['Nom'];
$classe=$character['Classe'];
$race= $character['Race'];
$FOR= $character['FOR'];
$INT =$character['INT'];
$ADR= $character['ADR'];
$PER =$character['PER'];
$CHA= $character['CHA'];
$COU =$character['COU'];
$PV =$character['Points de Vie'];
$PM =$character['Points de Magie'] ;
$Combat=$character['Habileté au Combat'] ;

$msg_cmd_inconnue=array("Tu reprends tes esprits et choisis de prendre une meilleure décision.","Tu décides de faire quelque chose de plus pertinent.",
"Tu ne sais pas trop ce que tu avais l'intention de faire, alors tu décides de faire autre chose.", "Tu penses que tu devrais prendre une autre décision.",
"Tu penses qu'il y a mieux à faire.");

#La fonction pour tester les caracs : un jet de dé à 10 faces ; si le résultat est égal ou inférieur à la caractéristique testée, le jet est considéré comme réussi !
function test($x){
  $dice=rand(1,10);
  if ($x >= $dice){
    return TRUE;
  }
  else{
    return FALSE;
  }
}

#fonction qui renvoie un résultat d'un lancer de dé à X faces
function D($face){
  $result=rand(1,$face);
  return $result;
}
?>

<!DOCTYPE html>
<html lang='fr'>
        <head>
                <meta charset='UTF-8' name='AdamDupuis'/>
                <title>welcome</title>
        </head>
        <body>


          <?php

            if ($stage==1){
              echo "Tu es dans une petite cellule sale et sombre. La seule source de lumière provient d'une petite fenêtre pourvue de barreaux qui laisse passer la lueur de la lune
                ainsi qu'un courant d'air frais te permettant de supporter l'odeur nauséabonde provenant du petit seau situé dans un coin de la pièce. Dans le coin opposé, tu peux
                voir un tas de foin posé sur le sol avec une couverture miteuse posée dessus. En face de la fenêtre, une rangée de barreaux avec en son centre, une porte, te sépare
                d'un couloir. <br><br>";
            }
            if ($time==0){
              switch ($_SESSION['Start_Situation']){
                case 'a' :
                  echo " Alors que tu t'apprêtes à jeter un coup d'oeil à la serrure de la porte, ";
                  break;
                case 'b' :
                  echo " Alors que tu tends l'oreille à l'affût d'informations intéressantes, ";
                  break;
                case 'c' :
                  echo " Alors que tu fais les cent pas dans la pièce, ";
                  break;
                case 'd' :
                  echo " Alors que tu prépares tes arguments dans l'attente d'un éventuel procès, ";
                  break;
                }

              echo "tu entends une conversation entre deux gardes tandis qu'ils passent devant ta cellule. <br> \"C'est quand même un peu sévère, tu penses pas ?\" <br>\"Les
              ordres sont les ordres. Le duc veut faire un exemple, et je dois t'avouer que je ne cracherais pas sur quelques prisonniers en moins à s'occuper !\" <br>
              Les gardes s'éloignent par la droite et te voilà seul à présent.<br><br>";
              $time++;

            }

            if (isset($_POST["choice"]) AND $_SESSION['Start']!='Init' ){
              $choice=$_POST["choice"];

              if ($_POST["choice"]==""){
                echo "Rien. Tu ne fais rien du tout.";
              }
              #afficher l'inventaire
              if(preg_match("#inventaire#i", $choice)){
                echo "<h2>Inventaire</h2>";
                echo "<br><strong>Pièces d'Or : </strong> ".$PO."<br>";
                for ($i=0 ; $i < count($inventory); $i++) {
                  echo "<br>".$inventory[$i]."<br>";
                }
              }
              #afficher la fiche de personnage
              if (preg_match("#character#i",$choice)){
                echo "<h2>Feuille de personnage</h2>";
                foreach ($character as $key => $value){
                  echo "<strong>{$key}</strong> : {$value}<br>";
                }
              }

              if (preg_match("#aide#i",$choice)){
                echo "<h2>Aide</h2>";
                echo "Utilise \"character\" pour afficher ta feuille de personnage<br><br>Sauras-tu trouver le mot permettant d'accéder à ton inventaire ? (Indice : la solution est dans la question)<br><br>Quelques mots-clés :<br><br>regarder<br>fouiller<br>prendre<br>attaquer<br>";
              }


              ##### STAGE 1 --- La Cellule ########
              while ($stage == 1 AND isset($choice)){

                #Passer directement à l'évenement patrouille d'un garde
                if (preg_match("#time7#i", $choice)){
                  $time=7;}


                #Evenement patrouille d'un garde

                if ($time == 7){
                  echo "Tout à coup, un garde en patrouille passe devant la porte de ta cellule, interrompant ce que tu comptais faire. ";
                  if ($porte =="ouverte"){
                    echo "Il voit la porte grande ouverte et décide de rentrer dans la cellule en dégainant un gourdin d'un air mauvais...<br>";
                    $stage = "fight";
                    $round = 1;
                    break;
                  }
                  else {
                    echo "Il possède un gros trousseau de clés à la ceinture et est armé d'un gourdin<br>";
                    $time++;
                    break;
                  }
                }#fin arrivée patrouille d'un garde
                if ($time == 8){
                  if (preg_match("#vol#i", $choice)){
                    if(preg_match("#cl[ée]#i", $choice)){
                      if (test($ADR)){
                        echo "Tu réussis à subtiliser discrètement le trousseau de clés. Le garde passe son chemin";
                        $time++;
                        $inventory[]="Trousseau de clés de la prison";
                        break;
                      }
                      else{
                        echo "Le garde te surprend et décide d'entrer dans ta cellule pour t'apprendre les bonnes manières...";
                        $stage = "fight";
                        $round= 1;
                        break;
                    }
                  }
                  if (preg_match("#gourdin#i", $choice)){
                    if (test($ADR-3)){
                      echo "Tu subtilises discrètement, mais non sans difficultés, l'arme du garde. Le garde passe son chemin";
                      $inventory[]="Gourdin";
                      $time++;
                      break;
                    }
                    else{
                      echo "Le garde te surprend et décide d'entrer dans ta cellule pour t'apprendre les bonnes manières...";
                      $stage = "fight";
                      $round= 1;
                      break;
                    }
                  }
                }

                if (preg_match("#parl|discut#i", $choice)){
                  if ($CHA > 7 OR test($CHA)){
                    echo "En engageant la discussion avec le soldat, tu apprends qu'afin de donner l'exemple à la population, tu seras pendu avec d'autres prisonniers à l'aube. Le garde semble désolé pour toi et en prolongeant la conversation, tu parviens à te faire apprécier de lui. Il décide alors de déverrouiller la porte de ta cellule et te montre le couloir à gauche : il y a au fond un local servant à jeter les ordures donnant directement accès aux égoûts. Il te confie que c'est le moyen le plus sûr de sortir sans se faire prendre. Il reprend alors sa patrouille.";
                    $porte ="déverrouillée";
                    $time++;
                    break;
                  }
                  else {
                    echo "A peine ouvres-tu la bouche que le soldat te rabroue avec des insultes avant de passer son chemin.";
                    $time++;
                    break;
                  }
                }

                if (preg_match("#attaq|comba#i", $choice)){
                  if ($porte=="déverrouillée"){
                    echo "Tu surgis d'un coup hors de ta cellule et bondis sur le garde qui n'a pas le temps de réagir !";
                    $stage="fight";
                    $round=0;
                    break;
                  }
                  else {
                    echo "Tu bondis sur le garde et te prends la porte fermée en pleine figure. Le garde éclate de rire et passe son chemin.<br><br><em>Tu perds 1PV !</em>";
                    $modPV--;
                    $time++;
                    break;
                  }
                }

              }

                #Choix d'attendre
                if (preg_match("#attend#i", $choice)){
                  echo "Tu attends.";
                  $time++;
                  break;
                }

                #Obervation de l'environnement
                if (preg_match("#exam[ie]n|observ|regard#i", $choice)){
                  if(preg_match("#foin|paillasse#i", $choice)){
                    echo "<br>Tu examines la paillasse de foin. Celle-ci est d'une hygiène douteuse, ainsi que la couverture la recouvrant. Il semble que ce soit fait pour
                    dormir...<br>";
                    $time++;
                    break;}
                  if(preg_match("#fen[êe]tre#i", $choice)){
                    echo "<br>";
                    if ($race='semi-homme' OR $race='nain'){
                      echo "Tu te mets sur la pointe des pieds pour atteindre la fenêtre et parviens à jeter un oeil à l'extérieur. ";
                    }

                    echo "En observant par la fenêtre, tu vois une grande cour éclairée par la lueur de plusieurs torches. Des hommes s'activent en bas et construisent
                    ce qui semble être un gibet de taille conséquente.<br>";
                    $time++;
                    break;
                  }
                  if(preg_match("#seau#i", $choice)){
                    echo "<br>Le seau dégage une odeur pestilentielle et contient une bouillie de fluides corporels répugnante.<br>";
                    $time++;
                    break;
                  }
                  if(preg_match("#porte|serrure#i", $choice)){
                    echo "<br>La porte en métal a l'air assez robuste, mais sa serrure a quant à elle un aspect plutôt ancien et primitif. Avec un outil convenable
                     et un peu d'adresse, ce ne serait pas trop difficile de la crocheter...<br> ";
                    $time++;
                    break;
                  }
                  if(preg_match("#couloir#i", $choice)){
                    echo "<br>En passant le bout de ta tête à travers les barreaux, tu vois que le corridor part de parts et d'autres des côtés de la cellule. A gauche, le couloir forme un angle et continue sur la droite.
                    A droite, il continue sur une dizaine de mètres avant de donner sur une porte en bois à double battants. C'est par là que ce sont dirigés les gardes
                    tout à l'heure.";
                    $time++;
                    break;
                  }
                  else {
                    echo "<br>Qu'examines-tu ?<br>";
                    break;
                  }
                }#fin choix d'examiner
                #CHOIX DE PRENDRE
                if(preg_match("#prend|attrap#i", $choice)){
                  if(preg_match("#couverture#i", $choice)){
                    if (in_array("Une couverture miteuse", $inventory)){
                        echo "Tu as déjà pris la couverture !";
                        break;
                      }
                    else {
                      echo "Tu prends la couverture miteuse avec toi.";
                      $inventory[]= "Une couverture miteuse";
                      $time++;
                      break;
                    }
                  }
                  if (preg_match("#seau#i", $choice)){
                    echo "C'est absolument dégoûtant et tu t'imagines mal t'en servir quand tu seras sorti d'ici.";
                    break;
                  }
                  else {echo "Que prends-tu ?"; break;}
                }#fin choix de prendre
                #Choix fouiller
                if(preg_match("#fouill|cherch#i", $choice)){
                  if(preg_match("#foin|paillasse#i", $choice)){
                    if (in_array("Une épingle à cheveux", $inventory)){
                      echo "Tu as déjà fouillé cette paillasse";
                      break;
                    }
                    else {
                      if (!test($PER) AND $PER<7){
                        echo "[PER]<br>A priori, il ne semble ne rien avoir dans ce tas de paille.";
                        $time++;
                        break;
                      }
                      else{
                        echo "[PER]<br>En fouillant la paillasse, tu trouves une épingle à cheveux ! Tu décides de la prendre avec toi. ";
                        $inventory[]= "Une épingle à cheveux";
                        $time++;
                        break;
                      }
                    }
                  }#fin chercher paillasse
                  if(preg_match("#seau#i", $choice)){
                    if ($seau == 1){
                      echo 'Tu plonges ta main dans le seau ignoble en espérant y trouver quelque chose, mais il n\' y a rien de plus qu\'un sentiment de stupidité teintée de rage qui commence à t\'envahir... <br><br><em>Tu perds un point d\'Intelligence !</em> ';
                      $seau++;
                      $INT--;
                      break;
                    }
                    else {
                      echo "Convaincu que le maître du jeu ne te laissera pas plonger la main dans le seau éternellement, tu décides bêtement d'essayer pour la ".$seau."e fois. <br><br><em>Tu perds un point d'Intelligence !</em>";
                      $seau++;
                      $INT--;
                      break;
                    }
                  }#fin chercher seau
                }#fin Choix fouiller
                if(preg_match("#porte#i", $choice)){
                  if (preg_match("#ouvr#i", $choice)){
                    if($porte=='fermée'){
                      echo 'La porte est fermée à l\'aide d\'une serrure rouillée';
                      $time++;
                      break;
                    }
                    if($porte=='déverrouillée'){
                      echo "La porte s'ouvre";
                      $time++;
                      $porte="ouverte";
                      break;
                    }
                    else {
                      echo "La porte est déjà ouverte !";
                      break;
                    }
                  }#fin ouvrir porte
                  if (preg_match("#ferm#i", $choice)){
                    if ($porte=='ouverte'){
                      echo "Tu fermes la porte";
                      $porte="déverrouillée";
                      break;
                    }
                    else {
                      echo "La porte est déjà fermée !";
                      break;
                    }
                  }#fin fermer porte
                  if (preg_match("#crochet|d[ée]verrouill#i", $choice)){
                    if ($porte!="fermée"){
                      echo "La porte est déjà déverrouillée !";
                      break;
                    }
                    if (in_array("Une épingle à cheveux", $inventory)){
                      if ($ADR>6 OR test($ADR)){
                        echo "Après quelques minutes à t'escrimer avec la serrure et l'épingle à cheveux, un déclic se fait entendre : la porte est déverouillée !";
                        $porte = "déverrouillée";
                        $time++;
                        break;
                      }
                      else {
                        echo "[ADR]<br>Tu passes les prochaines minutes à te battre avec cette satanée serrure, mais elle refuse de céder pour le moment !";
                        $time++;
                        break;
                      }
                    }
                    else {
                      echo "Tu te demandes comment ouvrir cette serrure sans outil";
                      $time++;
                      break;
                    }
                  }#fin déverouiller porte
                }#fin Choix porte
                if (preg_match("#crochet|d[ée]verrouill|ouvr#i", $choice)){
                  if (preg_match("#serrure#i", $choice)){
                    if ($porte!="fermée"){
                      echo "La porte est déjà déverrouillée !";
                      break;
                    }
                    if (in_array("Trousseau de clés de la prison", $inventory)){
                      echo "Après plusieurs essais, tu trouves finalement la clé du trousseau correspondant à la serrure et l'ouvres.";
                      $porte = "déverrouillée";
                      $time++;
                      break;
                    }
                    if (in_array("Une épingle à cheveux", $inventory)){
                      if ($ADR>6 OR test($ADR)){
                        echo "Après quelques minutes à t'escrimer avec la serrure et l'épingle à cheveux, un déclic se fait entendre : la porte est déverouillée !";
                        $porte = "déverrouillée";
                        $time++;
                        break;
                      }
                      else {
                        echo "[ADR]<br>Tu passes les prochaines minutes à te battre avec cette satanée serrure, mais elle refuse de céder pour le moment !";
                        $time++;
                        break;
                      }
                    }
                    else {
                      echo "Tu te demandes comment ouvrir cette serrure sans outil";
                      $time++;
                      break;
                    }
                  }
                }#fin crocheter serrure
                if (preg_match("#sor#i",$choice)){
                  if ($porte=="ouverte"){
                    $stage =2;
                    break;
                  }
                  else {
                    echo "Impossible de sortir si la porte est fermée";
                    $time++;
                    break;
                  }
                }
                #Si jamais le joueur veut utiliser une des éléments de la cellule sans avoir employé un verbe précis/reconnu par le programme
                if (preg_match("#foin|paillasse|couverture|fen[eê]tre|couloir|corridor|porte|serrure|seau#i", $choice)){
                  echo "Je n'ai pas compris exactement ce que tu veux faire avec \"" . $choice . "\". Essaye autre chose.";
                  break;
                }

                #empêche le programme de renvoyer une phrase destinée pour les mauvaises commandes lorsque le joueur affiche un menu inventaire, feuille perso ou aide
                if (preg_match("#inventaire|character|aide#i",$choice)){
                  break;
                }
                #si le joueur entre une commande qui ne produit rien
                else{
                  echo "<br>".$msg_cmd_inconnue[rand(0,count($msg_cmd_inconnue)-1)];
                  break;
                }
              }#fin while STAGE=Cellule
              while ($stage == "fight"){
                if (!isset($round)){
                  $round = $_SESSION['round'];
                }
                echo "<br><br>Tour ".$round. "<br>";

                if ($round == 0){
                  echo "Tu assènes un violent coup de poing au garde par surprise !";
                  echo "<br><em>Tu infliges ".$FOR." dégâts à l'ennemi !</em>";
                  $garde ["PV"] = $garde ["PV"] - $FOR;
                  $round++;
                  break;
                }
                if ($PV <= 0 ){
                  echo "Le garde finit par te frapper sur le côté du crâne, et tu sombres dans l'inconscience. Tu te réveilles quelques heures plus tard, la corde nouée autour du cou. A peine t'en rends-tu comptes que tu sens le sol disparaître sous tes pieds. Dommage.<br><br>Tu es mort.";
                  $stage = 0;
                  $_SESSION["Mort"] = TRUE;
                  break;
                }
                if ($garde['PV']<=0){
                  echo "D'un dernier coup de poing, tu envois ton adversaire au sol, inconscient. Tu récupères son gourdin, son trousseau de clés et un peu d'or";
                  $inventory[]="Gourdin";
                  $PO= $PO +D(20);
                  $inventory[]="Trousseau de clés de la prison";
                  $stage = 2;
                  break;

                }
                if ($round ==1){
                  echo "<br>Le garde et toi vous trouvez face à face. Tu es à mains nues, mais le gardien ne semble pas bien dangereux...<br>";
                  $round++;
                  break;
                }
                if (preg_match("#attaq|frapp#i",$choice)) {
                  $round++;
                  $HeroRoll = D(20);
                  $gardeRoll = D(20);
                  if ($Combat +$HeroRoll < $garde['Combat'] + $gardeRoll){
                    $degats = $garde['FOR']+ D(4);
                    echo "<br>Tu prends un coup de gourdin et perds ".$degats." PV !<br>";
                    $modPV = $modPV - $degats;
                    break;
                  }
                  if ($Combat +$HeroRoll >= $garde['Combat'] + $gardeRoll){
                    $degats = $FOR;
                    echo "<br>Tu frappes le garde et lui fais perdre ".$degats." PV !<br>";
                    $garde["PV"] = $garde["PV"] - $degats;
                    break;
                  }
                }
                if (preg_match("#lance|utilis#i",$choice)) {
                  $round++;
                  if (preg_match("#couverture#i",$choice) AND in_array("Une couverture miteuse", $inventory) ) {
                    echo "<br>Tu lances la couverture au visage du garde et en profite pour lui donner des coups tandis qu'il est aveuglé !<br>";
                    $degats = $FOR;
                    echo "<br>Tu frappes le garde et lui fais perdre ".$degats." PV !<br>";
                    $garde["PV"] = $garde["PV"] - $degats;
                    break;
                  }
                  if (preg_match("#seau#i", $choice)){
                    echo "<br>Tu cherches à t'emparer du seau pour le lancer sur ton adversaire, mais il est plus lourd qu'il n'y parait et le garde profite de ce temps pour te donner un coup. Tu lâches le seau !<br>";
                    $degats = $garde['FOR']+ D(4);
                    echo "<br>Tu prends un coup de gourdin et perds ".$degats." PV !<br>";
                    $modPV = $modPV - $degats;
                    break;
                  }
                  else {echo 'Tu veux lancer quoi ?';$round--;break;}
                }
                else {
                  echo "Je n'ai pas compris ce que tu veux faire, mais décide-toi vite, tu dois te battre !";
                  break;
                }
              }#fin while STAGE = fight
              while ($stage==2){
                if ($garde["PV"]>0){
                  echo "<br> Alors que tu sors de ta cellule, un garde en patrouille dans le couloir que tu n'avais pas vu te fonce dessus !<br>";
                  $stage = "fight";
                  $round = 1;
                  break;
                }
                else{
                  echo "<br> Tu te retrouves à présent dans le couloir en face de ta cellule... <br><br>Merci d'avoir joué à la démo de éPée Hache éPée !";
                  break;
                }
              }
            }#fin isset choice

              if ($stage != "fight" AND $stage != 0){
                echo "<br><br>Actions faites = " . ($time-1) . "<br> Niveau = ".$stage;
              }

              #Recalcul des statistiques avant de corriger la fiche perso. Il faudrait à l'avenir plutôt faire 3 variables par stats : stat de base, modificateur de stat, stat actuelle.
              #On s'assure également qu'aucune stat ne puisse descendre au-dessous de 1 ou aller au-dessus de 10
              if ($FOR<1){$FOR=1;}
              if ($INT<1){$INT=1;}
              if ($ADR<1){$ADR=1;}
              if ($PER<1){$PER=1;}
              if ($CHA<1){$CHA=1;}
              if ($COU<1){$COU=1;}
              if ($FOR>10){$FOR=10;}
              if ($INT>10){$INT=10;}
              if ($ADR>10){$ADR=10;}
              if ($PER>10){$PER=10;}
              if ($CHA>10){$CHA=10;}
              if ($COU>10){$COU=10;}

              $PV=($FOR+$COU)*2;
              $PM=$INT*2+$CHA;
              $Combat=round(($ADR+$PER)/2)+$COU;
              $PV = $PV + $modPV;
              $PM = $PM + $modPM;
              $Combat = $Combat + $modCombat;

              $character= array('Nom'=>$heroname , 'Classe'=>$classe , 'Race'=>$race , 'FOR'=>$FOR , 'INT'=> $INT , 'ADR'=>$ADR, 'PER' =>$PER, 'CHA'=>$CHA, 'COU'=>$COU
              , 'Points de Vie'=>$PV , 'Points de Magie'=>$PM , 'Habileté au Combat'=>$Combat);

              #affichage des PV durant le combat
              if ($stage == "fight"){
                echo "<br>PV de ".$character["Nom"]." : ".$character["Points de Vie"]."<br>";
                echo "<br>PV de ".$garde["Nom"]." : ".$garde["PV"]."<br>";
              }

              if (isset($round)){
                $_SESSION['round']=$round;
              }
              $_SESSION['character']=$character;
              $_SESSION['modPV']=$modPV;
              $_SESSION['modPM']=$modPM;
              $_SESSION['modCombat']=$modCombat;
              $_SESSION['seau']=$seau;
              $_SESSION['porte']=$porte;
              $_SESSION['Time']=$time;
              $_SESSION['Stage']=$stage;
              $_SESSION['Inventory']=$inventory;
              $_SESSION['garde']=$garde;
              $_SESSION['PO']=$PO;
          ?>
          <form action="game.php" method="post">
            <input type="text" placeholder="Que fais-tu ?" name="choice">
            <button type="submit">Valider</button>
          <form action="game.php" method="post">
            <input type="radio" name="Start" value ="Init" id="Init"><label for="Init">Récommencer le niveau</label>

          <?php
            if (isset($_POST["Start"])){
              $_SESSION["Start"]=$_POST['Start'];
            }
            end :
           ?>
          <br>
          <br>
          <a href="welcome.php">Retour à la création de personnage</a>
        </body>
</html>
