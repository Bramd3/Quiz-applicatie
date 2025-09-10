# Quiz Applicatie - Volledig Project

Een comprehensive Laravel-gebaseerde quiz applicatie voor docenten en studenten, gebouwd volgens alle specificaties in de user stories.

## 📋 Projectoverzicht

Deze applicatie is ontworpen om docenten te helpen studenten te testen op hun basiskennis door middel van interactieve quizzes. De applicatie ondersteunt zowel multiple choice als open vragen en biedt uitgebreide functionaliteiten voor vraagbeheer, resultaatanalyse en automatische scoring.

## ✨ Functies

### Voor Studenten
- **Quiz starten**: Eenvoudig quizzes starten met naam, email en gewenst aantal vragen
- **Multiple Choice vragen**: Klikbare antwoordopties met visuele feedback
- **Open vragen**: Tekstinvoer voor vrije antwoorden
- **Voortgangsindicator**: Realtime voortgang tijdens de quiz
- **Directe feedback**: Onmiddellijke resultaten na voltooiing
- **Resultaten inzien**: Gedetailleerd overzicht van alle gegeven antwoorden

### Voor Docenten
- **Uitgebreid dashboard**: Statistieken en overzicht van alle activiteiten
- **Vraagbeheer**: CRUD operaties voor alle vragen
- **Bestandsimport**: JSON en CSV import voor bulk toevoegen van vragen
- **Resultaatanalyse**: Gedetailleerde resultaten van alle studenten
- **Automatische scoring**: Real-time berekening van scores en percentages
- **Gebruikersbeheer**: Overzicht van alle studenten en hun voortgang

## 🏗️ Technische Specificaties

### Technologie Stack
- **Framework**: Laravel 11
- **Frontend**: Bootstrap 5.3 + Bootstrap Icons
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Authorization**: Gates-based role systeem
- **File Processing**: Native PHP voor JSON/CSV import

### Database Schema
- **Users**: Studenten en docenten met role-based access
- **Questions**: Vragen met type (multiple_choice/open), opties en antwoorden
- **Tests**: Quiz sessies gekoppeld aan gebruikers
- **Answers**: Individuele antwoorden met correctheid tracking

### Beveiligingsfeatures
- **Role-based Access Control**: Strikte scheiding tussen student/teacher functies
- **CSRF Protection**: Alle forms beveiligd
- **Input Validation**: Server-side validatie van alle gebruikersinput
- **File Upload Security**: Beperkte MIME types voor imports

## 🚀 Installatie

### Vereisten
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (optioneel voor asset compilation)

### Installatiestappen

1. **Clone en setup**:
```bash
git clone <repository-url>
cd Quiz-applicatie
composer install
cp .env.example .env
php artisan key:generate
```

