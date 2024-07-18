<?php
/* ********************************************************* */
/* GLOBAL VARIABLES  */
/* ********************************************************* */
global $theme_dir;
$theme_dir = get_template_directory_uri();

global $dummy;
$dummy = get_bloginfo('template_directory') . '/images/dummy.png';


// on page items must fire later
function set_global_variables()
{
    global $product_type, $display_forms, $global_offers;
    $product_type = get_field('product_type') ? get_field('product_type') : 'general';
    $display_forms = get_field('display_forms') ? get_field('display_forms') : 'yes';
    $global_offers = get_posts(array(
        'post_type' => 'offers',
        'posts_per_page' => -1,
    ));

    // global $display_forms;
    // $display_forms = get_field('display_forms');
}
add_action('wp_head', 'set_global_variables');


/* ********************************************************* */
/* STRIP SPACES AND CHARACTERS OUT OF PHONE NUMBER FOR TEL:  */
/* ********************************************************* */
function strip_phone_number($phone = '')
{
    return preg_replace('/\D+/', '', $phone);
}


/* ************************************************** */
/* ACF BUTTON */
/* ************************************************** */
function build_button($button_group_data, $extra_classes = 'btn btn-primary', $div_tag = false)
{
    $target = $button_group_data['link_type'] == 'External' ? 'target="_blank"' : '';
    $button_url = !empty($button_group_data['link_url']) ? $button_group_data['link_url'] : '';
    $tag = $div_tag ? 'div' : 'a';
    $href = ($tag == 'div') ? '' : 'href="' . $button_url . '"';

    if ($button_group_data['link_text']) {
        return '<' . $tag . ' ' . $href . ' class="' . $extra_classes . '" ' . $target . '>' . $button_group_data['link_text'] . '</' . $tag . '>';
    } else {
        return '';
    }
}
// To use, create a clone of Block - Button in your desired ACF Group. Pass the button info into the function:
// $my_group = get_field('my_acf_group','option');
// $button_1 = $my_group['button_1'];
// $button_2 = $my_group['button_2'];
// echo build_button($button_1); // will load with .btn .btn-primary classes
// echo build_button($button_2, 'btn btn-secondary'); // can pass alternative classes with second parameter

// Added for ease of use. Can do if( dev() ) instead of if( isset($_GET['dev]) )
function dev()
{
    return isset($_GET['dev']);
}


/* ************************************************** */
/* CUSTOM SHORTCODES */
/* ************************************************** */

/** 
 * Example Usage:
 * [button-primary href="https://americanhomedesign.com/" arrow=true]Get Started[/button-primary]
 */
add_shortcode("button-primary", function ($atts, $content) {
    if (!is_array($atts)) $atts = [];
    $arrow = ($atts["arrow"] ?? null) ? '<img src="' . get_template_directory_uri() . '/images/arrow-right.svg" loading="lazy" width="27" height="10" alt="arrow right" class="button-arrow">' : '';
    $link = ($atts["href"] ?? null) ? $atts["href"] : get_site_url();
    return <<<html
      <a data-w-id="8d611f4e-36ad-1dc1-90a2-bec24b26a4a9" href="{$link}" class="button is-icon w-inline-block">
        <div class="text-block-6">{$content} </div>
        {$arrow}
      </a>
    html;
});

/** 
 * Example Usage:
 * [button-secondary href="https://americanhomedesign.com/"]Get Started[/button-secondary]
 */
add_shortcode("button-secondary", function ($atts, $content) {
    if (!is_array($atts)) $atts = [];
    $link = ($atts["href"] ?? null) ? $atts["href"] : get_site_url();
    return <<<html
      <a href="{$link}" class="button is-khaki is-small w-button">{$content}</a>
    html;
});

/** 
 * Example Usage:
 * [button-tertiary href="https://americanhomedesign.com/"]Get Started[/button-tertiary]
 */
