<?php

namespace Company\Services\Keywords;

use Session;

class KeywordSession {
	
	protected $firstSelection = [];
    protected $secondSelection = [];

    protected $keywordsData = [];

	public function __construct()
	{
		if( Session::has( 'firstSelection' ) )
        {
            $this->firstSelection = Session::get( 'firstSelection' );
        }

        if( Session::has( 'secondSelection' ) )
        {   
            $this->secondSelection = Session::get( 'secondSelection' );
        }

        if( Session::has( 'keywordsData' ) )
        {
        	$this->keywordsData = Session::get( 'keywordsData' );
        }
	}

	public function destroy()
	{
		Session::forget( 'firstSelection' );
		Session::forget( 'secondSelection' );
		Session::forget( 'keywordsData' );
	}

	public function setKeywordsData( $data )
	{
		$this->keywordsData = $data;
		Session::set( 'keywordsData', $data );
	}

	public function getKeywordsData()
	{
		return $this->keywordsData;
	}

	public function setFirstSelection( $data )
	{
		$this->firstSelection = $data;
		Session::set( 'firstSelection', $data );
	}

	public function setSecondSelection( $data )
	{
		$this->secondSelection = $data;
		Session::set( 'secondSelection', $data );
	}

	public function getFirstSelection()
	{
		return $this->firstSelection;
	}

	public function getSecondSelection()
	{
		return $this->secondSelection;	
	}

}