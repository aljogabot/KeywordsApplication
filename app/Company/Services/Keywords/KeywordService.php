<?php

namespace Company\Services\Keywords;

class KeywordService {

	protected $threshold;
	protected $fileContent;
	protected $fileExtension;

	public $phrasesFromLeft = [];
	public $phrasesFromRight = [];

	public function init( $configuration )
	{
		foreach( $configuration as $property => $value )
		{
			$this->$property = $value;
		}

		return $this;
	}

	public function process()
	{
		$this->explodeLines();
		
		foreach( $this->fileContent as $wordLine )
		{
			$wordLine = $this->sanitize( $wordLine );
			$wordsLine = explode( " ", $wordLine );

			$phrase = '';
			foreach( $wordsLine as $word )
			{
				$phrase = $this->processPhrasesFrom( 'Left', $phrase, $word );
			}
		}

		foreach( $this->fileContent as $wordLine )
		{
			$wordLine = $this->sanitize( $wordLine );
			$wordsLine = explode( " ", $wordLine );
			$wordsLine = array_reverse( $wordsLine );

			$phrase = '';
			foreach( $wordsLine as $word )
			{
				$phrase = $this->processPhrasesFrom( 'Right', $phrase, $word );
			}
		}

		$this->applyThreshold();
	}

	public function applyThreshold()
	{
		foreach( $this->phrasesFromLeft as $keyword => $numberOfOccurence )
		{
			if( $numberOfOccurence < $this->threshold )
			{
				unset( $this->phrasesFromLeft[ $keyword ] );
			}
		}

		foreach( $this->phrasesFromRight as $keyword => $numberOfOccurence )
		{
			if( $numberOfOccurence < $this->threshold )
			{
				unset( $this->phrasesFromRight[ $keyword ] );
			}
		}
	}

	public function processPhrasesFrom( $from, $phrase, $word )
	{
		$property = 'phrasesFrom' . $from;

		if( $from == 'Right' )
		{
			$phrase = ! empty( $phrase ) ? $word . ' ' . $phrase : $word;
		} else {
			$phrase = ! empty( $phrase ) ? $phrase . ' ' . $word : $word;	
		}
		
		if( ! isset( $this->{$property}[ $phrase ] ) )
		{
			 $this->{$property}[ $phrase ] = 0;
		}
		$this->{$property}[ $phrase ]++;

		return $phrase;
	}

	public function explodeLines()
	{
		if( $this->fileExtension == 'txt' )
		{
			$this->fileContent = explode( "\n", $this->fileContent );
		}

		if( $this->fileExtension == 'csv' )
		{
			$this->fileContent = explode( ",", $this->fileContent );	
		}
	}

	public function sanitize( $wordLine )
	{
		$wordLine = str_replace( "-", "", $wordLine );
		$wordLine = str_replace( " ", "-", $wordLine );
		$wordLine = preg_replace( '/[^a-zA-Z0-9-]/', '', $wordLine );
		return str_replace( "-", " ", $wordLine );
	}

	public function getData()
	{
		$totalLeftPhrases 	= count( $this->phrasesFromLeft );
		$totalRightPhrases 	= count( $this->phrasesFromRight );
		return [ 
			'phrasesFromLeft' 	 => $this->phrasesFromLeft,
			'phrasesFromRight' 	 => $this->phrasesFromRight,
			'totalLeftPhrases'   => $totalLeftPhrases,
			'totalRightPhrases'  => $totalRightPhrases,
			'totalKeywords'   	 => $totalLeftPhrases + $totalRightPhrases
		];
	}

	public function getMultipliedPhrases()
	{
		$output = [];

		foreach( $this->phrasesFromRight as $rightPhrase )
		{
			foreach( $this->phrasesFromLeft as $leftPhrase )
			{
				$output[] = $leftPhrase . ' ' . $rightPhrase;
			}
		}

		return $output;
	}
}