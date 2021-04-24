<?php
define('ACCOUNT_NOT_ACTIVATED', 'Tento účet není povolen');
define('ACTION_CONST', 'Akce');
define('ADD', 'Přidat');
define('ADD_CATEGORY', 'Přidat kategorii');
define('ADD_EDIT_VALUES', 'Přidat / Upravit hodnoty');
define('ADD_FILTER', 'Přidat filtr');
define('ADD_NEW', 'Přidat nový');
define('ADD_TO_NAVBAR', 'Přidat do navigačního panelu');
define('ADDRESS', 'Adresa');
define('ADMIN', 'Admin');
define('ADMIN_AUTHENTIFICATION_MODULE', 'Uživatelský autentizační modul');
define('ADMIN_AUTHENTIFICATION_MODULE_ENABLED', 'Autentizace uživatele povolena');
define('ADMIN_AUTHENTIFICATION_MODULE_IS_ENABLED', 'Modul uživatelské autentizace je <span class="text-success-800">povolen</span>');
define('ADMIN_AUTHENTIFICATION_MODULE_DISABLED', 'Autentizace uživatele zakázána');
define('ADMIN_AUTHENTIFICATION_MODULE_IS_DISABLED', 'Modul uživatelské autentizace je  <span class="text-danger-800">zakázán</span>');
define('ADMIN_PASSWORD_HELP', 'Minimálně 6 znaků. Velká písmena + malá písmena. Čísla a znaky.');
define('ADVANCED', 'Další');
define('AJAX_LOADING', 'Načítání Ajaxu');
define('ALL', 'Vše');
define('ALL_ON_THE_SAME_PAGE', 'Vše na stejné stránce');
define('ALL_RECORDS', 'Všechny záznamy');
define('ARGUMENTS', 'Argumenty');
define('ARRAY_VALUE_TYPE', 'Oblast (checkbox nebe vícenásobný výběr)');
define('AT_LEAST', 'Alespoň');
define('AUTO', 'Auto');
define('BOOLEAN_CONST', 'Boolean');
define('BUILD', 'Vytvářet');
define('BULK_DELETE_BUTTON', 'Povolit hromadné mazání');
define('BULK_DELETE_SUCCESS_MESSAGE', ' záznamy byly smazány');
define('CANCEL', 'Zrušit');
define('CASCADE_DELETE_OPTIONS', 'Možnosti kaskádového mazání');
define('CHANGES_RECORDED', 'Změny byly uloženy');
define('CHAR_COUNT', 'Počítadlo znaků');
define('CHAR_COUNT_MAX', 'Maximální počet znaků');
define('CHARACTERS', 'Znaky');
define('CHECKBOXES', 'Checkboxy');
define('CHOOSE_DATABASE', 'Databáze');
define('CHOOSE_LIST_TYPE', 'Typ seznamu');
define('CHOOSE_TABLE', 'Tabulka');
define('CHOOSE_VALUES_FROM_TABLE', 'Vyberte hodnoty v databázové tabulce');
define('CITY', 'Město');
define('CLICK_TO_EDIT', 'Klikněte pro editaci');
define('CLICK_TO_REFRESH', 'Klikněte pro obnovení a zobrazení změn');
define('CLOSE', 'Zavřít');
define('COLOR', 'Barva');
define('COLUMN', 'Sloupec');
define('COLUMN_INDEX', 'Číslo sloupce');
define('COMPARE', 'Porovnat');
define('CONSTRAINT_USERS_CREATE_HELPER', 'Práva CREATE / DELETE na tabulce uživatelů nelze omezit - to by byl nesmysl');
define('CONSTRAINT_QUERY_TIP', '<p>KDE se dotazovat, pokud mají omezená práva.</p><p>Příklad: <br><em>, users KDE table.users_ID = users.ID AND users.ID = CURRENT_USER_ID</em></p><p><em>CURRENT_USER_ID</em> bude automaticky nahrazen připojeným uživatelem ID.</p>');
define('CREATE_IMAGE_THUMBNAILS', 'Vytvářejte miniatury');
define('CREATED_UPDATED_FILES', 'Soubory vytvořeny / upraveny');
define('CROP', 'Oříznutí');
define('CURRENT_VIEW', 'Aktuální pohled');
define('CUSTOM', 'Vlastní');
define('CUSTOM_VALUES', 'Vlastní hodnoty');
define('DATABASE_CONST', 'Databáze');
define('DATE_CONST', 'Datum');
define('DATE_DISPLAY_FORMAT', 'Formát zobrazení data');
define('DATE_HELPER', 'Zobrazit dostupné formáty');
define('DATE_NOW_HIDDEN', 'Skryté aktuální datum');
define('DATE_NOW_HIDDEN_HELPER', 'Skrýt pole a nastavit hodnotu na aktuální datum (ne | ano)');
define('DB_ERROR', 'Chyba při ukládání');
define('DB_RELATIONS_REFRESHED', 'Vztahy v databázi byly obnoveny');
define('DEFAULT_CONST', 'Výchozí');
define('DEFAULT_SEARCH_FIELD', 'Výchozí pole pro vyhledávání');
define('DELETE_CONST', 'vymazat'); // avoiding 'delete' keyword usage
define('DELETE_ACTION', 'Odstranění');
define('DELETE_RECORDS_FROM', 'Smazat záznamy od ');
define('DELETE_SELECTED_RECORDS', 'Delete selected records');
define('DELETE_SUCCESS_MESSAGE', '1 záznam vymazán');
define('DETAIL', 'Detail');
define('DIFF_FILES', 'Porovnání souborů');
define('DISABLE', 'Zakázat');
define('DISABLED', 'Zakázán');
define('DISPLAY', 'Zobrazit');
define('DISPLAY_ALL', 'Zobrazit vše');
define('DISPLAY_NAME', 'Zobrazit jméno');
define('DISPLAY_VALUE', 'Zobrazit hodnotu');
define('DOMAIN', 'Doména');
define('DRAG_ME', 'Chytni');
define('EDIT', 'Upravit');
define('EDITABLE_CONTENT', 'Upravitelný obsah');
define('EDIT_IN_PLACE', 'Upravit v místě');
define('EMAIL', 'E-mail');
define('ENABLE', 'Povolit');
define('ENABLED', 'Povoleno');
define('ENABLE_SORTING', 'Povolit třízení');
define('ENTER_YOUR_CREDENTIALS_BELOW', 'Níže zadejte své přihlašovací údaje');
define('ERROR_CANT_CREATE_DIR', 'Adresář nelze vytvořit');
define('ERROR_CANT_WRITE_FILE', 'Nelze vytvořit / upravit soubor');
define('ERROR_FILE_NOT_FOUND', 'Soubor nenalezen. Před přístupem na tuto stránku musíte vytvořit formulář JHUcto');
define('EXPORT_CSV_BUTTON', '"Export tlačítko (xls / csv)"');
define('EXPORT_TO_CSV', 'Exportovat do formátu CSV');
define('EXPORT_TO_EXCEL', 'Exportovat do formátu excel');
define('EXPORT_TO_TSV', 'Exportovat do formátu TSV');
define('EXTERNAL_RELATIONS', 'Vnější vztahy');
define('FAILED_TO_CONNECT_DB', 'Při připojování k databázi došlo k chybě');
define('FAILED_TO_DELETE', 'Nelze smazat');
define('FAILURE', 'Selhání');
define('FIELD', 'Pole');
define('FIELD_DELETE_CONFIRM', 'Pole pro potvrzení odstranění');
define('FIELD_TYPE', 'Typ pole');
define('FIELD_WIDTH', 'Šířka pole');
define('FIELDS', 'Pole');
define('FIELDS_TO_DISPLAY', 'Pole k zobrazení');
define('FIELDS_TO_FILTER', 'Pole k filtrování');
define('FILE', 'Soubor');
define('FILE_AUTHORIZED', 'Autorizované typy souborů');
define('FILE_NOT_FOUND', 'Soubor nenalezen');
define('FILE_PATH', 'Cesta k souborům');
define('FILE_URL', 'URL souborů');
define('FILTER', 'Filtr');
define('FILTER_BY_DATE_RANGE', 'Filtrovat podle časového období');
define('FILTER_BY_DATE_RANGE_HELPER', 'Pokud "Ano", uživatelé si vyberou záznamy mezi 2 daty. Jinak si vyberou jediné datum.<br><span class="text-orange-600">Nelze použít s načítáním Ajaxu.</span>');
define('FILTER_DROPDOWNS', 'Filtry (rozevírací seznamy pro filtrování výsledků)');
define('FILTER_HELP_1', 'Pole filtru');
define('FILTER_HELP_2', 'Přidružené pole - volitelné - (příklad: křestní jméno + příjmení)');
define('FILTER_LIST', 'Filtrovat seznam');
define('FIRST_NAME', 'Jméno');
define('FORGOT_PASSWORD', 'Zapomněli jste heslo');
define('FORMS_GENERATED', 'Formulář byl vygenerován');
define('FUNCTION_CONST', 'Funkce');
define('GENERAL_SETTINGS', 'Všeobecná nastavení');
define('GENERATED_FILTER', 'Filtr byl vygenerován ');
define('GROUP_WARNING', 'Seskupené pole %field% musí být seskupeny s druhým sousedícím polem');
define('GROUP_WIDTH_WARNING', 'Skupina [%field1%, %field2%] překračuje maximální šířku (100%)');
define('GROUPED', 'Seskupeno');
define('HEIGHT', 'výška');
define('HELP_TEXT', 'Pomocný text');
define('HIDE', 'Skrýt');
define('HOME', 'Domů');
define('HUMAN_READABLE_NAMES', 'Jména zobrazená v administrátorovi');
define('IMAGE', 'Obrázek');
define('IMAGE_EDITOR', 'Editor obrázků');
define('IMAGE_PATH', 'Cesta k obrázkům');
define('IMAGE_URL', 'URL obrázků');
define('IN_A_PAGINATED_LIST', 'Na stránkovaném seznamu');
define('INFO_REGISTERED', 'Informace byly zaregistrovány');
define('INSTALL_ADMIN_AUTHENTIFICATION_MODULE', 'Nainstalujte modul ověřování uživatelů');
define('INSERT_SUCCESS_MESSAGE', '1 záznam přidán');
define('INVALID_CHARS_ERROR', 'Následující %target_name% obsahuje nestandardní neplatné znaky:<br>%target_values%<br><br>Vy <span class="font-weight-bold">MUST</span> změňte tato jména, nebo bude blokována PHPCG funkcionalita.<br><br>Povolené znaky jsou: malá, velká, čísla a podtržítka. Čísla nejsou povolena jako 1. znak.<br><br><span class="font-weight-bold">Po dokončení klikněte na tlačítko „znovu načíst strukturu databáze“.</span>.');
define('LABEL', 'Označení');
define('LIST_GENERATED', 'Seznam byl vygenerován');
define('LOAD_CURRENT_THEME_DEFAULT_SKIN', 'Načíst aktuální vzhled výchozího motivu');
define('LOADING_PLEASE_WAIT', 'Načítání ... prosím čekejte');
define('LOGIN_ERROR', 'Chyba autentizace');
define('LOGIN_TO_YOUR_ACCOUNT', 'Přihlásit se');
define('LOGOUT', 'Odhlásit se');
define('LOWERCASE', 'malá písmena');
define('LOWERCASE_CHARACTERS', 'Malá písmena');
define('MAIN_SETTINGS', 'Hlavní nastavení');
define('MAX_HEIGHT', 'Maximální výška');
define('MAX_SIZE_HELPER', 'Pokud to není omezeno, ponechte prázdné');
define('MAX_WIDTH', 'Maximální šířka');
define('MERGE', 'Spojit');
define('MATCHING_RECORDS_WILL_BE_DELETED', 'Odpovídající záznamy v následujících tabulkách budou smazány současně');
define('MESSAGE_SENT', 'Zpráva byla odeslána');
define('MISSING_TABLE_IN_AUTHENTIFICATION_MODULE', 'Tabulka <span class="font-weight-bold">%TABLE%</span> se používá v panelu administrátora, ale nebyla nainstalována s autentizačním modulem. <br> Aby bylo možné přidat modul ověřování, musí být znovu nainstalována tabulka <span class="font-weight-bold">%TABLE%</span> autentizačního modulu.');
define('MOBILE_PHONE', 'Mobilní telefon');
define('MULTIPLE_CONST', 'Násobný');
define('NAME', 'Jméno');
define('NEED_HELP', 'Potřebuji pomoc');
define('NESTED_TABLE', 'Vnořená tabulka');
define('NO', 'Ne');
define('NO_HTML', 'Ne HTML');
define('NO_PRIMARY_KEY', 'Nebyl nalezen žádný primární klíč. Primární klíč je nezbytný pro fungování vaší administrace.');
define('NO_RECORD_FOUND', 'Záznam nenalezen');
define('NO_RESULT_FOUND', 'Nebyl nalezen žádný výsledek');
define('NO_VALUE_SELECTED', 'Nastavte hodnoty pro pole ');
define('NONE', 'Není');
define('NUMBER', 'Číslo');
define('NUMBERS', 'Čísla');
define('OK', 'OK');
define('OPEN_ADMIN_PAGE', 'Otevřít admin stránku');
define('OPEN_URL', 'Otevřít URL');
define('OPEN_URL_BUTTON', 'Tlačítko otevřít URL');
define('OPTIONS', 'Volby');
define('ORDER_BY', 'řadit podle');
define('ORGANIZE_ADMIN_NAVBAR', 'Organizace navigačního panelu');
define('PAGE', 'stránka');
define('PAGINATED_LIST', 'Stránkování seznamu');
define('PASSWORD', 'Heslo');
define('PASSWORD_CONSTRAINT', 'Omezení');
define('PASSWORD_EDIT_HELPER', 'Chcete-li zachovat aktuální heslo, ponechte prázdné');
define('PHONE', 'Telefon');
define('PRINTABLE_VIEW', 'Tisknutelné zobrazení');
define('PROFILE', 'Profil');
define('PURCHASE_CODE', 'Kód nákupu');
define('QUERY', 'Dotaz');
define('QUERY_FAILED', 'Dotaz se nezdařil');
define('RECORDING', 'Ukládám');
define('RECORDS', 'Záznamy');
define('REFERENCED_TABLE', 'Referenční tabulka');
define('REFERENCED_COLUMN', 'Referenční sloupec');
define('RELATIONS', 'Vztahy');
define('RELOAD_DB_STRUCTURE', 'Znovu načíst strukturu databáze');
define('REMOVE', 'Odstranit');
define('REMOVE_FROM_NAVBAR', 'Odstranit z navigačního panelu');
define('REMOVE_ADMIN_AUTHENTIFICATION_MODULE_HELPER', '<p>Tím vymažete všechny generátory &amp; Admin uživatele &amp; soubory profilů</p><p>2 databázové tabulky a jejich data <span class="font-weight-bold">NEBUDOU</span> smazány - pokud je chcete odstranit, ručně</p><p>Pokud modul přeinstalujete později a tyto dvě tabulky již existují,  <span class="font-weight-bold">NEBUDOU</span> přepsány.</p>');
define('REQUIRED', 'Požadované');
define('RESET', 'Reset');
define('RESET_TABLE_DATA', 'Resetujte data tabulky');
define('RESTRICTED', 'Omezení');
define('RESULTS_PER_PAGE', 'Výsledky');
define('SAVE_CHANGES', 'Uložit změny');
define('SEARCH', 'Vyhledávání');
define('SELECT_CONST', 'Vybrat');
define('SELECT_ACTION', 'Vyberte akci');
define('SELECT_DATABASE', 'Vyberte databázi');
define('SELECT_FIELDS_TYPES_FOR_CREATE_UPDATE', 'Vyberte typy polí a možnosti pro Vytvořit | Aktualizace');
define('SELECT_MULTIPLE', 'Vyberte více');
define('SELECT_OPTIONS_FOR_PAGINATED_LIST', 'Možnosti z stránkovaného seznamu');
define('SELECT_OPTIONS_FOR_SINGLE_ELEMENT_LIST', 'Možnosti seznamu jediného záznamu');
define('SELECT_OPTIONS_FOR_DELETE_FORM', 'Možnosti pro formulář pro odstranění');
define('SELECT_TABLES_USED_IN_ADMIN', 'Tabulky použité v administraci');
define('SELECT_TABLES_USED_IN_ADMIN_HELP', 'Vybrané tabulky budou použity k definování profilů uživatelských práv');
define('SESSION_EXPIRED', 'Platnost relace vypršela. Připojte JHUcto znovu k databázi.');
define('SHOW', 'Ukázat');
define('SHOW_SEARCH_RESULTS', 'Zobrazit výsledky vyhledávání');
define('SIGN_IN', 'Přihlásit se');
define('SIDEBAR_EMPTY_ALERT', 'Boční panel je prázdný');
define('SIDE_BY_SIDE_COMPARISON', 'Porovnání vedle sebe');
define('SIDE_BY_SIDE_COMPARISON_HELPER', 'Poté klikněte na části, které chcete ponechat v levém a pravém sloupci <span class="font-weight-bold">"' . MERGE . '"</span> uložit vaše volby');
define('SIMPLE', 'Jednoduchý');
define('SINGLE', 'Unikátní');
define('SINGLE_ELEMENT_LIST', 'Seznam jediného záznamu');
define('SITE_ADMINISTRATOR', 'Hlavní administrace');
define('SKIP_THIS_FIELD', 'Nezobrazovat v seznamu');
define('SQL_FROM', 'SQL Formulář');
define('STRUCTURE', 'Struktura');
define('STRUCTURE_AND_DATA', 'Struktura a data');
define('STRUCTURE_ONLY', 'Struktura');
define('SUBMIT', 'Odeslat');
define('SYMBOLS', 'Symboly');
define('TABLE', 'Tabulka');
define('TABLE_HAS_BEEN_REMOVED', 'Tabulka %table% byl odstraněna z JHUcto a panelu administrace');
define('TABLES', 'Tabulky');
define('TEST', 'Test');
define('TEXT', 'Text');
define('TEXT_INPUT', 'Vložit text');
define('TEXT_NUMBER', 'Text / Číslo');
define('TEXTAREA', 'Textové pole');
define('TIME_DISPLAY_FORMAT', 'Time display format');
define('TIME_PLACEHOLDER', 'Hodina');
define('TINYMCE', 'Tinymce');
define('TOGGLE_ALL', 'Přepnout');
define('TOOLS', 'Nástroje');
define('TOOLTIP', 'Tip');
define('TYPE', 'Typ');
define('UPDATE_SUCCESS_MESSAGE', '1 změněný záznam');
define('UPPERCASE', 'Velká písmena');
define('UPPERCASE_CHARACTERS', 'Velká písmena');
define('URL', 'Url');
define('USER_MANAGEMENT', 'Správa uživatelů');
define('USER_MANAGEMENT_SUCCESSFULLY_CREATED', 'Správa uživatelů byla úspěšně vytvořena. Nyní můžete přidávat / upravovat uživatelské &amp; profily.<br><span class="font-weight-bold">Formuláře pro mazání uživatelských a uživatelských profilů musí být vytvořeny pomocí generátoru JHUcto.</span>');
define('USERS_TABLE_NAME', '<em class="text-primary">Uživatelé</em> table name');
define('USERS_TABLE_NAME_HELP', 'Pouze malá písmena + podtržítka (_)');
define('VALIDATION', 'Validace');
define('VALUE', 'Hodnota');
define('VALUE_S', 'Hodnota(y)');
define('VALUES', 'Hodnoty');
define('VALUES_TO_DISPLAY', 'Hodnoty k zobrazení');
define('VALUES_TYPE', 'Typy hodnot');
define('WIDTH', 'šířka');
define('WRONG_DATE', 'Chybné datum');
define('WRONG_DATE_FORMAT', 'Chybný formát data');
define('WRONG_TABLE_DATA', 'Chybná data tabulky');
define('YES', 'Ano');
define('ZIP_CODE', 'PSČ');

