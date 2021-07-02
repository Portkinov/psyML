
class speechCapture {
  
  //wraps SpeechRecognition browser detection and can extend it with external API if needed

  constructor( targetid ) {
      const SpeechRecognition = window.speechRecognition || window.webkitSpeechRecognition;
      this.targetElement = document.getElementById( targetid );
      this.speech = this.getSpeech();
      
      if( this.speech ) {
          this.listen( this.speech );
      } else { console.log('something went wrong')}
      
    }


    wordcount(){
        let textelements = this.targetElement.getElementsByTagName('P');
        let count = 0;
        if(textelements.length){
            for(let text of textelements){
                let textarray = text.innerText.split(' ');
                count+= textarray.length;
            }
        }
        return count;
    }
    doStopCapture( ){
        console.log('doing stopcapture');
        
    }
    getSpeech(){
        let instance = new window.SpeechRecognition();
        return instance;
    }
    
    listen( speech ) {
        speech.interimResults = true;
        speech.lang = 'en-US';
        let previous = document.createElement('div');
        previous.classList.add('psyML_transcript');
        previous.setAttribute('contentEditable', "true");
        target_element.appendChild(previous);
        let words = document.createElement('p');
        target_element.appendChild(words);
        /* native gives us access to speechRecognition result event */
        speech.addEventListener('result', (event) => {   
            let transcript = Array.from(event.results)
                .map(result => result[0])
                .map(result => result.transcript)
                .join(''); 
            words.innerText = transcript;
            /* could also use results[0] here instead of result.resultIndex
                - I'm not sure which is more x-browser future proof */
            if(event.results[0].isFinal) {       
                
                let thisround = document.createElement('p');
                thisround.innerText = words.innerText;
                previous.appendChild(thisround);
                words.innerText = '';
                /* scroll text */
                target_element.scrollTop = target_element.scrollHeight;
                let wordcount = this.wordcount();

                if(wordcount < 500){
                    this.speech.addEventListener('end', speech.start);
                } else {
                    this.speech.stop();
                    this.doStopCapture( speech );
                }
                
                }
        });

        this.speech.start();  
    }
}