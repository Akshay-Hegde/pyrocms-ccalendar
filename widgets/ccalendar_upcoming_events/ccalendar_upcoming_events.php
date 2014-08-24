<?php defined('BASEPATH') or exit('No direct script access allowed');

class Widget_Ccalendar_Upcoming_events extends Widgets
{
  public $author = 'Richard Malibiran';

  public $website = 'http://richard.malibiran.com';

  public $version = '0.1';

  public $title = array(
    'en' => 'Ccalendar Upcoming Events'
  );

  public $description = array(
    'en' => 'Display a list of Upcoming events.'
  );

  // build form fields for the backend
  // MUST match the field name declared in the form.php file
  public $fields = array(
    array(
      'field' => 'limit',
      'label' => 'Items to display',
    ),
    array(
      'field' => 'color',
      'label' => 'Color',
    )
  );

  public function form($options) 
  {
    $options['limit'] = ( ! empty($options['limit'])) ? $options['limit'] : 5;
    $options['color'] = ( ! empty($options['color'])) ? $options['color'] : "all";

    return array(
      'options' => $options
    );
  }

  public function run($options)
  {
    $this->load->driver('Streams');

    $options['limit'] = ( ! empty($options['limit'])) ? $options['limit'] : 5;
    $options['color'] = ( ! empty($options['color'])) ? $options['color'] : "all";

    $this->load->library('ccalendar/Service_Ccalendar');
    $events = $this->service_ccalendar->get_future_events(
      $options['limit'], 
      $options['color']
    );

    return array(
      'ccalendar_events' => $events,
      'ccalendar_date_format' => Settings::get('date_format')
    );
  }
}