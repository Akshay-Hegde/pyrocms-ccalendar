<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ccalendar Admin Controller
 *
 * @author    Richard Malibiran - CodeCarabao
 * @website   http://codecarabao.com
 * @package   PyroCMS
 * @subpackage  Ccalendar Client
 */
class Admin extends Admin_Controller
{
  protected $section = 'ccalendar';

  private $_module_namespace = '';
  private $_tbl_events = '';
  private $myStream;

  public function __construct()
  {
    parent::__construct();

    $this->load->driver('Streams');

    $this->_module_namespace = $this->module_details['module']->module_namespace;
    $this->_tbl_events = $this->module_details['module']->tbl_events;

    $this->myStream = $this->streams->streams->get_stream(
      $this->_tbl_events, 
      $this->_module_namespace
    );

    $this->lang->load('ccalendar');
  }

  public function index()
  {
    $offset_uri = 6;
    $pagination_uri = 'admin/ccalendar/index/';
  
    // -------------------------------------
    // Get Streams Entries Table
    // -------------------------------------

    $extra = array(
      'title'   => lang('ccalendar:ttl_title'),
      'buttons' => array(
        array(
          'label'   => lang('global:edit'),
          'url'   => 'admin/ccalendar/edit/'.$this->myStream->id.'/-entry_id-',
          'confirm' => false
        ),
        array(
          'label'   => lang('global:delete'),
          'url'   => 'admin/ccalendar/delete/'.$this->myStream->id.'/-entry_id-',
          'confirm' => true
        )
      ),
      'sorting' => 'date_from',
      'columns' => array(
        'title', 
        'date_from', 
        'date_to', 
        'is_whole_day', 
        'is_published', 
        'location', 
        'color'
      )
    );

    $this->streams->cp->entries_table(
      $this->myStream->stream_slug,
      $this->myStream->stream_namespace,
      Settings::get('records_per_page'),
      $pagination_uri,
      true,
      $extra
    );
  }

  public function add()
  {
    $extra = array(
      'return'      => 'admin/ccalendar/index/',
      'success_message'   => $this->lang->line('ccalendar:msg_new_entry_success'),
      'failure_message' => $this->lang->line('ccalendar:msg_new_entry_error')
    );

    // Title
    $extra['title'] = '<a href="admin/ccalendar/index/">'.
      lang('ccalendar:ttl_title').
      '</a> &rarr; '.
      lang('streams:new_entry');

    $this->streams->cp->entry_form(
      $this->myStream, 
      $this->_module_namespace, 
      'new', 
      null, 
      true, 
      $extra
    );    
  }

  public function edit()
  {
    $extra = array(
      'return'      => 'admin/ccalendar/index/',
      'success_message'   => $this->lang->line('ccalendar:msg_edit_entry_success'),
      'failure_message' => $this->lang->line('ccalendar:msg_edit_entry_error')
    );

    // Title
    $extra['title'] = '<a href="admin/ccalendar/index/">'.
      lang('ccalendar:ttl_title').
      '</a> &rarr; '.
      lang('streams:edit_entry');

    $entry_id = $this->uri->segment(5);

    if ( !$entry_id ) {
      show_error('streams:invalid_row');
    }

    $this->streams->cp->entry_form(
      $this->myStream, 
      $this->_module_namespace, 
      'edit', 
      $entry_id, 
      true, 
      $extra
    );
  }

  public function delete()
  {
    $row_uri_segment = 5;
  
    $row_id = $this->uri->segment($row_uri_segment);
    
    if( !$this->row_m->delete_row($row_id, $this->myStream) ) {
      $this->session->set_flashdata('notice', lang('ccalendar:msg_delete_entry_success'));  
    } else {
      $this->session->set_flashdata('success', lang('ccalendar:msg_delete_entry_success')); 
    }

    redirect('admin/ccalendar/index/');
  }

}