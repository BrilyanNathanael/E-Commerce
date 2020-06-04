<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<br><br>
    <div class="table-responsive">
        <form method="post" id="dynamic_form">
            <span id="result"></span>
            <table class="table table-bordered table-striped" id="menu_table">
                <thead>
                    <tr>
                        <th width="35%">Nama Menu</th>
                        <th width="35%">Deskripsi Menu</th>
                        <th width="30%">Harga Menu</th>
                        <th width="30%">Action</th>
                    </tr>
                    </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right">&nbsp;</td>
                        <td>
                        @csrf
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function(){

        var count = 1;
        dynamic_field(count);

        function dynamic_field(number)
        {
            html = '<tr>';
                html += '<td><input type="text" name="nama_menu[]" class="form-control" required/></td>';
                html += '<td><input type="text" name="deskripsi_menu[]" class="form-control" required/></td>';
                html += '<td><input type="text" name="harga_menu[]" class="form-control" required/></td>';
                if(number > 1)
                {
                    html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                    $('tbody').append(html);
                }
                else
                {   
                    html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                    $('tbody').html(html);
                }
        }

        $(document).on('click', '#add', function(){
            count++;
            dynamic_field(count);
        });

        $(document).on('click', '.remove', function(){
            count--;
            $(this).closest("tr").remove();
        });

        $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:'{{ route("RegisMenu.insert") }}',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {
                        if(data.error)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<p>'+data.error[count]+'</p>';
                            }
                            $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                        }
                        else
                        {
                            dynamic_field(1);
                            $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                        }
                        $('#save').attr('disabled', false);
                    }
            })
        });

    });
</script>