add_shortcode("button-tertiary", function ($atts, $content) {
    if (!is_array($atts)) $atts = [];
    $link = ($atts["href"] ?? null) ? $atts["href"] : get_site_url();
    return <<<html
      <a href="{$link}" class="button is-outline is-khaki is-small w-button">{$content}</a>
    html;
});

/** 
 * Example Usage:
 * [specials-offer-boxes]
 */
add_shortcode("specials-offer-boxes", function ($atts, $content) {
    global $global_offers;
    if (!is_array($atts)) $atts = [];
    $offer_boxes = '';
    foreach ($global_offers as $offer_post) {
        $offer = get_field('offer', $offer_post->ID);
        $link = ($offer['product_type'] == 'water-quality') ? get_site_url() . '/water-test-free' : get_site_url() . '/estimate';
        $button_text = ($offer['product_type'] == 'water-quality') ? 'Learn More' : 'Get an Estimate';

        $offer_boxes .= '<div id="w-node-f14605f0-733d-d832-8784-799fb889d496-7f12c65b" class="nav5_dropdown-cta-wrapper content-cta">
                            <div class="dropdown_cta-overlay">
                                <div class="dropdown_cta-text">' . $offer['single_line_offer'] . '</div>
                            </div>
                            <div class="button-group dropdown-cta-button">
                                ' . do_shortcode('[button-primary href="' . $link . '" arrow=true]' . $button_text . '[/button-primary]') . '
                            </div>
                            <div class="dropdown_cta-image-wrapper"><img src="' . $offer['featured_image']['sizes']['large'] . '" loading="lazy" alt="" class="image-cover"></div>
                        </div>';
    };

    return <<<html
    <div class="internal_column2">
        {$offer_boxes}
    </div>
    html;
});

/** 
 * Example Usage:
 * [related-articles]
 */
add_shortcode("related-articles", function ($atts, $content) {
    if (!is_array($atts)) $atts = [];
    $terms = get_the_terms(get_the_ID(), 'smct_areas');
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'smct_areas',
                'field' => 'slug',
                'terms' => $terms[0]->slug
            )
        ),
        'posts_per_page' => 12
    );
    $related_articles = new WP_Query($args);

    $article_boxes = '';
    foreach ($related_articles->posts as $article) {
        $image = first_image_in_post($article->ID) ? first_image_in_post($article->ID) : get_template_directory_uri() . '/images/logos/american-home-design-client-version-p-500.png';
        $page_template = get_page_template_slug($article->ID);
        $image_style = first_image_in_post($article->ID) ? '' : 'style="object-fit:contain;padding:40px;"';
        $title = '';

        if (preg_match_all('#(<h[0-6].*?>).*?(</h[0-6]>)#', $article->post_content, $matches)) {
            if ($matches) {
                $title = strip_tags($matches[0][0]);
            } else {
                $title = $article->post_title;
            }
        } else {
            $title = $article->post_title;
        }

        if (!function_exists('the_excerpt_max_charlength')) {
            function the_excerpt_max_charlength($limit = 40)
            {

                $words = explode(' ', get_the_excerpt());

                //if excerpt has more than 20 words, truncate it and append ... 
                if (count($words) > 20) {
                    return sprintf("%s&hellip;", implode(' ', array_slice($words, 0, $limit)));
                }

                //otherwise just put it back together and return it
                return implode(' ', $words);
            }
        }

    
        if ($page_template != 'templates/flexible-content.php') :
            $article_boxes .=
                '<div role="listitem" class="blog_wrapper w-dyn-item">
                <div class="blog_image-wrapper">
                    <img src="' . $image . '" loading="lazy" alt="" class="blog_teaser-image" ' . $image_style . '>
                </div>
                <div id="w-node-ab58592d-65d1-f9c4-0798-9fd0f5d9944a-7f12c576" class="blog_content-wrapper">
                    <div class="heading-style-h5 text-color-dark">' . $title . '</div>
                    <div class="spacer-1 hide-tablet"></div>
                    <div class="blog_teaser">' . the_excerpt_max_charlength(50) . '</div>
                    <div class="button-group">
                        <a href="' . get_the_permalink() . '" class="button align-center-large w-button">Learn More</a>
                    </div>
                </div>
            </div>';
        endif;
    }

    $section = '<div class="w-dyn-list">
                    <div role="list" class="blog_teaser-wrapper w-dyn-items">' . $article_boxes . '</div>
                </div>';

    return $section;
});