// pagination
define('PAGINATION_RESULTS', 'Výsledky');
define('PAGINATION_TO', 'do');
define('PAGINATION_OF', 'od');

// tooltips
define('BULK_DELETE_BUTTON_TIP', '<a href="#" data-tooltip="Zaškrtněte políčko vedle každého záznamu a globální tlačítko \'Odstranit\'"><span class="badge badge-secondary append">?</span></a>');
define('CREATE_IMAGE_THUMBNAILS_TIP', '<a href="#" data-tooltip="Miniatury generované v podsložkách vybrané složky obrázků:<br>[image folder]/thumbs/lg/image.jpg<br>[image folder]/thumbs/md/image.jpg<br>[image folder]/thumbs/sm/image.jpg<br><br>Velikost obrázků a miniatur lze upravit v <em>class/phpformbuilder/plugins/fileuploader/image-upload/php/ajax_upload_file.php</em>"><span class="badge badge-secondary append">?</span></a>');
define('DATE_DISPLAY_TIP', '<a href="#" data-tooltip="Datum zobrazené v administračním rozhraní"><span class="badge badge-secondary append">?</span></a>');
define('GROUPED_SINGLE_TIP', '<a href="#" data-tooltip="Seskupená pole jsou zobrazena na stejném řádku ve formulářích."><span class="badge badge-secondary append">?</span></a>');
define('FILE_AUTHORIZED_HELPER', 'Seznam oddělený čárkami. Příklad: doc, docx, xls, xlsx, pdf, txt');
define('FILE_PATH_TIP', '<a href="#" data-tooltip="Cesta k adresáři souborů z kořenového adresáře webu. Příklad: uploads/documents/"><span class="badge badge-secondary append">?</span></a>');
define('FILE_URL_TIP', '<a href="#" data-tooltip="Adresa URL adresáře souborů. Příklad: uploads/documents/"><span class="badge badge-secondary append">?</span></a>');
define('IMAGE_EDITOR_TIP', '<a href="#" data-tooltip="Editor pro oříznutí a otočení obrázků v administračním rozhraní"><span class="badge badge-secondary append">?</span></a>');
define('IMAGE_PATH_TIP', '<a href="#" data-tooltip="Cesta adresáře obrázků z kořenového adresáře webu. Příklady: assets/images/ or assets/img/"><span class="badge badge-secondary append">?</span></a>');
define('IMAGE_URL_TIP', '<a href="#" data-tooltip="Adresa URL adresáře obrázků. Příklady: assets/images/ or assets/img/"><span class="badge badge-secondary append">?</span></a>');
define('OPEN_URL_BUTTON_TIP', '<a href="#" data-tooltip="Cílové adresy URL budete muset zadat ručně v souboru správce."><span class="badge badge-secondary append">?</span></a>');
define('TIME_DISPLAY_TIP', '<a href="#" data-tooltip="Čas zobrazený v administračním rozhraní"><span class="badge badge-secondary append">?</span></a>');

