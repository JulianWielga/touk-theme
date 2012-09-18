<?php
/*
	Section: ToukSocial
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: Shows the main site logo or the site title and description.
	Class Name: PageLinesToukSocial
	Workswith: header, footer, sidebar1, sidebar2, sidebar_wrap, templates, main, morefoot
*/

/**
 * ToukSocial Section
 *
 * @package PageLines Framework
 * @author PageLines
 */
class PageLinesToukSocial extends PageLinesSection
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
//    function before_section_template( $clone_id = null ){}

    /**
     * After Section Template
     *
     * For template code that should show after the standard section markup
     *
     * @since   ...
     *
     * @param   null $clone_id
     */
//    function after_section_template( $clone_id = null ){}

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
//	function before_section( $markup = 'content', $clone_id = null, $classes = ''){
//        parent::before_section( $markup, $clone_id, $classes);
//    }

    /**
     * Section template.
     */
    function section_template() {
    ?>
        <div class="toukSocial_wrap">
            <?php
                pagelines_register_hook('pagelines_before_social_icons', 'toukSocial'); // Hook

                printf('<div class="social-icons">');

                pagelines_register_hook('pagelines_social_icons_start', 'toukSocial'); // Hook

                if (ploption('rsslink'))
                    printf('<a target="_blank" href="%s" class="rsslink"><img src="%s" alt="RSS"/></a>', apply_filters('pagelines_branding_rssurl', get_bloginfo('rss2_url')), $this->base_url . '/rss.png');

                if (VPRO) {
                    if (ploption('twitterlink'))
                        printf('<a target="_blank" href="%s" class="twitterlink"><img src="%s" alt="Twitter"/></a>', ploption('twitterlink'), $this->base_url . '/twitter.png');

                    if (ploption('facebooklink'))
                        printf('<a target="_blank" href="%s" class="facebooklink"><img src="%s" alt="Facebook"/></a>', ploption('facebooklink'), $this->base_url . '/facebook.png');

                    if (ploption('linkedinlink'))
                        printf('<a target="_blank" href="%s" class="linkedinlink"><img src="%s" alt="LinkedIn"/></a>', ploption('linkedinlink'), $this->base_url . '/linkedin.png');

                    if (ploption('youtubelink'))
                        printf('<a target="_blank" href="%s" class="youtubelink"><img src="%s" alt="Youtube"/></a>', ploption('youtubelink'), $this->base_url . '/youtube.png');

                    if (ploption('gpluslink'))
                        printf('<a target="_blank" href="%s" class="gpluslink"><img src="%s" alt="Google+"/></a>', ploption('gpluslink'), $this->base_url . '/google.png');

                    pagelines_register_hook('pagelines_social_icons_end', 'toukSocial'); // Hook

                }
                printf('</div>');
            ?>
        </div>
        <?php pagelines_register_hook('pagelines_after_toukSocial_wrap', 'toukSocial'); // Hook ?>
    <?php
        enqueue_coffeescript('toukSocial', $this->base_dir . '/script.coffee', array('jquery'), false, true);
    }
}
