# Quiz Applicatie - Installatie & Test Gids

## 🚀 Snelle Installatie

### Vereisten
- PHP 8.2+
- Composer
- MySQL database
- Laravel 11

### Installatiestappen

1. **Database Setup**
```bash
php artisan migrate:fresh --seed
```

2. **Server Starten**
```bash
php artisan serve
```

3. **Browser openen**
Ga naar: http://127.0.0.1:8000

## 👥 Test Accounts

### Docent Account
- **Email**: `teacher@quiz.app`
- **Wachtwoord**: `password123`
- **Rol**: Teacher/Docent

### Student Account  
- **Email**: `student@quiz.app`
- **Wachtwoord**: `password123`
- **Rol**: Student

## 🎯 Testen van Functies

### Als Student (Zonder inloggen)
1. **Quiz Starten**
   - Ga naar de homepage
   - Vul naam, email en aantal vragen in
   - Start de quiz

2. **Quiz Doorlopen**
   - Beantwoord multiple choice vragen door op knoppen te klikken
   - Beantwoord open vragen door tekst in te typen
   - Bekijk je voortgang in de voortgangsbalk

3. **Resultaten Bekijken**
   - Na voltooiing zie je direct je score
   - Bekijk welke vragen goed/fout waren
   - Zie de juiste antwoorden

### Als Docent (Ingelogd)
1. **Inloggen**
   - Klik op "Inloggen" in de navigatie
   - Gebruik docent credentials

2. **Dashboard Bekijken**
   - Overzicht van statistieken
   - Recente tests en resultaten
   - Snelle toegang tot alle functies

3. **Vragen Beheren**
   - Klik op "Vragen Beheer" 
   - Voeg nieuwe vragen toe (Create)
   - Bewerk bestaande vragen (Edit)
   - Verwijder vragen (Delete)

4. **Vragen Importeren**
   - Ga naar "Import Vragen"
   - Upload een JSON of CSV bestand
   - Test met de voorbeeldbestanden in `storage/app/`

5. **Resultaten Analyseren**
   - Bekijk alle test resultaten
   - Klik op individuele tests voor details
   - Zie student prestaties en trends

## 📁 Voorbeeldbestanden

### JSON Import Voorbeeld
Bestand: `storage/app/sample_questions.json`
```json
[
  {
    "question": "Wat is de hoofdstad van Frankrijk?",
    "type": "multiple_choice",
    "options": ["Parijs", "Lyon", "Marseille", "Toulouse"],
    "answer": "Parijs"
  }
]
```

### CSV Import Voorbeeld  
Bestand: `storage/app/sample_questions.csv`
```csv
question,type,answer,option_1,option_2,option_3,option_4
"Wat is de grootste planeet?",multiple_choice,"Jupiter","Mars","Jupiter","Saturnus","Neptunus"
```

## 🔧 Probleemoplossing

### Database Problemen
```bash
# Reset de database volledig
php artisan migrate:fresh --seed
```

### Cache Problemen
```bash
# Clear alle caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Permission Problemen
```bash
# Zorg voor juiste permissions (Linux/Mac)
chmod -R 755 storage bootstrap/cache
```

## 🎨 Interface Features

### Responsive Design
- Werkt op desktop, tablet en mobiel
- Bootstrap 5 gebaseerd
- Touch-friendly voor mobiele apparaten

### Visuele Feedback
- Kleurgecodeerde resultaten (groen=goed, rood=fout)
- Progress bars voor voortgang
- Badges voor scores en percentages
- Icons voor alle acties

### Gebruikerservaring
- Één-klik antwoorden voor multiple choice
- Automatische opslag van voortgang
- Directe feedback na voltooiing
- Intuïtieve navigatie

## 📊 Database Schema

### Users
- `id`, `name`, `email`, `password`, `role`
- Rollen: 'student' of 'teacher'

### Questions  
- `id`, `question`, `type`, `options`, `answer`
- Types: 'multiple_choice' of 'open'

### Tests
- `id`, `user_id`, `score`, `timestamps`
- Gekoppeld aan user via foreign key

### Answers
- `id`, `test_id`, `question_id`, `student_answer`, `is_correct`
- Verbindt tests met questions via many-to-many

## 🔒 Beveiliging

- **CSRF Protection**: Alle forms beveiligd
- **Role-based Access**: Strikte scheiding teacher/student
- **Input Validation**: Server-side validatie
- **File Upload Security**: Beperkte MIME types

## ✅ Test Scenario's

### Complete Student Flow
1. Start quiz (3 vragen)
2. Beantwoord 1 multiple choice correct
3. Beantwoord 1 multiple choice incorrect  
4. Beantwoord 1 open vraag correct
5. Bekijk resultaten (66% score)

### Complete Teacher Flow
1. Login als teacher
2. Bekijk dashboard statistieken
3. Voeg nieuwe vraag toe
4. Import vragen via CSV/JSON
5. Bekijk student resultaten
6. Analyseer prestaties

### Import Testing
1. Test JSON import met sample file
2. Test CSV import (nieuw formaat)
3. Test CSV import (legacy formaat)
4. Controleer error handling bij foute bestanden

## 🎓 Educatieve Waarde

- **Immediate Feedback**: Studenten leren direct van fouten
- **Progress Tracking**: Motivatie door voortgangsvisualisatie  
- **Flexible Assessment**: Verschillende vraagtypen
- **Performance Analytics**: Docenten krijgen inzicht in prestaties

---

## 📞 Support

Bij problemen:
1. Controleer de Laravel logs: `storage/logs/laravel.log`
2. Controleer database connectie in `.env`
3. Zorg dat alle dependencies geïnstalleerd zijn: `composer install`

**Succes met het testen van de Quiz Applicatie!** 🎉