// months
define('JANUARY', 'Leden');
define('FEBRUARY', 'Únor');
define('MARCH', 'Březen');
define('APRIL', 'Duben');
define('MAY', 'Květen');
define('JUNE', 'Červen');
define('JULY', 'Červenec');
define('AUGUST', 'Srpen');
define('SEPTEMBER', 'Září');
define('OCTOBER', 'Říjen');
define('NOVEMBER', 'Listopad');
define('DECEMBER', 'Prosinec');

// help html content

define('AJAX_LOADING_HELP', 'Pokud tabulka obsahuje mnoho záznamů, povolte načítání ajaxu.');
define('AUTO_INCREMENT_HELP', '<p class="text-muted">Hodnoty polí Auto-increment jsou automaticky generovány ve formulářích CREATE<br>Ověření je automatické a nelze jej změnit</p>');
define('DRAG_AND_DROP_HELP', 'Chytní &amp; táhni pro organizaci - <span class="text-gray">Prázdné kategorie budou automaticky odstraněny</span>');
define('FIELD_DELETE_CONFIRM_HELP', '<p class="text-muted">Pole zobrazená uživateli v administrátorovi pro potvrzení odstranění</p>');

$filter_help = '<div class="well w-100 p-5 bg-slate-100">' . "\n";
$filter_help .= '<p class="alert alert-info has-icon">Použijte <a href="http://www.activedbsoft.com/overview-querytool.html" target="_blank">FlySpeed SQL Query</a> pro generování a testování dotazů.</p>';
$filter_help .= '<dl class="dl-horizontal mb-20">' . "\n";

