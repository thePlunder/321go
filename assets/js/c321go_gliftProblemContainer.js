// this js adds a bit more control to the problem set
//such as next, previous, and a function that submits the results.

//do_update = function(){
	// jQuery.ajax({url : "wp-content/plugins/c321go_glift/assets/js/get-testdata.php", 
	// dataType:'json',
	// data : {functionname:'test',arguments:[1]},
	// complete:function(response){window.alert(response.responseText);console.log(response);},
	// succes:function(response){window.alert(response.responseText);console.log(response);},
	// error: function(){}
//}); 

    // var oReq = new XMLHttpRequest(); //New request object
    // oReq.onload = function() {
    //     //This is where you handle what to do with the response.
    //     //The actual data is found on this.responseText
    //     alert(this.responseText); //Will alert: 42
    // };
    // oReq.open("get", "wp-content/plugins/c321go_glift/assets/js/get-testdata.php", true); //./../includes
    // //                               ^ Don't block the rest of the execution.
    // //                                 Don't wait until the request finishes to
    // //                                 continue.
    // oReq.send();
//};

var gliftContainer;
createGliftContainer = function(sgf,divId){
	gliftContainer = new GliftContainer(sgf,divId);
    gliftContainer.buildBoard(0);
	return gliftContainer;
}

function GliftContainer(sgf,divId){

var self = this;
self.sgf_array = sgf;
self.current_problem = 0;
self.problem_set  = sgf;
self.divId = divId;

self.board;




self.buildBoard = function(volgnr){
	self.single_sgf = self.problem_set[volgnr];
	self.single_sgf.divId = divId;
	self.single_sgf.hooks = {

        problemCorrect: function () {
        submitresult(self.single_sgf.sgf.problem_id); 
        },
        problemIncorrect: function () {
        	//console.log(next_button.css);
        
	//	window.alert("fout!");
        	
        }};

  self.board= glift.create(self.single_sgf);
 self.current_problem = volgnr;
}



//console.log(single_sgf);




// console.log(single_sgf);
// console.log(window.location.pathname);	
//do_update();
/**
,hooks:{
        problemCorrect: function () {window.alert("goed!"); board.destroy();
        },
        problemIncorrect: function () {window.alert("fout!")
        }}
**/


// var prev_button = jQuery('#321go_previous_button');
// var next_button= jQuery('#321go_next_button');
//jQuery(document).ready(function(){

jQuery('#321go_next_button'+self.divId).click(function(){ 
	console.log("length: " + self.sgf_array.length +" currprob " + self.current_problem);
	if (self.current_problem == (self.sgf_array.length-1)) return;
		
	self.board.destroy();
self.buildBoard(self.current_problem+1);
		console.log("next!"); 
});


jQuery('#321go_previous_button'+self.divId).click(function(){ 
	console.log("length: " + self.sgf_array.length +" currprob " + self.current_problem);
	if (self.current_problem == 0) return;
self.board.destroy();
self.buildBoard(self.current_problem-1);

		console.log("prev!"); 
});



//});
// jQuery('#321go_next_button').prop('disabled', true); 
// prev_button.css({'background-color':'grey'});
// console.log(jQuery('#321go_next_button'));
// jQuery('#321go_next_button').on('click', function(a){
// 	console.log("background-color");
// });

// jQuery('#321go_previous_button').onclick = function(){
// console.log(this.single_sgf);	
	
// }


//	next_button.css({'background':'grey'});
//get a reference to next and previous button to attach functions to them.

//'321go_previous_button'/>";  //previous button
//'321go_next_button'/>";  //next button



}

