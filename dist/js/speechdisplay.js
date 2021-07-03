
class speechDisplay {
  
    //wraps SpeechRecognition browser detection and can extend it with external API if needed
  
    constructor( target, textfallback, speechcontainer, transcript ) {
        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        window.SpeechGrammarList = window.SpeechGrammarList || window.webkitSpeechGrammarList;
        this.recognition = new window.SpeechRecognition();
        //do we have any native detection ? 
        this.isnative = function() {return (window.SpeechRecognition) ? true : false;}
        this.targetElement = this.checkTarget(target);
        this.targetFallback = this.checkTarget(textfallback);
        this.speechcontainer = this.checkTarget(speechcontainer);
        this.transcript = this.checkTarget(transcript);
        this.valid = (
            this.isnative() && 
            this.targetElement && 
            this.targetFallback &&
            this.speechcontainer &&
            this.transcript ) ? true : false;
        if(this.valid){
            this.renderCaptureButton( this.speechcontainer );
          /*  this.renderRecordButton( this.speechcontainer, this.transcript); */
            this.renderRecordButton( this.targetElement, this.speechcontainer, this.transcript )
        } else {
            console.log('Could not add Voice to Text Link');
        }

        
    }

    checkTarget ( target ){
        let returnvalue = false;
        if(typeof target==="object"){
            returnvalue = target;
        } else {
            if(typeof target==="string"){
                let root = document;
                if( this.hasOwnProperty('targetElement')) root = this.targetElement;
                let tryit = root.querySelector( target );
                if(tryit ){
                    returnvalue = tryit;
                } else {
                    tryit = document.getElementById( target );
                    if(tryit) returnvalue = tryit;
                }
            }
        }   

        return returnvalue;
    }
    renderCaptureButton( targetobject ){

        let d = document.createElement('div');
        d.classList.add('psyml_button');
        d.id = 'psyml_setuprecord';
        d.innerText = 'Speech to Text';
      /*  d.setAttribute('data-text-element', this.targetFallback.id ); */
        d.setAttribute('data-speech-target', 'psyML_speechToText');
        d.setAttribute('data-text-target', 'psyML_textonly');
        this.targetElement.appendChild(d);
        d.addEventListener('click', (event) => {
            /* make sure the event is only captured on main element */
            let target = (event.target.classList.contains('psyml_button')) ? event.target : event.target.closest('.psyml_button');

            if(target.classList.contains('active')){
                target.classList.remove('active');
                target.innerText = 'Record with Speech to Text';
                let speechcontainer = document.getElementById(target.dataset.speechTarget);
                let box1 = speechcontainer.querySelector('#psyML_s2tbox_1');
                box1.innerHTML = '';
                speechcontainer.classList.remove('active');
                let textcontainer = document.getElementById(target.dataset.textTarget);
                textcontainer.classList.add('active');
            } else {
                target.classList.add('active');
                target.innerText = 'Type the text instead';
                let speechcontainer = document.getElementById(target.dataset.speechTarget);
                speechcontainer.classList.add('active');
                let textcontainer = document.getElementById(target.dataset.textTarget);
                textcontainer.classList.remove('active');
            }
        });

        targetobject.insertBefore(d, targetobject.firstChild);
    }
    renderRecordButton( targetobject, speechcontainer, transcript ){
        let span_markup = '<span class="indicator"><span></span><span></span></span><span id="buttontext">Record</span>';
        let button = document.createElement('div');
        button.classList.add('psyml_button');
        button.id = 'psyml_record';
        button.innerHTML = span_markup;
        button.setAttribute('data-transcript-element', transcript.id)
        button.setAttribute('data-speech-container', speechcontainer.id)
        targetobject.insertBefore(button, targetobject.firstChild );
        button.addEventListener('click', (event) => {
            /* make sure the event is only captured on main element */
            let target = (event.target.classList.contains('psyml_button')) ? event.target : event.target.closest('.psyml_button');
            if( typeof window.recognition === "object" ){
                console.log('supposed to stop');
                window.recognition.removeEventListener('end', window.recognition.start );
                window.recognition.stop();
            }  else { console.log(typeof window.recognition)}
            if(target.classList.contains('active')){
            target.classList.remove('active');
            let text = target.querySelector('#buttontext');
            text.innerText = 'Record' 
            } else {
            target.classList.add('active');
            let text = target.querySelector('#buttontext');
            text.innerText = 'Recording';
            let transcriptid = target.dataset.transcriptElement;
            var capture = new speechCapture( transcriptid )
            }
        });
    }
}