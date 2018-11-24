<?php
/**
 * :: Class Azad_Plugin_Activation
 */
if(!class_exists('Azad_Plugin_Activation')){
    class Azad_Plugin_Activation{
        const APA_VERSION = '0.0.0.1';
        const WP_REPO_REGEX = '';
        const IS_URL_REGEX = '';
        public static $instance;
        public $plugins = array();
        protected $sort_order = array();
        protected $has_forced_activation = false;
        protected $has_forced_deactivation = false;
        public $id = 'apa';
        protected $menu = 'azad-install-plugins';
        public $parent_slug = 'themes.php';
        public $capability = 'edit_theme_options';
        public $default_path = '';        
        public $has_notices = true;
        public $dismissable = true;        
        public $dismiss_msg = '';        
        public $is_automatic = false;
        public $message = '';        
        public $strings = array();        
        public $wp_version;        
        public $page_hook;
        public function __construct(){
            add_action('init',array($this,'init'));
            //$this->_get_plugin_basename_from_slug('akismet');
        }
        public function __set($name,$value){
            return;
        }        
        public function __get($name){
            return $this->{$name};
        }
        public function init(){
            $this->strings = array(
                'page_title' => __('Install Required Plugins','apa'),
                'menu_title' => __('Install Plugins','apa'),
                'installing' => __('Installing plugin','apa'),
                'updating' => __('Updating plugin ','apa'),
                'oops' => __('Something went wrong with the plugin api','apa'),
                'notice_can_install_required' => __('This theme requires the following plugins.','apa'),
                'notice_can_install_recommended' => __('Something went wrong with the plugin api','apa'),
                'notice_ask_to_update' => __('Something went wrong with the plugin api','apa'),
                'notice_ask_to_update_maybe' => __('Something went wrong with the plugin api','apa'),
                'notice_can_activate_required' => __('Something went wrong with the plugin api','apa'),
                'notice_can_activate_recommended' => __('Something went wrong with the plugin api','apa'),
                'dashboard' => __('Return to the dashboard.','apa')
            );
            do_action('apa_register');
            add_action('admin_notices',array($this,'notices'));
            add_action('admin_menu',array($this,'admin_menu'));
            add_action('admin_init',array($this,'admin_init'));
        }
        public function load_textdomain(){
            
        }
        public function correct_plugin_mofile(){
            
        }
        public function overload_textdomain_mofile(){
            
        }
        public function add_plugin_action_link_filters(){
            
        }
        public function filter_plugin_action_links_activate(){
            
        }
        public function filter_plugin_action_links_deactivate(){
            
        }
        public function filter_plugin_action_links_update(){
            
        }
        public function admin_init(){
            
        }        
        public function thickbox(){
            
        }
        public function admin_menu(){
            $args = apply_filters(
                'apa_admin_menu_args',
                array(
                    'page_slug' => $this->parent_slug,                  // Parent menu slug.
                    'page_title' => $this->strings['page_title'],       // Page title.
                    'menu_title' => $this->strings['menu_title'],       // Menu title.
                    'capability' => $this->capability,                  // Capability.
                    'menu_slug' => $this->menu,                         // Menu slug.
                    'function'  => array($this,'install_plugins_page')  // Callback.
                )
            );
            $this->add_admin_menu($args);
        }
        public function add_admin_menu(array $args){
            add_theme_page($args['page_title'],$args['menu_title'],$args['capability'],$args['menu_slug'],$args['function']);
        }
        public function install_plugins_page(){ 
            // Store new instance of plugin table in an object.
            $plugin_table = new APA_List_Table();
            ?>
            <div class="apa wrap">
                <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                <?php $plugin_table->prepare_items(); ?>
                <form method="POST">
                    <?php $plugin_table->search_box('Search Post(s)','id'); ?>
                </form>
                <?php $plugin_table->display(); ?>
            </div>       
<?php        }
        public function do_plugin_install(){
            
        }
        public function inject_update_info(){
            
        }
        public function maybe_adjust_source_dir(){
            
        }
        protected function activate_single_plugin(){
            
        }
        public function notices(){ 
            // Store for the plugin slugs by message type
            $message = array();

            // Initialize counters used to determine plurality of action link texts.
            //$install_link_count = 0;
            //$update_link_count = 0;
            //$total_required_action_count = 0;
            echo '<div class="notice updated is-dismissible"><p>';
            if($this->is_apa_page()){
                //return;
            }
            foreach($this->plugins as $slug=>$plugin){
                //var_dump(is_plugin_active('akismet/akismet.php'));
                if($this->is_plugin_installed($slug)){
                    if(current_user_can('install_plugins')){
                        $install_link_count++;
                        if(true === $plugin['required']){
                            echo $message['notice_can_install_required'][] = $slug;
                        }else{
                            $message['notice_can_install_recommended'][] = $slug;
                        }                    
                    }
                    if(true === $plugin['required']){
                        $total_required_action_count++;
                    }
                }else{
                    echo 'No sir';
                }               
            }
            echo '</p></div>';
            unset($slug,$plugin);
            $this->plugins['file_path']['version'];
        }            
        protected function create_user_action_links_for_notice(){
            
        }
        protected function get_admin_notice_class(){
            
        }
        protected function display_settings_errors(){
            
        }
        public function dismiss(){
            
        }
        public function register($plugin){
            if(empty($plugin['slug']) || empty($plugin['name'])){
                return;
            }
            if(empty($plugin['slug']) || ! is_string($plugin['slug']) || isset($this->plugins[$plugin['slug']])){
                return;
            }
            $defaults = array(
                'name'                  => '',          // String
                'slug'                  => '',          // String
                'source'                => 'repo',      // String
                'required'              => false,       // Boolean
                'version'               => '',          // String
                'force_activation'      => false,       // Boolean
                'force_deactivation'    => false,       // Boolean
                'external_url'          => '',          // String
                'is_callable'           => ''           // String
            );
            
            // Prepare the recieved data
            $plugin = wp_parse_args($plugin,$defaults);

            // Standardize the recieved data
            $plugin['slug'] = $this->sanitize_key($plugin['slug']);

            // Forgive users for using string versions boolean or floats for version number
            $plugin['source']          = $plugin['version'];
            $plugin['version']              = $plugin['version'];
            $plugin['source']               = $plugin['source'];
            $plugin['required']             = $plugin['required'];
            $plugin['force_activation']     = $plugin['force_activation'];
            $plugin['force_deactivation']   = $plugin['force_deactivation'];

            // Set the class properties
            $this->plugins[$plugin['slug']] = $plugin;
            //echo $plugin['file_path'] = $this->_get_plugin_basename_from_slug($plugin['slug']);
            //var_dump($this->plugins);
            //echo $this->sort_order[$plugin['slug']] = $plugin['name'];
        }
        protected function get_plugin_source_type(){
            
        }
        public function sanitize_key($key){
            $raw_key = $key;
            $key = preg_replace('`[^A-Za-z0-9_-]`','',$key);
            return apply_filters('apa_sanitize_key',$key,$raw_key);
        }
        public function config($config){
            $keys = array(
                'id',
                'default_path',
                'has_notices',
                'dismissable',
                'dismiss_msg',
                'menu',
                'parent_slug',
                'capability',
                'is_automatic',
                'message',
                'strings'
            );
            foreach( $keys as $key ){
                if(isset($config[$key])){
                    //echo 'hey';
                }
            }
            //echo $config['id'];
        }
        public function actions(){
            
        }
        public function flush_plugins_cache(){
            
        }
        public function populate_file_path(){
            
        }
        protected function _get_plugin_basename_from_slug( $slug ) {
			$keys = array_keys( $this->get_plugins() );
			foreach ( $keys as $key ) {
				if ( preg_match( '|^' . $slug . '/|', $key ) ) {
					return $key;
				}
			}
			return $slug;
		}
        public function _get_plugin_data_from_name(){
            
        }
        public function get_download_url(){
            
        }
        protected function get_wp_repo_download_url(){
            
        }
        protected function get_plugins_api(){
            
        }
        public function get_info_link(){
            
        }
        protected function is_apa_page(){
            return isset($_GET['page']) && $this->menu === $_GET['page'];
        }
        protected function is_core_update_page(){
            
        }
        public function get_apa_url(){
            
        }
        public function get_apa_status_url(){
            
        }
        public function get_apa_complete(){
            
        }
        public function is_plugin_installed($slug){
            $installed_plugins = $this->get_plugins(); // Retrieve a list of all installes plugins (WP Cached)
            return ( ! empty( $installed_plugins[ $this->plugins[ $slug ]['file_path'] ] ) );
        }
        public function is_plugin_active(){
            
        }
        public function can_plugin_update(){
            
        }
        public function is_plugin_updatable(){
            
        }
        public function can_plugin_activate(){
            
        }
        public function get_installed_version(){
            
        }
        public function does_plugin_require_update(){
            
        }
        public function does_plugin_have_update(){
            
        }
        public function get_upgrade_notice(){
            
        }
        public function get_plugins($plugin_folder=''){
            if(! function_exists('get_plugins')){
                require_once(ABSPATH.'wp-admin/includes/plugin.php');
            }
            return get_plugins($plugin_folder);
        }
        public function update_dismiss(){
            
        }
        public function force_activation(){
            
        }
        public function force_deactivation(){
            
        }
        public function show_apa_version(){
            
        }
        public function admin_css(){
            
        }
        public static function get_instance(){
            if(! isset( self::$instance ) && ! ( self::$instance instanceof self ) ){
                self::$instance = new self();
            }
            return self::$instance;
        }
        public function __destruct(){}        
    }
    if(! function_exists('load_azad_plugin_activation')){
        function load_azad_plugin_activation(){
            $GLOBALS['apa'] = Azad_Plugin_Activation::get_instance();    
        }
    }
    if(did_action('plugins_loaded')){
        load_azad_plugin_activation();
    }else{
        add_action('plugins_loaded','load_azad_plugin_activation');
    }
}

