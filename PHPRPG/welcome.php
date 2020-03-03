<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang='fr'>
        <head>
                <meta charset='UTF-8' name='AdamDupuis'/>
                <title>start</title>
        </head>
        <body>
          <h3> Bienvenue dans...<br></h3>
          <h1>éPée Hache éPée (version démo)</h1>
          <p>Crée un personnage, relève des défis et couvre-toi de gloire ou bien décède avec panache !<p>
          <br><br>
          <form action="confirm.php" method="post">
              <input type ="text" placeholder="Quel est ton nom ?" name="heroname" required>
              <select name="classe">
                <option value="Guerrier">Guerrier</option>
                <option value="Mage">Mage</option>
                <option value="Voleur">Voleur</option>
                <option value="Barde">Barde</option>
                <option value="Ranger">Ranger</option>
                <option value="Paladin">Paladin</option>
                <option value="randomclass">Aléatoire</option>
              </select>

              <select name="race">
                <option value="Humain">Humain</option>
                <option value="Elfe">Elfe</option>
                <option value="Nain">Nain</option>
                <option value="Hobbit">Hobbit</option>
                <option value="Orque">Orque</option>
                <option value="randomrace">Aléatoire</option>
              </select>

              <p>Quelques questions pour déterminer tes statistiques...</p>
              <p>Tu arrives dans une nouvelle ville et décides de t'arrêter à une taverne du coin. Que vas-tu y faire ?</p>
              <input type="radio" name="question1" value="a" id="a" required><label for="a">"Je vais me joindre aux gros durs dans le fond de la salle qui se défient au bras de fer. Ils ne font pas le poids !"</label>
              <br>
              <input type="radio" name="question1" value="b" id="b"><label for="b">"Ces gens ne m'ont pas l'air très intéressant. Je préfère rester dans un coin et lire un livre."</label>
              <br>
              <input type="radio" name="question1" value="c" id="c"><label for="c">"Je me joins à un groupe d'inconnus et m'empresse de faire la conversation pour apprendre les derniers évènements."</label>
              <br>
              <input type="radio" name="question1" value="d" id="d"><label for="d">"Je devrais sans peine trouver quelques poches à fouiller dans cet endroit peuplé de gens insouciants..."</label>

              <p>Alors que la soirée bat son plein et que l'alcool coule à flot, une bagarre générale éclate ! Un homme ivre et deux fois plus costaud que toi s'approche pour te chercher des noises.</p>
              <input type="radio" name="question2" value="a" id="a" required><label for="a">"Haha ! Plus fort que moi ?! Hahahaha... Sérieusement ?"</label>
              <br>
              <input type="radio" name="question2" value="b" id="b"><label for="b">"Me chercher des noises ? Impossible ! Tout le monde m'apprécie !"</label>
              <br>
              <input type="radio" name="question2" value="c" id="c"><label for="c">"J'ai déjà repéré toutes les issues de la salle et je m'enfuis par la plus proche !"</label>
              <br>
              <input type="radio" name="question2" value="d" id="d"><label for="d">"Peu importe, rien ne me fait peur !"</label>

              <p>La soirée ayant dégénéré, la garde de la ville a fait irruption et choisi de jeter plusieurs saoulards au cachot... dont toi ! Que fais-tu ?</p>
              <input type="radio" name="question3" value="a" id="a" required><label for="a">"Aucun problème, la vieille serrure rouillée qui m'empêche de sortir ne devrait pas résister longtemps à mes talents de crochetage."</label>
              <br>
              <input type="radio" name="question3" value="b" id="b"><label for="b">"J'observe les habitudes des gardes et écoute leurs conversations en espérant trouver une occasion de m'évader."</label>
              <br>
              <input type="radio" name="question3" value="c" id="c"><label for="c">"Peu importe ce qu'il adviendra de moi, je saurai rester digne dans l'adversité !"</label>
              <br>
              <input type="radio" name="question3" value="d" id="d"><label for="d">"Je vais attendre d'être jugé et clamerai mon innocence. Je saurai sans problème argumenter pour défendre ma cause."</label>


              <br>
              <br>

              <button type="submit">Valider</button>
            <h2>Classes</h2>
              <p><strong>Guerrier :</strong> Tu as passé ta vie entière à apprendre le maniement des armes, impressionant ! Mais difficile de comprendre ce compliment quand on ne sait pas lire... <em>(+2 Force ; -1 Intelligence)</em></p>
              <p><strong>Mage :</strong> Une vie le nez plongé dans d'obscurs grimoires traitant de la magie t'a permis d'en retirer une quantité de connaissances incroyables, ainsi qu'une myopie fort gênante. <em>(+2 Intelligence ; -1 Perception)</em></p>
              <p><strong>Voleur :</strong> Faire les poches, crocheter des serrures, te faufiler en douce dans les appartements des honnêtes gens (ou des femmes mariées...), c'est toute ta vie ! Tu en es très fier d'ailleurs, excepté lorsque la garde (ou un mari jaloux) t'attrape. <em>(+2 Adresse ; -1 Courage)</em></p>
              <p><strong>Barde :</strong> Chanteur, musicien, conteur, tu as de multiples talents ! Les mauvaises langues douteront de leur utilité dans un monde médiéval violent, mais tu juges que captiver un auditoire est bien plus satisfaisant que savoir se battre ! <em>(+2 Charisme ; -1 Force)</em></p>
              <p><strong>Ranger :</strong> Vivre au grand air, affronter les éléments, ne faire qu'un avec la nature, tel est ton credo. Les gens semblent mal à l'aise lorsque tu daignes aller en ville, sans doute à cause de ton aura de mystère qui se dégage de toi... Ou de la crasse et de la boue sur tes vieux vêtements rapiécés, qui sait ? <em>(+2 Perception ; -1 Charisme)</em></p>
              <p><strong>Paladin :</strong> Défendre la veuve et l'orphelin, se battre pour une cause juste, telle est la voie que tu suis ! Ta volonté est inébranlable, ainsi que ton sens de la justice. Les combats désespérés ne te font pas peur et ton courage est aussi grand que ton instinct de survie est faible ! <em>(+2 Courage ; -1 Adresse)</em> </p>

            <h2>Races</h2>
              <p><strong>Humain :</strong> L'espèce dominante et banale de ce pseudo-univers fantasy sans aucune originalité. Le choix simple. </p>
              <p><strong>Elfe :</strong> Oreilles pointues, sage, parle dans une langue compliquée et connaît tout sur tout. Le choix ennuyeux.<em> (+1 Adresse ; +1 Perception ; +1 Intelligence ; -1 Force ; -2Courage)</em></p>
              <p><strong>Nain :</strong> Une barbe fournie, toujours de mauvais poil, mais ne l'a pas dans la main. Le choix velu.<em> (+1 Force ; +1 Adresse ; +1 Courage ; -2 Charisme ;-1 Intelligence)</em></p>
              <p><strong>Hobbit :</strong> Des petits êtres aux pieds velus qui ne pensent qu'à manger. Le choix audacieux.<em> (+1 Adresse ; +1 Charisme ; -2 Force)</em></p>
              <p><strong>Orque :</strong> Grand, fort, laid et complètement stupide. Le choix bourrin. <em>(+2 Force ; +1 Courage ; -2 Intelligence ; -1 Charisme)</em></p>

            <h2>Caractéristiques</h2>
              <p><strong>Force :</strong> Sert à soulever des trucs, casser des machins et cogner tout ce qui bouge ou non. Sert également à déterminer tes points de vie et tes dégâts au corps à corps. </p>
              <p><strong>Intelligence :</strong> Sert à résoudre des trucs, comprendre des machins et jeter des sorts sur tout ce qui bouge ou non. Sert également à déterminer tes points de magie et tes dégâts magiques.</p>
              <p><strong>Adresse :</strong> Sert à escalader des trucs, utiliser des machins et escamoter tout ce qui bouge ou non. Sert également à déterminer ton habileté au combat. </p>
              <p><strong>Charisme :</strong> Sert à raconter des trucs, vendre des machins et séduire tout ce qui bouge ou non. Sert également à déterminer tes points de magie.</p>
              <p><strong>Perception :</strong> Sert à voir des trucs, entendre des machins et se dissimuler de tout ce qui bouge ou non. Sert également à déterminer ton habileté au combat et tes dégâts à distance.</p>
              <p><strong>Courage :</strong> Sert à braver des trucs, impressionner des machins et à combattre tout ce qui bouge ou non. Sert également à déterminer tes points de vie et ton habileté au combat. </p>


            <a href="welcome.php">Haut de page</a>
            <?php
              $_SESSION['confirm']='1st'
             ?>
        </body>
</html>