$filter_help .= '<dt>' . LABEL . '</dt>' . "\n";
$filter_help .= '<dd>Štítek se zobrazí vedle rozevíracího seznamu.<br>Příklad: "Autor"</dd>' . "\n";

$filter_help .= '<dt>' . VALUE_S . '</dt>' . "\n";
$filter_help .= '<dd>Pole, která mají být zobrazena v rozevíracím seznamu, oddělena "+".<br>Příklad : "authors.name + authors.first_name"</dd>' . "\n";

$filter_help .= '<dt>' . FIELDS . '</dt>' . "\n";
$filter_help .= '<dd>Pole pro dotazy SQL SELECT.<br>Příklad : "authors.name, authors.first_name, articles.authors_id"</dd>' . "\n";

$filter_help .= '<dt>' . FIELDS_TO_FILTER . '</dt>' . "\n";
$filter_help .= '<dd>Pole použitá pro filtrování doazů.<br>Příklad : "articles.authors_id"</dd>' . "\n";

$filter_help .= '<dt>' . SQL_FROM . '</dt>' . "\n";
$filter_help .= '<dd>SQL FROM dotaz.<br>Příklad : "articles Left Join authors On articles.authors_id = authors.id"</dd>' . "\n";

$filter_help .= '<dt>' . COLUMN_INDEX . '</dt>' . "\n";
$filter_help .= '<dd>Index filtrovaného sloupce v stránkovaném seznamu <br> Používá se k zabarvení filtrovaného sloupce. Index začíná číslem 1.</dd>' . "\n";

