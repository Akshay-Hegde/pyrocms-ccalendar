<?php //var_dump($event); exit;?>
<div class="ccalendar-view">
  <div class="ccalendar-banner">
    <?php if ($event->banner_image['img']) : ?>
      <p><?php echo $event->banner_image['img']; ?></p>
    <?php endif; ?>
  </div>
  <div class="ccalendar-title">
    <h2><?php echo $event->title; ?></h2>
  </div>
  <div class="ccalendar-date">
    <?php 
      $start = null;
      $end = null;
      $dateFormat = Settings::get('date_format');
      $textOutput = '';
      if (isset($event->date_from) AND $event->date_from) {
        $start = date($dateFormat, $event->date_from);
      }

      if (isset($event->date_to) AND $event->date_to) {
        $end = date($dateFormat, $event->date_to);
        
        if ($start AND $end) {
          if ($start == $end) {
            $textOutput = $start;
          } else {
            $textOutput = "{$start} - {$end}";
          }
        }
      }
    ?>
    <p><?php echo $textOutput; ?></p>
  </div>
  <div class="ccalendar-location">
    <?php if ($event->location) : ?>
      <p><?php echo $event->location; ?></p>
    <?php endif; ?>
  </div>
  <div class="ccalendar-info">
    <?php echo $event->info; ?>
  </div>
</div>