window.addEventListener('load', function(){
    //move psyML Header to the absolute top of the page, avoiding being pushed down
    //by nag messages
    let psyml_header = document.querySelector('.psyml-admin-header');
    let adminpage_root = document.getElementById('wpbody');
    if(adminpage_root && psyml_header){
        adminpage_root.prepend(psyml_header);
    }
});
//tag_marked_posts

const tag_marked_posts = async(e) => {
    let panel = document.getElementById(e.target.dataset.displayPanel);
    if(panel){
        let payload = {"nonce": psyml.nonce, "element":e.target.dataset.displayPanel,"currentnum":0}
        let finished_process = await loopResults({
            "status" : 200,
            "action" : 'tag_marked_posts_firstrun',
            "currentnum" : 0,
            "maxnum" : 1,
            "payload" : payload,
            "element" : e.target.dataset.displayPanel,
            "state"  : 'Beginning analysis. This might take a while.'
        });
        console.log(finished_process);

    } else {
        console.log('could not do crawl links report: no panel.')
    }   
}

const is_error = (obj) => {
    //remember: FALSE IS TRUE in this pattern
    let error_message = false;
    if(!obj.hasOwnProperty('status')){
        console.log('object');
        console.log(obj);
        //this will always be a single message.
        error_message = 'Response is missing Status.';
    } else {
        if(obj.status !== 200){
            if(obj.hasOwnProperty('message')){
                error_message = obj.message;
            } else {
                error_message = 'There was a problem completing your request. Error:'+obj.status
            }
        } 
    }
    return error_message;
}


//* THE LOOP - calls itself recursively if last step is not reached and required arguments exist */
const loopResults = async function( obj ) {
    let element = (obj.hasOwnProperty('element')) ? obj.element : false;
    let was_there_an_error = is_error(obj);
    if(!was_there_an_error ){
        let thisstep = {}
        if(obj.hasOwnProperty('data')){thisstep = obj.data} else {thisstep = obj}
        const step = await doResultStep(thisstep);

        let steperror = is_error(step);
        if(!steperror){
            if( step.data.hasOwnProperty('currentnum') &&
            step.data.hasOwnProperty('maxnum') &&
            step.data.hasOwnProperty('payload') &&
            step.data.hasOwnProperty('action') &&
            parseInt(step.data.currentnum) <= parseInt(step.data.maxnum)){
            //keep steppin
            return await loopResults(step);
            } else {
                console.log('failed step required object data');
                console.log(step);
                return step;
            }
        } else {
            console.log(steperror);
            console.log(element);
            new ComboBreaker ({"status":400, "message":steperror}, element);
        }

    } else {
        console.log(was_there_an_error);
        new ComboBreaker({"status":400, "message":was_there_an_error}, element);
    }
}
            
