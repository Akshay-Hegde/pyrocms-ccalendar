<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A simple DAO-like library for ccalendar tables
 *
 * @license https://github.com/rmalibiran/pyrocms-ccalendar/blob/master/LICENSE
 * @author    Richard Malibiran
 * @website   http://richard.malibiran.com
 */
class Service_Ccalendar
{
  private $_CI;

  private $_module_namespace = 'ccalendar';
  private $_tbl_events = 'ccalendar_events';

  public function __construct()
  {
    $this->_CI =& get_instance();
    $this->_CI->load->driver('Streams');
  }

  public function get_event($id) 
  {
    return $this->_CI->streams->entries->get_entry(
      $id,
      $this->_tbl_events,
      $this->_module_namespace
    );
  }

  public function get_events($params)
  {
    // NOTICE: EXTR_PREFIX_ALL automatically adds _ to the prefixed param
    extract($params, EXTR_PREFIX_ALL, 'param');

    $getOptions = array(
      'stream' => $this->_tbl_events,
      'namespace' => $this->_module_namespace,
    );

    if (isset($param_sorting) && $param_sorting) {
      $getOptions['sorting'] = $param_sorting;
    }

    if ((isset($param_sort) && $param_sort) && $param_sorting) {
      $getOptions['sort'] = $param_sort;
    }

    if (isset($param_limit) && $param_limit) {
      $getOptions['limit'] = $param_limit;
    }

    if (isset($param_where) && $param_where) {
      $getOptions['where'] = $param_where;
    }

    $events = $this->_CI->streams->entries->get_entries(
      $getOptions
    );

    return $events['entries'] ? $events['entries'] : array();
  }

  public function get_future_events($limit = 5, $color = null)
  {
    $today = strtotime("today 00:00");
    $where = array("date_from >= {$today}");

    if ($color != 'all') {
      $where[] = 'color = "'.$options['color'].'"';
    }
    
    $where[] = 'is_published = "1"';

    $params = array(
      'sorting' => 'date_from',
      'sort' => 'ASC',
      'limit' => $limit,
      'where' => $where
    );

    return $this->get_events($params);
  }

  public function get_events_range($from, $to, $color = 'all')
  {
    $where = array(
      "date_from >= {$from}",
      "date_to <= {$to}",
      "is_published = \"1\""
    );

    if ($color != 'all') {
      $where[] = 'color = "'.$options['color'].'"';
    }

    $params = array(
      'where' => $where
    );

    return $this->get_events($params);
  }

  public function simplify($events)
  {
    $simplifiedEvents = array();

    foreach ($events as $event) {
      $tempArr = array();

      if (isset($event['id']) AND $event['id']) {
        $tempArr['id'] = $event['id'];
        $tempArr['url'] = site_url('ccalendar/view/'.$event['id']);
      }

      if (isset($event['date_from']) AND $event['date_from']) {
        $tempArr['start'] = date('Y-m-d', $event['date_from']);
      }

      if (isset($event['date_to']) AND $event['date_to']) {
        $tempArr['end'] = date('Y-m-d', $event['date_to']);
        
        // @FIXME: doing this just to fix the fullcalendar 
        // bug: long events are minus-one-ed
        if (isset($tempArr['start']) AND $tempArr['start']) {
          if ($tempArr['start'] != $tempArr['end']) {
            $tempArr['end'] = date('Y-m-d', strtotime("+1 day", $event['date_to']));
          }
        }
      }

      if (isset($event['title']) AND $event['title']) {
        $tempArr['title'] = $event['title'];
      }

      if (isset($event['info']) AND $event['info']) {
        $tempArr['info'] = $event['info'];
      }

      if (isset($event['location']) AND $event['location']) {
        $tempArr['location'] = $event['location'];
      }

      if (isset($event['color']['key']) AND $event['color']['key']) {
        $tempArr['color'] = $event['color']['key'];
      }

      if (isset($event['banner_image']) AND $event['banner_image']) {
        $tempArr['banner_image'] = $event['banner_image']['thumb'];
      }

      if (!empty($tempArr)) {
        $simplifiedEvents[] = $tempArr;
      }
    }

    return $simplifiedEvents;
  }

}