<?php
require_once  'app/funcion.php';
//no se pude tocar ya que de aqui se cargan las imagenes 
$data =
  [

    'productos' => get_producto()
  ];
  //session_destroy();
//add_to_cart(9);
//print_r(calcular_total());
//$producto=get_product_by_id(8);
//print_r($_SESSION);
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <script src="https://kit.fontawesome.com/af3c92f683.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="waitMe/waitMe.min.css">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <meta name="theme-color" content="#fafafa">
</head>

<body>

  <?php
  //  esta linea la ejecutamos para visualizar la cabecera del proyecto
  require_once 'assets/includes/inc_header.php';
  ?>

  <main class="contenedor clearfix">
    <?php foreach ($data['productos'] as $p) : ?>
      <div class="contenido">
        <img src="<?php echo $p['imagen']; ?>" alt=<?php echo $p['nombre']; ?>>
        <p><?php echo $p['nombre']; ?></p>
        <p><?php echo $p['precio']; ?></p>
        <button class="boton btn-agregar" data-cantidad="1" data-id="<?php echo $p['id']; ?>"> agregar al carrito</button>
      </div>
    <?php endforeach; ?>

    <section class="carrito">
      <h2>carrito</h2>
      <div id="cart-wrapper">

      </div>
    </section>
  </main>


  <?php
  // esta linea la ejecutamos para llamar el final de la pagina
  require_once 'assets/includes/inc_footer.php'

  ?>


  <script src="js/vendor/modernizr-3.8.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')
  </script>
  <script src="js/plugins.js"></script>
  <!-- swee alert libreria para alertas -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <!-- waitMe libreria para cargas -->
  <script src="waitMe/waitMe.min.js"></script>

  <script src="js/main.js"></script>


  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function() {
      ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>