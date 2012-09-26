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
                    <div class="inner"><a href="<?=home_url()?>"><span class="main"><?php echo get_bloginfo('name')?> </span></a><span class="subtitle" style="display: none; "></span>
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
                        <?php if (function_exists(qtrans_getLanguage)) {
                            global $q_config;?>
                            <div class="lang">
                                <span><?=__('Language', 'qtranslate')?></span>
                                <ul>
                                <?php
                                    foreach(qtrans_getSortedLanguages() as $language) {
                                        $classes = array($language);
                                        if($language == $q_config['language'])
                                            $classes[] = 'selected';
                                        echo '<li class="'. implode(' ', $classes) .'"><a href="'.qtrans_convertURL($url, $language).'" hreflang="'.$language.'" title="'.$q_config['language_name'][$language].'">';
                                        echo $q_config['language_name'][$language];
                                        echo "</a></li>\n";
                                    }
                                ?>
                                </ul>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <?php pagelines_register_hook('pagelines_after_branding_wrap', 'branding2'); // Hook ?>
    <?php
    }
}
