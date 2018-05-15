@extends('admin.layout.master')
@section('content')
    <style>
        p {
            margin-top: 0;
            margin-bottom: 3px;
            color: #c9cacc;
            font-style: normal;
            font-size: 14px;
        }

        #progress-wrp {
            padding: 1px;
            position: relative;
            height: 30px;
            margin: 10px;
            text-align: left;
            box-shadow: inset 3px -20px 6px 19px rgba(0, 0, 0, 0.12)
        }

        #progress-wrp .progress-bar {
            height: 100%;
            border-radius: 3px;
            background-color: #666;
            width: 0;
            box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
        }

        #progress-wrp .status {
            top: 3px;
            left: 50%;
            position: absolute;
            display: inline-block;
            color: #000000;
        }
    </style>

    <main class="main-content bgc-grey-100">
        <div id="mainContent">
            <div class="row pos-r" style="position: relative; height: 1096px;">
                <div class="masonry-sizer col-md-6"></div>
                <div class="masonry-item col-md-6" style="position: absolute; left: 0%; top: 0px;">
                    <div class="bgc-white p-20 bd"><h6 class="c-grey-900">CV Parser Form</h6>
                        <div class="mT-30">

                            <form>
                                <div class="form-group"><label for="exampleInputEmail1">Cvs zip File</label> <input
                                            type="file" id="file" name="file" class="form-control"
                                            aria-describedby="fileHelp">
                                    <small id="fileHelp" class="form-text text-muted">We'll never share your email with
                                        anyone else.
                                    </small>
                                </div>

                                <button type="submit" id="test" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="    max-width: 60%;">
            <div class="modal-content"
                 style="background-color: #32383e;height: 700px;overflow-y: auto;">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Output Progress Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div style="margin: 5%">

                    <div id="progress-wrp">
                        <div class="progress-bar"></div>
                        <div class="status">0%</div>
                    </div>

                    <div class="mT-30" id="output">
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('js')
            <script
                    src="https://code.jquery.com/jquery-3.3.1.js"
                    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
                    crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
            <script>

                var output = document.getElementById('output');


                document.getElementById('test').onclick = function () {

                    event.preventDefault();
                    $('#exampleModal').modal('show');

                    var formData = new FormData();
                    formData.append("upload[file]", document.getElementById("file").files[0]);

                    var xhr = new XMLHttpRequest();
                    xhr.previous_text = '';

                    xhr.onerror = function () {
                        alert("[XHR] Fatal Error.");
                    };

                    xhr.onreadystatechange = function () {
                        var new_response = xhr.responseText.substring(xhr.previous_text.length);
                        new_response = new_response.split('##');

                        $.each(new_response, function (index, value) {
                            if (value != '') {
                                var result = JSON.parse(value);
                                var result_element = document.createElement('p');
                                result_element.style.color = result.color;
                                result_element.innerText = result.message;

                                if (result.text_shadow)
                                    result_element.style.textShadow = '2px 3px #00000073';


                                output.appendChild(result_element);


                                if (result.progress) {
                                    $(".progress-bar").css("width", +result.progress + "%");
                                    $(".status").text(result.progress + "%");
                                }
                                if (result.progress == 100) {
                                    $(".progress-bar").css('background-color', '#2bbc8a');
                                }

                            }
                        });
                        xhr.previous_text = xhr.responseText;
                    }

                    xhr.open("POST", "{{route('cv.parse')}}");
                    xhr.send(formData);
                };
            </script>
@endsection
