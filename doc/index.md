Captain Kork - Game Document
============================

Captain Kork est un **jeu de survie coopératif par navigateur**. Le joueur incarne un [Personnage](character.md), membre d'un équipage à bord d'un [Vaisseau](ship.md).
Chaque autre [Personnage](character.md) du [Vaisseau](ship.md) est incarné par un joueur, il n'y a aucun PNJ (*Personnage Non Joueur, incarné par une IA*).

### Comment jouer

Le joueur utilise des [PA (Point d'Action)](pa.md) pour effectuer des actions. Le joueur possède un nombre limité de [PA](pa.md)

Chaque jour à 00h00, le [Vaisseau](ship.md) décolle et son équipage voyage vers une planète inconnue.
Si un [Personnage](character.md) n'est pas rentré au [Vaisseau](ship.md) avant minuit, il est abandonné sur la planète et est éliminé du jeu.
La partie continue avec le reste de l'équipage.

Le voyage dure 6 heures. Pendant ce laps de temps, le serveur de jeu n'est pas accessible.

Le lendemain à 6H00 heures du matin, le [Vaisseau](ship.md) attérit sur une nouvelle planète, et chaque membre de l'équipage se voit distribué des [PA](pa.md). Les [PA](pa.md) ne sont pas cumulables. Un [PA](pa.md) non dépensé à minuit sera donc perdu.

Les actions et autres évènements sont ainsi en temps réel.

### Résumé de la veille
Chaque jour à leur première connexion de la journée, un résumé est montré au joueur, qui résume la journée précédente.
Le résumé prend la forme d'un bulletin de news partagé par le Grand Consortium Galactique, exemple:

**Infos sur la planète visitée**
> - Il semblerait que l'équipage de pirates responsables de la mort du Capitaine Kork aient été aperçu dans le système de CPC-676, **sur la planète Anxar**.
> - Un brave citoyen Cyclopien aurait aperçu, je cite : "Deux, enfin, un... Non, non, deux !" vaisseau(x) quitter l'atmosphère de **la planète Anxar**.

**Infos sur les actions notables effectuées**
> - **Un temple XILAK** (manifique ouvrage s'il en est) a été entièrement ravagé et pillé par ces sauvages.
> - La companie de minage "MI-DGET, MI-NAIN" a reporté au Consortium qu'une de ses **mines d'hydratium a été vidée ** par effraction.

**Si résumé un peu vide, ajout de phrases RP de contexte un peu funky**
> - Si vous voyez ces pirates, merci de contacter immédiatement le poste de surveillance du Consortium le plus proche de chez vous. (Tout faux renseignement sera puni de 450C d'amende et d'une suspension du permis de piloter)
> - Nous rappelons que le Consortium est toujours à la recherche de ces dangereux pirates

**Message si des membres (personnages) sont restés sur la planète avant minuit**
> - Le 2e membre recherché, **un dénommé "Inspecteur Natchoulaki"** a enfin été appréhendé par le Consortium **sur la planète Anxar**, bien qu'ayant mollement resisté lors de sa capture, les 450mg de tranquilisant qui lui ont été administrés lui ont été fatal. L'enquête continue et il semblerait que l'équipage ne contienne plus que 3 membres.
> - Coup de filet ! Un des pirates responsable de l'assassinat du Capitaine Kork, connue sous **le nom de "Pitou-Pitou"**, a été capturé par une patrouille du Consortium **de la planète Anxar**. Il a été condamné à l'emprisonnement pour une durée de 734 ans dans la Prison d'Alcatrax dans le secteur GOUDOU-13.

Il faudrait aussi montrer le portrait des pirates toujours en lice (en vie...), avec un gros WANTED sur leur tronche, et le montant pour lequel ils sont recherchés.

### Actions sur une planète:
* **Aller à [LIEU]**
    * Commence le déplacement vers **[LIEU]** (plus long si plus loin…)
    * Pendant le déplacement, le [Personnage](character.md) n’a aucune action possible
    * Le [Vaisseau](ship.md) est un considéré comme un lieu
* **Explorer [LIEU]**
    * Action valide uniquement quand le [Personnage](character.md) est sur un lieu qui supporte l'exploration
    * Grotte, forêt, ruines, complexe scientifique, base, bâtiment abandonné...
    * Lance une tick toutes les X heures, qui fait un test pour savoir si:
		* Le [Personnage](character.md) loot un item
		* Un événement à décision apparaît (mini quete QCM)
	* Le [Vaisseau](ship.md) ne peut pas être exploré
* **Arrêter l’exploration**
	* Action valide uniquement quand le [Personnage](character.md) est en cours d'exploration du lieu
    * Arrête la fouille du [LIEU] dans lequel on se situe
* **Consommer [OBJET DANS INVENTAIRE]**
	* Multiples actions dépendant de l’objet, du consommateur et du lieux de consommation

### Actions dans le vaisseau:
* **Construire [MODULE DE VAISSEAU]**
	* Cette action lance la construction  du module sur le vaisseau et y met le premier PA
	* Toutes les ressources nécessaires au module sont consommées dès la construction commencée
* **Consommer [OBJET DANS INVENTAIRE]**
	* Multiples actions dépendant de l’objet, du consommateur et du lieux de consommation
* **Mettre [OBJET DANS INVENTAIRE] dans le réservoir**
* **Prendre [OBJET DANS VAISSEAU]**
	* L’objet va dans l’inventaire du personnage
* **Déposer [OBJET DANS INVENTAIRE] dans le vaisseau**
	* L'objet va dans l'inventaire du vaisseau
