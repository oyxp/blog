# Ajax
>1、JavaScript和Jqeury


>2、Ajax

    
    XMLHttpRequest对象
     
     xhr = new XMLHttpRequest();
    打开一个请求：
        xhr.open(method,url,async)
    
    发送请求：
        xhr.send(query_string)
    
    POST请求，需要设置一个请求头
       xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    响应：
     xhr.responseText
     xhr.responseXML
     
    事件：
    xhr.onReadyStateChange = function(response){
       
    }
     
    readyState:
      0：请求未初始化
      1：建立服务器连接
      2：请求已接收
      3：请求处理中
      4：请求已完成