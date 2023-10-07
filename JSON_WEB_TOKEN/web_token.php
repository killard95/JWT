<?php

/*

 Le json web token (JWT) sert à authentifier un utilisateur

 Pourquoi les sessions ne sont pas une bonne chose ?

 - Les données sont stockées en texte clair sur le serveur
 - impliquent des requetes entrées/sorties sur le systéme de fichiers
 - applications distribuées/clusterisées


Avantages des JWT :
 - clés d'API : chaînes aléatoires / JWT contient des données
 - pas d'authorité centralisée (type verisign)
 - compatible avec Oauth2 => (norme, procesus d'authentification)
 - les données du JWT peuvent être inspéctées
 - possédent des contrôles d'expiraction (deconexion automatique)
 - destinés aux environnements dont l'espace est limité (entêtes HTTP)
 - données au format JSON 
 - encodés en base64

 dans le header:
 - indique simplement l'algo et le type (JWT)
 {
    "alg": "HS256",
    "type": "JWT"
 }

 dans le payload :
  - iat: l'horodatage de l'émission du jeton
  - key: une  haine unique, qui polurrait être utilisée pour valider un jeton, mais qui va à l'encontre de l'abscence d'une autorité émetrice décentralisée
  - iss: une chaîne contenant le nom ou l'identifiant de l'émetteur.Peut être un nom de domaine et peut être utilisé pour rejeter les jetons d'autres serveur
  - nbf: un horodatage de la date à laquelle le jeton doit commencer à être consideré comme valide. Doit être égale ou supérieur à iat.
  - exp: un horodatage de la date à laquelle le jeton doit cesser d'être valide. Doit être supérieur à iat et nbf.

  - revendications publiques
    plus toutes les autres clés/valeurs du service/API.

 dans la signature:
  - mécanisme cryptographique qui garantit l'intégrité du JWT
  - combinaison de l'entête, du payload et de la signature.

 */
