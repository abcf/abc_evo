<?php
require('conexiones/config.php');


//Conexion a la BASE DE DATOS
$db = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB);
if (!$db) { exit('Imposible conectar con la base de datos.'); }

require('conexiones/config.inc.php');
require('includes/url_factory.inc.php');
require('includes/func_gestion.php');
require('includes/func_listados.php');

 // Variable de sesion del CART
 (isset($_SESSION['cart'])) ? $cart=$_SESSION['cart'] : $cart=false;
 // Variable de sesion retorno del CART
 $_SESSION['url'] = SITE_DOMAIN;

 // Query BANNERS
 $sql_banner = "SELECT f.id, f.franquicia, b.categoria_id, c.categoria, a.imagen
                FROM franquicias f, categorias_link b, categorias c, publicidad a, tipo_publicidad t
                WHERE f.estado = '1'
                AND f.id = b.franquicia_id
                AND b.categoria_id = c.id
                AND f.id = a.id_franquicia
                AND a.estado = '1'
                AND a.id_tipo = '5'
                AND a.id_tipo = t.id
                AND (
                      ( CURDATE() >= a.fecha_inicio AND CURDATE() < ADDDATE(a.fecha_inicio, INTERVAL t.duracion MONTH ) )
                      OR
                      ( a.cortesia AND CURDATE() < a.fecha_inicio AND CURDATE() >= ADDDATE(a.fecha_inicio, INTERVAL ".DIAS_CORTESIA." DAY ))
                    )
                GROUP BY f.id ORDER BY RAND() LIMIT 2";
 $result_banner = mysqli_query($db,$sql_banner);

 if (mysqli_num_rows($result_banner) > 0)
 {
    $i=0;
    while ($row_banner = mysqli_fetch_assoc($result_banner))
    {
      $banner = '';

      $imagen = $row_banner['imagen'];
      $ext = strrchr($imagen,'.');

      if ($ext == '.swf')
      {
        $banner = "<script type='text/javascript'>runSWF('".SITE_DOMAIN."'/img/banners/".$imagen."', 600, 100,'6,0,29,0', '#ffffff');</script>";
        ++$i;
      }
      else
      {
        $banner = '<a href="';
        $banner.= crear_url_franquicia($row_banner['categoria'], $row_banner['categoria_id'], $row_banner['franquicia'], $row_banner['id']);
        $banner.= '">';
        $banner.= '<img src="'.SITE_DOMAIN.'/img/banners/'.$imagen.'" class="banner" width="591" height="90" title="'.$row_banner['franquicia'].' - Franquicias de '.$row['categoria'].'" alt="'.$row['franquicia'].' - Franquicias de '.$row['categoria'].'">';
        $banner.= "</a>";
        ++$i;
      }
      if ($i==1) { $banner1 = $banner; } else { $banner2 = $banner; }
    }
  }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <meta name="robots" content="noindex,nofollow">

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Franquicias y Oportunidades de Negocio en Espa&ntilde;a <?php echo date('Y');?></title>
  <meta name="description" content="ABC FRANQUICIAS, directorio buscador de franquicias en Espa&ntilde;a. Encuentre las mejores oportunidades de negocio en la mayor guia de la franquicia">
  <meta name="author" content="ABCFRANQUICIAS MEDIA S.L.">
  <meta name="keywords" content="franquicias, espa&ntilde;a, oportunidades, negocio, franquicia, <?php echo date('Y');?>">

  <!-- Optimized mobile viewport -->
  <meta name="viewport" content="width=device-width">

  <!-- favicon.ico and apple-touch-icon.png in the root directory -->
  <link rel="shortcut icon" href="img/iconos/favicon.ico">
  <link rel="apple-touch-icon" href="img/iconos/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/iconos/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/iconos/apple-touch-icon-114x114.png">

  <!-- Css -->
  <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />

  <!-- Search Engine Verification -->
  <meta name="google-site-verification" content="nNfyfDUgu_zxGjFJDR1m5TNXTaT5gH1rl8niqnfNEic"><!--es-->
  <meta name="google-site-verification" content="eCVZvjSeqoY5uGlHLLOwSK5DGK-Oq36Q71YUXV_xs5g"><!--com-->
  <meta name="msvalidate.01" content="6B1E552DE87ED53A9AAC173A5AC19F40"><!--B-->
  <meta name="y_key" content="6ece37c267a7f2e6"><!--Y-->
  <meta content="WeLqOUIsElXzHa95iXzS2jeIryc"><!--A-->

  <!-- Modernizr enables HTML5 elements & feature detects for optimal performance -->
  <script src="js/libs/modernizr-2.6.1.min.js"></script>
  <!-- Polyfills -->
  <!--[if lt IE 10]><script type="text/javascript" src="js/libs/PIE.htc"></script><![endif]-->
