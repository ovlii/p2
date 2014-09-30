<?php

/*
* Name 			: Venkat Annangi
* Description	: xkcd style password generator 
* 
*/

function set_global_values() {
  // Initialize the global variables with defaults  
  $GLOBALS['no_of_words'] = '3';
  $GLOBALS['add_number'] = '0';
  $GLOBALS['add_special'] = '0';
  $GLOBALS['add_seperator'] = '-';
  $GLOBALS['make_upper'] = '0';
}

// Function to get a random number between 0 and 9 to add to the password.
function add_number($add_number) {
	if ($add_number == 1) {
		$number = rand(0,9);
	}
	return $number;
}

// Function to get special characters generated randomly.
function add_special($add_special) {
	
	if ( $add_special == 1 ) {
		$special = rand(33,47);	
	
	}
	return chr($special);
}

// Checks the input values from the forrm


function check_input_values() {

	// get global variables 
	set_global_values();
	
  // Get form values when POST and assign to GLOBAL variables.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
      // if the no_of_words is empty use default value.        
      $GLOBALS['no_of_words'] = !empty($_POST["no_of_words"]) ? $_POST["no_of_words"] :
      							$GLOBALS['no_of_words'];
      							      
      $GLOBALS['add_number'] = $_POST["add_number"];
      
      $GLOBALS['add_special'] = $_POST["add_special"];	
      
      // if the seperator is empty use default value.        
      $GLOBALS['add_seperator'] = !empty($_POST["add_seperator"])  ? $_POST["add_seperator"] :
      							  $GLOBALS['add_seperator'];
      
      $GLOBALS['make_upper'] = $_POST['make_upper'];
      
   }

}

// Main function generating the password. This function will take in 4 parameters and then
// generate the password by concatenating the words,number,special and seperator.

function generate_password() {

	check_input_values();
	
	$no_of_words = $GLOBALS['no_of_words'];
	$add_number = $GLOBALS['add_number'];
	$add_special = $GLOBALS['add_special'];
	$add_seperator = $GLOBALS['add_seperator'];
	$make_upper = $GLOBALS['make_upper'];
	
	// getting dictionary words into an array.
	$get_words = file('/usr/share/dict/words', FILE_IGNORE_NEW_LINES);

	// get the length of the array.. 
	$length = count($get_words);
  
	for (  $i=0; $i< $no_of_words; $i++ ) {
		
		$random_words = rand(0,$length);
		

			// This is to make the first letter upper case.
			if ( $make_upper == 0 ) {
			   $password = ( $password == '' ? ucwords($get_words[$random_words])  : 
			   							  $password . $add_seperator . ucwords($get_words[$random_words])  ) ;
			} else if ( $make_upper == 1 ) {
				$password = ( $password == '' ?  strtoupper($get_words[$random_words])  :
										   $password . $add_seperator . strtoupper($get_words[$random_words]) ); 
			} else {			
				$password = ( $password == '' ? $get_words[$random_words] : 
										   $password . $add_seperator . $get_words[$random_words] );
			}		
	}
        return trim($password . add_number($add_number) . add_special($add_special));	
}

?>
