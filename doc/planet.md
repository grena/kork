# Planète

## Biomes

### Cendres

- Aménagement "de fortune|blindé|en cours de construction"
- Edifice religieux "imposant|en ruines|illuminé|majestueux"
- Mine "à ciel ouvert|abandonnée|de cristaux rares"
- Geysers de cendres
- Gouffre "profond|abyssal|escarpé"
- Excavation d'artefacts "anciens|archaïques|antiques"
- Repère de la guilde des "Soiffards|Cognards|Fouettards"
- Nid de "cafards|rats|chat-taupes" radioactifs

### Atoll

- Repère de pirates "galactiques|reptiliens|robotiques"
- Structure pyramidale "mystérieuse|imposante|sonore|lumineuse"
- Embarquations indigènes
- Village abandonné
- Baie des "tortues|renards|poulets"
- Arbre creux "géant|démesuré|monumental|gigantesque"
- Epave de cargo "militaire|marchand|civile"
- Lieux de culte "païen|religieux|de secte|riche|dangereux"

### Forêt

- Cascade "splendide|éblouissante|gigantesque" 
- Antre "obscur|difficile d'accès|enchevêtré|brumeux"
- Falaise "abrupte|escarpée"
- Complex scientifique "sécurisé|abandonné|actif"
- Clairière "verdoyante|dégagée"
- Tanière d'animaux "à cornes|miniatures|" 
- Village suspendu "tribale|abandonné|labyrinthique"
- Temple enfoui "millénaire|maudit|condamné|barricadé"

### Lave

- Bivouac scientifique "en piteux état|imposant"
- Volcan "actif|inactif"
- Rivière de lave "sèche|animée"
- Geysers de lave "puissant|faiblards"
- Mine "abandonnée|condamnée"
- Tour de contrôle "technologique|abandonnée|envahie par la végétation"
- Station géothermique "neuve|engloutie|ravagée"
- Formes rocheuses "étranges|inhabituelles|élégantes"

### Toxic

- Lac d'acide "peu profond|profond"
- Marécage "puant|gluant|grouillant"
- Nid d'animal "rampant|à plume|odorant"
- Grotte "cachée|embrumée|sombre|occulte|profonde"
- Bâtiment "renforcé|blindé"
- Bunker "scientifique|militaire|civile"
- Gisement "de cristaux|de minerai|énigmatique"
- Bosquet "étouffant|touffu|toxique"

## Lieux
Une planète est composée de plusieurs lieux, dont le Vaisseau.

## Actions sur une planète:
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
