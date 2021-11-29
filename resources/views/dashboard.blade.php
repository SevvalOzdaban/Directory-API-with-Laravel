<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Directory-API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://smtpjs.com/v3/smtp.js"></script>
</head>

<body>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD USER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="modalName" aria-describedby="emailHelp"
                                placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="modalEmail" placeholder="Email">
                        </div>
                        <label for="statu">Select Statu</label>
                        <select id="mySelect" class="form-select" aria-label="Default select example">
                            <option value="Active">Active</option>
                            <option value="Passive">Passive</option>
                        </select>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onClick="create()" id="submit">Save</button>
                    <button type="button" class="btn btn-primary" onClick="edit()" id="editBtn">Edits Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="d-grid gap-2 col-4 my-3 mx-auto">
        <button type="button" class="btn btn-primary" onclick="triggerModal()" data-toggle="modal"
            data-target="#exampleModal">
            ADD
        </button>
    </div>
    <table id="table" class="table table-striped ">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Api-Key</th>
                <th scope="col">Status</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody id="tbody">
        </tbody>
    </table>
</body>

<script>
    var apiKey, name, email, status, selectedApi, selectedRow;
    //show datas from db
    $.ajax({
        url: "{{ route('index') }}",
        type: "GET",
        data: {
            name: name,
            email: email,
            status: status,
        },
        success: function(data) {
            var item = {!! json_encode($client) !!}; // object
            item.forEach(element => {
                var deneme = '<tr id=' + element.id + '>' +
                    '<td id="name' + element.id + '">' + element.name + '</td>' +
                    '<td id="email' + element.id + '">' + element.email + '</td>' +
                    '<td id="apiKey' + element.id + '">' + element.apiKey + '</td>' +
                    '<td id="status' + element.id + '">' + element.status + '<td>' +
                    '<button type="button" class="btn btn-danger" onclick="editUser(' + element.id +
                    ')" data-toggle="modal" data-target="#exampleModal">Edit </button>' +
                    '</tr>';
                $("table tbody").append(deneme);
            });
        },
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $("#editBtn").hide();

    //clear the model    
    function triggerModal() {
        $("#exampleModalLabel").text("ADD USER");
        $("#editBtn").hide();
        $("#submit").show();
        $('#modalName').val("");
        $('#modalEmail').val("");
    }
    //append user information to db
    function create() {
        name = $('#modalName').val();
        email = $('#modalEmail').val();
        status = $("#mySelect").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('create') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name: name,
                email: email,
                status: status,
            },
            
            success: function(response) {
                console.log(response);
                var deneme = '<tr id=' + response.data.id + '>' +
                    '<td id="name' + response.data.id + '">' + name + '</td>' +
                    '<td id="email' + response.data.id + '">' + email + '</td>' +
                    '<td id="apiKey' + response.data.id + '">' + response.data.apiKey + '</td>' +
                    '<td id="status' + response.data.id + '">' + status + '</td>' +
                    '<td><button type="button" class="btn btn-danger" onclick="editUser(' + response.data.id +
                    ')" data-toggle="modal" data-target="#exampleModal">Edit </button></td>' +
                    '</tr>';
                $("table tbody").append(deneme);
            },
        });
        $("#exampleModal .close").click();
        $(".modal-body input").val(" ");
    }

    function editUser(id) {
        $("#editBtn").show();
        $("#submit").hide();
        $("#exampleModalLabel").text("EDIT USER");
        //fill modal with chosen one
        $("#modalName").val($("#name" + id).text());
        $("#modalEmail").val($("#email" + id).text());
        $("#mySelect").val($("#status" + id).text());
        //add api area and value to edit modal
        // selectedApi = $("#apiKey" + id).text();
        // var label = $("<label>").text("Api-Key");
        // var labelContent = $(" <input type='text' class='form-control' readonly>");
        // labelContent.val(selectedApi);
        // $(".modal-body").append(label);
        // $(".modal-body").append(labelContent);
        selectedRow = id;
    }

    function edit() {
        var newName = $("#modalName").val();
        var newEmail = $("#modalEmail").val();
        var newStatus = $("#mySelect").val();
        console.log('id :>> ', selectedRow);
        $("#name" + selectedRow).text(newName);
        $("#email" + selectedRow).text(newEmail);
        $("#status" + selectedRow).text(newStatus);
        console.log(selectedRow);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ url('/edit') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: selectedRow,
                name: newName,
                email: newEmail,
                apiKey: selectedApi,
                status: newStatus,
            },
            success: function() {
                console.log('edit is succesfull');
            },
        });
        $("#exampleModal .close").click();
        $(".modal-body input").val(" ");
    }
</script>

</html>
