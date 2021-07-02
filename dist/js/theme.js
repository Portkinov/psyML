const psyML_submit = async(e) => {

    const location = props.ajaxurl + '?action=do_hexformcall';
    let text = get_form_first_textarea( e.target.closest('FORM') );
    let display_target = e.target.dataset.displayTarget;
    let display_element = (display_target) ? document.getElementById(display_target) : false ;

    if(location && text ){
        let nonce =  props.nonce;
        let senddata = encodeURIComponent( 'analysis_text' ) + '=' + encodeURIComponent( text );
        senddata += '&' + encodeURIComponent( 'nonce' ) + '=' + encodeURIComponent( nonce );

        let response = await sendit(location, senddata);   
        if(response && response.status){
            if(response.status == 200){
                console.log(response);
                window.location.href = response.link;
            } else {
                if(display_element){
                 display_element.innerHTML = '<pre>' + JSON.stringify(response) + '</pre>';
                }  
            }
        } 

    } else {
        if(display_element){
            display_element.innerHTML = '<pre>Error: Text missing or invalid</pre>'
        }
    }  
}
const get_form_first_textarea = (form) => {
    if(form.tagName !== 'FORM') return false;
    let textarea = form.querySelector('TEXTAREA');
    return (textarea) ? textarea.value : false;
}

const sendit = async(location, senddata ) => {
    const settings = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body:senddata
    };
    try {
        const fetchResponse = await fetch(location, settings);
        const receivedata = await fetchResponse.json();
        return receivedata;
    } catch (e) {
        console.log(e);
        return e;
    } 
}
const doSpeechForms = () => {
    let speechforms = document.getElementsByClassName('psyML_speechContainer');
    if(speechforms.length){
        if(typeof speechDisplay === "function"){
   

            /* no babel on this project */
            for(let sform of speechforms){
                let target = sform.dataset.target;
                let textfallback = sform.dataset.textfallback;
                let speechcontainer = sform.id;
                let transcript = sform.dataset.transcript;
                let sc = new speechDisplay( target, textfallback, speechcontainer, transcript );
            }
        }
    }
}
/* ONLOAD FUNCTIONS */
window.addEventListener('load', (event) => {

    doSpeechForms();
  });