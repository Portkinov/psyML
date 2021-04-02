<?php
namespace psyml\core;

/*
* The Hexaco class contains Hexaco translation methods
Hl $sky: #82e6fc;
Hh $sapphire: #1668a5;

Eh $violet: #7d2a8a;
El $lavender: #ca88d4;

Xh $ruby: #9d2138;
Xl $rose: #ef4b89;

Ah $copper: #ff6e37;
Al $tangerine: #ff970b;

Ch $emerald: #29972e;
Cl $jade: #aeea00;

Oh $gold: #ffd600;
Ol $amber: #ffff00;
*/

class Hexaco extends \psyML_Wp{

    // Plugin Variables
    const HEXACO = array(
        0 => array(
            'Letter' => 'H', 'Dimension' => 'honesty', 'Key' => 'Hh', 'Color' => 'sapphire', 'Role' => 'The Incorruptible', 'Link' => 'https://decoding-success.com/the-incorruptible/'
        ),
        1 => array(
            'Letter' => 'H', 'Dimension' => 'honesty', 'Key' => 'Hl', 'Color' => 'sky', 'Role' => 'The Rainmaker', 'Link' => 'https://decoding-success.com/the-rainmaker/'
        ),
        2 => array(
            'Letter' => 'E', 'Dimension' => 'emotionality', 'Key' => 'Eh', 'Color' => 'violet', 'Role' => 'The Empath', 'Link' => 'https://decoding-success.com/the-empath/'
        ),
        3 => array(
            'Letter' => 'E', 'Dimension' => 'emotionality', 'Key' => 'El', 'Color' => 'lavender', 'Role' => 'The Rationalist', 'Link' => 'https://decoding-success.com/the-rationalist/'
        ),
        4 => array(
            'Letter' => 'X', 'Dimension' => 'extraversion', 'Key' => 'Xh', 'Color' => 'ruby', 'Role' => 'The Connector', 'Link' => 'https://decoding-success.com/the-connedtor/'
        ),
        5 => array(
            'Letter' => 'X', 'Dimension' => 'extraversion', 'Key' => 'Xl', 'Color' => 'rose', 'Role' => 'The Contemplator', 'Link' => 'https://decoding-success.com/the-contemplator/'
        ),
        6 => array(
            'Letter' => 'A', 'Dimension' => 'agreeableness', 'Key' => 'Ah', 'Color' => 'copper', 'Role' => 'The Diplomat', 'Link' => 'https://decoding-success.com/the-diplomat/'
        ),
        7 => array(
            'Letter' => 'A', 'Dimension' => 'agreeableness', 'Key' => 'Al', 'Color' => 'tangerine', 'Role' => 'The Contrarian', 'Link' => 'https://decoding-success.com/the-contrarian/'
        ),
        8 => array(
            'Letter' => 'C', 'Dimension' => 'conscientiousness', 'Key' => 'Ch', 'Color' => 'emerald', 'Role' => 'The Chief of Staff',  'Link' => 'https://decoding-success.com/the-chief-of-staff/'
        ),
        9 => array(
            'Letter' => 'C', 'Dimension' => 'conscientiousness', 'Key' => 'Cl', 'Color' => 'jade', 'Role' => 'The Intuitive', 'Link' => 'https://decoding-success.com/the-intuitive/'
        ),
        10 => array(
            'Letter' => 'O', 'Dimension' => 'openness', 'Key' => 'Oh', 'Color' => 'gold', 'Role' => 'The Inquisitive', 'Link' => 'https://decoding-success.com/the-inquisitive/'
        ),
        11 => array(
            'Letter' => 'O', 'Dimension' => 'openness', 'Key' => 'Ol', 'Color' => 'amber', 'Role' => 'The Stalwart', 'Link' => 'https://decoding-success.com/the-stalwart/'
        ),

        
    );

    public function __construct() {

    }
    /* All Functions use the Hexaco Key as only parameter */
    public static function get_info( $key ){
        # Returns (object) HEXACO_row
        # From (string) Hexaco key
        $HEXACO_row = false;
        foreach(self::HEXACO as $row){
            if(strtolower($row['Key']) === strtolower($key) ) $HEXACO_row = $row;
        }
        return $HEXACO_row;
    }
    public static function get_color( $key ){
        $color = false;
        foreach(self::HEXACO as $row){
            if(strtolower($row['Key']) === strtolower($key) ) $color = $row['Color'];
        }
        return $color;
    }
    public static function get_role( $key ){
        $role = false;
        foreach(self::HEXACO as $row){
            if(strtolower($row['Key']) === strtolower($key) ) $role = $row['Role'];
        }
        return $role;
    }
    public static function get_dimension( $key ){
        $dim = false;
        foreach(self::HEXACO as $row){
            if(strtolower($row['Key']) === strtolower($key) ) $dim= $row['Dimension'];
        }
        return $dim;
    }
    public static function get_letter( $key ){
        $letter = false;
        foreach(self::HEXACO as $row){
            if(strtolower($row['Key']) === strtolower($key) ) $letter = $row['Letter'];
        }
        return $letter;
    }
      
}