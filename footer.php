<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package elexis
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'theme_layout_container', 'container' );
?>

<?php get_sidebar( 'footerfull' ); ?>

<?php get_sidebar( 'footersecondary' ); ?>

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>


<?php
  // @specific-elexis start
  include("config_acdh.php");
  if (ACDH_DEPLOYMENT == "PROD") { /* Matomo tracking only on production */
?>
  <!-- Matomo -->
  <script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="//matomo.apollo.arz.oeaw.ac.at/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', '83']);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <!-- End Matomo Code -->
<?php
  }
  // @specific-elexis end
?>

</body>

</html>

