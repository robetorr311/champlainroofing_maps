<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>    

  </head>
  <body>
    <div class="container">
<div id="map" style="height: 600px;"></div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
    </script>  
  <script type="text/javascript">
 
  </script>    
    <script>
      var map;
      var marker;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: 44.550869, lng: -73.164372},
          mapTypeId: 'roadmap'
        });
        marker = new google.maps.Marker({
          title: 'test',
          position: {lat: 44.550869, lng: -73.164372}
        });            
        marker.setMap(map);
      }
    </script>


  </body>
</html>