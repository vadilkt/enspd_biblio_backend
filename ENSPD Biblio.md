ENSPD Biblio
Enspd biblio est une application interne à l’enspd qui doit permettre aux utilisateurs (Enseignants,
Etudiants) de consulter des mémoires et des les rechercher.
LES ENTITES
- User (id, noms, matricule, mail, role, filiere)
Le champs role peut avoir une valeur null.
- Book(id, title, year, filiere, authors[ ], pdfLink)

LES ACTIONS
Le rôle peut être user ou admin.
L’administrateur ajoute/supprime des mémoires, ajoute et supprime des utilisateurs.
L’utilisateur (étudiant/professeur) consulte les mémoires et peut les rechercher
LES POINTS DE TERMINAISON
Login :
Tous les mémoires : api/get/books
Ajouter un mémoire : api/post/book
Ajouter un utilisateur : api/post/user
Supprimer un mémoire : api/delete/book/{id}
Rechercher un mémoire : api/get/book/{id} (Un livre se recherche avec soit son nom, le nom de son
auteur)

CONNEXION
La connexion se fait avec le nom complet de l’utilisateur et le matricule (as password).
La liste des users est chargée par l’administrateur. A noter qu’il peut également ajouter les utilisateurs
de façon manuelle.
La connexion renvoie un objet contenant un token et le rôle de l’utilisateur loggé.