
class speechDisplay {
  
    //wraps SpeechRecognition browser detection and can extend it with external API if needed
  
    constructor( target, textfallback, speechcontainer, transcript ) {
        
        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        window.SpeechGrammarList = window.SpeechGrammarList || window.webkitSpeechGrammarList;
        
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
            this.renderRecordButton( this.speechcontainer, this.transcript);
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
        d.classList.add('psyML_button');
        d.id = 'psyml_setuprecord';
        d.innerText = 'Record with Speech to Text';
        d.setAttribute('data-text-element', this.targetFallback.id );
        d.setAttribute('data-speech-target', this.speechcontainer.id);
        this.targetElement.appendChild(d);
        d.addEventListener('click', (event) => {
            /* make sure the event is only captured on main element */
            let target = (event.target.classList.contains('psyML_button')) ? event.target : event.target.closest('.psyML_button');

            if(target.classList.contains('active')){
                target.classList.remove('active');
                target.innerText = 'Record with Speech to Text';
                let speechcontainer = document.getElementById(target.dataset.speechTarget);
                let box1 = speechcontainer.querySelector('#psyML_s2tbox_1');
                box1.innerHTML = '';
                speechcontainer.classList.remove('active');
                let textcontainer = document.getElementById(target.dataset.textElement);
                textcontainer.classList.add('active');
            } else {
                target.classList.add('active');
                target.innerText = 'Type the text instead';
                let speechcontainer = document.getElementById(target.dataset.speechTarget);
                speechcontainer.classList.add('active');
                let textcontainer = document.getElementById(target.dataset.textElement);
                textcontainer.classList.remove('active');
            }
        });

        targetobject.appendChild(d);
    }
    renderRecordButton( targetobject, targetid ){
 
        let span_markup = '<span class="indicator"><span></span><span></span></span><span id="buttontext">Record</span>';
        let button = document.createElement('div');
        button.classList.add('psyml_button');
        button.id = 'psyml_record';
        button.innerHTML = span_markup;
        button.setAttribute('data-transcript-element', targetid )
        targetobject.appendChild(button);
        button.addEventListener('click', (event) => {
            /* make sure the event is only captured on main element */
            let target = (event.target.classList.contains('psyml_button')) ? event.target : event.target.closest('.psyml_button');
            if(target.classList.contains('active')){
            target.classList.remove('active');
            let text = target.querySelector('#buttontext');
            text.innerText = 'Record' 
            } else {
            target.classList.add('active');
            let text = target.querySelector('#buttontext');
            text.innerText = 'Recording';
            let transcriptid = target.dataset.transcriptElement;
            let speechInstance = new speechCapture( transcriptid )
            }
        });
    }
}