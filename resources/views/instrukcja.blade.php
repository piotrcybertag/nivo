@extends('layouts.app')

@section('title', 'Instrukcja obsługi')

@section('content')
    <div style="max-width: 52rem; margin: 0 auto;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">Instrukcja obsługi programu</h1>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">1. Przeznaczenie systemu</h2>
            <p style="line-height: 1.6; color: #374151;">
                Program służy do przeglądania i prowadzenia <strong>schematu organizacyjnego</strong>. Można w nim przechowywać listę
                pracowników z przypisanymi szefami (linia i matrix), oglądać strukturę w formie drzewa (Schemat) oraz otworzyć widok
                do przeglądania całej struktury (Przegląd).
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">2. Uruchomienie programu</h2>
            <p style="line-height: 1.6; color: #374151;">
                Program uruchamia się w przeglądarce internetowej. Otwórz adres, pod którym działa system (np. adres serwera lub
                <em>localhost</em>), a następnie zaloguj się e‑mailem i hasłem. Po zalogowaniu w górnym pasku zobaczysz opcje menu:
                Nivo, Pracownicy, Schemat, Przegląd, Instrukcja, Ustawienia i Wyloguj.
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">3. Logowanie</h2>
            <p style="line-height: 1.6; color: #374151;">
                Kliknij <strong>Zaloguj</strong>, wpisz swój adres e‑mail i hasło, potem przycisk „Zaloguj”. Jeśli dane są poprawne,
                zostaniesz przekierowany na stronę startową i zobaczysz pełne menu. Wylogowanie: użyj opcji <strong>Wyloguj</strong> w menu.
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">4. Pracownicy</h2>
            <p style="line-height: 1.6; color: #374151;">
                W menu wybierz <strong>Pracownicy</strong>. Zobaczysz listę pracowników (kartotekę). Możesz dodawać nowych („Dodaj pracownika”),
                edytować i usuwać istniejących oraz przeglądać szczegóły. Przy każdym pracowniku podajesz imię, nazwisko, stanowisko,
                szefa w linii i (opcjonalnie) szefa matrix. Pracownik bez szefa traktowany jest jako początek struktury (szczyt schematu).
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">5. Schemat</h2>
            <p style="line-height: 1.6; color: #374151;">
                Opcja <strong>Schemat</strong> pokazuje strukturę organizacyjną w formie drzewa. Na górze widać szefa najwyższego poziomu
                (lub typ użytkownika, gdy jesteś na samej górze). Poniżej — podwładnych z połączeniami. Kliknięcie w prostokąt pracownika
                przenosi do widoku schematu „od tego pracownika w dół”. W panelu bocznym możesz wyszukać pracownika po nazwisku lub imieniu.
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">6. Przegląd</h2>
            <p style="line-height: 1.6; color: #374151;">
                <strong>Przegląd</strong> otwiera się w nowej karcie i pokazuje całą strukturę od korzenia. Przydatne do wydruku lub
                obejrzenia dużego drzewa. Przyciski „+” i „−” u dołu pozwalają powiększać i pomniejszać widok.
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">7. Ustawienia i link do udostępnienia</h2>
            <p style="line-height: 1.6; color: #374151;">
                W menu wybierz <strong>Ustawienia</strong>. Na tej stronie zobaczysz <strong>link do logowania</strong> przypisany do Twojego konta.
            </p>
            <p style="line-height: 1.6; color: #374151;">
                <strong>Do czego służy ten link?</strong> Pozwala on innym osobom wejść w program bez wpisywania hasła — po otwarciu linku
                w przeglądarce użytkownik zostanie od razu „zalogowany” w Twoim imieniu. Zobaczy wtedy <strong>Schemat</strong> i <strong>Przegląd</strong>
                (czyli strukturę organizacyjną), ale nie będzie miał dostępu do kartoteki Pracownicy ani do wylogowania. Przydaje się np. gdy
                chcesz komuś pokazać aktualny schemat bez udostępniania hasła.
            </p>
            <p style="line-height: 1.6; color: #374151;">
                <strong>Co zrobić z linkiem?</strong> Skopiuj go z strony Ustawienia (możesz kliknąć w link, aby go otworzyć, lub skopiować
                z paska adresu) i prześlij go mailem, komunikatorem lub w inny sposób osobie, której chcesz udostępnić podgląd. Ta osoba
                wkleja link do przeglądarki i od razu widzi Schemat i Przegląd. Link jest przypisany do Twojego konta — każdy, kto go ma,
                zobaczy strukturę w taki sam sposób jak Ty (w ramach Twoich uprawnień). Jeśli nie widzisz żadnego linku w Ustawieniach,
                skontaktuj się z osobą obsługującą system.
            </p>
        </section>
    </div>
@endsection
