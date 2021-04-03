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
        )

        
    );
    const ARCHETYPES = array(
        'Hh' => array(
            'name' => 'The Incorruptible',
            'content'=> 'Nothing would make you compromise your morals. There is no price tagon your values ,even if it may advance your business goals. Material gain is not your foremost goal,  especially if it means you have to compromise  your incorruptible belief system. You act with integrity at allcosts. You would rather face the discomfort  of telling somebody something they would rather not hear instead of placating them. You don\'t  seek excessive attention or special treatment; you are the most equitable of the personality types. Working in teams is a joy for your fellow participants.',
            'roles' => 'Research Scientist, Principal Investigator on a Clinical Trial, Accountant',
            'story' => 'Ana runs a startup that has not been able to exceed $1 million in sales for ten years. Her Board has strongly advised her to reduce payroll and increase marketing. She has had hundreds of investor meetings but can’t seem to close on additional capital.',

        ),
        'Hl' => array(
            'name' => 'The Rainmaker',
            'content'=>'Material gain and making money matter to you, a lot. You have worked hard to build all that you have and you have a right to enjoy life. Status symbols signal to others all that you have accomplished - the more you have the more you have done, and the more you will be able to do. You also see value in stretching the truth, so long as the end goal . You don\'t see the harm in warming up to someone or flattering them if it helps the overall objective. The world was built on \'white lies\', so why should you feel bad? Machiavelli was right; the ends justify the means.',
            'roles' => 'Marketing, Sales',
            'story' => 'Jasper started a social media video site. Frustrated that it took three months to get to 1k followers, he bought followers in Asia and in month four showed 100+k followers. He told investors he had an industry-defying 5% conversion rate of paying customers. He raised $5 million and now has to pay people to buy his service so he can show growth.',

        ),
        'Eh' => array(
            'name' => 'The Empath',
            'content' => 'Emotions grip you more than they do most people. You are reluctant to deliver any news that may be harmful to others. You have been considered an empath your life. You like it when everyone gets along and is thoughtful about your feelings and that of the group. Sharing youremotions and seeking support from others is what life is about. You find yourself resonating with others in the group. You consider your work colleagues your tribe. You are sad when they are not around and you worry that they are okay, hoping regularly that nothing bad happened to them. Because of such concerns, you tend to avoid any activity that might put your physical well being at risk - it just isn\'t worth it to you.',
            'roles' => 'Non-Profit Director, Working with children',
            'story' => 'Timothy is the CTO of a VR business started by his college roommate. He vomits before every demo the Founder schedules. He gets so afraid of the feedback that he excuses himself to go to the bathroom after the demo is over and waits there until the meeting is over.',

        ),
        'El' => array(
            'name' => 'The Rationalist',
            'content' => 'You are very secure in your emotions and are not easily swayed if someone is over-reacting to news you may need to deliver them. You like being quantitatively focused on running a business based on numbers and analytics. Data doesn\'t lie, good logic usually wins That\'s why your so good with finances, risk doesn\'t scare you because you understand its causes. You know that sometimes people have to swallow hard decisions, including that they may need to be let go. Whenpeople come in and out of your life - that\'s just how it is. You have the confidence that you can replace your team members or even someone you have a close relationship with.',
            'roles' => 'Technical Head',
            'story' => 'Lance is celebrating a milestone. He is on his 1,000th investor meeting. He hasn’t adjusted his presentation since the first one. People are constantly giving him advice on how to modify, change it, or even tell him he should give up. It doesn\'t deter him. He knows that eventually he will find the right person who gets it.',

        ),
        'Xh' => array(
            'name' => 'The Connector',
            'content' => 'You love people and feed off of every opportunity you have to interact with them. You have a hard time understanding people who get nervousor shy speaking in front of others, because you can\'t wait to experience that jolt of a rush of energy you get from having an audience, of being infront of a crowd. People love being in your  company as well; you are always hearing how you are the life of the party. You are the one in a plane or restaurant who has no qualms about striking up a conversation with those around you. You run out of your business cards at conferences because you are meeting so many people.',
            'roles' => 'CEO',      
            'story'=> 'Edgar keeps raising money because he loves being on a roadshow. He has been to all of the industry conferences that year, yet convinces the Board to go to ancillary conferences. He has logged 250 hotel nights outof the last 365.',

        ),
        'Xl' => array(
            'name' => 'The Contemplator',
            'content' => 'You are thoughtful and reflective, preferring to convey your ideas or wisdom in more intimate settings, particularly one-on-one. You don\'t seethe value of large crowd gatherings because it feels inefficient to you, they can even feel draining. And you can\'t really have the depth of conversation you like to develop the right relationship in that format. You don\'t consider it necessary to talk to strangers; chit chat is not your favorite and it just takes time to develop the type of relationships you find valuable.  It\'s far better to interact with people who have been \'qualified\' as having some relevance through a referral from a colleague or acquaintance.',
            'roles' => 'CTO, Chief Medical Officer',
            'story' => 'Howard feels relieved by COVID and only needing to do meetings over Zoom, Google Hangouts or Skype. He is proud of his AI algorithm to determine drug efficacy and binding properties. He was excited to have his paper published in Nature, but has declined opportunities to present it at symposia, even when on-line.',

        ),
        'Ah' => array(
            'name' => 'The Diplomat',
            'content'=> 'You intuitively understand that when we all get along, we do better as a group. You make it a point to resolve differences between factions with whom you might be working or within your own team group dynamic. Compromise is not a dirty word to you, in fact, more people would be able to get what they want if it were more common. You do your best not to let your  emotions impact your decisions but relationships are very personal for you. So even though you stay calm on the outside  and are often able to find a path that works for everyone it helps if you have someone, or someplace, where you can destress. Then it’s back to what you love to do .',
            'roles' => 'Negotiator, Biz Dev Head, C-Suite Executive, Executive Administrator',
            'story' => 'Felicia runs sales of cloud-based accounting software. She has a team of 12 focused on different industry verticals, but is a master of swoopingin to close deals when her salespeople hit a wall. She has a knack for making a customer feel like she deeply understands the problem facing them and has just the solution to overcome an impasse.',

        ),
        'Al' => array(
            'name' => 'The Contrarian',
            'content'=> 'You don\'t see the value in conceding, in fact compromise rarely makes sense. No one else will look out for your interests so it’s up to you to make sure that happens. If someone really wants something, they\'ll givein. It\'s okay to say no to people\'s requests. There is no need to grant favors or budge for others. People can get caught up in the euphoria of getting a business deal done and they often ignore the fundamentals, leading to problems later where they end up regretting what they chose.People don\'t really change. If they harmed you once, shame on them; if they harm you twice, shame on you. Showing a tough, unrelenting facade in a meeting is the best way to ensure you don\'t get the short end of the stick.',
            'roles' => 'Head of Sales, Legal',
            'story' => 'Joseph is the quality control lead for a nutritional supplements business.He oversees the intake of product from over 1,000+ supply relationships. He created “THE BINDER”, the list of acceptable parameters to allow product to enter their warehouse and inventory. He has a 13% rejection rate, double his predecessor. He spends most mornings on the phone with pleading suppliers who don’t want product returned and yelling production supervisors who have to constantly re-schedule production.',

        ),
        'Ch' => array(
            'name' => 'The Chief of Staff',
            'content'=> "You know how to get things done. You are the most reliable member of the team, first at the table, material organized, presentation ready. You always deliver. When discussions are being had about what needs to beaccomplished, your mind is racing, setting up the step-by-step process for how you can get to that visualized finish line. You are organized and on top of all that needs to get done, when it needs to get done. You know how to judge what might be frivolous or highly valuable, you are always aware of the context within which you are operating. You firmly believe that if it is worth doing, it is worth doing well and you go to great lengths to make things as perfect as possible, because that means that life runs smoothly and who wouldn't want that?",
            'roles' => 'Chief of Staff, Execution Head, COO',
            'story' => "William is Chief of Staff at a commercial production company. He sits in when the CEO meets clients and staffs projects with in-house cameramen, control booth operators, make-up artists and editors. He also oversees scheduling and delivery of the final product.",

        ),
        'Cl' => array(
            'name' => 'The Intuitive',
            'content'=> "You are a big picture person. You know what it should look and feel like,but you are not the person to see it through. You learned early on that there are plenty of people who are not only good at management and organization they even enjoy it. Which is perfect for you because you are too busy focusing on your next great big idea that will change the world. You don't see the need to clear off your desk or office - you know where to find your things. Also, with all the inspiration you see, why not be surrounded by it? Deadlines are suggestions; for you, if it requires more time to fully bake, you should take it. If you don't get it right this time, there's more chances in the future to keep working at it.",
            'roles' => 'Founder, Visionary, Head of Workplace Culture',
            'story' => "Lyrica is Chief Creative Officer at a digital branding firm. She has an ability to immediately see a vision for a marketing campaign for a client. Clients love her concept and often ask for her during the implementationstage, feeling disappointed that she isn’t around.",

        ),
        'Oh' => array(
            'name' => 'The Inquisitive',
            'content'=> 'No idea is a bad idea until proven so. You love borrowing paradigms from other disciplines in order to solve problems. You find yourself constantly asking "how does that work?" Life is beautiful and creativity isthe engine that drives all of humanity and has been the bedrock for every successful business in history. You love to read about those stories. Often times the more disparate the conflation of ideas, the moreexcited you get. The person who invented velcro after seeing it in natureis your personal hero. You keep seeking your \'velcro\' but as long as youhave the chance to keep learning it’s all good.',
            'roles' => 'CEO, Head of Product Development',
            'story' => 'Jules is a designer championing ergonomically friendly, sustainably manufactured, household products. Some of her best concepts come when she is walking in nature.',

        ),
        'Ol' => array(
            'name' => 'The Stalwart',
            'content'=> "If it isn't broken, don't try to fix it. Most solutions have already been thought of, there are few truly new ideas. They are tried and true and are so because they have consistently worked and there is no reason toreinvent the wheel when a perfectly good solution is available. You lean on practicality.  Your friends who spend thousands on art work baffle you - they seem so intelligent otherwise. You like reading biographies because you can learn from what worked for other people - let them experiment for you to benefit. You like tradition, you remember birthdaysand anniversaries and you prefer sticking with the restaurants you know. Life is good.",
            'roles' => 'CFO, Accounting, General Counsel',
            'story' => 'Tom advises start-ups on their tax strategy. In most cases he recommends how they can apply their significant Net Operating Losses.There are often creative suggestions from his clients based on what they have heard others do. If Tom hasn’t seen it work already, he is loathe to try it.',

        )
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