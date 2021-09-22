<?php
namespace psyml\admin;
use \psyml\core\Hexaco as Hexaco;
use \psyml\admin\Setup as Setup;

\psyml\admin\AdminFunctions::get_instance();

class AdminFunctions extends \psyML_Wp {
    private static $instance = null;
    public static function get_instance(){
        if (self::$instance == null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /* CONTRUCTOR */
    public function __construct() {

        \add_action('admin_enqueue_scripts', array(get_class(), 'admin_enqueue' ) );
 
        \add_action('wp_ajax_do_personality_call', array(get_class(), 'do_personality_call'));

        \add_action('wp_ajax_do_hexformcall', array(get_class(), 'do_hexformcall'));
        \add_action('wp_ajax_nopriv_do_hexformcall', array(get_class(), 'do_hexformcall'));

        \add_action('wp_ajax_tag_marked_posts', array(get_class(), 'tag_marked_posts'));
        \add_action('wp_ajax_tag_marked_posts_firstrun', array(get_class(), 'tag_marked_posts_firstrun'));

        \add_action('wp_ajax_uninstall_delete_posts', array( get_class(), 'uninstall_delete_posts'));
    }

    public static function admin_enqueue() {
        \wp_enqueue_script(self::text_domain.'_admin-js', self::get_plugin_url('dist/js/admin.js'), array('jquery'), self::version, false);  
        \wp_enqueue_style(self::text_domain.'_admin-css', self::get_plugin_url('dist/css/admin.css'), array(), self::version, 'all');

        \wp_localize_script( self::text_domain. '_admin-js', strtolower(self::text_domain), array(
            'ajaxurl' => \admin_url( 'admin-ajax.php' ),
            'debug' => self::$debug,
            'nonce' => \wp_create_nonce( strtolower(self::text_domain) )
        ));
    }

    public static function nicename( $text ){
        if(strpos($text, '-')) str_replace('-', ' ', $text);
        if(strpos($text, '_')) str_replace('_', ' ', $text);
        
    }

    public static function uninstall_delete_posts(){
        if(!empty($_POST['deleteposts'])){
            if($_POST['deleteposts']=='yes' ) {
                \update_option( 'psyml_deleteposts', 1 );
            } else if($_POST['deleteposts']=='no' ){
                \update_option( 'psyml_deleteposts', 0 );
            }
            
        }
        echo json_encode(array('message'=>'Got it. Thanks for using PsyML'));
        wp_die();
    }

    private static function get_current_run($run_id){
        $folder = self::get_plugin_path( 'lastrun/' . $run_id);
        $csv = fopen( $folder .'/'. ucfirst(self::text_domain).'_posts_run.csv', 'r+');
        return ($csv) ? $csv : false;
    }
    private static function start_current_run($run_id){

        $folder = self::get_plugin_path( 'lastrun');

        if(!file_exists($folder)) mkdir($folder, 0755,true);
        //delete last run
        self::delete_everything_in_folder($folder);

        if(!file_exists( $folder.'/'.$run_id )) {            
            mkdir($folder.'/'.$run_id, 0755, true);
        }
        if(file_exists($folder.'/'.$run_id .'/'. ucfirst(self::text_domain).'_posts_run.csv') ){
            unlink( $folder.'/'.$run_id .'/'. ucfirst(self::text_domain).'_posts_run.csv');
        }
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.ucfirst(self::text_domain).'_posts_run.csv"');

        $csv = fopen( $folder.'/'.$run_id .'/'. ucfirst(self::text_domain).'_posts_run.csv', 'w');
        if($csv){
            $headers = array('ID', 'run_id','Tag');
            fputcsv($csv, $headers);
            return $csv;
        } else {
            echo json_encode(array('status'=>400, 'message'=> 'Could not open file.'));
            wp_die();
        }  
    }
    private static function delete_everything_in_folder($path){

        $dirs = scandir($path);
        $ignore = array('.', '..');
        #get rid of these annoying aliases
        $dirs = array_diff($dirs, $ignore);

        foreach($dirs as $dir){

            if(false === strpos($dir,'.')){

                $files = glob($path.'/'.$dir.'/*.csv'); // get csv file (s) but should only be one
 
                foreach($files as $file){ // iterate files
                    unlink($file); // delete file
                }
                rmdir($path.'/'.$dir);
            } else {
                unlink($dir);
            }
        }
    } 
    public static function tag_post_gatekeeping($thepost){
        //START GATEKEEPING
        if(empty($thepost) ) return false;
        if(empty($thepost['nonce'])) return false;
        $verify = \wp_verify_nonce( $thepost['nonce'], strtolower(self::text_domain) );
        if(!$verify){
            echo json_encode(array('status'=>400, 'message'=> 'Authentication failed (nonce)'));
            wp_die();
        }
        if(!isset($thepost['post_types'])) {
            $tagtypes = self::get_psyml_post_types();

            if(!$tagtypes){
                echo json_encode(array('status'=>400, 'message'=> 'No Post Types Chosen.'));
                wp_die();
            }
        } else {
            $types = explode(',', $thepost['post_types']);
            if(!$types || empty($types)){
                echo json_encode(array('status'=>400, 'message'=> 'No Post Types Chosen.'));
                wp_die();
            }
        }


        $currentnum = isset($_POST['currentnum']) ? (int)$_POST['currentnum'] : false;
        
        if(false === $currentnum){
            echo json_encode(array('status'=>400, 'message'=> 'Could not find current post number.'));
            wp_die();
        }
        
        return $currentnum;
    }
    public static function get_psyml_post_types(){
        $kvtypes = \get_post_types( '','names');
        $flat_types = array();
        foreach($kvtypes as $k=>$v){
            array_push($flat_types, $k);
        }
        $types = Setup::unset_nonsense($flat_types);
        $tagtypes = array();
        foreach($types as $type){
            if( \get_option('psyml_'.$type) === 'yes') array_push($tagtypes, $type);
        }
        return $tagtypes;
    }
    private static function set_up_results_array(){
        $termsraw = \get_terms( array(
            'taxonomy' => 'hexaco',
            'hide_empty' => false,
        ));
        $top = array();

        #loop through top level first
        foreach($termsraw as $term){
            if($term->parent === 0){
                $toprow = array('name'=>$term->name,'id'=>$term->term_id, 'count' => 0);
                $top[$term->term_id] = $toprow;
            }
        }
        #now loop bottom row
        $bottom = array();
        foreach($termsraw as $term){
            if($term->parent !== 0){
                $bottomrow = array('name'=>$term->name, 'id'=>$term->term_id, 'parent'=> $term->parent, 'count' => 0);
                $bottom[$term->parent][$term->name] = $bottomrow;
            }
        }
        $results_array = array();
        foreach($top as $topkey => $topval){
            foreach($bottom as $botkey => $botval){
                if($topkey === $botkey){
                    $hexkey = array_keys($botval);
                    $letter = Hexaco::get_letter( $hexkey[0]);
                    $toprow = array_merge($topval,array('letter'=>$letter) );
                    $row = array_merge($toprow, array('children'=>$botval));
                    $results_array[$topkey] = $row;
                }
            }
        }
        return $results_array;
    }

    private static function update_results_array($termslug, $results){
        #mutate the array
        $newcount = 0;
        $dimension = false;
        $key = false;
        foreach( $results as $dim => $val ){
            foreach($val['children'] as $k=>$v){
                if($k === $termslug){
                    $newcount = $v['count'] + 1;
                    $dimension = $dim;
                    $key = $k;
                } 
            }
        }
        $results[$dimension]['children'][$key]['count'] = $newcount;
        return $results;
    }

    public static function tag_marked_posts(){

        $currentnum = self::tag_post_gatekeeping($_POST);
        $currentnum++;
        $maxnum = $_POST['maxnum'];
        $post_types = explode(',', $_POST['post_types']);
        $results_json = stripslashes($_POST['results']);
        $results = json_decode($results_json, true);

        $run_id = isset($_POST['run_id']) ? $_POST['run_id'] : false;
        if(!$run_id){
            echo json_encode(array('status'=>400, 'message'=> 'Could not find current run id. Run aborted.'));
            wp_die(); 
        }

        $file = self::get_current_run($run_id);
        if(!$file){
            if(self::$debug)error_log('function get_current_run failed to load file');
            echo json_encode(array('status'=>400, 'message'=> 'Could not generate or find run file. Run aborted.'));
            wp_die(); 
        } 
        $skip_unpublished = \get_option('psyml_skip_unpublished') === 'yes' ? 'publish' : 'any';
        $skip_prevtag = \get_option('psyml_skip_currently_tagged') === 'yes' ? true : false;
        #GET Next ID
        $idx = 1;

        //Loop through the CSV rows.
        while (($row = fgetcsv($file , 0, ",")) !== FALSE) {

            //Dump out the row for the sake of clarity.
            if($idx === $currentnum) {

                #matched for next record$headers = array('ID', 'run_id','Tag');
                $ID=$row[0];
                $run_id = $row[1];
                $tag = $row[2];
                #see if file is currently tagged
                $post_hexaco_terms = \get_the_terms($ID, 'hexaco');
  
                if($post_hexaco_terms && $skip_prevtag){
                    fclose($file);
                    $results_array = self::update_results_array($post_hexaco_terms[0]->name,$results);
                    $data = array(
                        'element' => (isset($_POST['element'])) ? $_POST['element'] : false ,
                        'state' => '<p>Processed record '.$currentnum.' of '.$maxnum.'. Record Skipped.</p>',
                        'action' => 'tag_marked_posts',
                        'payload'=> array(
                            'nonce'=>$_POST['nonce'],
                            'post_types'=>$post_types,
                            'run_id'=>$run_id, 
                            'results'=>$results_array,
                            'currentnum'=>$currentnum,
                            'maxnum'=> $maxnum,
                            'element' => (isset($_POST['element'])) ? $_POST['element'] : false
                        ),
                        'currentnum' => $currentnum,
                        'maxnum' => $maxnum
                    );
                    echo json_encode(array('status'=> 200, 'data'=>$data));
                    wp_die();
                    break;
                }
                $thepost = \get_post((int)$ID, ARRAY_A);

                $postcontent = \apply_filters( 'the_content', $thepost['post_content'] );
  

                $term = self::do_personality_call($postcontent);
                if($term && $term !== 'Could Not Determine Hexaco Results.'){
                    #tag post       
                    $tagged = \wp_set_object_terms( $ID, strtolower($term['Key']), 'hexaco', false );
                    #update results array
                    $results_array = self::update_results_array($term['Key'],$results);

                    $add_message = (!$tagged || \is_wp_error($tagged)) ? 'There was a problem tagging record.' : 'Record tagged.';
                    fclose($file);
                    $data = array(
                        'element' => (isset($_POST['element'])) ? $_POST['element'] : false ,
                        'state' => '<p>Processed record '.$currentnum.' of '.$maxnum.'. '.$add_message.'</p>',
                        'action' => 'tag_marked_posts',
                        'payload'=> array(
                            'nonce'=>$_POST['nonce'],
                            'post_types'=>$post_types,
                            'run_id'=>$run_id, 
                            'results'=>$results_array,
                            'element'=>(isset($_POST['element'])) ? $_POST['element'] : false ,
                            'currentnum'=> $currentnum,
                            'maxnum'=> $maxnum
                        ),
                        'currentnum' => $currentnum,
                        'maxnum' => $_POST['maxnum']
                    );

                    echo json_encode(array('status'=> 200, 'data'=>$data));
                    wp_die();
                } else {
                    
                    fclose($file);
                    $data = array(
                        'element' => (isset($_POST['element'])) ? $_POST['element'] : false ,
                        'state' => '<p>Processed record '.$currentnum.' of '.$maxnum.'. '.$term.'</p>',
                        'action' => 'tag_marked_posts',
                        'payload'=> array(
                            'nonce'=>$_POST['nonce'],
                            'post_types'=>$post_types,
                            'run_id'=>$run_id, 
                            'results'=>$results,
                            'element'=>(isset($_POST['element'])) ? $_POST['element'] : false ,
                            'currentnum'=> $currentnum,
                            'maxnum'=> $maxnum
                        ),
                        'currentnum' => $currentnum,
                        'maxnum' => $_POST['maxnum']
                    );

                    echo json_encode(array('status'=> 200, 'data'=>$data));
                    wp_die();
                }

            }
            $idx++;
        }
        #then do end of file shit

        #TAG CURRENT POST

    }
    /* START HERE FOR JAVASCRIPT PAGE FLOW */
    public static function tag_marked_posts_firstrun(){
        #post validation function
        $recordnum = self::tag_post_gatekeeping($_POST);
        #get post types to be analyzed
        $tagtypes = self::get_psyml_post_types();
        #Make fresh report
        $run_id = date("Ymdh");
        $newfile = self::start_current_run($run_id );

        #get needed settings for record count
        $skip_unpublished = \get_option('psyml_skip_unpublished');
        $publish = ($skip_unpublished === 'yes') ? 'publish' : 'any';

        # Get Post IDs and record count
        $firstquery = \get_posts([
            'posts_per_page' => -1,
            'post_status' => $publish,
            'post_type' => $tagtypes,
            'fields' => 'ids',
        ]);
        foreach($firstquery as $record){
            $row = array($record,$run_id, '');
            fputcsv($newfile,$row);
        }
        fclose($newfile);
        $count = count($firstquery);
        \wp_reset_postdata();

        #set up results 
        $results_array = self::set_up_results_array();
        #start the two-way loop
        $data = array(
            'element' => (isset($_POST['element'])) ? $_POST['element'] : false ,
            'state' => '<p>Record 0 of '.$count.'. Options retrieved & Run created. Beginning the content analysis.</p>',
            'action' => 'tag_marked_posts',
            'payload'=> array('nonce'=>$_POST['nonce'],
                              'post_types'=>$tagtypes,
                              'run_id'=>$run_id, 
                              'results'=>$results_array,
                              'currentnum'=>1,
                              'maxnum' => $count,
                              'element' => (isset($_POST['element'])) ? $_POST['element'] : false
                              ),
            'currentnum' => 1,
            'maxnum' => $count
        );
        echo json_encode(array('status'=> 200, 'data'=> $data ));
        wp_die();
    }

    private static function make_personality_call( $text, $key ){

        $url = 'https://psymlapi.appspot.com/personality?key='.$key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Accept: application/json',
          'Content-Type: application/json',
        ));
        $bodyArray = array(
          'medium' => 'twitter',
          'sentences' => sanitize_text_field( $text ),
        );
        $body = json_encode($bodyArray);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);

        if($result === false){
            echo json_encode(array('status'=>400, 'message'=>'Could not execure CURL command'));
            wp_die();
        } else if(trim($result) === 'No personality'){
            echo json_encode(array('status'=>400, 'message'=>'No personality'));
            wp_die();
        } else {
            return $result;
        }
    }
    private static function make_full_personality_call( $text, $key ){

        
        $url = 'https://psymlapi.appspot.com/personality_full?key='.$key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Accept: application/json',
          'Content-Type: application/json',
        ));
        $bodyArray = array(
          'medium' => 'twitter',
          'sentences' => sanitize_text_field( $text ),
        );
        $body = json_encode($bodyArray);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);
   
        if($result === false){
            echo json_encode(array('status'=>400, 'message'=>'Could not execure CURL command'));
            wp_die();
        } else if(trim($result) === 'No personality'){
            echo json_encode(array('status'=>400, 'message'=>'No personality'));
            wp_die();
        } else {
            return $result;
        }
    }
    public static function do_hexformcall(){
        #No post No nonce No service
        if(!isset($_POST['nonce'])) return false;
        if(!isset($_POST['analysis_text'])) return false;
        $text = $_POST['analysis_text'];
        $nonce = $_POST['nonce'];
        if(empty($text)){
            echo json_encode(array('status'=>400, 'message'=>'Please include some text.'));
            wp_die();
        }
        #1 - Nonce 
        $verified = \wp_verify_nonce( $nonce, 'do_personality_call' );

        if($verified){
            $api_key = esc_attr( \get_option('psyml_api_key') );
            # 2 - We have key & text
            
            $result = self::make_full_personality_call($text, $api_key);

            if($result){
                #before json_decode, we need to replace single quotes with doublequotes
                #for PHPs json linter
                $result = str_replace("'", '"', $result);

                # A - Calculate Hexaco
                $resultArray = json_decode($result, true);

                $topArray = array(); 
                $dimensionArray = array();           
                $results= $resultArray['response'];
                #Separate the Scoring Dimensions vs. Sub Dimensions
                $currentrow = array();
                foreach($results as $row ){
                    if( array_key_exists( 'subDimensions', $row) ){

                        $toprow = array("type"=> $row["type"], "score"=> $row["score"]);
                        array_push($topArray, $toprow);
                        $bottom = $row['subDimensions'];
                        foreach($bottom as $botrow){
                            array_push($dimensionArray,$botrow);
                        }
                    } else {
                        array_push($dimensionArray, $row);
                    }
                }
                $topScore = 0;
                $realScore = 0;
                $topType = false;

                foreach($topArray as $row){
                    $score = abs(floatval ($row['score'] ));
                    if($score > $topScore) {
                        $topScore = $score;
                        $realScore = floatval($row['score'] );
                        $topType = $row['type'];
                    }
                }

                #Log this out if it doesnt work
                if($topType === false){
                    if(self::$debug) error_log('Could Not Determine Hexaco Results.' );
                    echo json_encode(array('status'=>400, 'message'=>'Error Translating Hexaco Results.'));
                    wp_die();
                }
                        
                $key = substr($topType,0,1);
                if($key === 'N') $key = 'E';
                $key .= (abs($realScore) === $realScore) ? 'h' : 'l';

                #B - get Hexaco Info
                $info = Hexaco::get_info($key);

                if($info === false){
                    if(self::$debug) error_log('Error Translating Hexaco Results.' );
                    echo json_encode(array('status'=>400, 'message'=>'Error Translating Hexaco Results.'));
                    wp_die();
                } else {
                    #All is good - Now we do SubDimensions
                    $translateArray = array();
                    foreach($dimensionArray as $subdim){
                        $name = str_replace(' ', '_', trim($subdim['type']));
                        $height = false;
                        $score = floatval($subdim['score']);
                        /* Score Criteria */
                        /*  -1 to -.33, -.3299999 to .3299999 and .33 + */
                        if($score <= -.33 ){
                            $height = 'low';
                        } else if($score <= .3299999){
                            $height = 'medium';
                        } else if( $score >= .33 ){
                            $height = 'high';
                        } else {
                            $height = 'Could not determine this score range.';
                        }
                        array_push( $translateArray, array($name=>$height));
                    }


                    $link = \get_site_url() . '/psyml-results/?result='.$key;
                    foreach($translateArray as $subrow){
                        foreach($subrow as $k=>$v){

                            $link.='&'.urlencode($k).'='.urlencode($v);
                        }
                    }

                    echo json_encode(array('status'=> 200, 'data'=>$resultArray, 'link'=>$link ));
                    wp_die();
                }
            }
        } else { 

            if(self::$debug) error_log('Failed Nonce');
            echo json_encode(array('status'=>400, 'message'=>'Failed Authentication check. Check with site admin.'));
            wp_die();
        }

    }

    public static function do_personality_call( $text ) {

        # 1 - Authentication
        $api_key = esc_attr( \get_option('psyml_api_key') );
        if($api_key){
            # 2 - We have key & text
            $result = self::make_personality_call($text, $api_key);

            if($result){
                #before json_decode, we need to replace single quotes with doublequotes
                #for PHPs json linter
                $result = str_replace("'", '"', $result);
                        
                # A - Calculate Hexaco
                $resultArray = json_decode($result, true);

                $topScore = 0;
                $realScore = 0;
                $topType = false;

                foreach($resultArray as $row){
                    $score = abs(floatval ($row['score'] ));
                    if($score > $topScore) {
                        $topScore = $score;
                        $realScore = floatval($row['score'] );
                        $topType = $row['type'];
                    }
                }
                if($topType === false){
                    fclose($file);
                    if(self::$debug) error_log('Could Not Determine Hexaco Results.' );
                    return 'Could Not Determine Hexaco Results.';
                }
                        
                $key = substr($topType,0,1);
                if($key === 'N') $key = 'E';
                $key .= (abs($realScore) === $realScore) ? 'h' : 'l';

                #B - get Hexaco Info
                $info = Hexaco::get_info($key);

                if($info === false){
                    fclose($file);
                    if(self::$debug) error_log('Error Translating Hexaco Results.' );
                    echo json_encode(array('status'=>400, 'message'=>'Error Translating Hexaco Results.'));
                    wp_die();
                } else {
                    #All is good
                    return $info;
                }
            } else {
                fclose($file);
                if(self::$debug) error_log('Error with make_personality_call');
                echo json_encode(array('status'=>400, 'message'=>'Error with make_personality_call'));
                wp_die();
            }
        } else {
            fclose($file);
            if(self::$debug) error_log('Error with API Key');
            echo json_encode(array('status'=>400, 'message'=>'Error with API Key'));
            wp_die();
        }
    }
}