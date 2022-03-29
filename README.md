# Challenge Sym

Challenge Sym est une applis demo, un challenge réalisé à la demande.
Une application se basant sur l'upload et la sécurisation & l'acces de documents et la gestion.
## Installation
- clone le repo:
`git clone git@github.com:PaulTAI/challengeSymfony.git`
- installer les dependances :
`npm i`
`composer install`

## Start Server
`symfony server:start`
* Webpack Encore (dev)
    `npm run dev`
    `-- watch ` pour run no-stop
* Parametrer la base de donnée dans le .ENV

## Features

- Permet toute l'authentification system (connexion / inscription / accès)
- La gestion d'utilisateurs :
    * Suppression
    * Upgrade / downgrade
    * Infos & nombre de documents uploadés
- La gestion de documents :
   * Accès sur les documents (restriction suivant les parametres désignés)
   * Suppression / Ajout 
   * Affichage /  Téléchargements
   * Propriétaire unique
* Gestion de la sécurité :
    * Constraintes renforcées
    * Utilisations de Tokens
    * CSRF pour les formulaires

Les Bonus =D !
* Gestion de catégories :
    * Ajout / Suppressions
    * Role acces
* Modals pré-action / Validations
* Alertes d'actions

## A Savoir :
Le Crud user a été crée à la main (e.g pas d'utilisation de FOSUserBundle, pas de make:crud)
Notez que l'interface administrateur, tous les services & requests ont étés réalisez à la main. (Pas d'utilisations d'administrations bundles e.g EasyAdmin 3)
-Restrictions sécuritaires sur les forms & gestions
-Champs parser hmtl & script
L'espace "Document" est aussi build à la main, pas d'utilisation de bundles hormis Flysystem pour le dépot d'object.
Menus from scratch.
Les DataFixtures sont locals, pas sur le repo at the moment.


## Tech
- [Symfony] - v.6.0 + [Twig] - rendering
- JS Natif
- [Framework SASS] - Fast
- Webpack encore (Automatique depuis v.6.0)

### Libs
Des Libs sont nécessaires pour la durée de production :
* Bootstrap 5.0 (réduit, uniquement pour les tables, forms & btns)
* Font Awsome (pour les icones)
* Select 2, pour les "select"
* Flysystem, pour gerer les dépôt Objets
* Jquery
* [Flashy] - Pour les notifs

## Production
[DEMO] -> Production (comming soon)
Prise en Main : Se créer un compte & Enjoy
`Voir les Rules(REAMDE) avant de commencer. #Rules`
Compte de production de test:
>Admin
```
admin@admin.fr
Adminadmin1
```
>Gestionnaire
```
gest@gest.fr
Gestgest1
```
>Utilisateur
```
test@test.fr
Testtest1
```


## Rules

Le compte Admin a les pleins pouvoirs sur l'application !
Voici la "role hierarchie" de l'application (v 1.0)
| Role | README |
| ------ | ------ |
| ADMIN | Gere toute l'application |
| Gestionnaire | Catégorie + Accès aux documents liés à son role + User |
| Utilisateur | Dit "User" simple utilisateur, peut ajouter des documents ! |
| Pas Validé | Utilisateur en attente de validation par un Admin. |
`Par défault après la création du compte l'utilisateur est en attente de validation par un administrateur ![Pas validé]`



[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

   [Symfony]: <https://symfony.com/>
   [Framework SASS]: <https://sass-lang.com/>
   [Twig]: <https://twig.symfony.com/>
   [flashy]: <https://github.com/mercuryseries/flashy-bundle>
   [DEMO]: <#>