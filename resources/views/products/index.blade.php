@extends('layout')
  
@section('content')
<style>
.error{
color: #FF0000; 
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">   

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 card-header text-center font-weight-bold">
          <h2>Ajax Crud Operation</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewProduct" class="btn btn-success">Add</button></div>
        <div class="col-md-12">
       
            <table class="table" id="product-table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($product_data as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->contact }}</td>
                    <td>
                       <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $data->id }}">Edit</a>
                       <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $data->id }}">Delete</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
             {!! $product_data->links() !!}
        </div>
    </div>        
</div>

<!-- boostrap model -->
    <div class="modal fade" id="ajax-product-model" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajaxProductModel"></h4>
          </div>
          <div class="modal-body">
               @if ($errors->any())
                    <div class="alert alert-danger">
                        There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <form action="javascript:void(0)" id="addEditProductForm" name="addEditProductForm" class="form-horizontal" method="POST">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"> Name </label>
                <div class="col-sm-12">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                  @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror            
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label"> Email </label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"> Contact </label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Phone Number" value="" required="">
                  
                </div>
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewProduct">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function() {
        $('#product-table').DataTable();
        
    } );

 $(document).ready(function($){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addNewProduct').click(function () {
       $('#addEditProductForm').trigger("reset");
       $('#ajaxProductModel').html("Add Book");
       $('#ajax-product-model').modal('show');
    });
 
    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('edit-product') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
              $('#ajaxProductModel').html("Edit Book");
              $('#ajax-product-model').modal('show');
              $('#id').val(res.id);
              $('#name').val(res.name);
              $('#email').val(res.email);
              $('#contact').val(res.contact);
           }
        });

    });

    $('body').on('click', '.delete', function () {

       if (confirm("Delete Record?") == true) {
        var id = $(this).data('id');
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('delete-product') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){

              window.location.reload();
           }
        });
       }

    });

    $('body').on('click', '#btn-save', function (event) {

          var id = $("#id").val();
          var name = $("#name").val();
          var email = $("#email").val();
          var contact = $("#contact").val();

          $("#btn-save").html('Please Wait...');
          $("#btn-save"). attr("disabled", true);
         
        // ajax
        $.ajax({
            type:"POST",
            url: "{{ url('add-update-product') }}",
            data: {
              id:id,
              name:name,
              email:email,
              contact:contact,
            },
            dataType: 'json',
            success: function(res){
             window.location.reload();
            $("#btn-save").html('Submit');
            $("#btn-save"). attr("disabled", false);
           }
        });

    });

    
});
</script>

@endsection