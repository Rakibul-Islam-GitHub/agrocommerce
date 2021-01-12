

<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="POST" class="px-5" action="{{route('customer.editProfile')}}">
                    @csrf
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input value="{{session('profile')->email}}" name="email" type="" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password</label>
                        <input value="{{session('profile')->password}}" name="password" type="password" class="form-control" id="inputPassword4" placeholder="Password">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="inputName">Name</label>
                    <input value="{{session('profile')->name}}" name="name" type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input value="{{session('profile')->address}}" name='address' class="form-control" id="inputAddress" rows="3"></input>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPhone">Phone</label>
                        <input value="{{session('profile')->phone}}" name="phone" type="text" class="form-control" id="inputPhone">
                    </div>
                    
                    </div>
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mb-4 " data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary mb-4 mr-4">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>