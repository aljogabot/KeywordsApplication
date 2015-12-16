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
			$reversedWordsLine = array_reverse( $wordsLine );

			$leftPhrase = '';
			foreach( $wordsLine as $word )
			{
				$leftPhrase = $this->processPhrasesFrom( 'Left', $leftPhrase, $word );
			}

			$rightPhrase = '';
			foreach( $reversedWordsLine as $word )
			{
				$rightPhrase = $this->processPhrasesFrom( 'Right', $rightPhrase, $word );
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
			if( strstr( $this->fileContent, "\n" ) )
			{
				$this->fileContent = explode( "\n", $this->fileContent );	
			}

			if( strstr( $this->fileContent, "\r" ) )
			{
				$this->fileContent = explode( "\r", $this->fileContent );
			}
		}

		if( $this->fileExtension == 'csv' )
		{
			if( strstr( $this->fileContent, "\n" ) )
			{
				$this->fileContent = explode( "\n", $this->fileContent );	
			}

			if( strstr( $this->fileContent, "\r" ) )
			{
				$this->fileContent = explode( "\r", $this->fileContent );
			}
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