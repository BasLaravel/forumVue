# forumVue

Dit is code voor een forum waar ik aan werk. Het is nog niet afgerond. Maar zo kunnen jullie mijn code in zien.

De volgende zaken kunnen jullie in zien, om er een paar te noemen:
- controllers
- models en traits
- policies
- listeners
- inspectors
- traits
- routes
- blade templates
- basic login en registreer functie
- public css en js files

De volgende functionaliteit is klaar:

Login en Registratie:
 - Alle functionaliteit die we gewend zijn via make:auth (out of the box)
 - Confirmatie email.
 - Er kunnen geen nieuwe threads worden gemaakt als er geen bevestiging is ontvangen per email.

Browse:
- alle threads
- mijn threads
- de populaire threads
- de onbeantwoorde threads
- per channel (Tap Channels)
-------------------------------------------
- Post een nieuwe thread
  - bewerk je eigen thread (update)
  - delete je eigen thread
  - refereer naar iemand met @name in het textvak. De users in de DB worden opgehaald en getoond voorbeeld: @Ba -> @Ba$
  - Volg een thread
  - Sluit een thread, er kunnen geen replies meer worden gegeven. (alleen admin kan dit, admin-namen 'gehardcode' in de user model)
--------------------------------------------
- Post een reply
  - Voor de thread eigenaar is er de beste anwoord knop per reply.
  - bewerk je eigen reply
  - delete je eigen reply
  - refereer naar iemand met @name in het textvak. De users in de DB worden opgehaald en getoond voorbeeld: @Ba -> @Ba$
  - Like een reply en zie het totaal aantal 'likes'
  - max 1 reply per minuut.
  - aantal spamfilters; keydown en blacklist.(App/Inspections)
-------------------------------------------------
Krijg 'notifications' wanneer:
  -iemand een thread volgt en daar een nieuw bericht is geplaatst. (in DB en Email)
  -Als iemand je heeft genoemd in een reply bijvoorbeeld @John; John krijgt een bericht als hij inlogd
-------------------------------------------------
My-profile
 - zie je eigen replies
 - zie je eigen threads
 - zie je eigen likes
 - kies een avatar (layout nog erg basic)
   
Enkele aandachtspunten:
de admin 'backend' is nog niet voltooid.
Op sommige pagina's worden nog teveel queries gedaan. 
De kanalen moeten nu nog handmatig in de DB worden gezet.
Voor de eerste opzet heb gebruik gemaakt van jQuery. Echter heb ik in deze versie gebruik gemaakt van Vue 2.0 in combinatie met axios. 


Hopelijk geeft dit enig inzicht.
Met vriendelijke groet,
Bas
