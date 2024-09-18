<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="container d-flex justify-content-center pt-5">
        <div class="col-md-9">
            <h2 class="text-center pb-3 text-danger">Add or remove student</h2>
            @if ($errors->any())
                    <div class="alert alert-danger"></div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success text-center"></div>
                        <ul>
                            <li>{{ Session::get('success') }}</li>
                        </ul>
                    </div>
                @endif

            <form action="/post" method="post">
                @csrf

                <table class="table table-bordered" id="table">
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="inputs[0]['name']" placeholder="Enter name" class="form-control"></td>
                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                    </tr>
                </table>

                <button type="submit" class="btn btn-primary col-md-2">Save</button>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        var i = 0;
        $('#add').click(function(){
            ++i;
            $('#table').append(
                '<tr>' +
                    '<td><input type="text" name="inputs['+i+'][name]" placeholder="Enter name" class="form-control"></td>' +
                    '<td><button type="button" class="btn btn-danger remove-table-row">Remove</button></td>' +
                '</tr>'
            );
        });
        // Remove row when "Remove" button is clicked
        $(document).on('click', '.remove-table-row', function(){
        $(this).closest('tr').remove();
    });
    </script>
  </body>
</html>
