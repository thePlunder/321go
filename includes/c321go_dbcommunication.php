<?php

/**
* getters and setters 
**/

//this function that allows calling of put_result from javascript
function report_solved_problem() { ?>
	<script type="text/javascript" >
	submitresult= function(sgf_id){
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	 jQuery.ajax({
   				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				type: "POST",
				data: {
				action: 'put_result','problem_id': sgf_id
				},			
				//dataType: 'html',
				success: function(response) {
 				console.log(response);
 				}
				,
  error: function(errorThrown){
      alert('fout!' + errorThrown);
      console.log(errorThrown);
	  } 
	});
 };
	</script> 
 <?php 
}

//-----------------------------------------------------------------------------------------------

function get_sgf_by_id($id){

global $wpdb;


	$sgf=$wpdb->get_var( $wpdb->prepare( 
		"
		SELECT   	SGF  
		FROM        321go_sgf	
		WHERE       SGF_ID = %s 	
		",
		$id 
	) ); 

//$sgf = $wpdb->get_var('SELECT SGF FROM 321go_sgf WHERE SGF_ID= $id');

	$sgf_array = array('sgfString' => $sgf,  'widgetType' => 'STANDARD_PROBLEM' );
	$array = array('sgf' => $sgf_array , 'divId'=> 'glifttag' );	
	$array2 = array($array);
	return json_encode($array2);
}

//-----------------------------------------------------------------------------------------------

function get_sgfs_by_chapter_section($chapter,$section){

global $wpdb;

$query = $wpdb->prepare( 
		"
		SELECT   	sgf.SGF, ptc.problem_id  
		FROM        321go_sgf sgf,
					321go_problems_to_chapter ptc	
		WHERE       sgf.SGF_ID = ptc.sgf_id
		AND   		ptc.chapter= %d
		AND 		ptc.section= %d
		ORDER BY ptc.volgnummer
		",
		$chapter,
		$section
	) ;
	$sgfs = $wpdb->get_col($query,0); 
	$prob_ids = $wpdb->get_col($query,1); 

//$sgf = $wpdb->get_var('SELECT SGF FROM 321go_sgf WHERE SGF_ID= $id');

$problemset_json=array();
$counter=0;
foreach ($sgfs as $sgf) {
	$sgf_sub_array = array('sgfString' => $sgf,  'widgetType' => 'STANDARD_PROBLEM' , 'problem_id' => $prob_ids[$counter]);
	$counter++;
	$sgf_array = array('sgf' => $sgf_sub_array , 'divId'=> 'glifttag' );	
	array_push($problemset_json, $sgf_array);

		
}

	return json_encode($problemset_json);
}




//-----------------------------------------------------------------------------------------------

function put_result(){
	
	if (!is_user_logged_in())  {echo 'User not logged in, unable to track progress';	wp_die();}

	$problem_id = intval( $_POST['problem_id'] ); 
	$user_id = get_current_user_id();
    global $wpdb;
	$wpdb->insert( 
	'321go_solved_problems', 
	array( 
		'user_id' => $user_id, 
		'problem_id' => $problem_id 
	), 
	array( 
		'%d', 
		'%d' 
	) 
	);

    ob_clean();
    echo $problem_id;

	wp_die();
}


//------------------------------------------------------------------------------------------------
//adds a new sgf to the database, or updates an already existing sgf of a problem.
// Q add a new

function add_problem_sgf($sgf, $chapter, $section, $volgnummer){



//WordPress database error: [Unknown column 'section' in 'field list']
//REPLACE INTO `321go_problems_to_chapter` (`sgf_id`, `chapter`, `section`, `volgnummer`) VALUES (3, 1, 1, 1)

//check if we already gave an sgf associated with this problem
	 global $wpdb;
$sgf_id=$wpdb->get_var( $wpdb->prepare( 
		"
		SELECT   	ptc.SGF_ID
		FROM       	321go_problems_to_chapter ptc
		WHERE       ptc.chapter = %d 	
		AND 		ptc.section = %d
		AND 		ptc.volgnummer = %d
		",
		$chapter,
		$section,
		$volgnummer
	) ); 

//
if (is_null($sgf_id)) {

	$wpdb->insert( 
	'321go_sgf', 
	array( 
		'sgf' => $sgf	
	), 
	array( 
		'%s' 
	) 
	); //insert the SGF	
		
    $sgf_id = $wpdb->insert_id;
		$wpdb->replace( 
		'321go_problems_to_chapter', 
		array( 
			'sgf_id' => $sgf_id,
			'chapter' => $chapter,
			'section' => $section,
			'volgnummer' => $volgnummer,
 			), 
		array( 
			'%d',
			'%d',
			'%d',
			'%d' 
			) 
		);	//couple sgf to chapter
	} 
	else {

	$wpdb->replace( 
			'321go_sgf', 
		array( 
			'sgf_id' => $sgf_id,
			'sgf' => $sgf	
			), 
		array( 
			'%d',
			'%s' 
		) 
	); //insert the SGF	

	}
}

//------------------------------------------------------------------------------------------------
//adds a new chapter and a new section. Mostly for the problem-sgf's 
// name kinda optional, but would be nice for a reference.

function add_chapter_section($chapter, $section,$name){


}


//------------------------------------------------------------------------------------------------
//maybe we want to move an sgf? this function willl 'move' it. 
function update_problem_sgf($sgf_id,$new_chapter,$new_section) {

}

//------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------


?>