const doResultStep = async function( response ){
    //Middle Step that allows break conditions and eventually branching
    if(response.hasOwnProperty('breakcondition') && response.breakcondition){
        return new ComboBreaker(response.state, response.element);
    } else {
        try {
            return await resultStep(response);            
        }
        catch(err) {
            console.log(err);
            if(typeof err === 'object' && err.element){
                this.returned = new ComboBreaker(err.state, err.element)
            }
        }
    }
}
const stylesniptransparent = ()=>{
    return 'style="background:transparent;" ';
}
const stylesnippet = (n,t) =>{
    let prcnt = Math.round(n/t * 100);
    return 'style="height:'+prcnt+'%;" ';
}
const doChartStyle = (n = null,t = null)=>{
    if(!n || !t) return stylesniptransparent();
    return stylesnippet(n,t);
}
const doCountSpan = (n) =>{
    return (n) ? '<span class="thecount">'+n+'</span>' : '';
}
function psymlChart(obj){
    //Mother of god this got ugly - @todo
    if(!obj.hasOwnProperty('total')) return false;

    let Hh = obj.H.hasOwnProperty('Hh') ? obj.H.Hh : false;
    let Hl = obj.H.hasOwnProperty('Hl') ? obj.H.Hl : false;
    let Eh = obj.E.hasOwnProperty('Eh') ? obj.E.Eh : false;
    let El = obj.E.hasOwnProperty('El') ? obj.E.Eh : false;
    let Xh = obj.X.hasOwnProperty('Xh') ? obj.X.Xh : false;
    let Xl = obj.X.hasOwnProperty('Xl') ? obj.X.Xl : false;
    let Ah = obj.A.hasOwnProperty('Ah') ? obj.A.Ah : false;
    let Al = obj.A.hasOwnProperty('Al') ? obj.A.Al : false;
    let Ch = obj.C.hasOwnProperty('Ch') ? obj.C.Ch : false;
    let Cl = obj.C.hasOwnProperty('Cl') ? obj.C.Cl : false;
    let Oh = obj.O.hasOwnProperty('Oh') ? obj.O.Oh : false;
    let Ol = obj.O.hasOwnProperty('Ol') ? obj.O.Ol : false;

    let markup ='<div class="psyml_admin_background"><div class="toppanel"><div class="bars"><div class="letter">';
    markup+='<span '+doChartStyle(Hh.count,obj.total)+'class="Hh';
    markup+=(Hh.count) ? ' active' : '';
    markup+='">Hh'+doCountSpan(Hh.count)+'</span>';
    markup+='<span '+doChartStyle(Hl.count,obj.total)+'class="Hl';
    markup+=(Hl.count) ? ' active' : '';
    markup+='">Hl'+doCountSpan(Hl.count)+'</span></div><div class="letter">';
    markup+='<span '+doChartStyle(Eh.count,obj.total)+'class="Eh';
    markup+=(Eh.count) ? ' active' : '';
    markup+='">Eh'+doCountSpan(Eh.count)+'</span>';
    markup+='<span '+doChartStyle(El.count,obj.total)+'class="El';
    markup+=(El.count) ? ' active' : '';
    markup+='">El'+doCountSpan(El.count)+'</span></div><div class="letter">';
    markup+='<span '+doChartStyle(Xh.count,obj.total)+'class="Xh';
    markup+=(Xh.count) ? ' active' : '';
    markup+='">Xh'+doCountSpan(Xh.count)+'</span>';
    markup+='<span '+doChartStyle(Xl.count,obj.total)+'class="Xl';
    markup+=(Xl.count) ? ' active' : '';
    markup+='">Xl'+doCountSpan(Xl.count)+'</span></div><div class="letter">';
    markup+='<span '+doChartStyle(Ah.count,obj.total)+'class="Ah';
    markup+=(Ah.count) ? ' active' : '';
    markup+='">Ah'+doCountSpan(Ah.count)+'</span>';
    markup+='<span '+doChartStyle(Al.count,obj.total)+'class="Al';
    markup+=(Al.count) ? ' active' : '';
    markup+='">Al'+doCountSpan(Al.count)+'</span></div><div class="letter">';
    markup+='<span '+doChartStyle(Ch.count,obj.total)+'class="Ch';
    markup+=(Ch.count) ? ' active' : '';
    markup+='">Ch'+doCountSpan(Ch.count)+'</span>';
    markup+='<span '+doChartStyle(Cl.count,obj.total)+'class="Cl';
    markup+=(Cl.count) ? ' active' : '';
    markup+='">Cl'+doCountSpan(Cl.count)+'</span></div><div class="letter">';
    markup+='<span '+doChartStyle(Oh.count,obj.total)+'class="Oh';
    markup+=(Oh.count) ? ' active' : '';
    markup+='">Oh'+doCountSpan(Oh.count)+'</span>';
    markup+='<span '+doChartStyle(Ol.count,obj.total)+'class="Ol';
    markup+=(Ol.count) ? ' active' : '';
    markup+='">Ol'+doCountSpan(Ol.count)+'</span></div></div></div><div class="bottompanel"><ul class="legend">';
    markup+='<li>H</li>';
    markup+='<li>E</li>';
    markup+='<li>X</li>';
    markup+='<li>A</li>';
    markup+='<li>C</li>';
    markup+='<li>O</li>';
    markup+='</ul></div></div>';
    return markup;
}
function progressBar(step, total){
    let percentile = Math.round( (step / total) * 100 );
    let style = '<style>#progBar_obp{display:block;width:100%;background:white;height:25px;border-radius:3px;}#progBarInside_obp{height:25px;background:#0F99F7;width:'+percentile+'%;border-radius:3px;transition:all 0.5s ease;}</style>';
    let markup ='<div id="progBar_obp"><div id="progBarInside_obp"></div></div>'; 
    let blob = style + markup;
    return (percentile) ? blob : '';   
};