$filter_help .= '<dt>' . VALUES_TYPE . '</dt>' . "\n";
$filter_help .= '<dd>Text nebo Boolean.</dd>' . "\n";

$filter_help .= '</dl>' . "\n";
$filter_help .= '<p><span class="font-weight-bold">Jako příklad bude uveden dotaz:</span></p><pre class=" mb-20"><code>SELECT DISTINCT authors.name, authors.first_name, articles.authors_id FROM articles INNER JOIN authors ON articles.authors_id = authors.id</code></pre>' . "\n";
$filter_help .= '<p><span class="font-weight-bold">Když si uživatel vybral položku ze seznamu:</span></p><pre><code>SELECT DISTINCT authors.name, authors.first_name, articles.authors_id FROM articles INNER JOIN authors ON articles.authors_id = authors.id WHERE articles.authors_id = [posted value]</code></pre>' . "\n";
$filter_help .= '</div>' . "\n";
define('FILTER_HELP', $filter_help);

$filter_help_3 = '<p class="alert alert-warning has-icon">Použijte <span class="badge text-lowercase bg-yellow-400"><code>table.field</code></span> raději než <span class="badge text-lowercase bg-yellow-400"><code>field</code></span> pro vyhnutí se nejasným dotazům.</p>';
define('FILTER_HELP_3', $filter_help_3);

