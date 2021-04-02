let admin_ajax = "<?php echo \get_site_url() . '/wp-admin/admin-ajax.php' ?>";
/* set form conditional logic here */
/* currently only booleans like checkboxes or radios are supported but can be expanded */
let condition_terms = [ 'true', 'false', 'empty', 'notempty', 'checked'];
let conditions = [
    { 
        'id': 'addlink_desc_Hh',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Hl',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Eh',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_El',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Xh',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Xl',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Ah',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Al',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Ch',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Cl',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Oh',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    },
    { 
        'id': 'addlink_desc_Ol',
        'dependency': 'addlink_use_descriptions',
        'condition': 'checked',
        'checkvalue': null
    }

];

function doConditionalLogic(event){
    let thisID = event.target.id;
    
    conditions.forEach(function(condition) {
        if(condition.dependency === thisID){
            //run condition
            if(condition_terms.indexOf(condition.condition) !== -1){
                switch(condition.condition){
                    case 'true': 
                        if( condition.checkvalue){
                            if(event.target.value.trim().toLowerCase() == condition.checkvalue.trim().toLowerCase() ){
                                let target = document.getElementById(condition.id);
                                if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                            } else {
                                let target = document.getElementById(condition.id);
                                if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                            }
                        } else {
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                        }
                        break;
                    case 'false':
                        if( condition.checkvalue){
                            if(event.target.value !== condition.checkvalue){
                                let target = document.getElementById(condition.id);
                                if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                            } else {

                                let target = document.getElementById(condition.id);
                                if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                                }
                        } else {
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                        }
                        break;
                    case 'empty':
                        if(event.target.value = null || event.target.value == '' || !event.target.value ){
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                        } else {
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                        }
                    break;
                    case 'notempty':
                        if(event.target.value = null || event.target.value == '' || !event.target.value ){
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                        } else {
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');
                        }
                    break;
                    case 'checked':
                        if(event.target.checked){
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.remove('theme_admin_hidden');      
                        } else {
                            let target = document.getElementById(condition.id);
                            if(target) target.closest('.formrow').classList.add('theme_admin_hidden');
                        }
                    default: return false;
                } //end switch
            }
        } 
    });

}