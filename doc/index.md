Captain Kork - Game Document
============================

Captain Kork est un **jeu de survie coopératif en temps réel par navigateur**. 
- Le joueur incarne un [Personnage](character.md)
- Il fait parti d'un équipage à bord d'un vaisseau composé uniquement d'autres [Personnages](character.md) _(pas de PNJ)_
- Chaque jour, le vaisseau se rend sur une nouvelle [Planète](planet.md)
- Les joueurs doivent explorer, récolter des ressources, ravitailler le vaisseau, l'améliorer... pendant la journée. (Actions en temps réel)
- Tous les soirs à Minuit, le vaisseau repart pour une nouvelle planète avec un temps de voyage important

### Comment jouer

Le joueur utilise des [PA (Point d'Action)](pa.md) (**A DEFINIR**) pour effectuer des actions. Le joueur possède un nombre limité de [PA](pa.md)

Chaque jour à 00h00, le [Vaisseau](ship.md) décolle et son équipage voyage vers une planète inconnue.
Si un [Personnage](character.md) n'est pas rentré au [Vaisseau](ship.md) avant minuit, il est abandonné sur la planète et est éliminé du jeu.
La partie continue avec le reste de l'équipage.

Le voyage dure X heures (dépendant de plusieurs facteurs). Pendant ce laps de temps, la partie n'est pas accessible.

Le lendemain à XH00 heures du matin, le [Vaisseau](ship.md) attérit sur une nouvelle planète, et chaque membre de l'équipage se voit distribué des [PA](pa.md). Les [PA](pa.md) ne sont pas cumulables. Un [PA](pa.md) non dépensé à minuit sera donc perdu.

Les actions et autres évènements sont ainsi en temps réel.

### Game Loop

1) Ecran du [Résumé de la veille](summup.md)
2) Les [Personnages](character.md) explorent la [Planète](planet.md) sur laquelle ils sont arrivés :
    1) Exploration
    2) Récolte
    3) Amélioration du vaisseau / équipement
3) A minuit, décollage du [Vaisseau](ship.md)

Avant le Game Loop se situe la [Salle d'attente _ou Lobby_](lobby.md)
