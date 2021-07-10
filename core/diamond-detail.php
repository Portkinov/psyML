<?php
namespace psyml\core;
use psyml\admin\Content as Content;

class DiamondDetails extends \psyML_Wp {

    public function __construct( $subdimension_keys = array() ) {
            $this->html = (empty( $subdimension_keys)) ? '' : $this->get_html( $subdimension_keys );
            $this->json = (empty( $subdimension_keys)) ? 
                json_encode( array('status'=>400,'message'=>'no subdimension data included in request') ) : 
                $this->get_json ($subdimension_keys );

    }
    private function get_html( $keys ){
        $markup = '';
        #we have to structure / destructure in a way to get the high/low/med value from the keys

        $keygrid = array();

        foreach($keys as $key){
            #get last _
            $tempkeyarray = explode('_', $key);
            $degree = array_pop( $tempkeyarray);
            $key = self::keystoupper( implode('_', $tempkeyarray) );

            $keygrid[$key] = $degree;
        }
        error_log(print_r($keygrid,true));

        foreach(Content::DIAMONDS as $diamond => $subdimensions){
            $topkey = $subdimensions['top'];
            $topvalue = $keygrid[$topkey];
            $leftkey =  $subdimensions['left'];
            $leftvalue = $keygrid[$leftkey];
            $rightkey = $subdimensions['right'];
            $rightvalue = $keygrid[$rightkey];
            $bottomkey = $subdimensions['bottom'];
            $bottomvalue = $keygrid[$bottomkey];

            $markup.='<h1 class="fullpage">Diamond Detail</h1><div class="results-container"><div class="results-row">';
            $markup.='<div class="results-col1"><div class="col-block"><h5 class="results-colheader">';
            $markup.= self::prettykey($topkey).' '.ucfirst($topvalue).'</h5><div class="results-description">'.Content::SUBDIMENSION[$topkey][$topvalue];
            $markup.='</div></div><div class="col-block leftcenter"><h4 class="results-col-head">'.$leftkey.'</h4>';
            $markup.='</div><div class="col-block"><h5 class="results-colheader">'.self::prettykey($leftkey);
            $markup.=' '.ucfirst($leftvalue).'</h5>';
            $markup.='<div class="results-description">'.Content::SUBDIMENSION[$leftkey][$leftvalue].'</div></div></div>';
            $markup.='<div class="results-col2"><div class="col-block-shrink"><h4 class="results-col-head">';
            $markup.=self::prettykey($topkey).'</h4>';
            $markup.='</div><div class="col-block-grow"><h2 class="results-diamondhead">'.$diamond.'</h2></div>';
            $markup.='<div class="col-block-shrink"><h4 class="results-col-head">'.self::prettykey($bottomkey).'</h4></div></div>';
            $markup.='<div class="results-col3"><div class="col-block"><h5 class="results-colheader">'.self::prettykey($rightkey);
            $markup.=' '.ucfirst($rightvalue).'</h5><div class="results-description">'.Content::SUBDIMENSION[$rightkey][$rightvalue];
            $markup.='</div></div><div class="col-block rightcenter"><h4 class="results-col-head">'.self::prettykey($rightkey).'</h4>';
            $markup.='</div><div class="col-block"><h5 class="results-colheader">'.self::prettykey($bottomkey);
            $markup.=' '.ucfirst($bottomvalue).'</h5>';
            $markup.='<div class="results-description">'.Content::SUBDIMENSION[$bottomkey][$bottomvalue].'</div>';
            $markup.='</div></div></div></div>';

        }
        return $markup;
    }
    private static function keystoupper($key){
        $temparray = explode('_',$key);
        $newkey = '';
        foreach($temparray as $word) {

            $newkey.= ($newkey === '') ? ucfirst($word) : '_'.ucfirst($word);
        }
        $newkey = trim($newkey);
        $newarray = explode('-', $newkey );
        $finalkey = '';
        foreach($newarray as $word){
            $finalkey.= ($finalkey === '') ? ucfirst($word) : '-'.ucfirst($word);
        } 
        $finalkey = trim($finalkey);
        return $finalkey;
    }
    private static function prettykey($key){
        $newkey = str_replace( '_', ' ', $key );
        return $newkey;
    }
    private function get_json( $keys ){
        #once we structure the data for HTML we will for here too
        return true;
    }
    public function render(){
        echo $this->html;
    }
}