if(! function_exists('apa')){
    function apa($plugins, $config){
        $instance = call_user_func( array( get_class( $GLOBALS['apa'] ), 'get_instance' ) );
        foreach( $plugins as $plugin ){
            call_user_func( array( $instance, 'register'), $plugin );
        }
        if(! empty($config) && is_array($config)){
            // Send out notices for depricated arguments passed
            if(isset($config['notices'])){
                $config['has_notices'] = $config['notices'];
            }
            if(isset($config['parent_menu_slug'])){
                $config['has_notices'] = $config['notices'];
            }
            if(isset($config['parent_url_slug'])){
                $config['has_notices'] = $config['notices'];
            }
            call_user_func(array($instance,'config'),$config);
        }
    }
}
/**
 * :: WP_List_Table is not always available. If it isn't always available, we load it here...
 */
if(! class_exists('WP_List_Table')){
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}

if(! class_exists('APA_List_Table')){
    class APA_List_Table extends WP_List_Table{
        protected $apa;
        var $data = array(
            array('id'=>1,'plugin'=>'Woo','source'=>'repo','type'=>'required','status'=>'Published'),
            array('id'=>2,'plugin'=>'Woo','source'=>'repo','type'=>'required','status'=>'Published'),
            array('id'=>3,'plugin'=>'Woo','source'=>'repo','type'=>'required')
        );
        public $view_context = 'all';
        public $view_totals = array(
            'all'       => 0,
            'install'   => 0,
            'update'    => 0,
            'activate'  => 0
        );
        public function __construct(){
            $this->apa = call_user_func(array(get_class($GLOBALS['apa']),'get_instance'));
            parent::__construct(
                array(
                    //'singular'  => 'plugin',
                    //'plural'    => 'plugins',
                    //'ajax'      => false
                )
            );
        }
        public function get_table_classes(){
            return array('widefat','fixed');
        }
        protected function _gather_plugin_data(){
            // Set thickbox for plugin links
            $this->apa->admin_init();
            $this->apa->thickbox();

            // Categories the plugins which have open actions
            $plugins = $this->categorize_plugins_to_views();

            // Set the counts for the view links
            $this->set_view_totals();

            $table_data = array();
            $id = 0;
            return $table_data;
        }
        protected function categorize_plugins_to_views(){
            $plugins = array(
                'all'       => array(),
                'install'   => array(),
                'update'  => array(),
                'activate'  => array()
            );
            foreach($this->apa->plugins as $slug=>$plugin){

            }
        }
        /*protected function __set_view_totals(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        protected function __get_plugin_advise_type_text(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        protected function __get_plugin_source_type_text(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        protected function __get_plugin_status_text(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        public function __sort_table_items(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        public function __get_views(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }*/
        public function column_default( $item,$column_name ){
            switch( $column_name ){
                case 'id':
                case 'plugin':
                case 'source':
                case 'type':
                case 'status':
                    return $item[$column_name];
                case 'action':
                    return '<a href="">Edit</a> | <a href="">Delete</a>';
                default:
                    return 'No value found';
            }
        }
        public function column_cb($item){
            return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" id="%3$s" />',
				esc_attr( $this->_args['singular'] ),
				esc_attr( $item['slug'] ),
				esc_attr( $item['sanitized_plugin'] )
            );
        }
        public function column_plugin($item){
            $action = array(
                'edit'=>'<a href="">Edit</a>',
                'delete'=>'<a href="">Delete</a>'
            );
            return sprintf(
                '%1$s %2$s',
				$item['plugin'],
				$this->row_actions( $action )
            );
        }
        public function column_version($item){
            //return;
        }
        public function no_items(){
            echo  esc_html__('No plugins to install, update or activate','apa').' <a href="'. esc_url(self_admin_url()) .'">' . esc_html($this->apa->strings['dashboard'],'apa') .'</a>';
        }
        public function get_columns(){
            $columns = array(
                'cb'        => '<input type="checkbox" />',
                'id'    => __('ID','apa'),
                'plugin'      => __('Plugin','apa'),
                'source'    => __('Source','apa'),
                'type'      => __('Type','apa'),
                'status'      => __('Status','apa'),
                'action'      => __('Action','apa')                
            );
            return apply_filters('apa_table_columns',$columns);
        }
        protected function get_default_primary_column_name(){
            return 'plugin';
        }
        protected function get_primary_column_name(){
            if(method_exists('WP_List_Table','get_primary_column_name')){
                return parent::get_primary_column_name();
            }else{
                return $this->get_default_primary_column_name();
            }
        }
        protected function get_row_actions(){
            $actions = array();
            $action_links = array();
        }
        public function _single_row($item){
            
        }
        public function wp_plugin_update_row(){
            
        }
        public function extra_tablenav($which){
            
        }
        public function get_bulk_actions(){
            $actions = array(
                'edit'=>'Edit',
                'delete'=>'Delete'
            );
            return $actions;
        }
        public function process_bulk_actions(){
            
        }
        public function get_hidden_columns(){
            //return array('id','name','email');
            return array();
        }
        public function get_sortable_columns(){
            return array(
                'id' => array('id',true),
                'plugin' => array('plugin',true),
                'source' => array('source',true),
                'type' => array('type',true)
            );
        }
        public function prepare_items(){
            //$this->items = $this->data;
            $columns = $this->get_columns();
            $hidden = $this->get_hidden_columns();
            $sortable = $this->get_sortable_columns();
            $primary = $this->get_primary_column_name();
            $this->_column_headers = array($columns,$hidden,$sortable,$primary);

            // Store all of our plugin data into items array so WP_List_Table can use it..
            $this->items = apply_filters('apa_table_data_items',$this->_gather_plugin_data());
        }
        protected function get_plugin_data_form_name(){
            
        }
        public function __destruct(){}
    }
}

if(! class_exists('APA_Bulk_Installer')){
    class APA_Bulk_Installer{
        public function __construct(){

        }
        public function __destruct(){
            
        }
    }
}

if(! class_exists('APA_Bulk_Installer_Skin')){
    class APA_Bulk_Installer_Skin{
        public function __construct(){

        }
        public function __destruct(){
            
        }
    }
}

if(! class_exists('APA_Utils')){
    class APA_Utils{
        public static $has_filtes;
        public function __construct(){

        }
        public static function wrap_in_em(){

        }
        public static function wrap_in_strong(){

        }
        public static function validate_bool(){

        }
        protected static function emulate_filter_bool(){

        }
        public function __destruct(){
            
        }
    }
}
