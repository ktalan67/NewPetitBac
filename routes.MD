# Documentation de l'API

| Endpoint | Méthode HTTP | Donnée(s) | Description |
|--|--|--|--|
| `/main/user/new ` | GET/POST | - | Nouvel utilisateur |
| `/main/user/[id]/profil ` | GET/POST | ['id'] = user.id, ['id2'] = partie.id // '$parties->getByUserWhereFINISH' | Page profil du joueur (Résumé infos, stats, derniers résultats) |
| `/main/user/[id]/amis ` | GET/POST | ['id'] = user.id // '$amis->getByUser' | Page des amis du joueur |
| `/main/user/[id]/amis/invitations ` | GET/POST | ['id'] = user.id, '$invitations->getByUser&UserDemand' | Page des invitations reçues et envoyées |
| `/main/user/[id]/partie/` | GET | ['id'] = user.id // '$games->findByUserId&NOT FINISH' | Page des parties du joueur |
| `/main/user/[id]/partie/[id2]/partie/manche/[id3]/feuille/[id4] ` | GET/POST | ['id'] = user.id, ['id2'] = game.id, ['id3'] = manche.id, ['id4'] = feuille.id | Page réponse d'un joueur à une manche  |
| `/main/user/[id]/partie/[id2]/partie/manche/[id3]/ ` | GET/POST | ['id'] = user.id, ['id2'] = game.id // '$game->getByUser', ['id3'] = manche.id // '$manche->getByGame', ['id4'] = feuille.id // '$feuilles->getByManche'| Page réponse d'un joueur à une manche  |

| `/main/user/[id]/partie/[id2]/partie/manche/[id3]/feuille/[id4]/vote/[id5] ` | GET/POST | ['id'] = user.id,['id2'] = game.id, ['id3'] = manche.id,['id4'] = feuille.id, ['id5'] = vote.id // '$vote->getByUser' | Page de validation des réponses d'une feuille  |

| `/main/partie/[id2]/manche/[id3]/user/[id]` | GET/POST | ['id'] = user.id, ['id2'] = game.id, ['id3'] = manche.id | Page User de la manche en cours |

| `/main/partie/[id2]/manche/new` | GET/POST | ['id'] = user.id, ['id2'] = game.id | Page de création d'une nouvelle manche à la partie |