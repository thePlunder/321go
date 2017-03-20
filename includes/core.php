<?php
/**
 * Main functionality
 **/


//include('js/get-testdata.php');
//register js on page-load?



function c321go_glift_register_scripts() {

	if ( is_admin() ) return; // don't load scripts in admin dashboard
 //echo "<br/ ><br/ ><br/ ><br/ ><br/ ><br/ ><h1>". print_r(wp_get_current_user()) ."</h1>" ;
	// register scripts
	$glift_js_url = c321GO_GLIFT_URL.'assets/js/glift_1_0_6.min.js';
	$test_url = c321GO_GLIFT_URL.'assets/js/c321go_gliftProblemContainer.js';
    

 	wp_enqueue_script("jQuery");
	wp_register_script('glift', $glift_js_url, array(), GLIFT_JS_VERSION );
	wp_register_script('test', $test_url, array(), GLIFT_JS_VERSION );

 	add_action( 'wp_footer', 'report_solved_problem' ); 
	wp_enqueue_script( 'glift' );
	wp_enqueue_script( 'test' );
}


//largly based on the glift viewer
function c321go_placeglift($atts){  // eats shortcode //I for now only 1!! problem per page....
	//wp_enqueue_script('c321go_gliftProblemContainer', c321GO_GLIFT_URL."/assets/js/c321go_gliftProblemContainer.js", 'jquery');
 
$a = shortcode_atts( array(
    'chapter' => 0,
    'section' => 0,
    'id' => 0,
), $atts );

 
 
$divIdPostfix='';
 $json = null;
 if ($a['id'] != 0) {
 	$json = get_sgf_by_id($a['id']);
 	$divIdPostfix.='id'.$a['id'];
 }
else
 	{
 	$json = get_sgfs_by_chapter_section($a['chapter'],$a['section']);
	$divIdPostfix.='c'.$a['chapter'].'s'.$a['section'];
 	}
 
$divId ='glifttag'.$divIdPostfix;
$nextButtonId = '321go_previous_button'.$divId;
$previousButtonId= '321go_next_button'.$divId;

 $height = '500px';
 $width = '100%';
 $style = "height:$height; width:$width; position:relative;"; // position:relative;

 $html = "\n\r<div id='$divId' style='$style'></div>".
			"\n\r<script type='text/javascript'>".
			"jQuery(document).ready(function(){createGliftContainer($json,'$divId')}); </script>\n\r<p>&nbsp;</p>\n\r". //
			"<div align ='center'> 		"; //This should change in the future!

$html .= "<input type='button' value='&#8592;' id='$previousButtonId'/>";  //previous button
$html .= "<input type='button' value='&#8594;' id='$nextButtonId'/>";  //next button
	return "$html" ;

}



?>