# wikicampers

# La demande

Création d'un formulaire de contact sous symfony 3 ou 4.

- Créer un formulaire de demande de contact avec les champs nom, prénom, email et description de la demande.

- Lors de la soumission du formulaire, 2 emails différents sont générés :

1. Un email envoyé à jobs@wikicampers.fr avec les informations saisies par le visiteur. L’email peut être en texte brut.

2. Un email de confirmation envoyé à l’adresse mail saisie par le visiteur. Ce mail doit être au format HTML. La présence d’un header et d’un footer dans le mail est un plus.

Pour aller plus loin (facultatif) :

- Créer une entité Contact qui contient les champs du formulaire.

- Créer le FormType de l’entité Contact.

- Stocker chaque demande en base de données.


## Outils utilisés

Symfony 4, SwiftMailer, MySql, Bootstrap 4.

## Démarche technique

L'utilisation des bundles ayant été fortement restreinte à partir de la version 4 de Symfony, il n'est plus possible de créer un ContactBundle.
J'ai donc organisé mes fichiers dans le dossier src. (controller, entity, form, repository et templates).


## Données à configurer au préalable dans fichier env.

Créer une base de données pour communiquer avec le formulaire et renseigner user, password et databasename:

```python
###> doctrine/doctrine-bundle ###

DATABASE_URL=mysql://user:password@127.0.0.1:3306/databasename

```

Par défaut l'adresse email d'envoi est job@wikicampers.fr, configuration à renseigner:

```python
###> symfony/swiftmailer-bundle ###

# For a generic SMTP server, use: "smtp://localhost:25?encryption=&auth_mode="

```
