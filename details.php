<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Ccalendar extends Module {

  public $version = '0.1';

  public $module_namespace = 'ccalendar';
  public $tbl_events = 'ccalendar_events';

  public function __construct()
  {
    parent::__construct();
    
    //Load language
    $this->lang->load('ccalendar/ccalendar');
    
    //Load Streams
    $this->load->driver('Streams'); 
  }

  public function info()
  {
    return array(
      'name' => array(
        'en' => lang('ccalendar:module_name')
      ),
      'description' => array(
        'en' => 'A calendar module.'
      ),
      'frontend' => TRUE,
      'backend' => TRUE,
      'menu' => 'content',
      'sections' => array(
        'ccalendar' => array(
          'name' => 'ccalendar:ttl_title',
          'uri' => 'admin/ccalendar',
          'shortcuts' => array(
            'add' => array(
              'name' => 'ccalendar:lbl_add_event',
              'uri' => 'admin/ccalendar/add',
              'class' => 'add'
            )
          )
        )
      )
    );
  }

  public function install()
  {
    $this->streams->utilities->remove_namespace($this->module_namespace);

    // just in case namespace removal failed
    if ($this->db->table_exists('data_streams')) {
      $this->db->where('stream_namespace', $this->module_namespace)
        ->delete('data_streams');
    }

    // Banner Images Folder just to keep a clean view in the files module
    $this->load->library('files/files');
    $banner_img_folder = Files::create_folder(0 , lang('ccalendar:folder_name'));

    $this->streams->streams->add_stream(
      'lang:ccalendar:module_name',
      $this->tbl_events,
      $this->module_namespace,
      null,
      null
    );

    // add the fields -- this can be later removed by the admin
    // @TODO: find a way for the admins to NOT delete the required stream items
    $title_field = array(
      'name' => 'lang:ccalendar:lbl_title',
      'slug' => 'title',
      'namespace' => $this->module_namespace,
      'type' => 'text',
      'assign' => $this->tbl_events,
      'required' => true
    );

    $info_field = array(
      'name'    => 'lang:ccalendar:lbl_info',
      'slug'    => 'info',
      'namespace' => $this->module_namespace,
      'type'    => 'wysiwyg',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'editor_type' => 'simple', 
        'allow_tags' => 'y'
      ),
      'required'  => true
    );

    $location_field = array(
      'name' => 'lang:ccalendar:lbl_location',
      'slug' => 'location',
      'namespace' => $this->module_namespace,
      'type' => 'text',
      'assign' => $this->tbl_events,
      'required' => false
    );

    $from_field = array(
      'name'    => 'lang:ccalendar:lbl_from',
      'slug'    => 'date_from',
      'namespace' => $this->module_namespace,
      'type'    => 'datetime',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'input_type' => 'datepicker', 
        'use_time' => 'y', 
        'storage' => 'unix'
      ),
      'required'  => true
    );

    $to_field = array(
      'name'    => 'lang:ccalendar:lbl_to',
      'slug'    => 'date_to',
      'namespace' => $this->module_namespace,
      'type'    => 'datetime',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'input_type' => 'datepicker', 
        'use_time' => 'y', 
        'storage' => 'unix'
      ),
      'required'  => true
    );

    $is_whole_day_field = array(
      'name'    => 'lang:ccalendar:lbl_whole_day',
      'slug'    => 'is_whole_day',
      'namespace' => $this->module_namespace,
      'type'    => 'choice',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'choice_data' => "0 : No\n1 : Yes", 
        'choice_type' => 'radio', 
        'default_value' => '0'
      ),
      'required'  => false
    );

    $is_published_field = array(
      'name'    => 'lang:ccalendar:lbl_published',
      'slug'    => 'is_published',
      'namespace' => $this->module_namespace,
      'type'    => 'choice',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'choice_data' => "0 : No\n1 : Yes", 
        'choice_type' => 'radio', 
        'default_value' => '0'
      ),
      'required'  => false
    );

    $banner_image_field = array(
      'name'    => 'lang:ccalendar:lbl_banner_img',
      'slug'    => 'banner_image',
      'namespace' => $this->module_namespace,
      'type'    => 'image',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'folder' => $banner_img_folder['data']['id'], 
        'keep_ratio' => 'yes',
        'allowed_types' => 'jpg|jpeg|png'
      ),
      'required'  => false
    );

    $color_field = array(
      'name'    => 'lang:ccalendar:lbl_color',
      'slug'    => 'color',
      'namespace' => $this->module_namespace,
      'type'    => 'choice',
      'assign' => $this->tbl_events,
      'extra'   => array(
        'choice_data' => "ffffff : Default\n".
                         "428bca : Primary\n".
                         "dff0d8 : Success\n".
                         "d9edf7 : Info\n".
                         "fcf8e3 : Warning\n".
                         "f2dede : Danger\n".
                         "e6e6e6 : Neutral",
        'choice_type' => 'radio', 
        'default_value' => 'ffffff'
      ),
      'required'  => false
    );

    $this->streams->fields->add_fields(array(
      $title_field,
      $info_field,
      $location_field,
      $from_field,
      $to_field,
      $is_whole_day_field,
      $is_published_field,
      $banner_image_field,
      $color_field
    ));
    
    // @FIXME: do no assume everything runs fine!
    return true;
  }

  public function uninstall()
  {
    $this->load->driver('Streams');

    $this->streams->utilities->remove_namespace($this->module_namespace);

    // just in case namespace removal failed
    if ($this->db->table_exists('data_streams')) {
      $this->db->where('stream_namespace', $this->module_namespace)
        ->delete('data_streams');
    }

    return true;
  }


  public function upgrade($old_version)
  {
    // Your Upgrade Logic
    return TRUE;
  }

  public function help()
  {
    // Return a string containing help info
    // You could include a file and return it here.
    return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
  }
}
/* End of file details.php */
