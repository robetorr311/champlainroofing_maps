    jQuery(document).ready(function() {
    var map;      
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: {lat: 44.550869, lng: -73.164372},
        mapTypeId: 'roadmap',
        gestureHandling: 'greedy'
      });
      var data= {
        action:'get_locations'
      };
      var icons = {
        rsr: {
          name: 'Residential Shingle Roof',
          icon: markerimageurl + "red@2x.png"
        },
        rmr: {
          name: 'Residential Metal Roof',
          icon: markerimageurl + "orange@2x.png"
        },
        csr: {
          name: 'Commercial Shingle Roof',
          icon: markerimageurl + "blue@2x.png"
        },
        cmr: {
          name: 'Commercial Metal Roof',
          icon: markerimageurl + "green@2x.png"
        },
        rr: {
          name: 'Roof Repair',
          icon: markerimageurl + "purple@2x.png"
        }
      };      
      jQuery.post(ajaxurl, data, function(response) {
        console.log(response);
        var json = jQuery.parseJSON(response);
        var latLng;
        var icon;
        var image; 
        jQuery(json).each(function (i, val) {
          var popupimageurl=uploadimageurl + val.image;
          var contentString =
            '<div id="content" style="background: #102e43; color: #ffffff; z-index:1;">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h1 id="firstHeading" class="firstHeading" ><span style="color: #ffffff;"'+val.address+'</span></h1>' +
            '<div id="bodyContent">' +
            '<p><img src="'+popupimageurl+'" width="600px" height="483px" /></p><div style="background: #ffffff; color: #102e43; border: 5px solid #102e43; "><p>' +
            val.description +
            '</div></p>' +
            '</div>' +
            '</div>';
          var infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 615,
          });
          google.maps.event.addListener(infowindow,'closeclick',function(){
            jQuery("#legend").css('z-index','0');
          });                    
          switch (val.type) {
          case "Residential Shingle Roof":
            image = {
              url: markerimageurl + "red@2x.png",
              size: new google.maps.Size(24, 35),
              type: 'rsr'
            };
            break;
          case "Residential Metal Roof":
            image = {
              url: markerimageurl + "orange@2x.png",
              size: new google.maps.Size(24, 35),
              type: 'rmr'
            };
            break;
          case "Commercial Shingle Roof":
            image = {
              url: markerimageurl + "blue@2x.png",
              size: new google.maps.Size(24, 35),
              type: 'csr'
            };
            break;
          case "Commercial Metal Roof":
            image = {
              url: markerimageurl + "green@2x.png",
              size: new google.maps.Size(24, 35),
              type: 'cmr'
            };
            break;
          case "Roof Repair":
            image = {
              url: markerimageurl + "purple@2x.png",
              size: new google.maps.Size(24, 35),
              type: 'rr'
            };
            break;
          default:
            image = {
              url: markerimageurl + "red@2x.png",
              size: new google.maps.Size(24, 35),
            };
          }          
          var marker = new google.maps.Marker({
            title: val.name,
            position: {lat: val.latitude, lng: val.longitude},
            icon: image,
          });
          marker.addListener("click", function() {
            jQuery("#legend").css('z-index','-1');
            infowindow.open(map, marker);
          });          
          marker.setMap(map);
        });

      });

      var legend = document.getElementById('legend');
      for (var key in icons) {
        var type = icons[key];
        var name = type.name;
        var icon = type.icon;
        var div = document.createElement('div');
        div.innerHTML = '<img src="' + icon + '"> ' + name;
        legend.appendChild(div);
      }
      map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);            
    });