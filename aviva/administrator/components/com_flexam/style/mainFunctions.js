/**
* @package      com_flexam for Joomla! 1.5
* @version	$Id: flexam.php 2010-04-02 10:07:31Z Hernán Roa $
* @author       Hernán Roa Reyes
* @copyright	(C) 2010 - 2012 Hernán Roa Reyes.
* @license	GNU/GPLv3 http://www.gnu.org/copyleft/gpl.html
* See license.txt
* flexam is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

function str_replace (search, replace, subject, count) {
    var i = 0, j = 0, temp = '', repl = '', sl = 0, fl = 0,
            f = [].concat(search),
            r = [].concat(replace),
            s = subject,
            ra = r instanceof Array, sa = s instanceof Array;
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }

    for (i=0, sl=s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j=0, fl=f.length; j < fl; j++) {
            temp = s[i]+'';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length-s[i].length)/f[j].length;}
        }
    }
    return sa ? s : s[0];
}

function showLayer(idLay){
    if(document.getElementById(idLay).style.display == 'none'){
        document.getElementById(idLay).style.display = 'block';
    }else{
        document.getElementById(idLay).style.display = 'none';
    }
}

function submitFm(idFm){
    document.forms[idFm].submit();
}

function AJAXConstructObj(){
    var obj;
    if(window.XMLHttpRequest) { // no es IE
        obj = new XMLHttpRequest();
    } else { // Es IE o no tiene el objeto
        try {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (e) {
            alert('Browser is NOT supported');
        }
    }
    return obj;
}

function ajaxObj(url, idLayer, params){
    oXML = AJAXConstructObj();
    oXML.open('POST', url, true);
    oXML.onreadystatechange = function (){document.getElementById(idLayer).innerHTML = oXML.responseText;};
    oXML.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    oXML.send(params + '&nocache=' + Math.random());
}

function serverObjFound(params){
    var usData = params.split('::') ;
    
    document.getElementById('usName').value = usData[0] ;
    document.getElementById('usMail').value = usData[1] ;
    document.getElementById('curId').value = usData[2];
    
    submitFm('loginFlexamFm');
}

function getQuestionDefinition(idFm, action){
    document.getElementById('task').value = action;
    submitFm(idFm);
}

function setQuestionModify(idFm, action, act){
    document.getElementById('task').value = action;
    document.getElementById('selAct').value = act;
    submitFm(idFm);
}

function getDetailType(idBox, idDspl){
    var typeQst  = document.getElementById(idBox).value;
    var comLang = document.getElementById('defLang').value;
    ajaxObj('components/com_flexam/tQuestionDefAjax.php', idDspl, 'typeQst=' + typeQst + '&comLang=' + comLang + '&nTypeQ=' + idBox);
}

function imprSelec(){
    var pagHead = '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title></title><style>#titleFlExamUser{ font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 24px; font-weight: bold; padding: 30px 8px 40px; }  #footFlExamUser{ font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 8px; font-weight: bold; color: #9fdfef; padding-top: 30px; }  .tableTest{  }  #imgFloatDspl{ 	background-color:#f5f5f5;	 	position: absolute; 	top: 250px; 	left: 40%; 	width: 400px; 	height: 350px; 	padding:20px 20px 20px 20px ; }  #titleItem{ 	font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 14px; font-weight: bold; color:#2e2e2e; padding-top: 7px; }  #imgScreen{ 	background-image:url(""); 	background-position: center center; 	background-repeat: no-repeat; 	width: 400px; 	height: 350px; }  #nameTst{ 	font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 16px; font-weight: bold; color:#000000; padding-top: 7px; }  #instruct{ 	font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color:#4a4a4a; padding-top: 7px; }  #quest{ 	font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; color:#4a4a4a; padding-top: 7px; }  #alterna{ 	font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 10px; font-weight: lighter; color:#2e2e2e; padding-top: 5px; padding-left: 10px; }  .icon-32-print { background-image: url("/joomla/administrator/templates/khepri/images/toolbar/icon-32-print.png"); }</style></head><body>';
    var pagFoot = '</body></html>';
    
    var ficha = document.adminForm.innerHTML;
    var ventimp = window.open('components/com_flexam/views/index.html', 'Previsualización');
    
    ventimp.document.write(pagHead + ficha + pagFoot);
    ventimp.document.close();
    
    ventimp.print();
    ventimp.close();
}

function goAway(url, timeDelay){
    setTimeout("window.location='" + url+"'", parseInt(timeDelay) * 1000);
}

function checkNumberField(id, msg){
    var txtVal = document.getElementById(id).value;
    var disc = txtVal;

    txtVal = txtVal.replace(/[^0-9]/g ,"");

    if((disc!=txtVal)){
        alert(msg);

        document.getElementById(id).value = txtVal;
    }
}

function checkMailField(id, msg){
    var txtVal = document.getElementById(id).value;
    var disc = txtVal;

    txtVal = txtVal.replace(/[^a-zA-Z0-9\-\@\_\.]/g ,"");

    if((disc!=txtVal)){
        alert(msg);

        document.getElementById(id).value = txtVal;
    }
}


function checkAnswerUser(id, type, msg){
    if(parseInt(type) < 3 ){
        var txtVal = document.getElementById(id).value;
        var disc = txtVal;

        txtVal = txtVal.replace(/[^0-9\;]/g ,"");

        if((disc!=txtVal)){
            alert(msg);

            document.getElementById(id).value = txtVal;
        }
    }
}

function checkStackMode(id, msg){
    var txtVal = document.getElementById(id).value;
    var disc = txtVal;

    txtVal = txtVal.replace(/[^0-1]/g ,"");

    if((disc!=txtVal)){
        alert(msg);

        document.getElementById(id).value = txtVal;
    }
}

function checkTypeQ(idT, idA, idP, msg){
    var typeQ = document.getElementById(idT).value;
    
    if( parseInt(typeQ) == 4 ){
        var rAnsw = typeQ = document.getElementById(idA).value;
        var pAnsw = typeQ = document.getElementById(idP).value;
        var nAnsw = rAnsw.split(';');

        if(parseInt(nAnsw.length) !== parseInt(pAnsw)){
            alert(msg);
        }
    }
}