define('RESET_DATA_CHOICES_HELP_1', '<p>V obou případech musí být tabulka a její data znovu sestavena a budou odstraněna z administračního panelu.</p>');
define('RESET_DATA_CHOICES_HELP_2', '<p><span class="text-red-300 prepend">*</span>Pokud se struktura tabulky změnila, bude aktualizována (pole přidat / změnit / odstranit). Existující data budou <span class="font-weight-bold">zachována</span> (vlastní názvy polí, filtry, typy polí, výběr hodnot, ...)</p>');
define('RESET_DATA_CHOICES_HELP_3', '<p><span class="text-red-400 prepend">**</span>Pokud se struktura tabulky změnila, bude aktualizována (pole přidat / změnit / odstranit). Existující data budou <span class="font-weight-bold">resetována</span> (vlastní názvy polí, filtry, typy polí, výběr hodnot, ...)</p>');

define('ALLOW_CRUD_IN_LIST', 'Povolit uživatelům přidávat / upravovat / mazat záznamy z internetu <span class="font-weight-bold">READ LIST</span>');

define('EXPLAIN_RELATION', 'Vysvětlete tento vztah');
$relation_many_to_many = '<div class="well w-100 p-5 bg-slate-100">';
$relation_many_to_many .= '<p class="h5"><span class="badge badge-info">MANY_TO_MANY vztah</span></p><p>Povolení tohoto vztahu vám umožní spojit jeden nebo více <code class="badge badge-secondary">%target_table%</code> s každým záznamem tabulky <code class="badge badge-secondary">%origin_table%</code>.</p><p class="mb-5"> Tabulka <code class="badge badge-secondary">%intermediate_table%</code> je v tomto případě <span class="font-weight-bold">čistá relační tabulka</span> která spojuje <code class="badge badge-secondary">%target_table%</code> s <code class="badge badge-secondary">%origin_table%</code> tabulkou.</p><p>The <span class="font-weight-bold">READ LIST</span> zobrazí záznamy v tabulce <code class="badge badge-secondary">%target_table%</code> ve vnořené tabulce.</p><p>The <span class="font-weight-bold">CREATE</span> a <span class="font-weight-bold">EDIT</span> formuláře umožní přiřadit záznamy tabulky <code class="badge badge-secondary">%target_table%</code> k <code class="badge badge-secondary">%origin_table%</code> přidání/editaci.</p>';
$relation_many_to_many .= '</div>';
define('EXPLAIN_RELATION_MANY_TO_MANY', $relation_many_to_many);

$relation_one_to_many = '<div class="well w-100 p-5 bg-slate-100">';
$relation_one_to_many .= '<p class="h5"><span class="badge badge-info">ONE_TO_MANY vztah</span></p><p class="mb-5">Pokud povolíte tento vztah, <span class="font-weight-bold">READ LIST</span> zobrazí se pro každý záznam v tabulce <code class="badge badge-secondary">%target_table%</code> odpovídající záznamy v tabulce <code class="badge badge-secondary">%original_table%</code> v rozevírací tabulce.</p><p>Pokud povolíte <span class="font-weight-bold"><em>' . ALLOW_CRUD_IN_LIST . '</em></span> možnost, kterou budou uživatelé moci přidat / upravit / odstranit záznamy z tabulky <code class="badge badge-secondary">%origin_table%</code> přímo z této tabulky .</p>';
$relation_one_to_many .= '</div>';
define('EXPLAIN_RELATION_ONE_TO_MANY', $relation_one_to_many);

$allow_records_management_in_forms = 'Povolit uživatelům %target_table% z vytváření/editace %origin_table% formulářů.';
define('ALLOW_RECORDS_MANAGEMENT_IN_FORMS', $allow_records_management_in_forms);

