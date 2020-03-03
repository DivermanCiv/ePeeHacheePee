<?php
  session_start();
?>
<!DOCTYPE html>
<html lang='fr'>
        <head>
                <meta charset='UTF-8' name='AdamDupuis'/>
                <title>welcome</title>
        </head>
        <body>
          <?php
            if ($_SESSION['confirm']!='1st') {
              $character=$_SESSION['character'];
              $charactercopie=$_SESSION['charactercopie'];

              #### Calcul des nouvelles caracs quand le joueur choisit celle à augmenter
              if (isset($_POST['1'])){

                if ($_POST['3']=='FOR'){
                  $charactercopie['FOR']=$charactercopie['FOR']+3;
                }

                if ($_POST['3']=='INT'){
                  $charactercopie['INT']=$charactercopie['INT']+3;
                }

                if ($_POST['3']=='ADR'){
                  $charactercopie['ADR']=$charactercopie['ADR']+3;
                }

                if ($_POST['3']=='PER'){
                  $charactercopie['PER']=$charactercopie['PER']+3;
                }

                if ($_POST['3']=='CHA'){
                  $charactercopie['CHA']=$charactercopie['CHA']+3;
                }

                if ($_POST['3']=='COU'){
                  $charactercopie['COU']=$charactercopie['COU']+3;
                }

                if ($_POST['2']=='FOR'){
                  $charactercopie['FOR']=$charactercopie['FOR']+2;
                }

                if ($_POST['2']=='INT'){
                  $charactercopie['INT']=$charactercopie['INT']+2;
                }

                if ($_POST['2']=='ADR'){
                  $charactercopie['ADR']=$charactercopie['ADR']+2;
                }

                if ($_POST['2']=='PER'){
                  $charactercopie['PER']=$charactercopie['PER']+2;
                }

                if ($_POST['2']=='CHA'){
                  $charactercopie['CHA']=$charactercopie['CHA']+2;
                }

                if ($_POST['2']=='COU'){
                  $charactercopie['COU']=$charactercopie['COU']+2;
                }

                if ($_POST['1']=='FOR'){
                  $charactercopie['FOR']=$charactercopie['FOR']+1;
                }

                if ($_POST['1']=='INT'){
                  $charactercopie['INT']=$charactercopie['INT']+1;
                }

                if ($_POST['1']=='ADR'){
                  $charactercopie['ADR']=$charactercopie['ADR']+1;
                }

                if ($_POST['1']=='PER'){
                  $charactercopie['PER']=$charactercopie['PER']+1;
                }

                if ($_POST['1']=='CHA'){
                  $charactercopie['CHA']=$charactercopie['CHA']+1;
                }

                if ($_POST['1']=='COU'){
                    $charactercopie['COU']=$charactercopie['COU']+1;
                }
              }#fin isset augmentation carac

              #Verification qu'aucune stat modifiée ne dépasse 10 et que deux stats n'ont pas été choisies + d'1 fois
              if ($charactercopie["FOR"]>10 OR $charactercopie["INT"]>10 OR $charactercopie["ADR"]>10 OR $charactercopie["PER"]>10 OR $charactercopie["CHA"]>10 OR $charactercopie["COU"]>10){
                echo "Une valeur que tu cherches à augmenter est déjà assez élevée ! Recommence ! <br><br>";
                foreach ($character as $key => $value){
                  echo "{$key} : {$value}<br>";
                }

              }
              elseif ($_POST['3']==$_POST['2'] OR $_POST['3']==$_POST['1'] OR $_POST['1']==$_POST['2']){
                echo "Tu n'as pas le droit de choisir deux fois la même caractéristique à augmenter ! Recommence !<br><br>";
                foreach ($character as $key => $value){
                  echo "{$key} : {$value}<br>";
                }
              }
              else {
                echo "Tu es maintenant prêt à démarrer !<br><br>";
                $_SESSION["Mort"]=FALSE;
                $characterfinal=$charactercopie;
                $characterfinal["Points de Vie"]=($characterfinal["FOR"]+$characterfinal["COU"])*2;
                $characterfinal["Points de Magie"]=$characterfinal["INT"]*2+$characterfinal['CHA'];
                $characterfinal["Habileté au Combat"]=round(($characterfinal["ADR"]+$characterfinal["PER"])/2+$characterfinal["COU"]);
                foreach ($characterfinal as $key => $value){
                  echo "{$key} : {$value}<br>";
                }
              }
              $charactercopie=$character;

            }#fin if pas la premiere fois qu'on accede à cette page

            else {
              echo "Aïe aïe aïe... Tu m'as l'air bien parti pour te faire trucider à la première rencontre hostile ! Pour t'aider, tu peux encore augmenter trois
              caractéristiques de 3, 2, et 1 point ! Attention : ton nouveau score ne devra pas dépasser 10 !<br><br>";
              $_SESSION['Start_Situation']=$_POST['question3'];
              $heroname = $_POST["heroname"];
              $classe = $_POST["classe"];
              $classes=array("Guerrier","Mage","Voleur","Paladin","Ranger","Barde");
              $race = $_POST["race"];
              $races = array("Humain","Elfe","Nain","Hobbit","Orque");

              $FOR = 4; $INT=4;$ADR=4;$CHA=4;$PER=4;$COU=4;


              if ($classe=="randomclass") {
                $classe = $classes[rand(0,count($classes)-1)];
              }
              if ($race=="randomrace") {
                $race = $races[rand(0,count($races)-1)];
              }
              switch ($classe) {
                case 'Guerrier':
                  $FOR=$FOR+2;
                  $INT--;
                  break;

                case 'Mage':
                  $INT=$INT+2;
                  $PER--;
                  break;

                case 'Voleur':
                  $ADR=$ADR+2;
                  $COU--;
                  break;

                case 'Barde':
                  $CHA=$CHA+2;
                  $FOR--;
                  break;

                case 'Ranger':
                  $PER=$PER+2;
                  $CHA--;
                  break;

                case 'Paladin' :
                  $COU=$COU+2;
                  $ADR--;
                  break;
              }

              switch ($race){

                case 'Elfe':
                  $ADR++; $PER++; $INT++; $FOR--; $COU=$COU-2;
                  break;

                case 'Nain':
                  $ADR++;$FOR++;$COU++;$CHA=$CHA-2;$INT--;
                  break;

                case 'Hobbit':
                  $ADR++;$CHA++;$FOR=$FOR-2;
                  break;

                case 'Orque':
                  $FOR=$FOR+2;$COU++;$INT=$INT-2;$CHA--;
                  break;
              }

                switch ($_POST['question1']){
                  case 'a' :
                    $FOR++;
                    break;
                  case 'b' :
                    $INT++;
                    break;
                  case 'c' :
                    $CHA++;
                    break;
                  case 'd' :
                    $ADR++;
                    break;
                }



                switch ($_POST['question2']){
                  case 'a' :
                    $FOR++;
                    break;
                  case 'b' :
                    $CHA++;
                    break;
                  case 'c' :
                    $PER++;
                    break;
                  case 'd' :
                    $COU++;
                    break;
                }

                switch ($_POST['question3']){
                  case 'a' :
                    $ADR++;
                    break;
                  case 'b' :
                    $PER++;
                    break;
                  case 'c' :
                    $COU++;
                    break;
                  case 'd' :
                    $INT++;
                    break;
                }

              #Calcul des caractéristiques dérivées :
              $PV=($FOR+$COU)*2;
              $PM=$INT*2+$CHA;
              $Combat=round(($ADR+$PER)/2)+$COU;

              #création d'un array / fiche de personnage qui permet de garder les valeurs de base du personnage :
              $character= array('Nom'=>$heroname , 'Classe'=>$classe , 'Race'=>$race , 'FOR'=>$FOR , 'INT'=> $INT , 'ADR'=>$ADR, 'PER' =>$PER, 'CHA'=>$CHA, 'COU'=>$COU
              , 'Points de Vie'=>$PV , 'Points de Magie'=>$PM , 'Habileté au Combat'=>$Combat);
              #afficher la feuille de perso :
              foreach ($character as $key => $value){
                echo "{$key} : {$value}<br>";
              }
              $charactercopie=$character;
            }#fin else du if isset session character






            ?>
            <form action="confirm.php" method="post">
              <p>Augmenter une caractéristique de +3 : </p>
              <select name="3">
                <option value ="FOR">Force</option>
                <option value ="INT">Intelligence</option>
                <option value ="ADR">Adresse</option>
                <option value ="PER">Perception</option>
                <option value ="CHA">Charisme</option>
                <option value ="COU">Courage</option>
              </select>

              <p>Augmenter une caractéristique de +2 : </p>
              <select name="2">
                <option value ="FOR">Force</option>
                <option value ="INT">Intelligence</option>
                <option value ="ADR">Adresse</option>
                <option value ="PER">Perception</option>
                <option value ="CHA">Charisme</option>
                <option value ="COU">Courage</option>
              </select>

              <p>Augmenter une caractéristique de +1 : </p>
              <select name="1">
                <option value ="FOR">Force</option>
                <option value ="INT">Intelligence</option>
                <option value ="ADR">Adresse</option>
                <option value ="PER">Perception</option>
                <option value ="CHA">Charisme</option>
                <option value ="COU">Courage</option>
              </select>
              <br><br>
              <button type="submit">Valider l'augmentation de caractéristiques</button>
              <br><br>

            <?php

            $_SESSION["confirm"]='2nd';
            $_SESSION['charactercopie']=$charactercopie;
            if (isset($characterfinal)){
              $_SESSION['characterfinal']=$characterfinal;
            }
            $_SESSION['character']=$character;
            $_SESSION['Start']="Init";
           ?>
           <br>

           <a href="welcome.php">Changer de personnage</a>
           <a href ="game.php">Commencer la partie !</a>
        </body>
</html>
