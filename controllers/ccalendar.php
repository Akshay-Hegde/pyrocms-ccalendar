<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Ccalendar Public Controller
 *
 * @author    Richard Malibiran - CodeCarabao
 * @website   http://codecarabao.com
 * @package   PyroCMS
 * @subpackage  Ccalendar
 */
class Ccalendar extends Public_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->lang->load('ccalendar');
  }

  public function index()
  {
    /**
    * @TODO: add to settings
    * - is_moment enabled
    * - is_jquery_admin
    * - is_jquery_public
    * - is_jquery_ui_admin
    * - is_jquery_ui_public
    */

    $this->template->append_css('module::fullcalendar/fullcalendar.css');
    $this->template->append_css('module::fullcalendar/fullcalendar.print.css');

    $this->template->append_js('module::fullcalendar/lib/moment.min.js');
    $this->template->append_js('module::fullcalendar/lib/jquery-ui.custom.min.js');
    $this->template->append_js('module::fullcalendar/fullcalendar.min.js');

    $this->template->append_js('module::ccalendar.js');
    $this->template->append_css('module::ccalendar.css');

    $this->template
    ->title(lang('ccalendar:ttl_title_front'))
    ->build('index');
  }

  /**
  * TODO: make strict json response headers
  */
  public function fetchevents()
  {
    $this->load->library('ccalendar/Service_Ccalendar');
    $getParams = $this->input->get();

    $from = $getParams['start'] ? 
      strtotime("{$getParams['start']} 00:00:00") : 
      strtotime("today 00:00:00");

    $to = $getParams['end'] ? 
      strtotime("{$getParams['end']} 23:59:59"): 
      strtotime("today 23:59:59");

    $events = $this->service_ccalendar->get_events_range($from, $to);
    $events = $this->service_ccalendar->simplify($events);
    // var_dump($events); exit;
    echo json_encode($events);
    exit();
  }

}