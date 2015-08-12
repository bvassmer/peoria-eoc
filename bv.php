<?php
/**
 * Resume Submission Web Service
 *
 * PHP version 5
 *
 * @author     Benjamin Vassmer <bvassmer@gmail.com>
 * @version    0.0.1 Alpha
 */
 
	//GET Reqest "question"
	$ques = $_GET['q'];
	//GET Request "description" 
	$desc = $_GET['d'];
	
	switch ($ques) {
    case "Ping":
	    echo "OK";
	    break;
    case "Name":
    	echo "Benjamin Vassmer";
    	break;
    case "Email Address":
    	echo "bvassmer@gmail.com";
    	break;
    case "Phone":
    	echo "(405) 512-2028";
    	break;
    case "Position":
    	echo "Senior Software Developer";
    	break;
    case "Years":
    	echo "6.5 Years";
    	break;
    case "Referrer":
    	echo "Stack Overflow Careers";
    	break;
    case "Degree":
    	echo "* Rogers State University: B.S., Information Technology emp. on Computer Programming. * Oklahoma City Community College: A.S. Computer Science";
    	break;
    case "Resume":
    	echo "http://w5dge.com/resume/";
    	break;
    case "Source":
    	echo "http://w5dge.com/resume/webservice.txt";
    	break;
    case "Status":
    	echo "Yes.";
    	break;
    case "Puzzle":
    	$compare_data = parse_puzzle($desc);
    	$ordered_clues = order_clues($compare_data);

    	$a = 0;
    	$b = 1;
    	$c = 2;
    	$d = 3;
    	
    	//output puzzle answer table
    	echo " ABCD\n";
    	echo "A".compare($a, $a, $ordered_clues).compare($a, $b, $ordered_clues).compare($a, $c, $ordered_clues).compare($a, $d, $ordered_clues)."\n";
    	echo "B".compare($b, $a, $ordered_clues).compare($b, $b, $ordered_clues).compare($b, $c, $ordered_clues).compare($b, $d, $ordered_clues)."\n";
    	echo "C".compare($c, $a, $ordered_clues).compare($c, $b, $ordered_clues).compare($c, $c, $ordered_clues).compare($c, $d, $ordered_clues)."\n";
    	echo "D".compare($d, $a, $ordered_clues).compare($d, $b, $ordered_clues).compare($d, $c, $ordered_clues).compare($d, $d, $ordered_clues)."\n";
    	break;
    	
	}
	
	/**
   * Parses the puzzle string provided
   *
   * @param string 	$puzzle_str 			the puzzle string to parse
	 * @return array(array(),array()) 	[0]=comparison operators [1]=keys (ABCD=0123)
   */
 	function parse_puzzle($puzzle_str) {
		$pos_array = array(strrpos($puzzle_str, "A")+1, strrpos($puzzle_str, "B")+1,strrpos($puzzle_str, "C")+1, strrpos($puzzle_str, "D")+1);
		$pos_keys = array();
		$pos_compel = array();
		
		for($p = 0; $p < count($pos_array); $p++){
			for($i = $pos_array[$p];$i < $pos_array[$p] + 4; $i++){
				$comp_element = $i - $pos_array[$p];
				if(substr($puzzle_str, $i, 1) !== "-"){
					$pos_compel[$p] = $comp_element;
					$pos_keys[$p] = substr($puzzle_str, $i, 1);
					continue;
				}
			}
		}
		$data_array = array($pos_compel, $pos_keys);
		return $data_array;		
	} //parse_puzzle END
	
	/**
   * Readies the clues for later comparison
   *
   * @param array(array(),array()) 	$compare_data 		data array from parse_puzzle()
	 * @return array																		contains the order of the clues
   */
	function order_clues($compare_data) {
		$final_clue_array = array(0,0,0,0); 
		$pos_keys = $compare_data[0];
		$pos_compel = $compare_data[1];

		for($i = 0; $i < count($final_clue_array); $i++){
			//we don't need to know if an element is equal, keep the loop moving.
			if($pos_compel[$i] === "=") {
				continue;
			}
			
			//Determine greater/less, and in/decrement the clue's counters
			if($pos_compel[$i] === ">") {
				$final_clue_array[$i]++;
				$final_clue_array[$pos_keys[$i]]--;
			} else if ($pos_compel[$i] === "<") {
				$final_clue_array[$pos_keys[$i]]++;
				$final_clue_array[$i]--;
			} 
		}
		
		//Find and create the last comparison we need to complete the puzzle
		for($i = 0; $i < count($pos_keys); $i++){
			for($j = 0; $j < count($pos_keys); $j++){
				if($i !== $j && $pos_keys[$i] !== $i && $pos_keys[$j] !== $j && $i === $pos_keys[$j]) {

					if($pos_compel[$i] === ">") {
						$final_clue_array[$pos_keys[$j]]++;
						$final_clue_array[$j]++;
						
					} /* else if ($pos_compel[$i] === "<") {
						//do we need this? Haven't gotten the puzzle to fail without it...
						$final_clue_array[$pos_keys[$j]]--;
						$final_clue_array[$j]--;
					} */
					
				}			
			}
		}
		return $final_clue_array;
	} // order_clues END
	
	/**
   * Compares the clues to create output table
   *
   * @param int $a 								first key to compare
   * @param int $b 								second key to compare
   * @param array $ordered_var 		data array from order_clues()
	 * @return string								formatted data for output table
   */
	function compare($a, $b, $ordered_var) {
		if($ordered_var[$a] === $ordered_var[$b]) {
			return "=";
		}
		if($ordered_var[$a] > $ordered_var[$b]) {
			return ">";
		}
		if($ordered_var[$a] < $ordered_var[$b]) {
			return "<";
		}		
	} //compare END
	
?>