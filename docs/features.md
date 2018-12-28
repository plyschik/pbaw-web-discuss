# Funkcjonalności
W tym dokumencie zawarto szczegółowy opis funkcjonalności systemu WebDiscuss.

### Autoryzacja dostępu
W systemie wyróżniamy trzy rodzaje (role) użytkowników: zwykły użytkownik, moderator oraz administrator. Stosujemy system hierarchii ról (dziedzicznie uprawnień z ról niższych w hierarchii) z czego wynika, że np. moderator ma te same prawa co zwykły użytkownik + prawa związane z zadaniami moderatora.

### Rejestracja
Każdy użytkownik, który chce zacząć udzielać się na forum powinien przejść prosty proces rejestracji. Użytkownik rejestrując się w serwisie oznajmia, że zapoznał się oraz zgadza się z regulaminem serwisu. W celu ukończenia procesu rejestracji należy potwierdzić adres email poprzez przejście pod adres wysłany w mailu.

### Logowanie
Zarejestrowany użytkownik ma możliwość zalogowania się przez wpisanie danych podanych przy rejestracji.

### Kategorie
Forum pogrupowane jest na kategorie (a te na podkategorie nazwane kanałami). Lista kategorii wyświetlana jest na stronie głównej wraz z informacją o moderatorach, którzy zarządzają tematami i odpowiedziami w danej sekcji. Kategoriami i kanałami może zarządać tylko administrator. Jeden użytkownik może być moderatorem w wielu kategoriach, możliwość nadawania/odbierania uprawnień moderatora ma tylko administrator.

### Tematy
Po wybraniu danego kanału wyświetla się lista z tematami z tego kanału. Każdy temat ma swój tytuł, treść (pierwszy post) oraz kanał, do którego należy. Aby utworzyć temat należy posiadać rangę minimum zwykłego użytkownika. Tematami może zarządzać użytkownik o randze minimum moderator, który może zmienić tytuł tematu (minimum moderator) oraz go usunąć (tylko administrator).

### Odpowiedzi
Każda odpowiedź jest związana z tematem. Aby udzielić odpowiedzi w temacie trzeba być uwierzytelnionym użytkownikiem. Przewidziana jest możliwość odpowiadania na odpowiedzi (tylko do jednego poziomu wgłębienia). Odpowiedzi mogą być moderowane przez użytkownika z rangą minimum moderatora - edycja oraz usuwanie odpowiedzi. Treść odpowiedzi może być formatowana za pomocą Markdown.

### Zgłaszanie tematów i odpowiedzi
Każdy użytkownik z rangą zwykłego użytkownika ma możliwość zgłoszenia zarówno tematu jak i odpowiedzi z powodu złamania regulaminu w postaci formularza, w którym musi wskazać powód zgłoszenia. Użytkownik z rangą minimum moderatora posiada dostęp do panelu, w którym ma możliwość przeglądania zgłoszeń. Każde zgłoszenie może zakończyć się na trzy sposoby: zgłoszenie zostanie zignorowane (brak naruszeń w zgłaszanych treściach), treść zostanie usunięta lub twórca treści zostanie zbanowany.

### Banowanie użytkowników
Użytkownik, który naruszył regulamin poprzez umieszczenie treści niezgodnej z regulaminem może zostać zbanowany (brak możliwości zalogowania się) na okres od 1 dnia do 3 miesięcy.

### Profile użytkowników
Każdy użytkownik serwisu ma w nim swoją stronę profilową, na której wyświetlają się podstawowe informacje o użytkowniku oraz szczegółowe informacje o aktywnościach użytkownika w postaci statystyk. Podstawowe dane każdy użytkownik może zmienić w przygotowanym do tego panelu. W celu identyfikacji użytkowników dodatkowo zapisuje się informację o adresie IP oraz User Agent każdego użytkownika, a także historię banów (dostęp tylko dla użytkowników z rangą administrator). Każdy użytkownik ma możliwość usunięcia swojego konta poprzez dokonanie odpowiedniej akcji w panelu zarządzania kontem.

### Statystyki
Każdy użytkownik ma wgląd do podstawowych statystyk dotyczących forum.

### Soft delete
Treści usuwane z systemu są usuwane metodą *soft delte*, która polega na ustawianiu daty usunięcia rekordu - nie jest on fizycznie usuwany z bazy danych. Dzięki takiemu podejściu nie ma problemu ze spójnością danych oraz jest możliwość szybkiego przywrócenia usuniętego rekordu.