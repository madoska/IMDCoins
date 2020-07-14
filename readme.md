# Virtual Currency
**PHP 2020 2de zit: Virtual Currency**
> [imdcoins.site](http://www.imdcoins.site/login.php)  
> [trello board](https://trello.com/b/cFIe1Rzx/php-virtual-currency)  
> Medina Dadurgova

## Checklist
### Frontend
Je kiest zelf een gepaste layout\
Gebruik van CSS frameworks (tailwind, **bootstrap**, ... ) is toegestaan

### Technische vereisten
Je werkt lokaal aan je app, maar deployed naar een online versie. Je app moet online werken en testbaar zijn.\
Beveilig tegen XSS\
Beveilig tegen SQL Injection\
Maak gebruik van sessies en/of cookies\
Gebruik bcrypt en zorg dat je dit mechanisme kan uitleggen\
Gebruik PDO voor je queries\
Werk object-georiënteerd\
Gebruik minstens volgende klassen: User & Transaction\
Gebruik getters en setters op een zinvolle manier\
Gebruik voor je AJAX-features bij voorkeur fetch() ipv jQuery\
We maken vanaf dag 1 gebruik van GIT\
Commit regelmatig, GIT is je bewijs van opgeleverd werk. Als je niet correct met GIT werkt heb je geen bewijs van je eigen werk. Het vaak gehoorde “mijn computer is gecrashed en ik heb alles in één keer overgezet naar een nieuwe GIT repo” gaat niet op. Goede, kleine, regelmatige commits in GIT, vanaf dag 1.

### Functionaliteiten
**Users**
- Kunnen registreren
- Email moet eindigen op @student.thomasmore.be
- Password
- Hash dit veilig met bcrypt
- Moet minstens 5 karakters lang zijn
- Kunnen aanloggen
- Kunnen uitloggen
- Krijgen na registratie automatisch 10 tokens op hun rekening\
**Transfers**
- Virtueel geld sturen kan naar een andere gebruiker op volgende manier
- Je selecteert een gebruiker
- Werk via een AJAX-autocomplete die na twee letters de volledig naam toont van gebruikers die aan deze selectie voldoen
- Geef een bedrag in
- Mag niet minder dan 1 zijn
- Mag niet meer zijn dan je beschikbaar saldo
- Geef een reden in voor deze transfer
- Vb: “bedankt om te helpen met het design van m’n app !”
- Gebruik AJAX + een timer/interval om elke 10 seconden te controleren wat je actueel saldo is.
- Als iemand je geld stuurt moet dit dus zonder page refresh zichtbaar zijn na maximaal 10 seconden
- Toon een overzicht van alle transfers
- Vb: “Will Smith heeft je 10 tokens gestuurd op maandag 7 augustus 2020”
- Vb: “Je hebt 5 tokens gestuurd naar Will Smith op 5 augustus 2020”
- Je kan doorklikken op een transactie om de details te lezen (vb: de reden van deze transactie is dan te zien)
- Gebruikt hier zinvol $_GET
- Bonus: laat nieuwe inkomende transacties automatisch verschijnen door middel van AJAX