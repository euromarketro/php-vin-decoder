<?php
/*
	Produced 2019
	By https://github.com/amattu2
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

// Exception Classes
class InvalidVINException extends Exception {}
class InvalidVINCharacterException extends Exception {}

// Vehicle Identification Number Class
class VIN {
	// Class Variables
	protected $VIN = "";
	protected $Characters = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

	/**
	* Class constructor
	*
	* @param string $vin
	* @return None
	* @throws TypeError, InvalidVINException, InvalidVINCharacterException
	**/
	public function __construct(string $vin) {
		// Checks
		if (strlen($vin) !== 17) {
			throw new InvalidVINException("VIN length is not 17 characters");
		}
		if ($this->validateCharacters($vin) !== true) {
			throw new InvalidVINCharacterException("VIN contains a invalid character");
		}

		// Variables
		$this->VIN = strtoupper($vin);
	}

	/**
	* Class stringify method
	*
	* @param None
	* @return string $vin
	* @throws None
	**/
	public function __tostring() : string {
		return "VIN:" . $this->VIN;
	}

	/**
	* Validate VIN characters
	*
	* @param string $vin
	* @return boolean valid
	* @throws TypeError
	*/
	protected function validateCharacters(string $vin) {
		// Variables
		$valid = true;

		// Loops
		for ($i = 0; $i < strlen($vin); $i++) {
			if (strpos($this->Characters, strtoupper($vin[$i])) !== false) {
				continue;
			} else {
				$valid = false;
				break;
			}
		}

		// Return
		return $valid;
	}
}
?>
