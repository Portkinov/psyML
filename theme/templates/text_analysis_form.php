<?php 
?>
<div class="psyML siteform">
    <div id="return_display">
    </div>
    <form id="psyML_form" >
    <label for="psyML_text">Enter your text:</label>

    <textarea id="psyML_text" name="psyML_text" rows="4" cols="50">
    
    </textarea>
    <button type="submit" data-display-target="return_display" form="psyML_Form" onclick="psyML_submit(event);return false;" value="Submit">Submit</button>
</div>
<div class="psyML footer">
<span>powered by <a href="https://psyml.co/" target="_blank">psyML Inc</a>.</span>
</div>