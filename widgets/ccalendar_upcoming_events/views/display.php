<style type="text/css">
  aside .widget ul.upcoming-events-widget,
  ul.upcoming-events-widget {
    margin: 0;
    padding: 0;
    list-style: none;
    margin-bottom: 20px;
  }

  ul.upcoming-events-widget li {
    margin-bottom: 1px;
    list-style: none;
    padding: 0;
  }  

  ul.upcoming-events-widget li div.event-wrapper {
    display: table;
    width: 100%;
    border: 1px solid #ddd;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
  } 

  ul.upcoming-events-widget li div.event-panel {
    display: table-cell; 
  }

  ul.upcoming-events-widget li div.event-left-panel {
   -moz-border-radius-topleft: 9px;
   -webkit-border-top-left-radius: 9;
    border-top-left-radius: 9px;
    -moz-border-radius-bottomleft: 9px;
    -webkit-border-bottom-left-radius: 9px;
    border-bottom-left-radius: 9px;
    width: 5%;
  }

  ul.upcoming-events-widget li div.event-right-panel {
    padding: 5px;
    width: 95%;
    background-color: #ffffff;
    -moz-border-radius-topright: 9px;
   -webkit-border-top-right-radius: 9;
    border-top-right-radius: 9px;
    -moz-border-radius-bottomright: 9px;
    -webkit-border-bottom-right-radius: 9px;
    border-bottom-right-radius: 9px;
  }

  ul.upcoming-events-widget li div.event-color {
    
  } 

  ul.upcoming-events-widget li div.event-date {
    padding: 5px;
    display: table-row;
  } 

  ul.upcoming-events-widget li div.event-title {
    padding: 5px;
    display: table-row; 
  } 
   
</style>

<ul class="upcoming-events-widget">
  <?php foreach($ccalendar_events as $post_widget): ?>
    <li>
      <?php 
        // echo anchor(
        //   'article/'.date('Y/m', $post_widget->created_on) .'/'.$post_widget->slug, 
        //   $post_widget->title
        // ) 
      ?>

      <div class="event-wrapper">
        <div class="event-left-panel event-panel" style="background-color: #<?php echo $post_widget['color']['key']; ?>">
        </div>
        <div class="event-right-panel event-panel">
          <div class="event-date">
            <?php 
              $from = date($ccalendar_date_format, $post_widget['date_from']);
              $to = date($ccalendar_date_format, $post_widget['date_to']);
              if ($post_widget['date_from'] == $post_widget['date_to']) {

              }

              echo $from ." - ". $to;
            ?>
          </div>
          <div class="event-title">
            <h4>
            <a href="<?php echo 'ccalendar/view/'.$post_widget['id'] ?>"> 
              <?php echo $post_widget['title']; ?>
            </a>
            </h4>
          </div>
        </div>

      </div>

    </li>
  <?php endforeach ?>
</ul>