2. **Database configuratie**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quiz_applicatie
DB_USERNAME=root
DB_PASSWORD=
```

3. **Database migratie en seeding**:
```bash
php artisan migrate:fresh --seed
```

4. **Server opstarten**:
```bash
php artisan serve
```

### Standaard Accounts
Na seeding zijn de volgende accounts beschikbaar:

**Docent Account**:
- Email: teacher@quiz.app
- Wachtwoord: password123

**Student Account**:
- Email: student@quiz.app
- Wachtwoord: password123

## 🎯 User Stories Implementatie

### ✅ Story 1: Bestand uploaden (Docent)
- **JSON Import**: Gestructureerde vragen met type, opties en antwoorden
- **CSV Import**: Beide nieuwe en legacy formaten ondersteund
- **Error Handling**: Uitgebreide validatie en gebruiksvriendelijke foutmeldingen
- **Bulk Processing**: Meerdere vragen tegelijk importeren

### ✅ Story 2: Vragen beantwoorden (Student)
- **Intuïtieve interface**: Duidelijke vraagweergave met voortgangsindicator
- **Verschillende vraagtypen**: Naadloze overgang tussen multiple choice en open vragen
- **Session management**: Betrouwbare opslag van voortgang

### ✅ Story 3: Multiple Choice vragen
- **Visuele antwoordopties**: Knoppen met labels (A, B, C, D)
- **Hover effects**: Interactieve feedback bij mouseover
- **Eén-klik submit**: Directe doorgang naar volgende vraag

### ✅ Story 4: Open vragen
- **Tekstinvoer**: Grote invoervelden voor uitgebreide antwoorden
- **Validatie**: Verplichte invulling met client-side feedback
- **Flexibele matching**: Case-insensitive vergelijking

### ✅ Story 5: Antwoorden indienen en controleren
- **Automatische opslag**: Realtime opslaan van alle antwoorden
- **Voortgangsbehoud**: Geen gegevensverlies bij verbindingsproblemen
- **Voltooiing feedback**: Duidelijke bevestiging van quiz voltooiing

### ✅ Story 6: Automatische controle (Docent)
- **Real-time scoring**: Onmiddellijke berekening bij elke ingediende vraag
- **Intelligente matching**: Flexibele antwoordvergelijking voor open vragen
- **Bulk validation**: Efficiënte verwerking van alle antwoorden

### ✅ Story 7: Eindscore tonen (Student)
- **Gedetailleerde resultaten**: Score, percentage en prestatie-indicators
- **Visuele feedback**: Kleurgecodeerde badges voor performance levels
- **Historiek**: Toegang tot eerdere quiz resultaten

### ✅ Story 8: Score berekening (Docent)
- **Automatische berekening**: Real-time updates van scores
- **Percentage conversie**: Intelligente omrekening naar percentages
- **Statistische insights**: Gemiddelde scores en trends

### ✅ Story 9: Feedback per vraag (Student)
- **Antwoord vergelijking**: Jouw antwoord vs. correct antwoord
- **Kleurcodering**: Groen voor correct, rood voor incorrect
- **Leermogelijkheden**: Directe toegang tot juiste antwoorden

### ✅ Story 10: Gebruiksvriendelijke interface
- **Responsive design**: Werkt op alle devices
- **Bootstrap theming**: Moderne, professionele uitstraling
- **Iconografie**: Intuïtieve Bootstrap Icons voor alle acties
- **Loading states**: Duidelijke feedback tijdens processing

### ✅ Story 11: Resultaten analyseren (Docent)
- **Dashboard statistieken**: Totaal vragen, tests, studenten, gemiddelde scores
- **Gedetailleerd overzicht**: Per-student analyse van resultaten
- **Exportmogelijkheden**: Data beschikbaar voor verdere analyse
- **Trend tracking**: Historische prestatie data

### ✅ Story 12: Vraagbank beheer (Docent)
- **CRUD interface**: Volledig beheer van alle vragen
- **Bulk operations**: Meerdere vragen tegelijk bewerken/verwijderen
- **Search & filter**: Eenvoudig vinden van specifieke vragen
- **Version control**: Tracking van wijzigingen

## 📁 Import Formaten

### JSON Format
```json
[
  {
    "question": "Wat is 2+2?",
    "type": "multiple_choice",
    "options": ["2", "4", "6", "8"],
    "answer": "4"
  },
  {
    "question": "Hoofdstad van Nederland?",
    "type": "open",
    "answer": "Amsterdam"
  }
]
```

### CSV Format (Nieuw)
```csv
question,type,answer,option_1,option_2,option_3,option_4
"Wat is 2+2?",multiple_choice,"4","2","4","6","8"
"Hoofdstad Nederland?",open,"Amsterdam"
```

### CSV Format (Legacy)
```csv
question,correct_answer,answer_a,answer_b,answer_c
"Wat is 2+2?",b,"2","4","6"
"Multiple choice vraag",a,"Juist","Fout","Misschien"
```

## 🎨 Design Features

### Bootstrap 5 Theming
- **Gradient backgrounds**: Moderne kleurovergangen
- **Card-based layout**: Duidelijke content structuur
- **Responsive grid**: Optimaal op alle schermgroottes
- **Interactive components**: Smooth transitions en hover effects

### Custom CSS Enhancements
- **Quiz cards**: Speciale styling voor vraag weergave
- **Result indicators**: Kleurgecodeerde feedback
- **Progress bars**: Visuele voortgangsindicatoren
- **Stats cards**: Dashboard statistiek weergave

## 🚦 Routing Structuur

### Publieke Routes
- `GET /` - Quiz start pagina
- `POST /quiz/start` - Quiz initiatie
- `GET /quiz/{test}` - Quiz spelen
- `POST /quiz/{test}/submit` - Antwoord indienen

### Docent Routes (Beveiligd)
- `GET /teacher/dashboard` - Docent dashboard
- `GET /questions` - Vraag overzicht
- `POST /questions` - Nieuwe vraag aanmaken
- `PUT /questions/{id}` - Vraag bijwerken
- `DELETE /questions/{id}` - Vraag verwijderen
- `POST /questions-import` - Bestand import
- `GET /teacher/results` - Alle resultaten
- `GET /teacher/results/{test}` - Gedetailleerd resultaat

## 📊 Database Seeding

Het systeem komt met voorbeelddata:
- **2 Gebruikers**: 1 docent, 1 student
- **8 Voorbeeldvragen**: Mix van multiple choice en open vragen
- **Diverse onderwerpen**: Geografie, wiskunde, programmeren, algemene kennis

## 🔧 Ontwikkeling

### Code Structuur
```
app/
├── Http/Controllers/
│   ├── QuestionController.php (CRUD + Import)
│   ├── QuizController.php (Quiz logica)
│   └── TeacherController.php (Docent functionaliteit)
├── Models/
│   ├── User.php (Gebruikers + rollen)
│   ├── Question.php (Vragen + opties)
│   ├── Test.php (Quiz sessies)
│   └── Answer.php (Antwoorden + scoring)
└── Providers/
    └── AppServiceProvider.php (Authorization gates)
