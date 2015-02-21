    function checktextbox(field){
        var errfield = field.id+"error";
        var checkvalue = field.value;
        var checkspace = trim(checkvalue);
       
        if(checkspace.length == 0) {
            document.getElementById(errfield).innerHTML = "<font color='#FF0000'>Required</font>";
            return false;
        } else{
             document.getElementById(errfield).innerHTML = "&nbsp;";
             return true;
        }     
    }
   
    function validate() {
        var flag=true;
		var flag1;
        var errcnt=0;
        for(var i=0; i<document.forms[0].length-1; i++){
            flag1=checktextbox(document.forms[0].elements[i]);
            flag=flag && flag1;
        }
		return flag;
        if(flag) 
		{
			alert(flag);
            document.loginForm.submit();
        }
    }
   
    function trim(str) {
            var whitespace = new String(" \t\n\r");
            var s = new String(str);
            if (whitespace.indexOf(s.charAt(0)) != -1) {
                var j=0, i = s.length;
                while (j < i && whitespace.indexOf(s.charAt(j)) != -1) { j++; }
                s = s.substring(j, i);
            }
            return s;
    }