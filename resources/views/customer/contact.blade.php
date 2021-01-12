

<!-- Modal -->
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                <form method="POST" class="px-5" action="{{route('customer.contact')}}">
                    @csrf
                    <div class="form-group">
                        <label for="inputEmail4">Sender Email</label>
                        <input value="" name="receiver_email" type="" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message</label>
                        <textarea name="message"class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
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