define('WRONG_TABLE_DATA_MESSAGE', '<div class="alert alert-danger has-icon my-4">
<p><span class="font-weight-bold">Váš navigační panel používá jednu nebo více tabulek, jejichž strukturu je třeba regenerovat.</span></p>
<ol>
<li>Otevřít generátor</li>
<li>vyberte tabulku a klikněte na tlačítko „reset“</li>
<li>zvolte "strukturu" a potvrďte.</li>
<li>Poté aktualizujte tuto stránku a nakonfigurujte svůj navigační panel</li>
</ol></div>');

include_once ADMIN_DIR . 'secure/conf/conf.php';

$ut = 'users_table';
if (defined('USERS_TABLE')) {
    $ut = USERS_TABLE;
}
$users_profiles_helper = '<div class="card card-body bg-gray-100 mb-5">';
$users_profiles_helper .= '<h4 class="card-title text-center my-3"><a class="dropdown-toggle text-gray-700" data-toggle="collapse" href="#users-profiles-helper" role="button" aria-expanded="false" aria-controls="users-profiles-helper">Instructions to limit users\' rights</a></h4>';
$users_profiles_helper .= '<div class="collapse" id="users-profiles-helper">';
$users_profiles_helper .= '<ol>';
$users_profiles_helper .= '<li>Nastavit <span class="font-weight-bold"><em>Čtení</em></span>, <span class="font-weight-bold"><em>Aktualizace</em></span>, <span class="font-weight-bold"><em>Vytvoření/Smazání</em></span> práva tabulky, která chcete omezit "<span class="font-weight-bold">Restricted</span>" v rozevíracím seznamu</li>';
$users_profiles_helper .= '<li>V <span class="font-weight-bold"><em>Omezovacím dotazu</em></span> pole, vložte <span class="font-weight-bold"><em>WHERE</em></span> dotaz k omezení uživatelských oprávnění </li>';
$users_profiles_helper .= '</ol>';
$users_profiles_helper .= '<h4 class="badge badge-secondary px-3 py-2">Příklad: </h4><p><code>KDE your_table.' . $ut . '_ID = CURRENT_USER_ID</code></p>';
$users_profiles_helper .= '<hr>';
$users_profiles_helper .= '<p><code class="font-weight-bold">CURRENT_USER_ID</code> bude automaticky nahrazeno ID připojeného uživatele.</p>';
$users_profiles_helper .= '<hr>';
$users_profiles_helper .= '<p>Vaše tabulka <span class="font-weight-bold">MUST</span> má <span class="font-weight-bold">přímý nebo nepřímý</span> vztah k <code class="font-weight-bold">' . $ut . '</code>. Příklad:</p>';
$users_profiles_helper .= '<ul>';
$users_profiles_helper .= '<li class="mb-2"><code class="font-weight-bold">your_table.' . $ut . '_ID</code> => <code class="font-weight-bold">' . $ut . '.ID</code> (direct relationship)</li>';
$users_profiles_helper .= '<li><code class="font-weight-bold">your_table.t2_ID</code> => <code class="font-weight-bold">t2.ID</code><br><code class="font-weight-bold">t2.' . $ut . '_ID</code> => <code class="font-weight-bold">' . $ut . '.ID</code> (indirect relationship)</li>';
$users_profiles_helper .= '</ul>';
$users_profiles_helper .= '</div>';
$users_profiles_helper .= '</div>';
define('USERS_PROFILES_HELPER', $users_profiles_helper);

// validation helpers
$validation_helper_texts = array(
    'between'       => 'between($min, $max, $include = TRUE, $message = null)',
    'callback'      => 'callback($callback, $message = null, $params = array())',
    'captcha'       => 'captcha($field, $message = null)',
    'ccnum'         => 'ccnum($message = null)',
    'date'          => 'date($message = null)',
    'digits'        => 'digits($message = null)',
    'email'         => 'email($message = null)',
    'endsWith'      => 'endsWith($sub, $message = null)',
    'float'         => 'float($message = null)',
    'hasLowercase'  => 'hasLowercase($message = null)',
    'hasNumber'     => 'hasNumber($message = null)',
    'hasPattern'    => 'hasPattern(\\\'/regex/\\\', $message = null)',
    'hasSymbol'     => 'hasSymbol($message = null)',
    'hasUppercase'  => 'hasUppercase($message = null)',
    'integer'       => 'integer($message = null)',
    'ip'            => 'ip($message = null)',
    'length'        => 'length($length, $message = null)',
    'matches'       => 'matches($field, $label, $message = null)',
    'max'           => 'max($limit, $include = TRUE, $message = null)',
    'maxDate'       => 'maxDate($date, $format, $message = null)',
    'maxLength'     => 'maxLength($length, $message = null)',
    'min'           => 'min($limit, $include = TRUE, $message = null)',
    'minDate'       => 'minDate($date, $format, $message = null)',
    'minLength'     => 'minLength($length, $message = null)',
    'notEndsWith'   => 'notEndsWith($sub, $message = null)',
    'notMatches'    => 'notMatches($field, $label, $message = null)',
    'notStartsWith' => 'notStartsWith($sub, $message = null)',
    'oneOf'         => 'oneOf($allowed, $message = null)',
    'required'      => 'required($message = null)',
    'startsWith'    => 'startsWith($sub, $message = null)',
    'url'           => 'url($message = null)'
);

// password contraints helpers
$lower_char = mb_strtolower(LOWERCASE_CHARACTERS, 'UTF-8');
$char       = mb_strtolower(CHARACTERS, 'UTF-8');
define('MIN_3', AT_LEAST . ' 3 ' . $lower_char);
define('MIN_4', AT_LEAST . ' 4 ' . $lower_char);
define('MIN_5', AT_LEAST . ' 5 ' . $lower_char);
define('MIN_6', AT_LEAST . ' 6 ' . $lower_char);
define('MIN_7', AT_LEAST . ' 7 ' . $lower_char);
define('MIN_8', AT_LEAST . ' 8 ' . $lower_char);
define('LOWER_UPPER_MIN_3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_MIN_4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_MIN_5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_MIN_6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_MIN_7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_MIN_8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE);
define('LOWER_UPPER_NUMBER_MIN_3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_MIN_4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_MIN_5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_MIN_6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_MIN_7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_MIN_8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_3', AT_LEAST . ' 3 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_4', AT_LEAST . ' 4 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_5', AT_LEAST . ' 5 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_6', AT_LEAST . ' 6 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_7', AT_LEAST . ' 7 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);
define('LOWER_UPPER_NUMBER_SYMBOL_MIN_8', AT_LEAST . ' 8 ' . $char . ' - ' . LOWERCASE . ' + ' . UPPERCASE . ' + ' . NUMBERS . ' + ' . SYMBOLS);

// Secure install messages
define('USER_DATA_RESERVED_NAME', '"user_data" je vyhrazený název tabulky - vyberte prosím jiný pro vaši tabulku uživatelů');
define('USER_TABLE_ALREADY_EXISTS', 'Jméno tabulky "%posted_table%" ajiž existuje. YZvolte jiné jméno.');
define('WRONG_PATTERN', 'Název tabulky musí obsahovat pouze malá písmena a podtržítka (_)');

// general-settings-form
define('ADMIN_ACTION_BUTTONS_POSITION_TXT', 'Pozice tlačítek Správce AKCE');
define('ADMIN_LOGO_HELPER', 'Velikost nahraného obrázku bude změněna na výšku 100 pixelů');
define('ADMIN_LOGO_TXT', 'Logo administrace');
define('ADMIN_PANEL_SETTINGS_TXT', 'Nastavení panelu administrace');
define('ADMIN_SKIN_TXT', 'Vzhled administrace');
define('COLLAPSE_INACTIVE_SIDEBAR_CATEGORIES_TXT', 'Sbalit neaktivní položky panelu');
define('DATE_TIME_TRANSLATIONS_FOR_LISTS_HELPER', 'Nastavení PHP <code class=language-php">Locale :: setDefault </code> pro automatický překlad PHP dat');
define('DATE_TIME_TRANSLATIONS_FOR_LISTS_TXT', 'Překlad data/času pro seznamy v administraci');
define('DATETIMEPICKERS_LANG_HELPER', 'Dostupné jazyky naleznete v <span class="badge badge-light">class/phpformbuilder/plugins/pickadate/lib/compressed/translations/</span>');
define('DATETIMEPICKERS_LANG_TXT', 'Date &amp; Jazyk pro výběr času');
define('DATETIMEPICKERS_MATERIAL_LANG_HELPER', 'Dostupné jazyky naleznete v <span class="badge badge-light">class\phpformbuilder\plugins\material-datepicker\dist\i18n</span>');
define('DEFAULT_BODY_CLASS_HELPER', 'Bootstrap CSS třída pro tělo panelu administrace');
define('DEFAULT_BODY_CLASS_TXT', 'Výchozí třída těla');
define('DEFAULT_BUTTONS_BACKGROUND_HELPER', 'Bootstrap CSS třída pro sekundární tlačítka panelu administrace');
define('DEFAULT_BUTTONS_BACKGROUND_TXT', 'Výchozí třída tlačítek');
define('DEFAULT_CARD_CLASS_HELPER', 'Bootstrap CSS třída pro karty v panelu administrace');
define('DEFAULT_CARD_CLASS_TXT', 'Výchozí třída karet');
define('DEFAULT_CARD_FOOTER_CLASS_HELPER', 'Bootstrap CSS třída pro karty v panelu administrace');
define('DEFAULT_CARD_FOOTER_CLASS_TXT', 'Výchozí třída zápatí karet');
define('DEFAULT_CARD_HEADING_CLASS_HELPER', 'Bootstrap CSS třída pro karty v panelu administrace');
define('DEFAULT_CARD_HEADING_CLASS_TXT', 'Výchozí třída hlavičky karet');
define('DEFAULT_PAGE_HEADER_HELPER', 'Bootstrap CSS třída pro hlavičku karet v panelu administrace');
define('DEFAULT_PAGE_HEADER_TXT', 'Výchozí hlavní třída záhlaví');
define('DEFAULT_SIDEBAR_USER_HELPER', 'Bootstrap CSS třída pro uživatelskou sekci postranního panelu panelu administrace');
define('DEFAULT_SIDEBAR_USER_TXT', 'Výchozí třída postranního panelu uživatelů');
define('DEFAULT_TABLE_HEADING_BACKGROUND_HELPER', 'Bootstrap CSS třída pro záhlaví tabulek administrace');
define('DEFAULT_TABLE_HEADING_BACKGROUND_TXT', 'Výchozí pozadí záhlaví tabulek');
define('ENABLE_FILTERS_TXT', 'Povolit filtry');
define('GENERAL_SETTINGS_SUCCESS_MESSAGE', 'Vaše nastavení byla uložena');
define('LANGUAGE_OTHER_HELPER', 'Zadejte svůj kód ISO jazyka a vytvořte překladový soubor do <span class="badge badge-light">admin\i18n\</span>');
define('LANGUAGE_OTHER_TXT', 'Zadejte svůj jazyk');
define('LANGUAGE_SETTINGS_TXT', 'Nastavení jazyka');
define('LANGUAGE_TXT', 'Jazyk');
define('LOCK_THE_GENERATOR_HELPER', 'Pokud je to pravda, musíte zadat svůj e-mail &amp; nákupní kód pro přístup k adrese JHUcto generátoru');
define('LOCK_THE_GENERATOR_TXT', 'Zamknout generátor');
define('MAIN_SETTINGS_TXT', 'Hlavní nastavení');
define('NO_LOCALE', '<p class="alert alert-warning">Enable <a href="https://www.php.net/manual/en/book.intl.php" target="_blank">PHP Funkce internacionalizace</a> pokud chcete automaticky přeložit data &amp; časy v seznamech administrace.</p>');
define('ON_FILTER_BUTTON_CLICK_TXT', 'Když kliknete na tlačítko "filtr"');
define('ON_SELECT_TXT', 'Jakmile je v rozevíracím seznamu vybrán filtr');
define('ON_THE_LEFT', 'Nalevo');
define('ON_THE_RIGHT', 'Napravo');
define('SITE_NAME_HELPER', 'Jméno zobrazované v hlavičce administrace');
define('SITE_NAME_TXT', 'Název stránky');
define('USERS_PASSWORD_CONSTRAINT_HELPER', '<a href="https://www.phpformbuilder.pro/documentation/jquery-plugins.php#passfield-example">Zde jsou vysvětleny vzory hesel</a>');
define('USERS_PASSWORD_CONSTRAINT_TXT', 'Omezení hesla pro nové uživatelské účty');
