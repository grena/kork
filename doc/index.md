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

### But du jeu



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