</head>

<body>
<!--[if lt IE 7]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]-->

<div id="main-wrap" class="shadow">

  <header id="header-wrap">
    <div class="header-content">
      <img src="img/web/transparente.png" class="sprite logo" alt="xxxx">
      <h1>Franquicias y Oportunidades de Negocio</h1>
      <p>Directorio de referencia para la b&uacute;squeda de <strong>franquicias en Espa&ntilde;a</strong>.</p>
      <ul id="css3" class="social">
        <li class="facebook">
          <a href="http://www.facebook.com/"><img src="img/web/transparente.png" class="sprite socialfacebook" alt="xxxx"></a>
        </li>
        <li class="twitter">
          <a href="http://twitter.com/"><img src="img/web/transparente.png" class="sprite socialtwitter" alt="xxxx"></a>
        </li>
        <li class="googleplus">
          <a href="http://digg.com/"><img src="img/web/transparente.png" class="sprite socialgoogleplus" alt="xxxx"></a>
        </li>
        <li class="rss">
          <a href="http://digg.com"><img src="img/web/transparente.png" class="sprite socialrss" alt="xxxx"></a>
        </li>
      </ul>
    </div><!-- header-content -->

    <div class="nav-content">

      <div id="buscador">
        <label>Busqueda por franquicia:</label>
        <input id="autocomplete" class='description_active' value=''>
      </div><!-- buscador -->


      <div id="accordion">
        <label>Busqueda por categor&iacute;a:</label>
        <?php
        // Query familias
        $sql_familia = "SELECT * FROM familias ORDER BY familia";
        $result_familia = mysqli_query($db,$sql_familia);

        if (mysqli_num_rows($result_familia) > 0)
        {
          while ($row_familia = mysqli_fetch_assoc($result_familia))
          {
            $sectores = '<h3><a href="#">'.$row_familia['familia'].'</a></h3>';
            $sectores.= '<ul>';

            // Query categorias
            $sql_categoria = "SELECT p.id, p.categoria
                              FROM categorias p, cat_fam_link pk
                              WHERE p.id = pk.cat_id
                              AND pk.fam_id = '".$row_familia['id']."'";
            $sql_categoria.= " ORDER BY categoria";
            $result_categoria = mysqli_query($db,$sql_categoria);

            if (mysqli_num_rows($result_categoria) > 0)
            {
              while ($row_categoria = mysqli_fetch_assoc($result_categoria))
              {
                $sectores.= '<li>';
                $sectores.= '<a href="';
                $sectores.= crear_url_categoria($row_categoria['categoria'], $row_categoria['id']);
                $sectores.= '" title="Franquicias '.$row_categoria['categoria'].' ">';
                $sectores.= $row_categoria['categoria'];
                $sectores.= '</a>';
                $sectores.= '</li>';
              }
            }

            $sectores.= '</ul>';

            echo $sectores;
          }
        }
        ?>
      </div><!-- accordion -->
    </div><!-- nav-content -->
  </header><!-- header-wrap -->

  <nav id="menu-wrap" class="default">
    <ul id="menu" class="gradient">
    <li><a href="#">Inicio</a></li>
    <li><a href="#">Franquicias</a>
     <ul>
        <?php
        // Query familias
        $sql_familia = "SELECT * FROM familias ORDER BY familia";
        $result_familia = mysqli_query($db,$sql_familia);
        if (mysqli_num_rows($result_familia) > 0)
        {
          while ($row_familia = mysqli_fetch_assoc($result_familia))
          {
            $sectores = '<li>';
            $sectores.= '<a href="#">'.$row_familia['familia'].'</a>';

            // Query categorias
            $sql_categoria = "SELECT p.id, p.categoria
                              FROM categorias p, cat_fam_link pk
                              WHERE p.id = pk.cat_id
                              AND pk.fam_id = '".$row_familia['id']."'";
            $sql_categoria.= " ORDER BY categoria";
            $result_categoria = mysqli_query($db,$sql_categoria);

            if (mysqli_num_rows($result_categoria) > 0)
            {
              $sectores.= '<ul>';
              while ($row_categoria = mysqli_fetch_assoc($result_categoria))
              {
                $sectores.= '<li>';
                $sectores.= '<a href="';
                $sectores.= crear_url_categoria($row_categoria['categoria'], $row_categoria['id']);
                $sectores.= '" title="Franquicias '.$row_categoria['categoria'].' ">';
                $sectores.= $row_categoria['categoria'];
                $sectores.= '</a>';
                $sectores.= '</li>';
              }
              $sectores.= '</ul>';
            }
            $sectores.= '</li>';
            echo $sectores;
          }
        }
        ?>
        <li>
          <a href="">Inversion</a>
          <ul>
            <li><a href="franquicias-inversion-inferior-10000-euros.html" title="franquicias con inversion inferior a 10000 euros">< 10.000 euros</a></li>
            <li><a href="franquicias-inversion-entre-10000-25000-euros.html" title="franquicias con inversion entre 10000 y 25000 euros">10.000 - 25.000 euros</a></li>
            <li><a href="franquicias-inversion-entre-25000-50000-euros.html" title="franquicias con inversion entre 25000 y 50000 euros">25.000 - 50.000 euros</a></li>
            <li><a href="franquicias-inversion-entre-50000-75000-euros.html" title="franquicias con inversion entre 50000 y 75000 euros">50.000 - 75.000 euros</a></li>
            <li><a href="franquicias-inversion-entre-75000-150000-euros.html" title="franquicias con inversion entre 75000 y 150000 euros">75.000 - 150.000 euros</a></li>
            <li><a href="franquicias-inversion-entre-150000-300000-euros.html" title="franquicias con inversion entre 150000 y 300000 euros">150.000 - 300.000 euros</a></li>
            <li><a href="franquicias-inversion-superior-300000-euros.html" title="franquicias con inversion superior 300000 euros">> 300.000 euros</a></li>
          </ul>
        </li>
        <li>
          <a href="">Top</a>
          <ul>
            <li><a href="top-franquicias-comercio.html" title="Las mejores franquicias de comercio">Franquicias de Comercio</a></li>
            <li><a href="top-franquicias-moda.html" title="Las mejores franquicias de moda">Franquicias de Moda</a></li>
            <li><a href="top-franquicias-hosteleria.html" title="Las mejores franquicias de hosteleria">Franquicias de Hosteler&iacute;a</a></li>
            <li><a href="top-franquicias-servicios.html" title="Las mejores franquicias de servicios">Franquicias de Servicios</a></li>
          </ul>
        </li>
        <li>
          <a href="franquicias-baratas.html" title="Franquicias baratas y rentables">Baratas y Rentables</a>
        </li>
        <li>
          <a href="nuevas-franquicias.html" title="Nuevas franquicias">Nuevas Franquicias</a>
        </li>
      </ul>
    </li>

    <li><a href="">Consultoria</a></li>
    <li><a href="">Actualidad</a></li>
    <li><a href="">Ferias</a></li>
    </ul>
  </nav><!-- menu-wrap -->

  <div id="left-wrap">

        <section id="bienvenida">
        <h3>Bienvenido a ABC FRANQUICIAS</h3>
        <article>
          <div class="fondo"></div>
          <p>Directorio de referencia para la b&uacute;squeda de <h1>franquicias</h1> <strong>en Espa&ntilde;a</strong>, donde los emprendedores podr&aacute;n encontrar <strong>oportunidades de negocio</strong> en el modelo de la franquicia.<br /><br />
          Esta gu&iacute;a, ayuda tanto a empresas como a profesionales a conseguir sus objetivos de negocio mediante la generaci&oacute;n de contactos y la posibilidad de informar, comunicar y publicitar su actividad, productos y servicios.
          <!-- Datos como fichas t&eacute;cnicas, descripci&oacute;nes, notas de prensa, y entrevistas aparecer&aacute;n actualizadas en este directorio. -->
          <br /><br />
          Atentamente,<br />
          El equipo de <span class="red">ABC</span> FRANQUICIAS.</p>
          </article>
      </section>

    <div id="logoParade">
      <?php
        $result_tipo = listado_tipo_publicidad(3,0);
        $result_logo_parade = mysqli_query($db,$result_tipo);

        if (mysqli_num_rows($result_logo_parade) > 0)
        {
          while ($row_logo_parade = mysqli_fetch_assoc($result_logo_parade))
          {
            $logo_parade = '<a href="';
            $logo_parade.=  crear_url_franquicia($row_logo_parade['categoria'], $row_logo_parade['categoria_id'], $row_logo_parade['franquicia'], $row_logo_parade['id']);
            $logo_parade.= '">';
            $logo_parade.= '<img src="includes/ver_logo.php?franquicia_id='.$row_logo_parade['id'].'&amp;tam=100"';
            $logo_parade.= ' title="'.$row_logo_parade['franquicia'].' - '.$row_logo_parade['categoria'];

            if (($row_logo_parade['inversion_total']=='0')||($row_logo_parade['inversion_total']==''))
            {
              $logo_parade.= '<br>Inversion: '.$row_logo_parade['inversion_total_obs'].'"';

            } else {

              $logo_parade.= '<br>Inversion: '.number_format($row_logo_parade['inversion_total'],0,'','.').'&euro;"';
            }

            $logo_parade.= 'alt="'.$row_logo_parade['franquicia'].' - Franquicias de '.$row_logo_parade['categoria'].'" />';
            $logo_parade.= '</a>';

            echo $logo_parade;
          }
        }
      ?>
    </div><!-- logoParade -->

    <section id="actualidad">
      <h3 >Actualidad</h3>
      <?php
        $sql_actualidad = "SELECT n.id, n.id_franquicia, n.titulo, n.texto, c.categoria
                           FROM noticias n, categorias_link l, categorias c
                           WHERE n.estado = '1'
                           AND l.franquicia_id = n.id_franquicia
                           AND l.categoria_id = c.id
                           ORDER BY n.fecha DESC LIMIT 8";
        $result_actualidad = mysqli_query($db,$sql_actualidad);

        if (mysqli_num_rows($result_actualidad) > 0)
        {
          $noticianum = 0;
          while ($row_noticia = mysqli_fetch_assoc($result_actualidad))
          {
            $extensiones = array(".jpg"=>"image/jpeg",".gif"=>"image/gif",".png"=>"image/png");

            $imgNews = 0;

            foreach($extensiones as $ext => $mime)
            {
              $ruta_fichero = 'img/noticias/not_'.$row_noticia['id'].$ext;

              if (file_exists($ruta_fichero))
              {
                $imgNews = 1;
                break;
              }
            }

            $noticia = '<article>';
            $noticia.= '<p class="categoria"><strong>'. $row_noticia['categoria'] .'</strong></p>';
	          $noticia.= '<h4><a href="'. make_news_url($row_noticia['id'], $row_noticia['titulo']) .'" rel="bookmark" title="'.$row_noticia['titulo'].'">'.$row_noticia['titulo'].'</a></h4>';

            if ($imgNews)
            {
              $noticia.=  '<div class="imgcontainer"><img src="includes/ver_noticia.php?franquicia_id='.$row_noticia['id'].'&amp;tam=250" alt="'.$row_noticia['titulo'].'" /></div>';
            }

            $noticia.= '<div class="descripcion">'. descripcion($row_noticia['texto']) .'</div>';
            $noticia.= '</article>';

            echo $noticia;
            ++$noticianum;
            if ($noticianum  == 4) {echo '<div id="banner">'.$banner1.'</div>';}
          }
        }
        echo '<div id="banner">'.$banner2.'</div>';
     ?>
    </section><!-- actualidad -->
  </div><!-- left-wrap -->

  <div id="right-wrap">
    <section id="destacados">
     <h3>Destacados</h3>
     <img src="img/web/transparente.png" class="sprite startag" alt="xxxx">
     <article>
       <ul class="acordeon">
          <li><a href="nuevas-franquicias.html" title="Nuevas Franquicias">Nuevas Franquicias</a></li>
          <li><a href="franquicias-baratas.html" title="Franquicias Baratas y Rentables">Baratas y Rentables</a></li>
          <li><span class="bullet"></span><a href="#">Top Franquicias</a>
            <ul>
              <li>Comercio</li>
              <li>Hosteleria</li>
              <li>Moda</li>
              <li>Servicios</li>
            </ul>
          </li>
          <li><span class="bullet"></span><a href="#">Busqueda por Inversion</a>
            <ul>
              <li><a href="franquicias-inversion-inferior-10000-euros.html" title="franquicias con inversion inferior a 10000 euros">Menos de 10.000&euro;</a></li>
              <li><a href="franquicias-inversion-entre-10000-25000-euros.html" title="franquicias con inversion entre 10000 y 25000 euros">Entre 10.000&euro; y 25.000&euro;</a></li>
              <li><a href="franquicias-inversion-entre-25000-50000-euros.html" title="franquicias con inversion entre 25000 y 50000 euros">Entre 25.000&euro; y 50.000&euro;</a></li>
              <li><a href="franquicias-inversion-entre-50000-75000-euros.html" title="franquicias con inversion entre 50000 y 75000 euros">Entre 50.000&euro; y 75.000&euro;</a></li>
              <li><a href="franquicias-inversion-entre-75000-150000-euros.html" title="franquicias con inversion entre 75000 y 150000 euros">Entre 75.000&euro; y 150.000&euro;</a></li>
              <li><a href="franquicias-inversion-entre-150000-300000-euros.html" title="franquicias con inversion entre 150000 y 300000 euros">Entre 150.000&euro; y 300.000&euro;</a></li>
              <li><a href="franquicias-inversion-superior-300000-euros.html" title="franquicias con inversion superior 300000 euros">Mas de 300.000&euro;</a></li>
            </ul>
          </li>
          <li><a href="franquicias-baratas.html" title="Franquicias Baratas">Franquicias Baratas</a></li>
        </ul>
      </article>
    </section><!-- destacados -->

    <div id="cart">
      <h3>FRANQUICIAS SELECCIONADAS</h3>
      <img src="img/web/franquicias_seleccionadas.png" width="111" height="111" alt="xxxxx">
      <p>Todav&iacute;a no ha seleccionado ninguna franquicia.</p>
    </div><!-- cart -->



    <div class="consultoria">
      <img src="img/consultoria/mundofranquicia_2.png" width="298" height="220" alt="xxxxx">
    </div><!-- End Consultoria -->

    <div class="consultoria">
      <!-- <img src="img/web/10razones.jpg" width="350" height="170" alt="xxxxxx"> -->
    </div><!-- End 10 razones -->

    <aside class="multimedia"><!-- Begin Multimedia -->
      <iframe width="100%" height="240" src="http://www.youtube.com/embed/-6gtR9jxQNk" frameborder="0"></iframe>
      <?php
          $cab = '<p class="cab">prlinpadel</p>';
          $cab.= '<p class="cab1">Entrevista</p>';
          $cab.= '<p class="cab2">Responsable de ComunicaciÃ³n</p>';

          echo $cab;
      ?>
    </aside><!-- Multimedia -->
  </div><!-- right-wrap -->

  <footer>
    <p>Franquicias y Opotunidades de Negocio en Espa&ntilde;a</p>
  </footer><!-- footer -->

