# StatusStokuBundle

Wielokrotnego użytku pakiet z widżetem statusu stoku narciarskiego, API JSON oraz pełną integracją EasyAdmin.

## Wymagania
- PHP >= 8.1
- Symfony 6.4/7.x (FrameworkBundle, TwigBundle, DoctrineBundle)
- EasyAdminBundle 4.x

## Instalacja
1. Dodaj do `composer.json` głównej aplikacji wpis repozytorium lub opublikuj pakiet w Packagist.
2. Zainstaluj bundla:
   ```bash
   composer require rybno/status-stoku-bundle
   ```
3. Zarejestruj bundla w `config/bundles.php`:
   ```php
   return [
       // ...
       Rybno\StatusStokuBundle\StatusStokuBundle::class => ['all' => true],
   ];
   ```
4. Dodaj routing w `config/routes/status_stoku.yaml`:
   ```yaml
   status_stoku:
       resource: '@StatusStokuBundle/Resources/config/routes.yaml'
   ```

## Konfiguracja (`config/packages/status_stoku.yaml`)
```yaml
status_stoku:
    widget_route: '/status-stoku'
    api_route: '/api/status-stoku.json'
    widget_template: '@StatusStoku/widget.html.twig'
    camera_url: 'https://twoja-kamera.pl'
    cache_ttl: 60
    easyadmin_menu_label: 'Status stoku'
    easyadmin_menu_icon: 'fa fa-mountain'
```
- `widget_route`, `api_route` – ścieżki HTTP generowane przez bundla.
- `widget_template` – pozwala nadpisać domyślny plik (umieść własny w `templates/bundles/StatusStokuBundle/widget.html.twig`).
- `camera_url` – adres przekazywany do widżetu. `null` ukrywa link.
- `cache_ttl` – czas współdzielonego cache (sekundy). `null` wyłącza cache i wymusza `private`.

## EasyAdmin
1. Zaimportuj encję `Rybno\StatusStokuBundle\Entity\StatusStoku` w Doctrine (`php bin/console doctrine:migrations:diff` jeśli tworzysz tabelę).
2. W `DashboardController` skorzystaj z helpera menu:
   ```php
   use Rybno\StatusStokuBundle\Service\StatusStokuMenuBuilder;

   public function __construct(private StatusStokuMenuBuilder $statusMenu) {}

   public function configureMenuItems(): iterable
   {
       yield $this->statusMenu->build();
       // ...inne pozycje
   }
   ```
3. CRUD dostarczany przez `LechuGuziec\StatusStokuBundle\Controller\Admin\StatusStokuCrudController` można nadpisać własnym, rejestrując go jako usługę i wskazując w menu.

## Widget i API
- Widżet renderuje `@StatusStoku/widget.html.twig` i udostępnia dane statusu (`wyciągi`, `pokrywa`, `warunki`, `updatedAt`).
- Endpoint JSON (`api_route`) zwraca ten sam zestaw danych, co ułatwia odświeżanie przez JS.

## Nadpisywanie szablonów
Utwórz plik `templates/bundles/StatusStokuBundle/widget.html.twig`, aby zmienić wygląd widżetu.

## Rozwój
- Testy uruchomisz poleceniem w katalogu głównym aplikacji:
  ```bash
  php bin/phpunit packages/StatusStokuBundle/tests
  ```
- Zalecane narzędzia: PHPStan, Rector (konfiguracje możesz współdzielić z projektem).
