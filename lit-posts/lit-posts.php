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
function get_lit_posts() {
    $url = "https://litci.org/pt/wp-json/wp/v2/posts";
    $json = json_decode(file_get_contents($url), TRUE);

    echo '<div style="display:grid;gap:24px;grid-template-columns:
    repeat(auto-fit, minmax(216px, 1fr)); width:100%">';
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
    echo '<div><div style="width:100%;height:auto;aspect-ratio:4/3"><img style="object-fit:cover; width:100%; height:100%; margin:0" src="'.$object['jetpack_featured_media_url'].'"/></div><div><h4>'.$object['title']['rendered'].'</h4></div></div>';
}
// Função para adicionar um shortcode ao repertório do WordPress
function register_shortcode_litposts() {
    add_shortcode('get_lit_posts', 'get_lit_posts');
}

// Registrar o shortcode quando o WordPress é inicializado
add_action('init', 'register_shortcode_litposts');