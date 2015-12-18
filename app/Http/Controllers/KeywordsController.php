<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

use Company\Handlers\ResponseHandlers\JsonResponse;

use Company\Services\Keywords\KeywordService;
use Company\Services\Keywords\KeywordValidation;
use Company\Services\Keywords\KeywordSession;

use App\Http\Requests\KeywordSelectionRequest;

class KeywordsController extends Controller
{
    protected $json;
    protected $keywordService;
    protected $keywordValidation;
    protected $keywordSession;

    public function __construct( 
        JsonResponse $json, KeywordService $keywordService, 
        KeywordValidation $keywordValidation, KeywordSession $keywordSession
    )
    {
        $this->json                 = $json;
        $this->keywordService       = $keywordService;
        $this->keywordValidation    = $keywordValidation;
        $this->keywordSession       = $keywordSession;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'keywords.main' );
    }

    public function processUserInput( Request $request )
    {
        // 1. Get Dependencies
        // 2. Validate
        // 3. Process The Input
        $threshold = $request->get( 'threshold' );
        $file = $request->file( 'file' );

        // We are still testing baby ...
        // Uncomment this when done ...
        // $this->keywordSession->flush();

        // Validation of Upload ...
        $this->keywordValidation->init( [ 'threshold' => $threshold, 'file' => $file ] );

        if( ! $this->keywordValidation->validate() )
            return $this->json->error( $this->keywordValidation->getErrors() );

        // Process the Validated File ...
        $this->keywordService->init( 
            [ 'threshold' => $threshold, 'fileContent' => file_get_contents( $file ), 'fileExtension' => $file->getClientOriginalExtension() ]
        )->process();

        $this->keywordSession->setKeywordsData( $this->keywordService->getData() );

        return $this->firstSelectionPreview();
    }

    public function firstSelectionPreview()
    {
        // If User Goes Back ... He will still see his first selections ....
        $firstSelection = $this->keywordSession->getFirstSelection();

        // Display to the User the processed Keywords based on the Threshold ...
        $content = \View::make( 'keywords.modals.first-preview', array_merge( $this->keywordSession->getKeywordsData(), [ 'firstSelection' => $firstSelection ] ) )
                            ->render();

        return $this->json->set( 'content', $content )
                    ->success();
    }

    public function secondSelectionPreview( KeywordSelectionRequest $request )
    {
        if( $request->has( 'fromFirstPreview' ) )
            $this->keywordSession->setFirstSelection( $request->get( 'keywords' ) );

        // If User Goes Back ... He will still see his first selections ....
        $secondSelection = $this->keywordSession->getSecondSelection();

        // Display to the User the processed Keywords based on the Threshold ...
        $content = \View::make( 'keywords.modals.second-preview', array_merge( $this->keywordSession->getKeywordsData(), [ 'secondSelection' => $secondSelection ] ) )
                            ->render();

        return $this->json->set( 'content', $content )
                    ->success();
    }

    public function multiplied( KeywordSelectionRequest $request )
    {
        $this->keywordSession->setSecondSelection( $request->get( 'keywords' ) );
        
        //$this->keywordService->setData( $this->keywordSession->getKeywordsData() );
        $this->keywordService->setFirstSelection( $this->keywordSession->getFirstSelection() );
        $this->keywordService->setSecondSelection( $this->keywordSession->getSecondSelection() );

        // Display to the User the processed Keywords based on the Threshold ...
        $content = \View::make( 'keywords.modals.multiplied', 
                        array_merge(
                            [ 'keywords' => $this->keywordService->getMultipliedPhrases() ],
                            $this->keywordSession->getKeywordsData()
                        )
                    )->render();

        return $this->json->set( 'content', $content )
                    ->success();
    }

    public function saveToFile()
    {   
        $this->keywordService->setFirstSelection( $this->keywordSession->getFirstSelection() );
        $this->keywordService->setSecondSelection( $this->keywordSession->getSecondSelection() );

        $keywords = $this->keywordService->getMultipliedPhrases();

        $output = implode( "\n", $keywords );

        $filename = "keywords-" . time() . ".csv";

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            );

        // our response, this will be equivalent to your download() but
        // without using a local file
        return \Response::make(rtrim($output, "\n"), 200, $headers);
    }
}