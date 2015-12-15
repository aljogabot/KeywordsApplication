<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

use Company\Handlers\ResponseHandlers\JsonResponse;

use Company\Services\Keywords\KeywordService;
use Company\Services\Keywords\KeywordValidation;

class KeywordsController extends Controller
{
    protected $json;
    protected $keywordService;
    protected $keywordValidation;

    public function __construct( JsonResponse $json, KeywordService $keywordService, KeywordValidation $keywordValidation )
    {
        $this->json = $json;
        $this->keywordService = $keywordService;
        $this->keywordValidation = $keywordValidation;
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

    public function preview( Request $request )
    {
        // 1. Get Dependencies
        // 2. Validate
        // 3. Process The Input
        $threshold = $request->get( 'threshold' );
        $file = $request->file( 'file' );

        // Validation of Upload ...
        $this->keywordValidation->init( [ 'threshold' => $threshold, 'file' => $file ] );

        if( ! $this->keywordValidation->validate() )
            return $this->json->error( $this->keywordValidation->getErrors() );

        // Process the Validated File ...
        $this->keywordService->init( 
            [ 'threshold' => $threshold, 'fileContent' => file_get_contents( $file ), 'fileExtension' => $file->getClientOriginalExtension() ]
        )->process();

        // Display to the User the processed Keywords based on the Threshold ...
        $content = \View::make( 'keywords.modals.preview', $this->keywordService->getData() )
                            ->render();

        return $this->json->set( 'content', $content )
                    ->success();
    }

    public function multiplied( Request $request )
    {
        $this->keywordValidation->init( 
            [ 'phrasesFromLeft' => $request->get( 'leftPhrases' ), 'phrasesFromRight' => $request->get( 'rightPhrases' ) ] 
        );

        if( ! $this->keywordValidation->validatePhrases() )
            return $this->json->error( $this->keywordValidation->getErrors() );

        $this->keywordService->init( 
            [ 'phrasesFromLeft' => $request->get( 'leftPhrases' ), 'phrasesFromRight' => $request->get( 'rightPhrases' ) ]
        );

        // Display to the User the processed Keywords based on the Threshold ...
        $content = \View::make( 'keywords.modals.multiplied', 
                        [ 
                            'keywords' => $this->keywordService->getMultipliedPhrases(),
                            'totalPhrasesFromLeft' => count( $this->keywordService->phrasesFromLeft ),
                            'totalPhrasesFromRight' => count( $this->keywordService->phrasesFromRight )
                        ] 
                    )->render();

        return $this->json->set( 'content', $content )
                    ->success();
    }
}