<?php
/**
 * Template Name: Landingpage
 */

defined("ABSPATH") || die("Can't access directly");

$create_team_code_popup = get_field('create_team_code_popup', 'option');
$forgot_team_code_text = get_field('forgot_team_code_text', 'option');
$landing_page_bg = get_field('landing_page_bg', 'option') ?: THEME_URL . "/assets/images/bg.jpg";

get_header();
?>

    <div class="app" id="landingpage">
        <div class="app__page landingpage">
					<div class="app__bg" style="background-image: url(<?= $landing_page_bg ?>)"></div>
            <?php get_template_part("partials/components/comp", "grid"); ?>
            <div class="app__content">
                <div class="container">
                    <div class="landingpage__content" id="welcome">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub"><?= get_field("homepage_subtitle", "option") ?></span>
                                <span class="landingpage__title--text"><?= get_field(
                                    "homepage_title",
                                    "option"
                                ) ?></span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
                                <?= get_field("homepage_text", "option") ?>
                            </div>

                            <div class="landingpage__actions">
                                <button type="button"  class="btn btn--primary btn--c-blue btn--icon-before js-create-team" title="<?= __(
                                    "For team leads only: create your team",
                                    "asmlanm"
                                ) ?>">
                                    <i class="amicon  amicon-user-group icon"></i>
                                    <span><?= __("For team leads only: create your team", "asmlanm") ?></span>
                                </button>
                                <button type="button"  class="btn btn--secondary btn--c-white js-forgot-team" title="<?= __(
                                    "I forgot my team code",
                                    "asmlanm"
                                ) ?>">
                                    <span><?= __("I forgot my team code", "asmlanm") ?></span>
                                </button>
                                <h5 class="landingpage__actions--separator"><?= __(
                                    "Did you already receive your team code?",
                                    "asmlanm"
                                ) ?></h5>
                                <button type="button"  class="btn btn--primary btn--c-pink btn--icon-before js-join-team" title="<?= __(
                                    "Fill in your travel mix",
                                    "asmlanm"
                                ) ?>">
                                    <i class="amicon  amicon-user-edit icon"></i>
                                    <span><?= __("Fill in your travel mix", "asmlanm") ?></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="landingpage__content" id="teamCreation">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub">
                                    <button type="button"  class="back-btn js-landingpage-back" title="Go back"><i class="amicon amicon-arrow-left"></i><span><?= __(
                                        "Back",
                                        "asmlanm"
                                    ) ?></span></button>
                                </span>
                                <span class="landingpage__title--text"><?= __("Create your team", "asmlanm") ?></span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
                                <?= get_field("create_team_text", "option") ?>
                            </div>

                            <div class="landingpage__actions">
                                <form class="form" id="teamCreation--form">
                                    <div class="fieldgroup">
                                        <input type="email" placeholder="Your ASML e-mail address" id="email"/>
                                    </div>
                                    <div class="fieldgroup">
                                        <span class="tooltip">
                                            <span class="tooltip__icon">?</span>
                                            <span class="tooltip__text">
                                                <?= $create_team_code_popup ?>
                                            </span>
                                        </span>
                                        <input type="text" placeholder="<?= __(
                                            "Team code",
                                            "asmlanm"
                                        ) ?>" id="teamCode"/>
                                        <span class="fieldgroup--separator"></span>
                                        <input type="text" placeholder="<?= __(
                                            "Team name",
                                            "asmlanm"
                                        ) ?>" id="teamName"/>
                                    </div>
                                    <button type="button"  class="btn btn--primary btn--c-blue btn--icon-after js-submit-team" title="<?= __(
                                        "Create your team",
                                        "asmlanm"
                                    ) ?>">
                                        <i class="amicon  amicon-check icon"></i>
                                        <span><?= __("Create your team", "asmlanm") ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="landingpage__content" id="joinTeam">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub">
                                    <button type="button"  class="back-btn js-landingpage-back" title="Go back"><i class="amicon amicon-arrow-left"></i><span><?= __("Back", "asmlanm")?></span></button>
                                </span>
                                <span class="landingpage__title--text"><?= __("Enter your team code", "asmlanm") ?></span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
                                <?= get_field("enter_team_text", "option") ?>
                            </div>

                            <div class="landingpage__actions">
                                <form class="form" id="joinTeam--form">
                                    <div class="fieldgroup">
                                        <input type="text" placeholder="<?= __(
                                            "Team Code",
                                            "asmlanm"
                                        ) ?>" id="team-code"/>
                                    </div>
                                    <button type="button"  class="btn btn--primary btn--c-pink btn--icon-after js-submit-join-team" title="<?= __(
                                        "Submit",
                                        "asmlanm"
                                    ) ?>">
                                        <i class="amicon  amicon-check icon"></i>
                                        <span><?= __("Submit", "asmlanm") ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="landingpage__content" id="forgotTeam">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub">
                                    <button type="button"  class="back-btn js-landingpage-back" title="Go back"><i class="amicon amicon-arrow-left"></i><span><?= __(
                                        "Back",
                                        "asmlanm"
                                    ) ?></span></button>
                                </span>
                                <span class="landingpage__title--text"><?= __("Resend Team Code", "asmlanm") ?></span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
																<?= $forgot_team_code_text ?>
                            </div>

                            <div class="landingpage__actions">
                                <form class="form" id="forgotTeam--form">
                                    <div class="fieldgroup">
                                        <input type="email" placeholder="Email address" id="email-forgot"/>
                                    </div>
                                    
                                    <button type="button"  class="btn btn--primary btn--c-blue btn--icon-after js-submit-forgotTeam" title="<?= __(
                                        "Send Link and Team Code",
                                        "asmlanm"
                                    ) ?>">
                                        <i class="amicon  amicon-check icon"></i>
                                        <span><?= __("Send Link and Team Code", "asmlanm") ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="teamNotification">                
                <button type="button" class="close-btn js-landingpage-back" title="Go back"><?= __(
                    "Close",
                    "asmlanm"
                ) ?></button>

                <div class="teamNotification__inner">
                    <div class="teamNotification__content">
                        <header class="landingpage__intro">
                            <h1 class="landingpage__title">
                                <span class="landingpage__sub"><?= __("Your team has been created", "asmlanm") ?></span>
                                <span id="new-team-name" class="landingpage__title--text"></span>
                            </h1>
                        </header>

                        <div class="landingpage__body">
                            <div class="entrycontent">
                                <?= __(
                                    "We've sent you an e-mail with your team code, team name and the link to your team page. Read the instruction in the email how to invite your team members.",
                                    "asmlanm"
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php get_template_part("partials/components/comp", "curtain"); ?>
        </div>
    </div>

<?php
get_sidebar();
get_footer();
