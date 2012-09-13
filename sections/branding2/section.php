<?php
/*
	Section: ToukBranding
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Shows the main site logo or the site title and description.
	Class Name: PageLinesToukBranding
	Workswith: header 
*/

/**
 * ToukBranding Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class PageLinesToukBranding extends PageLinesSection
{

    /**
     * Before Section Template
     *
     * For template code that should show before the standard section markup
     *
     * @since   ...
     *
     * @param   null $clone_id
     */
    function before_section_template( $clone_id = null ){
        ?>
        <div class="section-wrap branding2-wrap">
        <?php
    }

    /**
     * After Section Template
     *
     * For template code that should show after the standard section markup
     *
     * @since   ...
     *
     * @param   null $clone_id
     */
    function after_section_template( $clone_id = null ){
        ?>
        </div>
        <?php
    }

    /**
     * Before Section
     *
     * Starts general section wrapper classes content and content-pad; adds class to uniquely identify clones
     * Dynamically creates unique hooks for section: pagelines_before_, pagelines_outer_, and pagelines_inside_top_
     *
     * @since       ...
     *
     * @param       string $markup
     * @param       null $clone_id
     * @param       string $classes
     *
     * @internal    param string $conjugation
     *
     * @uses        pagelines_register_hook
     */
	function before_section( $markup = 'content', $clone_id = null, $classes = ''){
        parent::before_section( $markup, $clone_id, $classes);
    }

    /**
     * Section template.
     */
    function section_template() {
        enqueue_coffeescript('branding2', $this->base_dir . '/branding.coffee', array('jquery'), false, false);
    ?>
        <div class="branding2_wrap">
            <div class="header-content">
                <div class="logo">
                    <div class="inner"><?php pagelines_main_logo()?></div>
                </div>
                <div class="title">
                    <div class="inner"><?php echo get_bloginfo('name')?> <span class="subtitle" style="display: none; "></span>
                    </div>
                </div>
                <div class="line">
                    <div class="inner"></div>
                </div>
                <div class="about">
                    <div class="inner"><?php echo get_bloginfo('description')?></div>
                </div>
                <div class="deco">
                    <div class="inner">
                        <div class="lang">
                            <span>język</span>
                            <ul>
                                <li class="pl selected">polski</li>
                                <li class="en">english</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                pagelines_register_hook('pagelines_before_branding_icons', 'branding'); // Hook

                printf('<div class="icons" style="bottom: %spx; right: %spx;">', intval(pagelines_option('icon_pos_bottom')), pagelines_option('icon_pos_right'));

                pagelines_register_hook('pagelines_branding_icons_start', 'branding'); // Hook

                if (ploption('rsslink'))
                    printf('<a target="_blank" href="%s" class="rsslink"><img src="%s" alt="RSS"/></a>', apply_filters('pagelines_branding_rssurl', get_bloginfo('rss2_url')), $this->base_url . '/rss.png');

//                if (VPRO) {
//                    if (ploption('twitterlink'))
//                        printf('<a target="_blank" href="%s" class="twitterlink"><img src="%s" alt="Twitter"/></a>', ploption('twitterlink'), $this->base_url . '/twitter.png');
//
//                    if (ploption('facebooklink'))
//                        printf('<a target="_blank" href="%s" class="facebooklink"><img src="%s" alt="Facebook"/></a>', ploption('facebooklink'), $this->base_url . '/facebook.png');
//
//                    if (ploption('linkedinlink'))
//                        printf('<a target="_blank" href="%s" class="linkedinlink"><img src="%s" alt="LinkedIn"/></a>', ploption('linkedinlink'), $this->base_url . '/linkedin.png');
//
//                    if (ploption('youtubelink'))
//                        printf('<a target="_blank" href="%s" class="youtubelink"><img src="%s" alt="Youtube"/></a>', ploption('youtubelink'), $this->base_url . '/youtube.png');
//
//                    if (ploption('gpluslink'))
//                        printf('<a target="_blank" href="%s" class="gpluslink"><img src="%s" alt="Google+"/></a>', ploption('gpluslink'), $this->base_url . '/google.png');
//
//                    pagelines_register_hook('pagelines_branding_icons_end', 'branding'); // Hook
//
//                }
                printf('</div>');
            ?>
        </div>
        <?php pagelines_register_hook('pagelines_after_branding_wrap', 'branding'); // Hook ?>
        <script type="text/javascript">
            jQuery('.icons a').hover(function () {
                jQuery(this).fadeTo('fast', 1);
            }, function () {
                jQuery(this).fadeTo('fast', 0.5);
            });
        </script>
    <?php
    }
}