/* ************************************************** */
/* Custom Nav Walker */
/* ************************************************** */
// WP - Menu - Custom Walker Mega - Primary Menu
class walker_mega_primary extends Walker_Nav_Menu
{
    private $curItem;
    private $curColumnItem;
    private $counter_megas = 1;


    function start_lvl(&$output, $depth = 0, $args = array())
    {
        global $global_offers;
        $tempItem = $this->curItem;
        $menu_type = '';
        $offers = $global_offers;

        if ($tempItem) {
            $menu_type = get_field('menu_item_type', $tempItem);
        }

        if ($menu_type == 'megaparent') {
            $product = get_field('product', $tempItem);

            if ($offers) {
                foreach ($offers as $offer_post) {
                    $offer = get_field('offer', $offer_post->ID);

                    if ($offer['product_type'] == $product['product_type']) {
                        $offer_text = $offer['single_line_offer'];
                        $offer_image = $offer['featured_image'];
                        $offer_button_text = $offer['mega_menu_button']['text'];
                        $offer_button_link = $offer['mega_menu_button']['link'];
                    }
                }
            }

            $output .= '<div class="navbar5_dropdown-list w-dropdown-list">';
            $output .= '<div class="padding-global menu">';
            $output .=     '<div class="navbar5_dropdown-wrapper">';
            $output .=     '<div class="nav5_dropdown-cta-wrapper">';
            $output .=     '<div class="dropdown_cta-overlay">';
            $output .=     '<div class="dropdown_cta-text">' . $offer_text . '';
            $output .=     '</div> <!-- .dropdown_cta-text -->';
            $output .=     '</div> <!-- .dropdown_cta-overlay -->';
            $output .=     '<div class="button-group dropdown-cta-button">';
            $output .=     '' . do_shortcode('[button-primary href="' . $offer_button_link . '" arrow=true]' . $offer_button_text . '[/button-primary]') . '';
            $output .=     '</div> <!-- .button-group -->';
            $output .=     '<div class="dropdown_cta-image-wrapper">';
            $output .=     '<img src="' . $offer_image['sizes']['large'] . '" loading="lazy" alt="' . $offer_image['alt'] . '" class="image-cover">';
            $output .=     '</div> <!-- .dropdown_cta-image-wrapper -->';
            $output .=     '</div> <!-- .nav5_dropdown-cta-wrapper -->';
            $output .=     '<div class="navbar5_dropdown-link-list">';
            $output .=     '<div class="max-width-full w-dyn-list">';
            $output .=     '<ul role="list" class="navbar5-collection-link-list w-dyn-items">';
        } else {
            $output .= '<ul class="navbar1_dropdown-list w-dropdown-list">';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $tempItem = $this->curItem;
        $menu_type = '';
        global $theme_dir;

        if ($tempItem) {
            $menu_type = get_field('menu_item_type', $tempItem);
        }

        if ($menu_type == 'megaparent') {
            // Output
            $output .=         '</ul> <!-- .navbar5-collection-link-list -->';
            $output .=     '</div> <!-- .w-dyn-list -->';
            $output .=     '</div> <!-- .navbar5_dropdown-link-list -->';
            $output .=     '</div> <!-- .navbar5_dropdown-wrapper -->';
            $output .=     '</div> <!-- .padding-global menu -->';
            $output .=     '</div> <!-- .navbar5_dropdown-list -->';

            // Clear out cached item.
            $this->curItem = null;
            $this->counter_megas++;
        } else {
            $output .= '</ul>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $curItem = null;
        $title = $item->title;
        $permalink = $item->url;
        $menu_type = get_field('menu_item_type', $item);
        $counter = $this->counter_megas;

        if ($menu_type === 'megaparent') {
            // Cache current mega parent item for end_lvl function
            $this->curItem = $item;
            $item->classes[] = 'navbar5_menu-dropdown w-dropdown megaparent-' . $counter;
        } elseif ($menu_type == 'megachild') {
            $item->classes[] = 'nabbar5-collection-item w-dyn-item megachild';
        } elseif ($menu_type == 'normalparent') {
            $item->classes[] = 'navbar5_menu-dropdown simple w-dropdown';
        } elseif ($menu_type == 'normalchild') {
            $item->classes[] = '';
        }

        $output .= '<li data-hover="true" data-delay="300" data-w-id="9bcb3886-cdf4-f105-8e54-d5fe1ab7b565"  class="' . implode(" ", $item->classes) . '">';

        // Open with either <a> or <span>, depending on permalink
        if ($permalink && $permalink != '#') {
            if ($menu_type === 'megaparent') {
                $output .= '<div class="navbar5_dropdown-toggle w-dropdown-toggle" id="w-dropdown-toggle-' . $counter . '" aria-controls="w-dropdown-list-' . $counter . '" aria-haspopup="menu" aria-expanded="false" role="button" tabindex="0"><div class="dropdown-icon w-embed"><svg width=" 100%" height=" 100%" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M2.55806 6.29544C2.46043 6.19781 2.46043 6.03952 2.55806 5.94189L3.44195 5.058C3.53958 4.96037 3.69787 4.96037 3.7955 5.058L8.00001 9.26251L12.2045 5.058C12.3021 4.96037 12.4604 4.96037 12.5581 5.058L13.4419 5.94189C13.5396 6.03952 13.5396 6.19781 13.4419 6.29544L8.17678 11.5606C8.07915 11.6582 7.92086 11.6582 7.82323 11.5606L2.55806 6.29544Z" fill="currentColor"></path>
				</svg></div><a href="' . $permalink . '" class="main-link">';
            } elseif ($menu_type == 'megachild') {
                $output .= '<a href="' . $permalink . '" class="navbar5_dropdown-link w-inline-block" tabindex="0">';
            } elseif ($menu_type == 'normalparent') {
                $output .= '<div class="navbar5_dropdown-toggle w-dropdown-toggle"><div class="dropdown-icon w-embed"><svg width=" 100%" height=" 100%" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.55806 6.29544C2.46043 6.19781 2.46043 6.03952 2.55806 5.94189L3.44195 5.058C3.53958 4.96037 3.69787 4.96037 3.7955 5.058L8.00001 9.26251L12.2045 5.058C12.3021 4.96037 12.4604 4.96037 12.5581 5.058L13.4419 5.94189C13.5396 6.03952 13.5396 6.19781 13.4419 6.29544L8.17678 11.5606C8.07915 11.6582 7.92086 11.6582 7.82323 11.5606L2.55806 6.29544Z" fill="currentColor"></path>
                </svg></div><a href="' . $permalink . '" class="main-link">';
            } elseif ($menu_type == 'normalchild') {
                $output .= '<a href="' . $permalink . '" class="navbar5_dropdown-link simple w-inline-block">';
            }
        } else {
            $output .= '<span>';
        }

        // Output title in between tags.
        if ($menu_type == 'megachild' || $menu_type == 'normalchild') {
            $output .= '<span class="link-list_text">' . $title . '</span>';
        } else {
            $output .= $title;
        }

        // Close with either <a> or <span>, depending on permalink
        if ($permalink && $permalink != '#') {
            if ($menu_type === 'megaparent' || $menu_type === 'normalparent') {
                $output .= '</a></div>';
            } else {
                $output .= '</a>';
            }
        } else {
            $output .= '</span>';
        }
    }
}

// WP - Menu - Custom Walker Mega - Sticky Sidebar Menu
class walker_mega_sticky extends Walker_Nav_Menu
{
    private $curItem;
    private $curColumnItem;
    private $counter_megas = 1;

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $tempItem = $this->curItem;
        $menu_type = '';

        if ($tempItem) {
            $menu_type = get_field('menu_item_type', $tempItem);
        }

        if ($menu_type == 'normalparent' || $menu_type == 'megaparent') {

            $output .= '<div class="navbar4_dropdown-list-4 w-dropdown-list">';
            $output .=   '<div class="w-dyn-list">';
            $output .=     '<ul role="list" class="w-dyn-items">';
        } else {
            $output .= '<ul class="navbar1_dropdown-list w-dropdown-list">';
        }
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $tempItem = $this->curItem;
        $menu_type = '';
        global $theme_dir;

        if ($tempItem) {
            $menu_type = get_field('menu_item_type', $tempItem);
        }

        if ($menu_type == 'normalparent' || $menu_type == 'megaparent') {
            // Output
            $output .=         '</ul> <!-- .w-dyn-items -->';
            $output .=     '</div> <!-- .w-dyn-list -->';
            $output .=     '</div> <!-- .navbar4_dropdown-list-4 w-dropdown-list -->';

            // Clear out cached item.
            $this->curItem = null;
            $this->counter_megas++;
        } else {
            $output .= '</ul>';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $curItem = null;
        $title = $item->title;
        $permalink = $item->url;
        $menu_type = get_field('menu_item_type', $item);
        $counter = $this->counter_megas;

        if ($menu_type === 'normalparent' || $menu_type === 'megaparent') {
            $this->curItem = $item;
            $item->classes[] = 'navbar4_menu-dropdown-3 w-dropdown';
        } else {
            $item->classes[] = 'w-dyn-item';
        }

        $output .= '<li data-hover="false" data-delay="200" data-w-id="636b6471-ae5b-fec8-c113-a2b8be69893c"  class="' . implode(" ", $item->classes) . '">';

        // Open with either <a> or <span>, depending on permalink
        if ($permalink && $permalink != '#') {
            if ($menu_type === 'normalparent' || $menu_type === 'megaparent') {
                $output .= '<div class="navbar4_dropdown-toggle-4 w-dropdown-toggle w--nav-dropdown-toggle-open" id="w-dropdown-toggle-' . $counter . '" aria-controls="w-dropdown-list-' . $counter . '" aria-haspopup="menu" aria-expanded="true" role="button" tabindex="0"><div class="dropdown-icon_sidebar w-embed"><svg width="1.2rem" height="1.2rem" viewbox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.55806 6.29544C2.46043 6.19781 2.46043 6.03952 2.55806 5.94189L3.44195 5.058C3.53958 4.96037 3.69787 4.96037 3.7955 5.058L8.00001 9.26251L12.2045 5.058C12.3021 4.96037 12.4604 4.96037 12.5581 5.058L13.4419 5.94189C13.5396 6.03952 13.5396 6.19781 13.4419 6.29544L8.17678 11.5606C8.07915 11.6582 7.92086 11.6582 7.82323 11.5606L2.55806 6.29544Z" fill="currentColor"></path>
                </svg></div><a href="' . $permalink . '" class="navbar4_dropdown_main-link">';
            } else {
                $output .= '<div><a href="' . $permalink . '" class="navbar4_dropdown-link">';
            }
        } else {
            $output .= '<span>';
        }

        // Output title in between tags.

        $output .= $title;


        // Close with either <a> or <span>, depending on permalink
        if ($permalink && $permalink != '#') {

            $output .= '</a></div>';
        } else {
            $output .= '</span>';
        }
    }
}
