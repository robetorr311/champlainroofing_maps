<div class="wrap">
<div class="postbox-container">
<div class="postbox">  
<div class="inside">
<h3 class='hndle'>Locations Form</h3>
<form id="locations_form">
<table>
  <tr>
    <td>
      <div class="form-group">
         Name:
        <input type="text" id="name" name="name" class="form-control" placeholder="Project Name">
      </div>
    </td>
    <td>
      <div class="form-group">
        Project type:
        <select id="type" name="type" class="form-control">
          <option value="">Choose a type of project</option>
          <option value="Residential Shingle Roof">Residential Shingle Roof</option>
          <option value="Residential Metal Roof">Residential Metal Roof</option>
          <option value="Commercial Shingle Roof">Commercial Shingle Roof</option>
          <option value="Commercial Metal Roof">Commercial Metal Roof</option>
          <option value="Roof Repair">Roof Repair</option>
        </select>
      </div>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <div class="form-group">
         Address:
        <textarea id="address" name="address" class="form-control" placeholder="Address" style="width: 100%"></textarea>
      </div>
    </td>
  </tr>  
  <tr>
    <td colspan="2">
      <div class="form-group">
         Description:
        <textarea id="description" name="description" class="form-control" placeholder="Description of project" style="width: 100%"></textarea>
      </div>
    </td>
  </tr>
  </table>
  <table> 
  <tr>
    <td>
      <div class="form-group">
        Latitude:
        <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Latitude">
      </div>
    </td>
    <td>
      <div class="form-group">
        Longitude:
        <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude">
      </div>
    </td>
  </tr>
</table>
<table>
  <tr>
    <td>
      <div class="form-group">
        Image:
        <input type="text" id="picture" name="picture">
        <input id="upload_button_map" type="button" class="button button-primary" value="Upload and Choose an Image" />
      </div>
    </td>    
  </tr>
  </table>
  <table>
  <tr>
    <td>
      <button type="submit" class="button button-primary">Submit</button>
    </td>
  </tr>     
</table>
</form>
</div>
</div>
<div id="tables_admin">
<div class="postbox">
<span>
<h3 class='hndle'>General Settings</h3>
</span>
<br>
<div class="inside">
<h3 class='hndle'>Owners</h3>
<div id="table_owner">
<table id="table_dis" class="table table-striped table-bordered" >
<thead>
    <tr>
      <th>Name</th> 
      <th>Type</th> 
      <th>Address</th> 
      <th>Description</th> 
      <th>Options</th>
    </tr>
</thead>
<tbody>
<?php
foreach ($results_locations as $key_location) {
?>	
  <tr>
    <td> <?php echo $key_location->name; ?> </td>  
    <td> <?php echo $key_location->type; ?> </td> 
    <td> <?php echo $key_location->address; ?> </td> 
    <td> <?php echo $key_location->description; ?> </td> 
    <td>
      <button type="button" class="button button-primary" onclick="deletelocation('<?php echo $key_location->id; ?>')">Delete</button>
    </td>
</tr>
<?php
}
?>
</tbody>
<tfoot>
    <tr>
      <th>Name</th> 
      <th>Type</th> 
      <th>Address</th> 
      <th>Description</th> 
      <th>Options</th>
    </tr>
</tfoot>	
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";  
jQuery(document).ready( function($) {
  jQuery("#table_dis").dataTable({
    "oPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "lengthMenu":[[10,25,50,100,200,-1],[10,25,50,100,200,"All"]]    
  });   
  jQuery("#locations_form").validate({
          ignore: [],
          rules: {
                 name: "required",
                 address:"required",
                 description:"required",
                 type:"required",
                 latitude: "required",
                 longitude:"required",
                 picture:"required",
          },
          messages: {
             name: "Please provide a name",
             address: "Please enter address",
             description: "Please enter description",
             type: "Please choose type",
             latitude: "Please enter latitude",
             longitude: "Please enter longitude",
             picture: "Please upload image",
          },
          errorClass: "error_validate",
          inputContainer: "form-group",
          submitHandler: function(response){
            var name=jQuery("#name").val();
            var type=jQuery("#type").val();
            var address=jQuery("#address").val();
            var description=jQuery("#description").val();
            var latitude=jQuery("#latitude").val();
            var longitude=jQuery("#longitude").val();
            var picture=jQuery("#picture").val();
            var data= {
                action:'save_location',
                name: name,
                type: type,
                address: address,
                description: description,
                latitude: latitude,
                longitude: longitude,
                picture: picture
            };
              jQuery.post(ajaxurl, data, function(response) {
                alert(response);
                location.reload();
            });            
          }
        });      
});
function save_location(){
    var pages=jQuery("#pages").val();
    var signup_type=jQuery("#signup_type").val();
    var err=0;
    if(!pages) err=1;
    if(!signup_type) err=1;
    if(err==0){    
    var data= {
        action:'save_location',
        pages: pages,
        signup_type: signup_type
    };
    jQuery.post(ajaxurl, data, function(response) {
      alert(response);
      location.reload();
    });
  }
  else {
    alert('Choose page and choose type of user before add new rule!');
  }
}  
function deletelocation(id){
    if (confirm("Are you sure?")) {
    var data= {
        action:'delete_location',
        id: id
    };
    jQuery.post(ajaxurl, data, function(response) {
      location.reload();
    });
    }
    return false;
}
</script>