const getChartObject = (object) => {
    //everything should be here
    let totalcount = 0;
    let children = [];
    let returnObject = [];
    if(object.payload.results){
        for(var key of Object.keys(object.payload.results)) {
            children.push(object.payload.results[key]["children"])
    
        }
        for(let objArray of children){
            if( objArray.hasOwnProperty('Hh') && objArray.hasOwnProperty('Hl') ) {
                returnObject["H"] = objArray;
                let objcount = objArray.Hh.count + objArray.Hl.count;
                totalcount+= objcount;
            } else if( objArray.hasOwnProperty('Eh') && objArray.hasOwnProperty('El') ) {
                returnObject["E"] = objArray;
                let objcount = objArray.Eh.count + objArray.El.count;
                totalcount+= objcount;
            } else if( objArray.hasOwnProperty('Xh') && objArray.hasOwnProperty('Xl') ) {
                returnObject["X"] = objArray;
                let objcount = objArray.Xh.count + objArray.Xl.count;
                totalcount+= objcount;
            } else if( objArray.hasOwnProperty('Ah') && objArray.hasOwnProperty('Al') ) {
                returnObject["A"] = objArray;
                let objcount = objArray.Ah.count + objArray.Al.count;
                totalcount+= objcount;
            } else if( objArray.hasOwnProperty('Ch') && objArray.hasOwnProperty('Cl') ) {
                returnObject["C"] = objArray;
                let objcount = objArray.Ch.count + objArray.Cl.count;
                totalcount+= objcount;
            } else if( objArray.hasOwnProperty('Oh') && objArray.hasOwnProperty('Ol') ) {
                returnObject["O"] = objArray;
                let objcount = objArray.Oh.count + objArray.Ol.count;
                totalcount+= objcount;
            }
        }
        returnObject["total"] = totalcount;    //let return_obj = {"H": ["Hh": object.payload.results]}
    }
    return returnObject;
}

const resultStep = async function(object){
    return new Promise((resolve,reject) => {
        element = (object.hasOwnProperty('element')) ? object.element : false;
        state = (object.hasOwnProperty('state')) ? object.state : '';
        action = (object.hasOwnProperty('action')) ? object.action : null;
        payload = (object.hasOwnProperty('payload')) ? object.payload : null;
        currentnum = (object.hasOwnProperty('currentnum')) ? object.currentnum : 0;
        maxnum = (object.hasOwnProperty('maxnum')) ? object.maxnum : 0;
        breakcondition = (object.hasOwnProperty('breakcondition')) ? object.breakcondition : false;
        results = (object.hasOwnProperty('results')) ? object.results : false;
    
        //render 
        let renderstate = document.createElement('div');
        renderstate.classList.add( 'system-dialog');
        let progress = progressBar(currentnum, maxnum);
        let chartobject = getChartObject(object);
        let chart = psymlChart(chartobject);
        console.log(chartobject);

        renderstate.innerHTML = (chart) ? progress +  state + chart : progress + state;

        if(isQuery(element)) {
            parentcontainer = document.querySelector(element);
        } else if(typeof element == 'string'){
            parentcontainer = document.getElementById(element);
        } else if(typeof element === 'object'){
            parentcontainer = element;
        } else { parentcontainer = false}
        console.log('parentcontainer');
        console.log(parentcontainer);
        if(parentcontainer){
          parentcontainer.innerHTML = '';
          parentcontainer.appendChild( renderstate );      
        }
        //end render do send
        sendInLoop(action, payload).then(function(response){
            resolve(response);
        })
    });
};

function isQuery(str){
    let pattern = /^[.#\[]/;
    return pattern.test(str);
};

const sendInLoop = async(action, payload) => {
    let workingPayload = null;
    let processedPayload = ''

    if(Array.isArray(payload)){
        workingPayload = payload[0];
    } else {
        workingPayload = payload;
    }
    if(typeof workingPayload == 'object'){
        let keys = Object.keys(workingPayload);
        keys.forEach(function(key){
            if(key !== 'results'){
            processedPayload+= encodeURIComponent(key) + '=' + encodeURIComponent(workingPayload[key]) + '&';
            } else {
            processedPayload+= encodeURIComponent(key) + '=' + encodeURIComponent(JSON.stringify(workingPayload[key])) + '&';
            }
        });
    processedPayload = processedPayload.substring(0, processedPayload.length - 1); //get rid of last & 
    }

    let location = psyml.ajaxurl + '?action=' + action;
    if( location && processedPayload){
        const settings = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
                body:processedPayload
        };
        try {
            const fetchResponse = await fetch(location, settings);
            const receivedata = await fetchResponse.json();

            return receivedata;
                    
            // do success stuff
        } catch (e) {
            console.log(e);
            return e;
        } 
            
    }
}
class ComboBreaker{
    constructor(obj ,element){
        if(typeof(element) == 'object'){
            let errorstring = '';
            for (const [key, value] of Object.entries(obj)) {
                errorstring+=`<p>${key}:${value}<p>`;
            }
            let div = document.createElement('div');
            div.innerHTML = errorstring;
            element.appendChild(div);
        } else {
            let parent = document.getElementById(element);
            if(parent){
                let errorstring = '';
                for (const [key, value] of Object.entries(obj)) {
                    errorstring+=`<p>${key}:${value}<p>`;
                }
                let div = document.createElement('div');
                div.innerHTML = errorstring;
                parent.appendChild(div);
            }
        }
    }
}