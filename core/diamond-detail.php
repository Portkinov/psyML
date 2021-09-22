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
        
        $count = 0;
        foreach(Content::DIAMONDS as $diamond => $subdimensions){
            $even = ($count % 2 == 0);
            $count++;
            $topkey = $subdimensions['top'];
            $topvalue = $keygrid[$topkey];
            $leftkey =  $subdimensions['left'];
            $leftvalue = $keygrid[$leftkey];
            $rightkey = $subdimensions['right'];
            $rightvalue = $keygrid[$rightkey];
            $bottomkey = $subdimensions['bottom'];
            $bottomvalue = $keygrid[$bottomkey];




            $markup.='<h1 class="fullpage">Diamond Detail</h1><div class="results-container"><div class="grid-top">';
            $markup.='<div class="col1"><h5 class="results-colheader">';
            $markup.= self::prettykey($topkey).' '.ucfirst($topvalue).'</h5><div class="results-description">'.Content::SUBDIMENSION[$topkey][$topvalue];
            $markup.='</div></div>';
            $markup.='<div class="col2">';
            $markup.='</div><div class="col3">';
            $markup.='<h5 class="results-colheader">'.self::prettykey($rightkey);
            $markup.=' '.ucfirst($rightvalue).'</h5><div class="results-description">'.Content::SUBDIMENSION[$rightkey][$rightvalue];
            $markup.='</div></div></div><div class="grid-mid"><div class="col1">';
            $markup.='</div>';
            $markup.='<div class="col2">';
            if($even){
                $markup.='<img class="diamond" src="' . self::get_plugin_url() . '/dist/css/img/blue-bg.svg">';
            } else {
                $markup.='<img class="diamond" src="' . self::get_plugin_url() . '/dist/css/img/yellow-bg.svg">';
            }
            $markup.='<h4 class="results-col-head">'.self::prettykey($topkey).'</h4>';
            $markup.='<h4 class="results-col-head">'.self::prettykey($leftkey).'</h4>';
            $markup.='<h2 class="results-diamondhead">'.self::prettykey($diamond).'</h2>';
            $markup.='<h4 class="results-col-head">'.self::prettykey($rightkey).'</h4>';
            $markup.='<h4 class="results-col-head">'.self::prettykey($bottomkey). '</h4>';
            $markup.='</div><div class="col3">';
            $markup.='</div></div>';
            $markup.='<div class="grid-bottom"><div class="col1"><h5 class="results-colheader">';
            $markup.=self::prettykey($leftkey).' '.ucfirst($leftvalue).'</h5>';
            $markup.='<div class="results-description">'.Content::SUBDIMENSION[$leftkey][$leftvalue];
            $markup.='</div></div>';
            $markup.='<div class="col2">';
            $markup.='</div>';
            $markup.='<div class="col3"><h5 class="results-colheader">'.self::prettykey($bottomkey);
            $markup.=' '.ucfirst($bottomvalue).'</h5><div class="results-description">';
            $markup.=Content::SUBDIMENSION[$bottomkey][$bottomvalue].'</div></div>';  
            #end col3
            $markup.='</div><!-- end column 3 -->';
            #end grid bottom;=
            $markup.='</div><!-- end results container -->';

        }
        return $markup;

        
            /*
            <div class="results-container">
                <div class="grid-top">
                    <div class="col1">
                        <h5 class="results-colheader">Organization Low</h5>
                        <div class="results-description">S.</div>
                    </div>
                     <div class="col2">
                        <h4 class="results-col-head">Organization</h4>
                     </div>
                    <div class="col3">
                        <h5 class="results-colheader">Diligence Low</h5>
                        <div class="results-description">Being.</div>
                    </div>
                </div>
                <div class="grid-mid">
                    <div class="col1">
                        <h4 class="results-col-head">Prudence</h4>
                    </div>
                    <div class="col2">
                        <h2 class="results-diamondhead">Conscientionsness</h2>
                    </div>
                    <div class="col3">
                        <h4 class="results-col-head">Diligence</h4>
                    </div>
    
                </div>
      
                <div class="grid-bottom">
    
                    <div class="col1">
                        <h5 class="results-colheader">Prudence Low</h5>
                        <div class="results-description">Life</div>
                    </div>
                    <div class="col2">
                        <h4 class="results-col-head">Perfectionism</h4>
                    </div>      
                    <div class="col3">
                        <h5 class="results-colheader">Perfectionism Low</h5>
                        <div class="results-description">People .</div>
                    </div>
                </div>
            </div>
            */
        
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