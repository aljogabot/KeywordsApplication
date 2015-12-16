<?php

namespace Company\Services\Keywords;

class KeywordValidation {

	protected $threshold;
	protected $file;

	public $phrasesFromLeft = [];
	public $phrasesFromRight = [];
	
	protected $errors = [];

	public function init( $configuration )
	{
		foreach( $configuration as $property => $value )
		{
			$this->$property = $value;
		}
	}

	public function filterValues()
	{
		$this->threshold = (int) $this->threshold;
	}

	public function validate()
	{
		$this->filterValues();

		$fileExtension = $this->file->getClientOriginalExtension();

		if( $fileExtension != 'csv' && $fileExtension != 'txt' )
		{
			$this->errors[] = 'File must be either TXT or CSV';
			return FALSE;
		}

		if( $this->threshold < 1 || $this->threshold > 99 )
		{
			$this->errors[] = 'Threshold must be greater than 0 and less than 100';
			return FALSE;	
		}

		return TRUE;
	}

	public function getErrors()
	{
		return implode( '<br />', $this->errors );
	}

	public function validatePhrases()
	{
		$totalLeftPhrases 	= count( $this->phrasesFromLeft );
		$totalRightPhrases 	= count( $this->phrasesFromRight );

		if( $totalLeftPhrases == 0 )
		{
			$this->errors[] = 'Please select atleast 1 phrase from the left';
			return FALSE;
		}

		if( $totalRightPhrases == 0 )
		{
			$this->errors[] = 'Please select atleast 1 phrase from the right';
			return FALSE;
		}

		return TRUE;
	}
}