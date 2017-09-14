<?php

/**
 * @author Administrator
 *
 */
class User {
	public $username;
	public $password;
	public $name;
	public $email;
	public $properties = array ();
	public function __construct($username = null, $password = null, $name = null, $email = null, $properties = array()) {
		$this->username = $username;
		$this->password = $password;
		$this->name = $name;
		$this->email = $email;
		$this->properties = $properties;
	}
	public function asXML() {
		//
		$xml = '' . '<user>' . '<username>' . $this->username . '</username>' . '<password>' . $this->password . '</password>' . '<name>' . $this->name . '</name>' . '<email>' . $this->email . '</email>';
		
		if ($this->properties != null && count ( $this->properties ) > 0) {
			$xml = $xml . '<properties>';
			
			foreach ( $this->properties as $property ) {
				$xml = $xml . $property->asXML ();
			}
			
			$xml = $xml . '</properties>';
		}
		
		$xml = $xml . '</user>';
		
		return $xml;
	}
}
class Property {
	public $key;
	public $value;
	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}
	public function asXML() {
		$xml = '<property key="' . $this->key . '" value="' . $this->value . '" />';
		return $xml;
	}
}

?>