</div><!-- main-wrap -->





  <!-- Scripts -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.0.min.js"><\/script>')</script>

  <!-- scripts concatenated and minified via build script -->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>



  <!-- Logo Parade -->
  <script src="js/libs/jquery-ui-1.8.23.custom.min.js"></script>
  <script src="js/libs/jquery.mousewheel.min.js"></script>
  <script src="js/libs/jquery.smoothdivscroll-1.3-min.js"></script>

  <!-- List expand/collapse -->
   <script src="js/libs/jquery.collapse.js"></script>


  <!-- Accordion & Autocomplete -->
   <script src="js/libs/jquery-ui-1.9.0.custom.min.js"></script>

  <!-- jQuery UI Widget and Effects Core (custom download) Tooltips -->
  <script src="js/libs/jquery.tools.min.js"></script>
  <!-- jQuery Text Shadow for IE9, 8, 7 (heygrady)  -->
  <script src="js/libs/jquery.textshadow.js"></script>

  <!-- Plugin initialization -->
  <script>
  $(function() {
    /* Menu */
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
    {
    $('li').has('ul').mouseover(function(){
      $(this).children('ul').css('visibility','visible');
      }).mouseout(function(){
      $(this).children('ul').css('visibility','hidden');
      })
    }

    var menu = $('#menu-wrap'),
        pos = menu.offset();


      $(window).scroll(function(){
        if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
          menu.fadeOut('fast', function(){
            $(this).removeClass('default').addClass('fixed').fadeIn('fast');
          });
        } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
          menu.fadeOut('fast', function(){
            $(this).removeClass('fixed').addClass('default').fadeIn('fast');
          });
        }
      });



    $('ul.acordeon li ul').hide();

    $('ul.acordeon li a').click(function(e){

        $('ul.acordeon li a').each(function(i){
            if($(this).next().is("ul") && $(this).next().is(":visible")){
                $(this).next().slideUp("fast");
            }
        });

        var e = $(e.target);

        if(e.next().is("ul") && e.next().is(":visible")){
            e.next().slideUp("fast");
            } else {
            e.next().slideDown("fast");
        }
    });





    /* Mobile */
    $('#menu-wrap').prepend('<div id="menu-trigger" class="default">MENU</div>');
    $("#menu-trigger").on("click", function(){
      // $('html,body').animate({scrollTop: 0}, 1000);

      $("#menu").slideToggle();



    });

    // iPad
    var isiPad = navigator.userAgent.match(/iPad/i) != null;
    if (isiPad) $('#menu ul').addClass('no-transition');


  //   if (!Modernizr.textshadow) {
  //      $('header').textshadow('2px 2px 2px #555');
  //   }






  //   // Tooltip - create custom animation algorithm for jQuery called "bouncy"
  //   $.easing.bouncy = function (x, t, b, c, d) {
  // 	  var s = 1.70158;
  // 	  if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
  // 	  return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
  //   }
  //   // create custom Tooltip effect for jQuery Tooltip
  //   $.tools.tooltip.addEffect(
  // 	  "bouncy",
  //   // Tooltip opening animation
  //   function(done) {
  // 	  this.getTip().animate({top: '+=15'}, 500, 'bouncy', done).show();
  //   },
  //   // Tooltip closing animation
  //   function(done) {
  // 	  this.getTip().animate({top: '-=15'}, 500, 'bouncy', function()  {
  // 	  $(this).hide();
  // 	  done.call();
  // 	  });
  //   });
  //   // Tooltip
  //   $("#franquiciasRentables img[title]").tooltip({effect: 'bouncy'});





  });
  </script>
  <!-- end scripts -->

  <!-- Asynchronous Google Analytics snippet.-->
  <script>
    var _gaq=[['_setAccount','UA-10279679-1'],['_trackPageview']];
    setTimeout('_gaq.push([\'_trackEvent\', \'NoBounce\', \'Over 20 seconds\'])',20000);
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
</body>
</html>