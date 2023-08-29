<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BornDigital
 */

defined("ABSPATH") || die("Can't access directly"); ?>

    <div class="alert"><!-- class is-error, is-success, is-wraning, no extra class for blue color !-->
        <div class="alert__inner">
            <div class="alert__content">
                <h4 id="global-alert-title" class="alert__title"></h4>  
                <span id="global-alert-body"></span>
            </div>    
            <button class="alert__close btn btn--secondary btn--c-white" title="Button label">
                <span id="global-alert-btn"></span>
            </button>              
        </div>
    </div> 
  </div>
  <!-- /.site: the opening tag is in header.php -->

  <?php wp_footer(); ?>

</body>
</html>
