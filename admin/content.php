<?php
namespace psyml\admin;


//spin it
#\psyml\admin\Content::run();

class Content extends \psyML_Wp{
    const SUBDIMENSION = array(
        'Sincerity' => array(
            'high'=> 'What you say is true. You have a hard time stretching thetruth even if it might benefit you. You have a need to be authentic in how you engage with the world.',
            'medium'=> 'You can see why it is better to not always be 100% forthright and why some massaging of the truth can be of value, help a situation and benefit all. Life is about the grays, it’s not black and white so adapting to the demands of each situation.',
            'low'=> 'Masking the truth can be a way to get ahead. People want to hear what they want tohear and you facilitate that. If they are disadvantaged, is it really your fault for their not being a bit more savvy?'

        ),
        'Fairness' => array(
            'high'=> 'We must strive to do everything possible to ensure that the world is an equitable and fair place, even if it meanswe have to sacrifice our position or a potential benefit.',
            'medium'=> 'Life should mostly be fair and equitable, but it doesn’t alwayswork out that way. We just have to accept that. We try our best and sometimes it works out, sometimes it doesn’t.',
            'low'=> 'Inequity is inevitable. There will always be the haves and the have nots. Any attempt to buck this natural order of things is futile, rather silly in fact.'
        ),
        'Greed_Avoidance' => array(
            'high'=> 'Material things are not what matter. They have little importance. Life is about experiences and about connection to ideas and people. You’d rather spend money on a vacation that took your breath away than on a fancy car that turned neighbors’ heads.',
            'medium'=> 'Who doesn’t like to have nice things? They make you feel good, but you aren’t into them exclusively and certainly don’t understand the people who need to constantly one up the other with the latest and greatest. That’s an eye-roll foryou.',
            'low'=> 'You’ve worked hard and you have no problems showing your success. A beautiful home, a flashy car, designer labels, bring it all on. How elsewill people know your accomplishments? Those thatcall that ostentatious are jealous because they don’t have those things.'
        ),
        'Modesty' => array(
            'high'=> 'We are all the same as humans. We face similar struggles and challenges and have similar potential. There is a connected story of human experience that binds all of us together. We all have our individual gifts and that is what makes us collectively special.',
            'medium'=> 'It’s nice to be recognized and acknowledged from time to time for your unique skill set.  Too much attention makes youuncomfortable, but it is motivating to be singled out from time to time. It makes you smile and feel good to be appreciated.',
            'low'=> 'Awards are won by people with extraordinary talent and ambition. Those are the ones remembered as well. You know what you bring to the world and you want to be recognized and cherished for it.'
        ),
        'Fearfulness' => array(
            'high'=> 'You cherish security. The secure ground beneath your feet feels safe. The world is filled with dangers that worry you. You’ve seen so much go wrong and you would rather avoid risk than end up being a casualty and a statistic.',
            'medium'=> 'You thrive in the realm of calculated risks. If the odds are on your side you will do it, but some risks seem preposterous and anyone who indulges in it is just asking for trouble.',
            'low'=> 'Mastering fear is the essence of life. People who are paralyzed by fear are prisonersof their own errant thoughts. That is no way to live life. If you are not bold, you are goingto miss out on life.'
        ),
        'Anxiety' => array(
            'high'=> 'In your experience, things can descend into chaos quickly if you don’t stay attentive and alert. Vigilance is a virtue and it has served you well; even if it does keep you more tense than you prefer.  The occasional sense of panic springs you into action.',
            'medium'=> 'You dwell in the realm of healthy and warranted concern. The world isn’t likely to fall apart, but exercising caution feels like the most comfortable approach.',
            'low'=> 'You can’t understand people whose first response is to panic. Solutions only present themselves when you remain calm. Things have a tendencyto work out, so why expend theenergy to get so worked up?'
        ),
        'Dependence' => array(
            'high'=> 'When life throws you a curveball, your instinctual reaction is to reach out for connections to find someone with whom to share and empathize with.  Your tribe helps you get through every day.',
            'medium'=> 'When you face problems, you find there is a balance of self-resolution and reaching out to others to have that support and encouragement to get youpast your hurdles.  Relationships enhance your life, but you are not reliant on them.',
            'low'=> 'Challenges arise everywhere and in your experience, digging deep within you to tap into your internal strength is what empowers you to overcome those obstacles.  You are highly self-reliant.'
        ),
        'Sentimentality' => array(
            'high'=> 'Relationships are everything.  We are nothing without connection.  You thrive when surrounded by a cocoon of love and feel really downtrodden when you have to part from loved ones.',
            'medium'=> 'We do what we can to foster and nurture relationships.  Sometimes it happens that we have to be far from the people we care about for work or other activities.  That is perfectly fine as we know we will eventually be together again.',
            'low'=> 'Relationships require work.  People are often unpredictableand unreliable.  Often it is better to limit human interaction and just be as self-reliant as possible.  Going it alone is virtuous.'
        ),
        'Social_Self-Esteem' => array(
            'high'=> 'People are drawn to you.  You have a magnetic sense to your personality.  People have beentelling you most of their lives that they wish they were more like you. You are comfortable with that because you are comfortable with you too.',
            'medium'=> 'You love learning from people. Seeing how they navigate different conversations or social situations are moments that you can then apply in yourown life, trying them on for sizeand seeing if it suits you.',
            'low'=> 'You would rather people watchthan be the one out there mingling with the crowd. People can be so entertaining at times! You prefer not to embarrass yourself the way they do sometimes. Safe zones are important. Nobody -especially you - gets hurt.'
        ),
        'Social_Boldness' => array(
            'high'=> 'You love to speak in front of large crowds and prefer leading meetings. Networking at conferences is your jam. You are usually the one to initiate a conversation with your stranger neighbor sitting on a plane, in a bar or waiting in line.',
            'medium'=> 'You don’t mind speaking publicly and leading a meeting once-and-a-while. You will speak with people next to you on a plane, but only if there is an obvious connection, like they are reading a book you love. Networking at a conference can be a chore after a while.',
            'low'=> 'Public speaking isn’t your thingand presenting ideas in a meeting is best done sparingly - everyone can read my email. Conferences seem pointless - you can’t remember a time when anything meaningful came from that stack of business cards you brought home.'
        ),
        'Sociability' => array(
            'high'=> 'You love being the life of the party.  You know that the mood ticks up just by your entering a room. You know how to energize people and get them smiling and laughing.You could do this all night.',
            'medium'=> 'You don’t mind being in large gatherings, but you prefer them in small doses. Ideal for you is to go to them with two orthree friends that you mostly stick with for the evening.',
            'low'=> 'Large gatherings of people seem counterproductive.  How can you build genuine connection and rapport with somany people?  You prefer more intimate interactions, or just being on your own.'
        ),
        'Liveliness' => array(
            'high'=> 'You bolt out of bed in the morning and bring that same level of enthusiastic energy in large doses throughout the day. Life is to be lived! You will only accomplish all that you want with your A-game. Let’s kick it into high gear!',
            'medium'=> 'There are times to be high energy and there are times to be more tranquil and zen. You pride yourself in knowing which situation calls for which version of you and you thrive when you can balance the two.',
            'low'=> 'Why do so many people seem like they are on a caffeine intravenous drip?  People should just calm down. A high level of continuous excitement and engagement seems so draining and often fake.'
        ),
        'Forgiving' => array(
            'high'=> 'People who cause harm often do so with a good set of intentions at the outset. Maybe things got away from them or they executed on it poorly. Few people are evil forthe sake of being evil. Forgiving others is paramount, something we will all need at times.',
            'medium'=> 'Some people will look to take advantage of you, some are inherently good. It’s important to see what type of person youare dealing with and react accordingly. Some people deserve a second chance, others are better off avoided.',
            'low'=> 'Never trust someone who has harmed you.  And if they burn you twice, well payback may be coming. You have been harmed so many times, you are wary of everybody.  Peopleneed to earn your trust.'
        ),
        'Gentleness' => array(
            'high'=> 'People are all driven by different motivations.  You haven’t walked in their shoes or grappled with the things they have, so you don’t feel comfortable in judging them or what drives them. Respect is your default.',
            'medium'=> 'There are some behaviors people exhibit that are just wrong. Society functions well when there are certain standards that we all adhere to. Civility is important and thehallmark of the modern world.',
            'low'=> 'There are people in this world who just get it blatantly wrong. They don’t know how to conduct themselves properly and they just end up ruining it for all others. These people need to know just how much ofa pain they are.'
        ),
        'Flexibility' => array(
            'high'=> 'Maintaining the peace and keeping things calm is always the end game. This should be pursued at all costs. It’s okay to sacrifice and not get all that you want if it serves the greater good of equanimity.',
            'medium'=> 'Compromise is where most of life exists. It is important to triage what is most significant and dear to you and argue for those, while letting those things go that you can live without.',
            'low'=> 'If you don’t stand up for yourself, you will lose. People will try their best to take advantage of you as much as possible. It’s important to preserve yourself and not give in.'
        ),
        'Patience' => array(
            'high'=> 'Reacting quickly usually means you lose and miss out on seeing the matrix of possibility.  Staying calm, evaluating what is being said and devoting energy to an effective solution is the best path.  Emotional reactions will short circuit the process.',
            'medium'=> 'Controlling emotions is critical to successful encounters.  If we stay calm we can gauge when and how we allow ourselves to react.  Sometimesletting a little bit of emotion show is an effective way to break through an impasse.',
            'low'=> 'If you don’t show how important something is to you, people won’t get it.  And they will probably take too long in the process. Raising your voice is okay if it gets your point across.  You have to let people know that it is not okay for them to disregard what you hold dear.'
        ),
        'Organization' => array(
            'high'=> 'Order and precision are the scaffolding upon which all success is built.  Cluttered environments are not conducive to efficient thinking. Everything has its place, so next time you know exactly where to go to find it.  It is sucha waste of time to wander about looking for something that is not in its proper place.',
            'medium'=> 'You like it when things are in their place, but pride yourself on not getting bent out of shape when you have to be responsive on the fly.  Shifting your schedule to make time forsomething unexpected?  Not aproblem for you.  You like to plan, but being rigid is just not your thing.',
            'low'=> 'Structured environments feel too clinical and lifeless.  Sure, you’ve got piles on your desk, but it’s organized chaos.  You can find what you need to.  Plus, when you have an idea about something, you love to act immediately.  Taking time to tidy things feels downright unproductive.  As long as no one is getting hurt, people should just leave you be.'
        ),
        'Diligence' => array(
            'high'=> 'You love getting things done. Nothing is more thrilling for youthan crossing things off of yourto do list and the harder they were to finish the better. You wonder about how you can be most efficient during your day to accomplish even more. At night your sense of a successful day is one where you got the most things done.',
            'medium'=> 'You like to experience life, but always feel irresponsible if youare straying too much from getting the things done that you need to get done.  You areokay not completing everythingfrom your task list as long as you focused on the most important things.',
            'low'=> 'Being married to your chore list yields a boring existence.  Life is to be enjoyed, not to be a slave to getting things done. So what if the bills get paid late?  Memories are formed when you go with the flow.  There’s always a way to figure things out and tomorrow is another day.'
        ),
        'Perfectionism' => array(
            'high'=> 'If it is worth doing, it is worth doing right.  Always strive to make your work as polished aspossible, even if it means revising continuously. There is no such thing as true perfection but that doesn’t mean you won’t try.',
            'medium'=> 'It’s important to try one’s best as often as possible and try to have work be the best it can.  It doesn’t always happen and that’s okay.  Sometimes ‘good enough’ is a good place to stop.',
            'low'=> 'People who break their backs to get everything absolutely right seem silly to you.  They clearly don’t understand the big picture.  At the end, it just won’t matter.  It’s best to enjoy the leisure time.'
        ),
        'Prudence' => array(
            'high'=> 'Life is precious and we should treat it as such. Doing things on a whim can lead to disastrous outcomes. It is important to exercise caution and identify all the potential pitfalls before proceeding.  Proper planning prevents disaster-scenarios that are often painful to recover from.',
            'medium'=> 'You like to do spontaneous things from time to time, but always feel better when you learn about the experience andwhat others have to say about it beforehand. You do research - talk to people who have done it before, read reviews - and if everything checks out, you push forward.',
            'low'=> 'Life is to be experienced! Whyhold back? There are so manyamazing things to do out there - don’t you wish you could just do them all?  Spontaneous activities get your juices flowing! You’ll figure out the details and how to be safe as you go. Not having a fully baked plan is no reason to preclude yourself from an amazing adventure, in fact it is the only way to go!'
        ),
        'Aesthetic_Appreciation' => array(
            'high'=> 'Art is the essence of life. It makes it worth living. Artistic expression is the highest ideal and should be supported and pursued at all costs. You find stimulation in the arts that feeds your soul in a profound way and makes you feel that life has purpose and meaning.',
            'medium'=> 'Art can be pleasing to you, but you may prefer there to be a utilitarian function to it. Designand architecture make sense to you, but some paintings andsculpture are ‘pretty out there’. You may find yourself at a museum, but only if it is a hugeshow that everyone is talking about and you’d rather not miss out.',
            'low'=> 'Practical subjects make more sense for you and you find more of a home in the sciences or math or simple conventions. Artistic expression feels superfluous and in your estimation, borderson being a waste of time. It’s hard to grasp why people spend a lot of time and money supporting the arts.'
        ),
        'Inquisitiveness' => array(
            'high'=> 'You thrive on the stimulation oflearning and knowing. The world is full of wonder for you and if only you could spend all of your time discovering how everything works and why it allholds together. Your mind often wanders to what would happen under various scenarios. You are eager to see different parts of the world and interact with other culturesto satisfy your curiosity about their take on life.',
            'medium'=> 'You are comfortable in your daily routine and mode of living, but every so often, you like to do something different or travel somewhere you haven’t been, just to break up the monotony a little.  Life is not boring to you at all and youhave a comfort in your rhythm of existence, but a little diversity is engaging.',
            'low'=> 'The world can be a scary and dangerous place, and frankly somewhat tedious and boring. There is a degree of risk in venturing out into the unknownand the unfamiliar that you avoid. Staying on the beaten, well worn path is not only how you ensure longevity it’s what you enjoy. The closer you are to home, the fewer things can go wrong.'
        ),
        'Creativity' => array(
            'high'=> 'Why anchor a new endeavor inold thinking? The canvas is completely blank, rife with possibility. Where can it take us and why should we hold back in exploring and unearthing every possibility until we stumble upon our nextgem? No idea is a bad idea and often the craziest of ideas are catalysts for discovering the best one.',
            'medium'=> 'We should build from the successes of the past. Systems and mechanisms have been in place for a long time because they have worked. Modernization is great, but we should begin withwhat has been established andbuild from there. Innovation is wonderful, but a foundation is needed to build from.',
            'low'=> 'It feels like a waste of time to constantly reinvent the wheel. If a baseline product or systemworks, we should just rely on it. Being grounded is a crucial ingredient for sustainable success. Experimenting with untried ways of doing things puts everyone at risk. It is often the best idea to leave things as is.'
        ),
        'Unconventionality' => array(
            'high'=> 'Some people like to think outside the box, but who said there was a box to begin with? Paradigm shifts make wholesale changes that drive innovation.  Innovation requires disruption and that requires people who aren’t afraid to march to their own drummer. Old ways of thinking will leave us in a rut.',
            'medium'=> 'Sometimes you need to breathe new life into an old problem.  A perspective shift can lead to incremental change which is a good path forward without rocking the boat.',
            'low'=> 'Tried and true, and by the book.  That’s the best way to go.  If it’s worked in the past and it is trusted, why alter it?  Problems are solved in a certain way and it’s best to stick with the traditional paths and with the norms that have gotten us here.'
        ), 

    );
    public static function get_subdimensions( $key ){
        $key = str_replace(' ', '_', $key);
        $dim = false;
        foreach(self::SUBDIMENSION as $row => $val){
            if( $key == $row ) $dim = $val;
        }
        return $dim;
    }
    public static function get_subdimension( $key, $degree ){
        $key = str_replace(' ', '_', $key);
        $dim = false;
        foreach(self::SUBDIMENSION as $row => $val){
            if( $key == $row ) {
                if(isset($row[$degree])) $dim = $row[$degree];
            }
        }
        return $dim;
    }

}