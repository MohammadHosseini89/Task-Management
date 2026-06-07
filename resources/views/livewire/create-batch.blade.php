<div wire:poll.180000ms>

    <style>
        .bg-custom {
            background:
                rgba(255, 255, 255, 0.92);
        }


        .modal-body {
            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0.92),
                    rgba(250, 250, 250, 0.99));
        }

        .my-container {
            height: 50%;
            width: 50%;
        }

        .my-table {
            height: 100%;
            width: 100%;
            font-size: 10px;
        }

        th,
        td {
            /* Set the width of each column as a percentage of the table's overall width */
            width: 25%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: bold;
            color: azure;
            font-family: "Arial", sans-serif;
        }

        .table-bordered {
            border: 1px solid burlywood;
        }

        .a {
            color: burlywood
        }

        .line {
            border-top: 2px solid rgb(24, 2, 41);
            margin: 20px 0;
        }
    </style>


    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success text-center">{{ session('message') }}</div>
    @endif

    <div class="row justify-content col-md-12">
        <div class="ml-2 mt-2">
            <form action="{{ route('batchupload') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                @csrf
                <div class="form-group"
                    style="border-bottom: 1px solid rgb(10, 10, 109);
                border-right: 1px solid rgb(10, 10, 109);
                border-top: 1px solid rgb(10, 10, 109);
                border-left: 1px solid rgb(10, 10, 109);">
                    <label for="csv_file" class="sr-only">Select CSV File For Create</label>
                    <input style="color:rgb(2, 45, 45)" type="file" name="csv_file" class="form-control-file"
                        id="csv_file">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Upload Batch Create</button>
            </form>
        </div>

    </div>
    <a class="mt-2 ml-2" style="color:rgb(0, 0, 0)" href="{{ route('downloadbatchtemplate') }}">Download Template
        Batch Create
    </a>

    <div class="line" style="color:black"></div>

    <div class="row justify-content-center col-md-12">
        <form action="{{ route('downloadallrunningsubtasks') }}" method="POST" enctype="multipart/form-data"
            class="form-inline">
            @csrf
            <button type="submit" class="btn btn-dark ml-2">Export All Sub Tasks</button>
        </form>
    </div>

    <div class="line" style="color:black"></div>

    <div class="row justify-content-center col-md-12" style="font-weight:bold">
        <div class="col bg-warning rounded col-md-10" style="text-align: center">
            You Can Only Change "Impact, RC, Solution, Solution2, Status, Progress, Feedback" Columns Value
        </div>
    </div>



    <div class="row justify-content col-md-12">
        <div class="ml-2 mt-2">
            <form action="{{ route('batchuploadupdate') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                @csrf
                <div class="form-group"
                    style="border-bottom: 1px solid rgb(10, 10, 109);
                border-right: 1px solid rgb(10, 10, 109);
                border-top: 1px solid rgb(10, 10, 109);
                border-left: 1px solid rgb(10, 10, 109);">
                    <label for="csv_file" class="sr-only">Select CSV File For Update</label>
                    <input style="color:rgb(2, 45, 45)" type="file" name="csv_file" class="form-control-file"
                        id="csv_file">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Upload Batch Update</button>
            </form>
        </div>

    </div>
    <a class="mt-2 ml-2" style="color:rgb(0, 0, 0)" href="{{ route('downloadbatchupdatetemplate') }}">Download Template
        Batch Update
    </a>

    <div class="line" style="color:black"></div>


    <div class="row justify-content col-md-12">
        <div class="ml-2 mt-2">
            <form action="{{ route('batchuploadcomplete') }}" method="POST" enctype="multipart/form-data" class="form-inline">
                @csrf
                <div class="form-group"
                    style="border-bottom: 1px solid rgb(10, 10, 109);
                border-right: 1px solid rgb(10, 10, 109);
                border-top: 1px solid rgb(10, 10, 109);
                border-left: 1px solid rgb(10, 10, 109);">
                    <label for="csv_file" class="sr-only">Select CSV File For Complete</label>
                    <input style="color:rgb(2, 45, 45)" type="file" name="csv_file" class="form-control-file"
                        id="csv_file">
                </div>
                <button type="submit" class="btn btn-dark ml-2">Upload Batch Complete Task</button>
            </form>
        </div>

    </div>
    <a class="mt-2 ml-2" style="color:rgb(0, 0, 0)" href="{{ route('downloadbatchcompletetemplate') }}">Download Template
        Batch Complete
    </a>

    <div class="line" style="color:black"></div>
</div>
