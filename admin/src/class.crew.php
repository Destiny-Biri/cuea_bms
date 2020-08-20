<?php

class Crew{

	public $crew_id;
	public $crew_type;
	public $crew_name;

	function __construct(String $crew_id, String $crew_type, String $crew_name){
		$this->crew_id = $crew_id;
		$this->crew_type = $crew_type;
		$this->crew_name = $crew_name;
	}


}