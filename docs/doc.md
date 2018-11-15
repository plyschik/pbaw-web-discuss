# WebDiscuss
WebDiscuss to prosty system forum internetowego stworzony w frameworku [Laravel 5.7](https://laravel.com).

## Autoryzacja dostępu
W systemie wyróżniamy trzy rodzaje użytkowników (tzw. role): zwykły użytkownik, moderator oraz administrator. Stosujemy tutaj zasadzę hierarchii ról (dziedzicznie uprawnień z ról niższych w hierarchii) z czego wynika, że np. moderator ma te same prawa co zwykły użytkownik + prawa związane z rolą moderatora.

## Funkcjonalność

### Rejestracja
Każdy użytkownik, który chce zacząć udzielać się na forum powinien przejść prosty proces rejestracji. Użytkownik rejestrując się w serwisie oznajmia, że zapoznał się oraz zgadza się z regulaminem serwisu. W celu ukończenia procesu rejestracji należy potwierdzić adres email.

![Rejestracja](https://screenshotscdn.firefoxusercontent.com/images/a1937e90-0a17-45a4-958c-73cfb8e3cc04.png)


### Logowanie
Zarejestrowany użytkownik ma możliwość zalogowania się przez wpisanie danych podanych przy rejestracji.

![Logowanie](https://screenshotscdn.firefoxusercontent.com/images/21e8925e-28dd-4e22-9b52-090a41ab3dc0.png)


### Kategorie
Forum pogrupowane jest na kategorie (a te na podkategorie nazwane kanałami). Lista kategorii wyświetlana jest na stronie głównej wraz z informacją o moderatorach, którzy zarządzają tematami i odpowiedziami w danej sekcji. Kategoriami i kanałami może zarządać tylko administrator. Jeden użytkownik może być moderatorem w wielu kategoriach, możliwość nadawania/cofania uprawnień moderatora ma tylko administrator.

![Kategorie](https://screenshotscdn.firefoxusercontent.com/images/b388919e-d9d7-4b6d-bbd9-840ca188858c.png)

### Tematy
Po wybraniu danej kategorii wyświetla się lista z tematami z wybranej kategorii. Każdy temat ma swój tytuł, treść (pierwszy post) oraz kategorię, do której należy. Aby utworzyć temat należy posiadać rangę minimum zwykłego użytkownika. Tematami może zarządzać użytkownik o randze minimum moderator, który może zmienić tytuł tematu (minimum moderator) oraz go usunąć (tylko administrator).

![Tematy](https://screenshotscdn.firefoxusercontent.com/images/36839805-9082-4fb0-9743-27c24599e00a.png)

### Odpowiedzi
Każda odpowiedź jest związana z tematem. Aby udzielić odpowiedzi w temacie trzeba być uwierzytelnionym. Przewidziana jest możliwość odpowiadania na odpowiedzi (tylko do jednego poziomu wgłębienia). Odpowiedzi mogą być moderowane przez użytkownika z rangą minimum moderatora - edycja oraz usuwanie odpowiedzi.

![Odpowiedzi](https://screenshotscdn.firefoxusercontent.com/images/d3f13400-7b8a-422b-908b-cf1fe51aca4d.png)

### Zgłaszanie tematów i odpowiedzi
Każdy użytkownik z rangą zwykłego użytkownika ma możliwość zgłoszenia zarówno tematu jak i odpowiedzi z powodu złamania regulaminu w postaci formularza, w którym musi wskazać powód zgłoszenia. Użytkownik z rangą minimum moderatora posiada dostęp do panelu, w którym ma możliwość przeglądania zgłoszeń. Każde zgłoszenie może zakończyć się na trzy sposoby: zgłoszenie zostanie zignorowane (brak naruszeń w zgłaszanych treściach), treść zostanie usunięta lub twórca treści zostanie zbanowany.

![Zgłoszone posty](https://screenshotscdn.firefoxusercontent.com/images/6b871ac2-4d0c-4802-8d6a-64490e690558.png)

### Banowanie użytkowników
Użytkownik, który naruszył regulamin poprzez umieszczenie treści niezgodnej z regulaminem może zostać zbanowany (brak możliwości zalogowania się) na okres od 1 dnia do 3 miesięcy.

![Ban](https://screenshotscdn.firefoxusercontent.com/images/a062717e-ba50-4b52-8793-4f523c61e62f.png)

### Profile użytkowników
Każdy użytkownik serwisu ma w nim swoją stronę profilową, na której wyświetlają się podstawowe informacje o użytkowniku oraz szczegółowe informacje o aktywnościach użytkownika w postaci statystyk. Podstawowe dane każdy użytkownik może zmienić w przygotowanym do tego panelu. W celu identyfikacji użytkowników dodatkowo zapisuje się informację o adresie IP oraz User Agent każdego użytkownika, a także historię banów (dostęp tylko dla użytkowników z rangą administrator). Każdy użytkownik ma możliwość usunięcia swojego konta poprzez dokonanie odpowiedniej akcji w panelu zarządzania kontem.

![Profil z punktu widzenia administratora](https://screenshotscdn.firefoxusercontent.com/images/1369dba3-1f42-4264-8696-f61cf766d835.png)

### Statystyki
Każdy użytkownik ma wgląd do podstawowych statystyk dotyczących forum.

![Statystyki](https://screenshotscdn.firefoxusercontent.com/images/81061dc1-139c-4808-89c4-5682dd59959c.png)

## Soft delete
Treści usuwane z systemu są usuwane metodą *soft delte*, która polega na ustawianiu daty usunięcia rekordu - nie jest on fizycznie usuwany z bazy danych. Dzięki takiemu podejściu nie ma problemu ze spójnością danych oraz jest możliwość szybkiego przywrócenia usuniętego rekordu.