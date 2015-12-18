<div class="modal-content">
    <form name="keywords-first-preview-form" method="POST" action="{{ URL::route( 'keywords-second-selection-preview' ) }}">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Keyword Results:</h4>
        </div>
        <div class="modal-body">
            <div class="alert form-message" style="display: none;"></div>
            <div class="col-md-6">
                <div class="alert alert-info">
                    <h5>Repeated Phrases From Left</h5>
                </div>
                <ul>
                    @foreach( $phrasesFromLeft as $phrase => $count )
                        <li style="list-style: none;">
                            <div class="form-group">
                                <input class="form-group" {{ in_array( $phrase, $firstSelection ) ? 'checked' : '' }} type="checkbox" name="keywords[]" value="{{ $phrase }}" />
                                <label style="margin-left: 10px;">{{ $phrase }}</label>    
                            </div>
                        </li>
                    @endForeach
                </ul>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger">
                    <h5>Repeated Phrases From Right</h5>
                </div>
                <ul>
                    @foreach( $phrasesFromRight as $phrase => $count )
                        <li style="list-style: none;">
                            <div class="form-group">
                                <input class="form-group" {{ in_array( $phrase, $firstSelection ) ? 'checked' : '' }} type="checkbox" name="keywords[]" value="{{ $phrase }}" />
                                <label style="margin-left: 10px;">{{ $phrase }}</label>    
                            </div>
                        </li>
                    @endForeach
                </ul>
            </div>
            <div class="clearfix"></div>

            <div class="bs-component">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">{{ $totalPhrasesFromLeft }}</span>
                        Total Phrases From Left
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{{ $totalPhrasesFromRight }}</span>
                        Total Phrases From Right
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary process-keywords">Process</button>
        </div>
        <input type="hidden" name="fromFirstPreview" value="1" />
    </form>
</div><!-- /.modal-content -->