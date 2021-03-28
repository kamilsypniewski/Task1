##Zadanie 1

Napisz program, który odczyta plik tekstowy, a następnie wykona jego kopię, w którym szyk liter w każdym z wyrazów będzie losowo zmieniony oprócz
pierwszej i ostatniej litery wyrazu.  (uwzględnij interpunkcje, wielkie/małe litery, wielolinijkowe teksty, polskie znaki)

Plik pobierany jest z /public/file/task1_file1.txt
zapisywany w var

##Zadanie 2
Napisz program do walidacji numeru PESEL zgodnie z oficjalną specyfikacją formatu. Przygotuj testy jednostkowe sprawdzające kilka danych
nieprawidłowych i przynajmniej jeden poprawny numer pesel.

Rest Api
localhost/validation/pesel
`{
"pesel":"94022165719"
}`

./bin/phpunit


Zadanie 3
Napisz obsługę API dostępnego pod adresem https://gorest.co.in/. 
Aplikacja powinna posiadać widok listy użytkowników (pobranych z API) oraz mieć możliwość ich wyszukiwania i edycji istniejących wpisów.
Użyj Symfony 3/5. Zastosowanie JQuery oraz ajax, działanie aplikacji bez odświeżania strony będzie dodatkowym atutem.