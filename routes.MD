# Documentation de l'API

| Endpoint | Méthode HTTP | Donnée(s) | Description | Fonction | Nom de la route |
|--|--|--|--|--|--|
| `/main/user/new` | GET/POST | - | Nouvel utilisateur |
| `/main/user/[id]/profil` | GET/POST | ['id']=user.id  ['id2']=partie.id  `$parties->getByUserWhereFINISH` | Page profil du joueur (Résumé infos, stats, derniers résultats) | userProfil() | user_profil |
| `/main/user/[id]/amis` | GET/POST | ['id']=user.id  `$amis->getByUser` | Page des amis du joueur | userAmi | user_friends |
| `/main/user/[id]/amis/invitations` | GET/POST | ['id']=user.id  ['id']=user.id  `$invitations->getByUser&UserDemand` | Page des invitations reçues et envoyées | userInvitations | user_invitations|
| `/main/user/[id]/partie/` | GET | ['id']=user.id  `$games->findByUserId&NOT FINISH` | Page des parties du joueur | userParties | user_parties |
| `/main/user/[id]/partie/new` | GET | ['id']=user.id  `$games->findByUserId&NOT FINISH` | Page de création d'une partie | nouvellePartie | nouvelle_partie|
| `/main/user/[id]/partie/[id2]/partie/manche/[id3]` | GET/POST | ['id']=user.id  ['id2']=game.id  `$game->getByUser`  ['id3']=manche.id  `$manche->getByGame`  ['id4']=feuille.id  `$feuilles->getByManche` | Page gestion de la manche | gameManche | partie_manche |
| `/main/user/[id]/partie/[id2]/partie/manche/[id3]/feuille/[id4]` | GET/POST | ['id']=user.id  ['id2']=game.id  ['id3']=manche.id  ['id4']=feuille.id | Page réponse d'un joueur à une manche | userReponse | user_reponse |
| `/main/user/[id]/partie/[id2]/partie/manche/[id3]/feuille/[id4]/vote/[id5]` | GET/POST | ['id']=user.id  ['id2']=game.id  ['id3']=manche.id  ['id4']=feuille.id  ['id5']=vote.id `$vote->getByUser` | Page de validation des réponses d'une feuille | userVote | user_vote |
| `/main/partie/[id2]/manche/new` | GET/POST | ['id']=user.id  ['id2']=game.id | Page de création d'une nouvelle manche à la partie | nouvelleManche | nouvelle_manche |


| {Groupe} | Entité | Propriété(s) | Description |
|--|--|--|--|
| {new user} | User | $username,$password | Nouvel utilisateur |
| {profil} | User/Parties | $username,$score,$level / $finish | Page profil du joueur (Résumé infos, stats, derniers résultats) |
| {profil-ami} | User/Parties | $username, $level, $ratio, $avatar | Page profil du joueur (Résumé infos, stats, derniers résultats) vu par un ami |

