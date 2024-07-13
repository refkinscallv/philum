<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title><?= $appName ?></title>
    <link rel="shortcut icon" href="<?= $appLogo ?>" type="image/png">

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Remix Icon 4.2.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">

    <!-- Highlight.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>hljs.highlightAll();</script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            scrollbar-width: thin;
            scrollbar-color: #3c7782 var(--bs-white);
        }
        *::-webkit-scrollbar {width: 12px}
        *::-webkit-scrollbar-track {background: var(--bs-white)}
        *::-webkit-scrollbar-thumb {background-color: #3c7782;border: 3px solid var(--bs-white)}

        .selector-for-some-widget {box-sizing: content-box}

        body, html {
            position: relative;
            width: 100%;
            margin: auto;
            font-family: 'Quicksand', sans-serif !important;
            font-size: 15px !important;
            color: var(--bs-gray-900)
        }

        a {
            color: #5574FF;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: .3s
        }

        a:hover {
            color: var(--bs-danger);
            text-decoration: none !important
        }

        .main-color {
            color: #5574FF !important
        }

        pre {
            margin: 0px !important;
            padding: 0px !important;
            white-space: pre;
        }

        code {
            margin: 0px !important;
            padding: 0px !important;
        }
    </style>

</head>
<body class="bg-light vh-100 w-100 m-auto overflow-auto position-relative">
    
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a href="https://philum.callvgroup.net/" class="navbar-brand" target="_blank">
            <img src="<?= $appLogo ?>" alt="<?= $appName ?>" height="25" class="d-inline-block align-text-middle" title="<?= $appName ?>">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="https://philum.callvgroup.net/" target="_blank"><i class="ri-home-line"></i>&nbsp; Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://philum.callvgroup.net/docs/v1/" target="_blank"><i class="ri-book-2-line"></i>&nbsp; Docs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://philum.callvgroup.net/forums/" target="_blank"><i class="ri-discuss-line"></i>&nbsp; Forum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/refkinscallv/philum" target="_blank"><i class="ri-github-fill"></i>&nbsp; Contribute</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container my-5">
    
<!-- Header -->
<header class="fw-thin">
    <h1 class="fw-light">Welcome To <span class="fw-bold"><?= $appName ?></span></h1>
    <p class="fs-4"><?= $appDesc ?></p>
    <hr>
    <p>Fast configuration, only 3 steps to create cool web application :</p>
    <p class="mb-5"><i class="ri-sparkling-fill"></i>&nbsp; <b>Create Controller File</b> &nbsp;<i class="ri-arrow-right-s-line"></i>&nbsp; <b>Create View File</b> &nbsp;<i class="ri-arrow-right-s-line"></i>&nbsp; <b>Set Route</b></p>
</header>

<!-- Section # Create Controller File -->
<section class="mb-5">
    <h3 class="fw-light main-color">1. Create <b>Controller</b> File</h3>
    <p>Open the <code class="fw-bold mx-2">apps/Controllers/</code> folder, then create a new file. Example, <code class="fw-bold mx-2">apps/Controllers/Welcome.php</code></p>
    <pre><code class="language-php">
    &lt;?php

        namespace Philum\App\Controllers;

        use \Philum\BaseController;

        class Welcome extends BaseController {

            public function __construct() {
                parent::__construct();
            }

            public function index() {
                $this-&gt;outputView-&gt;render(&quot;welcome&quot;, [
                    &quot;appLogo&quot; =&gt; &quot;https://philum.callvgroup.net/images/philum_logo.png&quot;,
                    &quot;appName&quot; =&gt; &quot;Philum&quot;,
                    &quot;appDesc&quot; =&gt; &quot;Traditional PHP Framework with MVC Architecture, Routing and Query Builder&quot;
                ]);
            }

        }
    </code></pre>
</section>

<!-- Section # Create View File -->
<section class="mb-5">
    <h3 class="fw-light main-color">2. Create <b>View</b> File</h3>
    <p>Open the <code class="fw-bold mx-2">apps/Views/</code> folder, then create a new file. Example, <code class="fw-bold mx-2">apps/Views/welcome.php</code></p>
    <pre><code class="language-php">
    &lt;!DOCTYPE html&gt;
    &lt;html lang=&quot;en&quot;&gt;
    &lt;head&gt;

        &lt;meta charset=&quot;UTF-8&quot;&gt;
        &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;

        &lt;meta content=&quot;&lt;?= $appDesc ?&gt;&quot; name=&quot;description&quot;&gt;

        &lt;title&gt;&lt;?= $appName ?&gt;&lt;/title&gt;

        &lt;link rel=&quot;shortcut icon&quot; href=&quot;&lt;?= $appLogo ?&gt;&quot; type=&quot;image/png&quot;&gt;

    &lt;/head&gt;
    &lt;body&gt;
        
        &lt;h1&gt;Hello World!&lt;/h1&gt;

    &lt;/body&gt;
    &lt;/html&gt;
    </code></pre>
</section>

<!-- Section # Set Route -->
<section class="mb-5">
    <h3 class="fw-light main-color">3. Set <b>Route</b></h3>
    <p>Last step, set the route by indicating the URL path where your page will be displayed. Open the <code class="fw-bold mx-2">apps/Routes.php</code> file.<b>
    <pre><code class="language-php">
    &lt;?php

        namespace Philum\App;

        use Philum\Router\Router AS SysRouter;

        class Routes {

            /**
            * @var SysRouter $route
            */
            private SysRouter $route;

            public function __construct() {
                $this-&gt;route = new SysRouter();
            }
            
            public function set() {
                /* Other routes implemented...  */

                /**
                * ----------------------------------------------------------
                * setDefault
                * Set default controller for the application
                * 
                * @param string | apps/Controllers/File/ | Class@Method
                * @param boolean | Allowed paremeter or not
                * ----------------------------------------------------------
                */
                $this-&gt;route-&gt;setDefault(&quot;Welcome@index&quot;, false);

                /**
                * Add a new route here, adjust the URL Path, Controller Class@method and parameter permissions.
                *
                * set()
                * Set url path for the controller
                * 
                * @param string | URL path
                * @param string | apps/Controllers/File | Class@Method
                * @param boolean | Allowed paremeter or not
                */
                
                $this-&gt;route-&gt;set(&quot;/about&quot;, &quot;Page@about&quot;, true);

                /* Other routes implemented...  */
            }
        }
    </code></pre>
</section>

<footer class="d-flex text-secondary align-items-center justify-content-between">
    <div>
        &copy; <a href="https://callvgroup.net" class="fw-bold">Callv Group</a> 2024
    </div>
    <div>
        Version <b>1.2.2</b>
    </div>
</footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>