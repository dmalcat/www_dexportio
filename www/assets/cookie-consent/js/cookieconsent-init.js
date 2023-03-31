// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    current_lang: document.documentElement.getAttribute('lang'),
    autoclear_cookies: false,                   // default: false
    //theme_css: '../assets/cookie-consent/css/cookieconsent.css',
    cookie_name: 'cookie_consent',              // default: 'cc_cookie'
    cookie_expiration: 365,                     // default: 182
    page_scripts: true,                         // default: false
    force_consent: false,                       // default: false

    // auto_language: null,                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                           // default: true
    // delay: 0,                                // default: 0
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: '/',                        // default: root
    // cookie_same_site: 'Lax',
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud',                    // box,cloud,bar
            position: 'bottom center',          // bottom,middle,top + left,right,center
            transition: 'slide'                 // zoom,slide
        },
        settings_modal: {
            layout: 'box',                      // box,bar
            position: 'center',                   // right,left (available only if bar layout selected)
            transition: 'slide'                 // zoom,slide
        }
    },

    onAccept: function (cookie) {
    },

    onChange: function (cookie, changed_preferences) {
        // If analytics category's status was changed ...
        if (changed_preferences.indexOf('analytics') > -1) {

            // If analytics category is disabled ...
            if (!cc.allowedCategory('analytics')) {

                // Disable gtag ...
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('consent', 'default', {
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied'
                });
            }
        }
    },

    languages: {
        'cs': {
            consent_modal: {
                title: 'Freshbang používá cookies.',
                description: 'Jsou to malé soubory, díky kterým vám web nabídne jen takový obsah, který očekáváte, nebude vás obtěžovat věcmi, které vás nezajímají a vy tak najdete to, co hledáte. Aby to tak opravdu bylo, potřebujeme od vás souhlas s ukládáním cookies do vašeho prohlížeče.',
                primary_btn: {
                    text: 'OK, souhlasím',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Nastavení',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Vážený uživateli, smluvní podmínky se od vaší poslední návštěvy změnily!'
            },
            settings_modal: {
                title: 'Nastavení cookies',
                save_settings_btn: 'Přijmout vybrané',
                accept_all_btn: 'Přijmout vše',
                reject_all_btn: 'Odmítnout vše',
                close_btn_label: 'Zavřít',
                blocks: [
                    {
                        title: 'K čemu jsou dobré cookies?',
                        description: 'Cookies jsou malé textové soubory, které mohou být používány webovými stránkami pro efektivnější zobrazování toho, co vás zajímá. <br><br> Některé cookies jsou používány samotnou webovou stránkou, jiné jsou umístěny třetími stranami, jejichž služby se na webu mohou objevovat. <br><br> Nově zákon nařizuje, abychom pro použití webu od od každého návštěvníka získali souhlas s používání cookies v těchto kategoriích:'
                    }, {
                        title: 'Nezbytné soubory cookie',
                        description: 'Tyto soubory neukládají žádné osobní identifikovatelné informace, web je ale ke svému fungování potřebuje. Nelze je vypnout.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Statistické soubory cookies',
                        description: 'Pro zlepšování výkonu stránky, sledování zdrojů a počtu návštěvníků webu využíváme anonymizované souhrnné statistické cookie.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                    }, {
                        title: 'Marketingové soubory cookies',
                        description: 'Kvůli přizpůsobení povahy zobrazovaných reklam a naopak zabránění zobrazování obsahu, který pro vás není relevantní a nemusel by vás zajímat, potřebujeme souhlas s marketingovými cookies. ',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                    }
                ]
            }
        }
    }
});