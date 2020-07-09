
<div class="container mt-5">
    <h3>Upload file</h3>
    <div class="row">


        <form action="/statistic/file" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="input-group mt-5">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="statistic_file" name="statistic_file">
                    <label class="custom-file-label" for="statistic_file">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

