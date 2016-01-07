<?php

/**
 * Crew Class represents the general model for a crew
 *
 * @package JPinkney\TVMaze
 * @author  jpinkney
 */

namespace JPinkney\TVMaze;

class Crew {

	/**
	 * @var
	 */
	public $type;

	/**
	 * @param $crew_data
	 */
	function __construct($crew_data){
		$this->type = $crew_data['type'];
	}

};