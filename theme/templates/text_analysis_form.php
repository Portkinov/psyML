<?php 

?>
<div class="psyML siteform">
    <div id="return_display">
    </div>
    <form id="psyML_form" >
    <label for="psyML_text">Enter your text:</label>
    <div id="speech_text_container" data-target="psyML_speechToText" data-textfallback="psyML_textonly" data-transcript="psyML_s2tbox_1" class="psyML_speechContainer">
        <div id="psyML_speechToText">
            <div class="psyML_speechToText" id="psyML_s2tbox_1" contentEditable="true"></div>
            <button type="submit" data-display-target="return_display" form="psyML_Form" onclick="psyML_submit_speech(event);return false;" value="Submit">Submit</button>
        </div>
    
        <div id="psyML_textonly" class="active">
            <textarea id="psyML_text" name="psyML_text" rows="4" cols="50">
        
            </textarea>
            <button type="submit" data-display-target="return_display" form="psyML_Form" onclick="psyML_submit(event);return false;" value="Submit">Submit</button>
        </div>
    </div>
</div>
<div class="psyML footer">
<span>powered by <a href="https://psyml.co/" target="_blank">psyML Inc</a>.</span>
</div>