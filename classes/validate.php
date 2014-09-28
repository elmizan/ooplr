<?php

class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach ($items as $item => $rules){
			foreach ($rules as $rule => $rule_values){

				$value = $source[$item];

				if($rule === 'required' && empty($value)){
					$this->addError("{$item} is required");
				}
				else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_values){
								$this->addError("{$item} must be a minimum of {$rule_values} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_values){
								$this->addError("{$item} must be a maximum of {$rule_values} characters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_values]){
								$this->addError("{$rule_values} must match {$item}");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_values, array($item, '=', $value));
							if($check->count()){
								$this->addError("{$item} already exists.");
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}

	public function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		 return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}