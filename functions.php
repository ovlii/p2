<?php

/*
* Name 			: Venkat Annangi
* Description	: xkcd style password generator 
* 
*/

function set_global_values() {
  // Initialize the global variables with defaults  
  $GLOBALS['no_of_words'] = '5';
  $GLOBALS['add_number'] = '0';
  $GLOBALS['add_special'] = '0';
  $GLOBALS['make_first_upper'] = '0';
  $GLOBALS['add_seperator'] = '-';
  $GLOBALS['make_all_upper'] = '0';
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
	// TODO 
	// getting special characters between ascii 33 and 126
	// excluding alphabets and numbers.
	
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
  
      $no_of_words = $_POST["no_of_words"];    

      if ( !empty($no_of_words) ){         
      	$GLOBALS['no_of_words'] = $no_of_words;
      }
      
      $add_number = $_POST["add_number"];
      $GLOBALS['add_number'] = $add_number;
      
      $add_special = $_POST["add_special"];	      
      $GLOBALS['add_special'] = $add_special;
      
      $make_first_upper = $_POST["make_first_upper"];     
	  $GLOBALS['make_first_upper'] = $make_first_upper;
      
      $add_seperator = $_POST["add_seperator"];   
      
      // if the seperator value is not empty      
      if ( !empty($add_seperator) ){         
      	$GLOBALS['add_seperator'] = $add_seperator;
      }
      
      $make_all_upper = $_POST['make_all_upper'];
      $GLOBALS['make_all_upper'] = $make_all_upper;
      
   }

}

// Main function generating the password. This function will take in 4 parameters and then
// generate the password by concatenating the words,number,special and seperator.

function generate_password() {

	check_input_values();
	
	$no_of_words = $GLOBALS['no_of_words'];
	$add_number = $GLOBALS['add_number'];
	$add_special = $GLOBALS['add_special'];
	$make_first_upper = $GLOBALS['make_first_upper'];
	$add_seperator = $GLOBALS['add_seperator'];
	$make_all_upper = $GLOBALS['make_all_upper'];
	
	
	// getting dictionary words into an array.
	$get_words = file('/usr/share/dict/words', FILE_IGNORE_NEW_LINES);

	// get the length of the array.. 
	$length = count($get_words);
  
	for (  $i=0; $i< $no_of_words; $i++ ) {
		
		$random_words = rand(0,$length);
		
		if ( $password == '' ) {

			// This is to make the first letter upper case.
			if ( $make_first_upper == 1 ) {
				$password = ucwords($get_words[$random_words]); 
			} else if ( $make_all_upper == 1 ) {
				$password = strtoupper($get_words[$random_words]); 
			} else {
				$password = $get_words[$random_words];
			}			
	
			
		} else {
			if ( $make_first_upper == 1 ) {
				$password = $password . $add_seperator . ucwords($get_words[$random_words]);
			} else if ( $make_all_upper == 1 ) {
				$password = $password . $add_seperator . strtoupper($get_words[$random_words]);
			} else {
				$password = $password . $add_seperator . $get_words[$random_words];
			}
			
		}
		
	}
	
	return $password . add_number($add_number) . add_special($add_special);
}

?>