```

### Key Features Code
- **Authorization**: Gate-based permission systeem
- **File Processing**: Robust JSON/CSV parsing
- **Session Management**: Reliable quiz state handling
- **Auto-scoring**: Intelligent answer matching
- **Responsive UI**: Mobile-first Bootstrap implementation

## 📚 API Documentatie

Hoewel primair een web-applicatie, zijn alle controllers RESTful opgezet voor potentiële API uitbreiding.

## 🧪 Testing

Voorbeeld bestanden beschikbaar in `storage/app/`:
- `sample_questions.json` - JSON import voorbeeld
- `sample_questions.csv` - CSV import voorbeeld

## 🔐 Beveiliging

- **Input Sanitization**: Alle user input wordt gevalideerd
- **File Upload Security**: Beperkte MIME types en grootte
- **CSRF Protection**: Alle POST requests beveiligd
- **XSS Prevention**: Output escaping toegepast
- **SQL Injection Prevention**: Eloquent ORM gebruikt

## 📈 Prestaties

- **Database Indexing**: Optimale query performance
- **Lazy Loading**: Efficiënte relatie loading
- **Caching**: Session-based state management
- **Asset Optimization**: Minified CSS/JS via CDN

## 🌐 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## 📱 Mobile Responsiveness

Volledig responsive design met Bootstrap 5:
- Mobile-first approach
- Touch-friendly interfaces
- Optimale viewing op alle devices
- Progressive enhancement

## 🎓 Educatieve Features

- **Immediate Feedback**: Direct leren van fouten
- **Progress Tracking**: Motivatie door voortgangsvisualisatie
- **Flexible Questioning**: Verschillende vraagtypen voor diverse leerstijlen
- **Performance Analytics**: Inzicht in leerprestaties

---

## 📞 Support & Contact

Voor vragen of ondersteuning, raadpleeg de documentatie of neem contact op met het ontwikkelteam.

**Versie**: 1.0.0  
**Laatst bijgewerkt**: December 2024  
**Laravel Versie**: 11.x  
**PHP Versie**: 8.2+
