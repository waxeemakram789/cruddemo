@extends('index')
@section('content')
  <div class="content">
    <section>
        <div class="alert alert-success content-xy mt-2" role="alert" id="successAlert">
            <h4 class="alert-heading" id="successMessage">Well done!</h4>
          </div>
        <div class="row">
            
                    
            <!-- /.card-header -->
            <!-- form start -->
            <div class="col-12 card mt-5">
                <form  method="post" id="userdet" enctype="multipart/form-data">
                    @csrf    
                    <div class="card-body row">
                        <div class="form-group col-8">
                            <label for="cat_name">Full Name</label>
                            <input type="text" name="name" class="form-control only_alpha" id="full_name" placeholder="Enter Your Full Name" data-bs-toggle="tooltip"  title="YOU CAN WRITE ONLY ALPHABET" >
                            
                            <span class="text-danger test" id="namespan"></span>
                            
                        </div>
                        <div class="form-group col-8">
                            <label for="cat_name">Email</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Your Email">
                            
                            <span class="text-danger test" id="emailspan"></span>
                            
                        </div>

                        <div class="form-group col-8">
                            <label for="cat_name">Mobile</label>
                            <input type="text" name="phone" class="form-control only_num"  id="phone" placeholder="Enter Your phone Number" minlength="10" maxlength="10"  data-bs-toggle="tooltip"  title="YOU CAN WRITE ONLY NUMBERS">
                            
                            <span class="text-danger test" id="phonespan"></span>
                            
                        </div>

                        <div class="form-group col-8">
                            <label for="cat_name">Image</label>
                            <input type="file" name="image" class="form-control only_num"  id="Image"  data-bs-toggle="tooltip"  title="Upload File">
                            
                            <span class="text-danger test" id="imagespan"></span>
                            
                        </div>
                        
                        <div class="form-group">
                            <label for="desc">Content*</label>
                            <textarea id="desc" name="desc" class="form-control @error('desc') is-invalid @enderror"></textarea>
                            
                                <span class="invalid-feedback test" role="alert" id="descspan">
                                    <strong></strong>
                                </span>
                            
                        </div>
                        <div class="form-group col-8">
                            <label>Role</label>
                            <select class="form-control select2" name="role" style="width: 100%;">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">
                                    {{$role->user_role}}
                                </option>
                                @endforeach
                            </select>
                            
                                <span class="text-danger test" id="rolespan"></span>
                            
                        </div>   
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-12 mt-5">
                <table class="table table-striped-columns">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Role ID</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    
                    <tbody id="userdata">
                        @forelse ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->desc}}</td>
                            <td>{{$user->roledata->user_role}}</td>
                            <td>
                                <img width="75px" height="75px" src="{{asset('storage/'.$user->image)}}" alt="">
                            </td>
                        </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                    
                </table>
            </div>
            
        </div>
    </section>
  </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="{{asset('js/index.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#successAlert').hide();
    </script>
    <script>
        $('#userdet').on('submit',function(e){
        e.preventDefault();
        var formdata = new FormData(this)
        console.log(formdata);
        $.ajax({
            url: `{{route('store')}}`,
            method: "POST",
            data: formdata,
            cache : false,
            processData: false,
            contentType: false,
            dataType:"json",
            success: function(data) {
                e.preventDefault();
                $('#userdata').html('');
                var datastring = '';
                let datasplit = data.userdata;
                // console.log(datasplit);
                $.each(datasplit, function( index, value ) {
                    console.log(value);
                    // console.log(`${index}----`+value['id']);
                    // datastring+=`${value.id}....`;
                    datastring+=`<tr>
                                    <td>${value.id}</td>
                                    <td>${value.name}</td>
                                    <td>${value.email}</td>
                                    <td>${value.phone}</td>
                                    <td>${value.desc}</td>
                                    <td>${value.role.user_role}</td>
                                    <td><img width="75px" height="75px" src="{{ asset('storage/${value.image}') }}" ></td>
                                    </tr>`;
                });
                // console.log(datastring);
                $('#userdata').html(datastring);
            },
            error:function(errors){
                $('.test').html('');
                let formErr= errors.responseJSON.errors;
                $.each(formErr, function( index, value ) {
                    $(`#${index}span`).html(value);
                });
            }
        });
    });
    </script>
@endpush