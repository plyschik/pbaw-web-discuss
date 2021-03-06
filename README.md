# WebDiscuss
WebDiscuss to prosty system forum internetowego stworzony w oparciu o framework [Laravel 5.7](https://laravel.com).

### Strona główna
[![](docs/images/screenshot1.png)](https://raw.githubusercontent.com/plyschik/pbaw-web-discuss/master/docs/images/screenshot1.png)

### Widok tematu
[![](docs/images/screenshot2.png)](https://raw.githubusercontent.com/plyschik/pbaw-web-discuss/master/docs/images/screenshot2.png)

### Profil użytkownika
[![](docs/images/screenshot3.png)](https://raw.githubusercontent.com/plyschik/pbaw-web-discuss/master/docs/images/screenshot3.png)

### Statystyki forum
[![](docs/images/screenshot4.png)](https://raw.githubusercontent.com/plyschik/pbaw-web-discuss/master/docs/images/screenshot4.png)

### Panel zarządzania banami
[![](docs/images/screenshot5.png)](https://raw.githubusercontent.com/plyschik/pbaw-web-discuss/master/docs/images/screenshot5.png)

# Funkcjonalność
* Rejestracja nowych użytkowników wraz potwierdzeniem adresu email,
* Uwierzytelnianie użytkowników,
* System ról użytkowników (zwykły użytkownik, moderator oraz administrator), który ogranicza dostęp do określonych funkcji systemu,
* Banowanie użytkowników za łamanie zasad (wraz z panelem do przeglądania zgłoszeń),
* Kategorie oraz podkategorie, które pozwalają na tematyczną segregację tematów,
* Tematy wraz z odpowiedziami (+ możliwość odpowiadania na odpowiedzi); możliwość formatowania treści odpowiedzi za pomocą Markdown,
* Zgłaszanie tematów oraz odpowiedzi za łamanie zasad,
* Profile użytkowników, które zawierają szczegółowe dane i statystyki na temat aktywności użytkownika prezentowane w formie wykresów,
* Szczegółowe statystyki całego systemu, które dotyczą aktywności wszystkich użytkowników prezentowane w formie wykresów.

[Szczegółowy opis funkcjonalności](docs/features.md)

## Wymagania
* PHP w wersji 7.1.3 lub wyższej,
* MySQL,
* spełnienie [wymagań](https://laravel.com/docs/5.7/installation#server-requirements) frameworka Laravel.

## Instalacja (Linux)
1. Sklonuj repozytorium:
```bash
$ git clone https://github.com/plyschik/pbaw-web-discuss.git
```
2. Przejdź do katalogu z projektem:
```bash
$ cd pbaw-web-discuss
```
3. Zmień nazwę pliku ```.env.example``` na ```.env```. Następnie dostosuj ustawienia zawarte w pliku ```.env``` do swojej konfiguracji:
```bash
$ mv .env.example .env
$ nano .env
``` 
4. Pobierz zależności:
```bash
$ composer install
```
5. Uruchom poniższe polecenie, aby przeprowadzić wstępną konfigurację systemu (stworzenie struktury bazy danych i jej wypełnienie, utworzenie konta administratora, utworzenie wstępnych statystyk):
```bash
$ php artisan webdiscuss:setup
```
6. Skonfiguruj CRON, który będzie uruchamiał polecenie: ```php artisan schedule:run``` co minutę w celu wykonania operacji cyklicznych związanych z działaniem systemu:
```bash
* * * * * php artisan schedule:run
```
7. [OPCJONALNE] Część zadań systemowych jest przystosowana do kolejkowania (kolejkowanie jest domyślnie wyłączone, zadania wykonują się od razu). Aby włączyć kolejkowanie zadań skonfiguruj ustawienia w pliku ```config/queue.php```:
```bash
$ nano config/queue.php
```
8. Uruchom serwer WWW:
```bash
$ php artisan serve
```
9. System działa pod adresem: [127.0.0.1:8000](http://127.0.0.1:8000).

# Użyte zewnętrzne biblioteki
* [spatie/laravel-permission](https://github.com/spatie/laravel-permission)
* [cybercog/laravel-ban](https://github.com/cybercog/laravel-ban)
* [consoletvs/charts](https://github.com/ConsoleTVs/Charts)
* [fzaninotto/faker](https://github.com/fzaninotto/Faker)

# Twórcy
* [plyschik](https://github.com/plyschik)
* [emicsto](https://github.com/emicsto)

# Licencja
WebDiscuss udostępniony jest na zasadach licencji MIT.