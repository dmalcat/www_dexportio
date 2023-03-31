<?php

$exceptions = array(
	'::1',           // local
	'127.0.0.1',     // local
	'192.168.0..*',  // intranet
);
if (preg_match('/^(' . implode('|', $exceptions) . ')$/', $_SERVER['REMOTE_ADDR'])) {
	return; // let's see the web
}

header('HTTP/1.1 503 Service Unavailable');
header('Retry-After: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 10));
header('Refresh: 10');

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex, nofollow">
        <title>Prosíme o strpení, aktualizujeme...</title>

        <style type="text/css">
            html, body {
                width: 100%;
                height: 100%;
                padding: 0;
                margin: 0;
                font-size: 16px;
                font-family: Helvetica, Arial, sans-serif;
                color: black;
                background: white;
            }

            .cover {
                position: relative;
                width: 100%;
            }

            .cover .cover__wrapper {
                position: absolute;
                top: 5rem;
                left: 50%;
                transform: translateX(-50%);
            }

            .cover .cover__image {
                display: block;
                max-width: 1920px;
                width: 100%;
            }

            .cover .cover__logo {
                display: block;
                max-width: 115px;
                width: 100%;
                margin: 0 auto 6rem;
            }

            .cover h1 {
                text-align: center;
                font-size: 2.5rem;
                line-height: 1.2;
                color: #e2001a;
                font-weight: 600;
                margin: 0 -.5em 5rem 0;
            }

            @media screen and (max-width: 600px) {
                .cover h1 {
                    font-size: calc(1.5rem + 1vw);
                }
            }

            p {
                text-align: center;
                font-size: 1.1rem;
                font-weight: 300;
                line-height: 2;
            }
        </style>

    </head>
    <body>

    <section class="cover">
        <div class="cover__wrapper">
            <h1>Aktualizujeme&hellip;</h1>
            <p>
                Prosíme o chvilku strpení.
            </p>
        </div>
    </section>
    </body>
    </html>

<?php

exit;
