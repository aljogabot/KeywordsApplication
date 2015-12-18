<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Keyword Results:</h4>
    </div>
    <div class="modal-body">
        <div class="alert form-message" style="display: none;"></div>
        <div class="alert alert-info">
            <h4 style="margin-bottom: 3px;">Multiplied Keywords</h4>
        </div>
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
                <li class="list-group-item">
                    <span class="badge">{{ count( $keywords ) }}</span>
                    Total Keywords
                </li>
            </ul>
        </div>
        <ul>
            @foreach( $keywords as $keyword )
                <li style="margin-bottom: 3px;">
                    <strong>{{ $keyword }}</strong>
                </li>
            @endForeach
        </ul>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default back-to-second-selection" data-url="{{ URL::route( 'keywords-second-selection-preview' ) }}">Back</button>
        <a href="{{ URL::route( 'keywords-save-to-file' ) }}" class="btn btn-primary">Save to File</a>
    </div>
</div><!-- /.modal-content -->