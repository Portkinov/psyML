
class speechCapture {
  
  //wraps SpeechRecognition browser detection and can extend it with external API if needed

  constructor( targetid, instance ) {
      const SpeechRecognition = window.speechRecognition || window.webkitSpeechRecognition;
      
      this.targetElement = document.getElementById( targetid );
      window.recognition = (typeof window.recognition !== "object") ? new window.SpeechRecognition() : window.recognition; 
      this.listen();
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
        let countcolor = (count > 250) ? 'green' : 'red';
        let span = 'wordcount: <span style="color:' + countcolor + '">'+count+'</span>';
        document.getElementById('psyML_s2t_wordcount').innerHTML = span;
        return count;
    }
    doStopCapture( ){
        console.log('doing stopcapture');
        if( typeof window.recognition == "object") window.recognition.stop();
    }

    
    listen(  ) {
        window.recognition.interimResults = true;
        window.recognition.lang = 'en-US';
        let previous = document.createElement('div');
        previous.classList.add('psyML_transcript');
        previous.setAttribute('contentEditable', "true");  
        this.targetElement.appendChild(previous);
        let words = document.createElement('p');
        this.targetElement.appendChild(words);
        /* native gives us access to speechRecognition result event */
        window.recognition.addEventListener('result', (event) => {   
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
                this.targetElement.scrollTop = this.targetElement.scrollHeight;
                let wordcount = this.wordcount();

                if(wordcount < 500){
                    //
                    window.recognition.addEventListener('end', window.recognition.start );
                } else {
                    window.recognition.removeEventListener('end', window.recognition.start );
                    window.recognition.stop();
                }
                
                }
        });
        window.recognition.start();
        
         
    }
}