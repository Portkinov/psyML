const psyML_submit = async(e) => {
    const location = props.ajaxurl + '?action=do_personality_call';
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
                window.location.href = response.data.link;
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