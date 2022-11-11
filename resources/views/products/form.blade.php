<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="modal-form modal" class="form-horizontal" data-toggle="validate" enctype="multipart/form-data" >
                @csrf
                @method('POST')

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">


                    <div class="box-body">

                        <div class="form-group">
                            <label >Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"  autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Price</label>
                            <input type="text" class="form-control rupiah" id="harga" name="harga"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Quantity</label>
                            <input type="text" class="form-control" id="qty" name="qty"   required>
                            <span class="help-block with-errors"></span>
                        </div>


                        <div class="form-group">
                            <label >Image</label>
                            <input type="file" class="form-control" id="image" name="image" >
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Category</label>
                            <select class="form-control select" name="category_id" id="category_id" required>
                                <option selected="selected" value="" disabled>-- Choose Category --</option>
                                @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>

                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Lokasi</label>
                            <select class="form-control select" name="lokasi_id" id="lokasi_id" required>
                                <option selected="selected" value="" disabled>-- Choose Lokasi --</option>
                                @foreach ($lokasi as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>

                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Assets/Inventory</label>
                            <select class="form-control select" name="assets_id" id="assets_id" required>
                                <option selected="selected" value="" disabled>-- Choose Assets / Inventory --</option>
                                @foreach ($asset as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>

                            <span class="help-block with-errors"></span>
                        </div>
                        {{-- <div class="form-group">
                            <label >Link</label>
                            <input type="text" class="form-control" id="link" name="link">
                            <span class="help-block with-errors"></span>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label >Product Code</label> --}}
                            {{-- <textarea class="form-control" id="description" name="description"></textarea> --}}
                            {{-- <input type="text" class="form-control" id="product_code" name="product_code"  autofocus required>
                            <span class="help-block with-errors"></span>
                        </div> --}}

                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function(){
  $(".rupiah").keyup(function(e){
    $(this).val(format($(this).val()));
  });
});
var format = function(num){
  var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
  if(str.indexOf(".") > 0) {
    parts = str.split(".");
    str = parts[0];
  }
  str = str.split("").reverse();
  for(var j = 0, len = str.length; j < len; j++) {
    if(str[j] != ",") {
      output.push(str[j]);
      if(i%3 == 0 && j < (len - 1)) {
        output.push(",");
      }
      i++;
    }
  }
  formatted = output.reverse().join("");
  return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
</script>
