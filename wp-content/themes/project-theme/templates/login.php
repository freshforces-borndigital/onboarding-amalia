<?php
/**
 * Template Name: Login
 */

defined("ABSPATH") || die("Can't access directly");

get_header();
?>

    <div class="app" id="landingpage">
        <div class="app__page landingpage">
            <div class="app__bg" style="background-image: url(<?= THEME_URL . "/assets/images/" ?>bg.jpg"></div>
            <?php get_template_part("partials/components/comp", "grid"); ?>
            <div class="app__content">
                <div class="container">
                    <div class="landingpage__content" id="login">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub"><?= __("Welkom bij", "asmlanm"); ?></span>
                                <span class="landingpage__title--text">
                                    <?= __("ASML AM Conversation tool", "asmlanm"); ?>
                                </span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
                                <?= __("Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.", "asmlanm"); ?>
                            </div>

                            <div class="landingpage__actions">
                                <button type="button"  class="btn btn--primary btn--c-blue btn--icon-after js-login-dummy" title="<?= __(
                                    "Create a new team",
                                    "asmlanm"
                                ) ?>">
                                    <i class="amicon  amicon-arrow-right icon"></i>
                                    <span><?= __("Login to ASML", "asmlanm"); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>                         
            <?php get_template_part("partials/components/comp", "curtain"); ?>
        </div>
    </div>

    
    <div class="alert"><!-- class is-error, is-success, is-wraning, no extra class for blue color !-->
        <div class="alert__inner">
            <div class="alert__content">
                <h4 class="alert__title"><?= __("Succes message title", "asmlanm"); ?></h4>
                <span><?= __("Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.", "asmlanm"); ?></span>
            </div>    
            <button class="alert__close btn btn--secondary btn--c-white" title="Button label">
                <span><?= __("Ok! great", "asmlanm"); ?></span>
            </button>              
        </div>
    </div>   

<?php
get_sidebar();
get_footer();
