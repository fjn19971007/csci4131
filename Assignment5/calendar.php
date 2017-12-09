<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="script_map.js"></script>
        <meta charset="utf-8">
        <title>My Academic Calendar</title>
    </head>
    <body>
        <div>
          <nav>
            <a class="active" href="calendar.php">My Calendar</a>
            <a href="form.php">Form Input</a>
          </nav>
        </div>

        <div id="calendar">
          <?php
          $days = array('Monday'=>1, 'Tuesday'=>2, 'Wednesday'=>3, 'Thursday'=>4, 'Friday'=>5);
          function compare($a, $b) {
            if ($days[$a->day] < $days[$b->day]) {
              return -1;
            } else if ($days[$a->day] > $days[$b->day]){
              return 1;
            } else {
              if ($a->startTime < $b->startTime) {
                return -1;
              } else {
                return 1;
              }
            }
          }

          if(file_exists('calendar.txt')) {
            echo '<table id="table">';
            $file = fopen('calendar.txt', 'r');
            $events = '[ ' . file_get_contents('calendar.txt') . ']';
            $events = json_decode($events, true);
            fclose($file);
            usort($events, 'compare');

            $dayCheck = array();
            for ($i=0; $i<count($events); $i++) {
              if (!isset($dayCheck[$events[$i]['day']])) {
                if (count($daycheck) > 0) {
                  echo '</tr>';
                }
                echo '<tr><th>';
                echo $events[$i]['day'];
                echo '</th>';
                $dayCheck[$events[$i]['day']] = 1;
              }

              echo '<td><span class="classes"><p><b>';
              echo $events[$i]['eventName'];
              echo '</b><br>';
              echo $events[$i]['startTime'];
              echo ' - ';
              echo $events[$i]['endTime'];
              echo '<br></span><span class="location">';
              echo $events[$i]['location'];
              echo '</span></p></td>';
            }
            echo '</tr></table>';
          } else {
            echo '<div class="errorMessage"><p>Calendar has no events. Please use the input page to enter some events. </p></div>';
          }
          ?>
        </div>
        <div id="map"></div>
        <div id="navPanel"></div>

        <div class="reference">
            <p>This page has been tested on Chrome, Firefox and Safari.</p>
        </div>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAanAUroipqqcvs9gusUqsVW-wUOlVvuZo&libraries=places&callback=initMap"></script>
        <div id="twitter">
            <a class="twitter-timeline"  href="https://twitter.com/hashtag/UMN" data-widget-id="920115999319429120">#UMN Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
            </script>
        </div>
    </body>
</html>

