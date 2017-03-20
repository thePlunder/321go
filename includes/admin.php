<?php
/**
 * Admin functions MSP Helloworld plugin
 **/
 
function registerAddSGFMenu() {
if (!is_super_admin() ) return;
	add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ),
        'Manage SGFs',
        'manage_options',
        'c321go_glift/manageSGF.php',
        'uploadsgf',
        '',//plugins_url( 'c321go_glift/default.png' ),
        130
    );    
    

}

function uploadsgf(){
echo '<div>';
	echo '<form id="my_sgf_upload" action="#" method="post" class="form" enctype="multipart/form-data">'  ; // ajax url should be some global.action="$ajaxurl"
		echo '<input type="file" required="required" name="my_sgf_upload" id="my_sgf_upload" value="" placeholder="<pad naar sgf file>">';
	echo 'Chapter: <input type="number" required="required" name="chapter" id="chapter" value="" >';  //todo keep pervious value, later a drop down menu.
	echo 'Section: <input type="number" required="required" name="section" id="section" value="" >';
	echo 'Volgnummer: <input type="number" required="required" name="volgnummer" id="volgnummer" value="" >';
	//wp_nonce_field( 'my_sgf_upload', 'my_sgf_upload_nonce' );
	 wp_nonce_field( plugin_basename( __FILE__ ), 'my_sgf_upload_nonce' );
	
	submit_button('submit', 'primary', 'submitSGF');
echo '</form>';
echo '</div>';


}


// Check that the nonce is valid, and the user can edit this post.
require_once(ABSPATH .'wp-includes/pluggable.php'); 
if ( 
	isset( $_POST['my_sgf_upload_nonce'] ) 
	//&& isset($_POST['submit'])
	//&& wp_verify_nonce( $_POST['my_sgf_upload_nonce'], 'my_sgf_upload' 		)
	//&& current_user_can( 'edit_post', $_POST['post_id'] )
) {
	// The nonce was valid and the user has the capabilities, it is safe to continue
	
$content = @file_get_contents( $_FILES['my_sgf_upload']['tmp_name'] );
$chapter =  $_POST['chapter'];
$section =  $_POST['section'];
$volgnummer = $_POST['volgnummer'];
	//$attachment_id = wp_upload_bits($_FILES['my_sgf_upload']['name'], null, @file_get_contents( $_FILES['my_sgf_upload']['tmp_name'] ) );
	
add_problem_sgf($content, $chapter, $section, $volgnummer);


} else {

	// The security check failed, maybe show the user an error.
}



?>

