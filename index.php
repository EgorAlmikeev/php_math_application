<?php
  require 'vendor/autoload.php';
  
  use Symfony\Component\HttpFoundation\Response;

  //const app = express();
  $app = new Silex\Application();
  $hdrs = function ($req, $res) {
    $res->headers->set('Access-Control-Allow-Origin', '*');
  };

  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
  ));

  $app->get('/', function () use($app) {
    return $app['twig']->render('home.twig', array(
      'content' => 'Welcome!'
    ));  
  });

  $app->get('/add/{n1}/{n2}', function ($n1, $n2) use($app) {
    return '<h2>Сумма равна: </h2><h3>' . $n1 . '+' . $n2 . '=' . ($n1 + $n2) . '</h3>'; 
  })->after($hdrs);

  $app->get('/mpy/{n1}/{n2}', function ($n1, $n2) use($app) {
    return '<h2>Произведение равно: </h2><h3>' . $n1 . '*' . $n2 . '=' . ($n1 * $n2) . '</h3>'; 
  })->after($hdrs);

  $app->get('/sub/{n1}/{n2}', function ($n1, $n2) use($app) {
    return '<h2>Разность равна: </h2><h3>' . $n1 . '-' . $n2 . '=' . ($n1 - $n2) . '</h3>'; 
  })->after($hdrs);
  
  $app->get('/div/{n1}/{n2}', function ($n1, $n2) use($app) {
    return '<h2>Частное равно: </h2><h3>' . $n1 . '/' . $n2 . '=' . ($n1 / $n2) . '</h3>'; 
  })->after($hdrs);

  $app->get('/pow/{n1}/{n2}', function ($n1, $n2) use($app) {
    return '<h2>Степень равна: </h2><h3>' . $n1 . '^' . $n2 . '=' . (pow($n1, $n2)) . '</h3>'; 
  })->after($hdrs);
  
  $app->get('/author', function () use($app) {
    return '<h4 id="author" title="GossJS">EgorAlmikeev</h4>'; 
  })->after($hdrs);
   

  $app->error(function ($e) use($app) {
    if ($e instanceof Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
      return new Response($app['twig']->render('404.twig'), 404);
    } else {
      return new Response($app['twig']->render('500.twig'), 500);
    };
  });

  $app->run();