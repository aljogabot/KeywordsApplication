@extends( 'layout' )
@section( 'content' )
    <form name="keywords-form" method="POST" action="{{ URL::route( 'keyword-preview-selection' ) }}" accept-charset="UTF-8" enctype="multipart/form-data">
        <h2 class="form-signin-heading">FAQ Keywords Multiplier</h2>
        <br />
        <div class="alert alert-info">This is an App where you can multiply your selected keywords ...</div>

        <div class="form-group">
            <label for="mult_threshold">Enter Threshold</label>
            <input type="text" maxlength="2" id="threshold" name="threshold" class="form-control" placeholder="Multiple Threshold" required autofocus>    
        </div>
        <div class="form-group">
            <label for="faq_file">Upload FAQ File</label>
            <input type="text" id="file_label" name="file_label" class="form-control" placeholder="Please upload your FAQ file (.txt/.csv)" readonly required autofocus>        
            <div class="file-upload btnupl btnupl-primary"><span>Upload</span>
                <input class="upload" type="file" id="upload" name="file">
            </div>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        </br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Process</button>
    </form>
@endsection