
    var url = http_path +'system/route.php';


    function sendRequestToServerPost(url,variables,callback){
        var var_string = JSON.stringify(variables);
            var request_url = variables;

            var xmlHttp = new XMLHttpRequest(); 
            xmlHttp.onreadystatechange = function(){
                if (xmlHttp.readyState==4 && xmlHttp.status==200){
                    callback(xmlHttp.responseText);
                }
            };
            xmlHttp.open( "POST", url, true );
            xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlHttp.send(request_url);
    }

