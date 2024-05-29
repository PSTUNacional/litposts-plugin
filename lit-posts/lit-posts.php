<?php
/*
Plugin Name: LIT Posts
Description: Adicione os posts da LIT-QI no seu site.
Version: 1.0
Author: Tiê Tecnologia
*/

// Verifica se o WordPress está sendo executado
defined('ABSPATH') or die('Acesso negado.');

// Função principal que faz o fetch do JSON e renderiza os blocos
function get_lit_posts($atts=[]) {

    # Define os valores de parâmetros e seus valores padrão
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
    $atributes = shortcode_atts(
        array(
            'lang' => 'es'
        ), $atts
    );
    switch($atributes['lang']){
        case "es":
            $url = "https://litci.org/es/wp-json/wp/v2/posts";
            break;
        case "pt":
            $url = "https://litci.org/pt/wp-json/wp/v2/posts";
            break;
    }
    
    $json = json_decode(file_get_contents($url), TRUE);

    echo '<div id="litposts-container">';
    for( $i=0; $i < 4; $i++)
    {
        render_lit_block($json[$i]);
    }
    echo "</div>";
}

// Função de renderiação dos blocos
// o css está todo inline. Essa não é uma boa prática.
function render_lit_block($object)
{
    $date = date_format(date_create($object['date']),"Y/m/d");

    echo '<a href="'.$object['link'].'" target="_blank"><div class="img-container"><img src="'.$object['jetpack_featured_media_url'].'"/></div><div><h4>'.$object['title']['rendered'].'</h4><span class="date">'.$date.'<span></div></a>';
}

#===============================
#
#   Definições de estilo
#
#===============================

function add_litposts_stylesheet() {
    // Substitua 'meu-estilo' pelo nome que deseja dar ao seu estilo.
    wp_enqueue_style('litposts_style', plugin_dir_url(__FILE__) . 'assets/style.css');
}

// Adiciona o CSS do plugin no Theme
add_action('wp_enqueue_scripts', 'add_litposts_stylesheet');

#===============================
#
#   Habilitando o plugin como shortcode
#
#===============================

// Função para adicionar um shortcode ao repertório do WordPress
function register_shortcode_litposts() {
    add_shortcode('get_lit_posts', 'get_lit_posts');
}
// Registrar o shortcode quando o WordPress é inicializado
add_action('init', 'register_shortcode_litposts');